<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/razorpay-config.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection error.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| CHECK RAZORPAY CONFIG
|--------------------------------------------------------------------------
*/

if (
    RAZORPAY_KEY_ID === 'YOUR_RAZORPAY_KEY_ID' ||
    RAZORPAY_KEY_SECRET === 'YOUR_RAZORPAY_KEY_SECRET'
) {
    echo json_encode([
        'success' => false,
        'message' => 'Razorpay test keys are not configured yet.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

$cartItems = $_SESSION['mart_cart'] ?? [];

if (!is_array($cartItems) || empty($cartItems)) {
    echo json_encode([
        'success' => false,
        'message' => 'Your cart is empty.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| PRODUCT IDS
|--------------------------------------------------------------------------
*/

$productIds = [];

foreach ($cartItems as $productId => $item) {
    $productIds[] = (int)$productId;
}

$productIds = array_values(
    array_unique(
        array_filter($productIds)
    )
);

if (empty($productIds)) {
    echo json_encode([
        'success' => false,
        'message' => 'No valid products found in cart.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| GET PRODUCTS
|--------------------------------------------------------------------------
*/

$ids = implode(',', $productIds);

$sql = "
    SELECT *
    FROM mart_products
    WHERE id IN ($ids)
    AND status = 'active'
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode([
        'success' => false,
        'message' => 'Unable to load cart products.'
    ]);
    exit;
}

$subtotal = 0;
$productCount = 0;

while ($product = mysqli_fetch_assoc($result)) {

    $productId = (int)$product['id'];

    $quantity = 1;

    if (isset($cartItems[$productId])) {

        if (is_array($cartItems[$productId])) {
            $quantity = (int)(
                $cartItems[$productId]['quantity'] ?? 1
            );
        } else {
            $quantity = (int)$cartItems[$productId];
        }
    }

    $quantity = max(1, $quantity);

    $price = isset($product['sale_price'])
        ? (float)$product['sale_price']
        : 0;

    $subtotal += ($price * $quantity);

    $productCount += $quantity;
}

/*
|--------------------------------------------------------------------------
| SHIPPING
|--------------------------------------------------------------------------
*/

$shipping = ($subtotal >= 499)
    ? 0
    : ($subtotal > 0 ? 49 : 0);

$total = $subtotal + $shipping;

if ($total <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid order amount.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| RAZORPAY AMOUNT
| Razorpay expects amount in paise.
|--------------------------------------------------------------------------
*/

$amountInPaise = (int)round($total * 100);

/*
|--------------------------------------------------------------------------
| RECEIPT
|--------------------------------------------------------------------------
*/

$receipt = 'CM' . date('ymdHis') . rand(100, 999);

/*
|--------------------------------------------------------------------------
| CREATE RAZORPAY ORDER
|--------------------------------------------------------------------------
*/

$requestData = [
    'amount' => $amountInPaise,
    'currency' => RAZORPAY_CURRENCY,
    'receipt' => $receipt,
    'partial_payment' => false
];

$ch = curl_init('https://api.razorpay.com/v1/orders');

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_USERPWD => RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET,
    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode($requestData),
    CURLOPT_TIMEOUT => 30
]);

$response = curl_exec($ch);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$curlError = curl_error($ch);

curl_close($ch);

/*
|--------------------------------------------------------------------------
| CURL ERROR
|--------------------------------------------------------------------------
*/

if ($response === false || $curlError !== '') {
    echo json_encode([
        'success' => false,
        'message' => 'Unable to connect to Razorpay.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| RAZORPAY RESPONSE
|--------------------------------------------------------------------------
*/

$data = json_decode($response, true);

if (
    $httpCode < 200 ||
    $httpCode >= 300 ||
    empty($data['id'])
) {
    echo json_encode([
        'success' => false,
        'message' => $data['error']['description']
            ?? 'Unable to create Razorpay order.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| SUCCESS
|--------------------------------------------------------------------------
*/

echo json_encode([
    'success' => true,
    'key_id' => RAZORPAY_KEY_ID,
    'razorpay_order_id' => $data['id'],
    'amount' => $amountInPaise,
    'currency' => RAZORPAY_CURRENCY,
    'receipt' => $receipt,
    'subtotal' => $subtotal,
    'shipping' => $shipping,
    'total' => $total
]);

exit;