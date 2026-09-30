<?php

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/razorpay-config.php';


/*
|--------------------------------------------------------------------------
| BASIC CHECK
|--------------------------------------------------------------------------
*/

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
| GET RAZORPAY RESPONSE
|--------------------------------------------------------------------------
*/

$razorpayPaymentId = trim(
    $_POST['razorpay_payment_id'] ?? ''
);

$razorpayOrderId = trim(
    $_POST['razorpay_order_id'] ?? ''
);

$razorpaySignature = trim(
    $_POST['razorpay_signature'] ?? ''
);


/*
|--------------------------------------------------------------------------
| VALIDATE PAYMENT DATA
|--------------------------------------------------------------------------
*/

if (
    $razorpayPaymentId === '' ||
    $razorpayOrderId === '' ||
    $razorpaySignature === ''
) {
    echo json_encode([
        'success' => false,
        'message' => 'Incomplete payment information.'
    ]);
    exit;
}


/*
|--------------------------------------------------------------------------
| VERIFY RAZORPAY SIGNATURE
|--------------------------------------------------------------------------
*/

$generatedSignature = hash_hmac(
    'sha256',
    $razorpayOrderId . '|' . $razorpayPaymentId,
    RAZORPAY_KEY_SECRET
);

if (!hash_equals($generatedSignature, $razorpaySignature)) {

    echo json_encode([
        'success' => false,
        'message' => 'Payment verification failed.'
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| CUSTOMER DETAILS
|--------------------------------------------------------------------------
*/

$customerName = trim(
    $_POST['customer_name'] ?? ''
);

$customerPhone = trim(
    $_POST['customer_phone'] ?? ''
);

$customerEmail = trim(
    $_POST['customer_email'] ?? ''
);

$address = trim(
    $_POST['address'] ?? ''
);

$city = trim(
    $_POST['city'] ?? ''
);

$state = trim(
    $_POST['state'] ?? ''
);

$pincode = trim(
    $_POST['pincode'] ?? ''
);


/*
|--------------------------------------------------------------------------
| VALIDATE CUSTOMER DETAILS
|--------------------------------------------------------------------------
*/

if ($customerName === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter your full name.'
    ]);
    exit;
}

if (
    $customerPhone === '' ||
    !preg_match(
        '/^[0-9]{10}$/',
        preg_replace('/\D/', '', $customerPhone)
    )
) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid 10-digit mobile number.'
    ]);
    exit;
}

if (
    $customerEmail !== '' &&
    !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)
) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
    ]);
    exit;
}

if ($address === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter your delivery address.'
    ]);
    exit;
}

if ($city === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter your city.'
    ]);
    exit;
}

if (
    $pincode === '' ||
    !preg_match('/^[0-9]{6}$/', $pincode)
) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid 6-digit pincode.'
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
        'message' => 'No valid products found.'
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
        'message' => 'Unable to load products.'
    ]);
    exit;
}


$products = [];

$subtotal = 0;


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

    $itemTotal = $price * $quantity;

    $product['checkout_quantity'] = $quantity;
    $product['checkout_price'] = $price;
    $product['checkout_total'] = $itemTotal;

    $products[] = $product;

    $subtotal += $itemTotal;
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


/*
|--------------------------------------------------------------------------
| START DATABASE TRANSACTION
|--------------------------------------------------------------------------
*/

mysqli_begin_transaction($conn);


try {

    /*
    |--------------------------------------------------------------------------
    | UNIQUE ORDER NUMBER
    |--------------------------------------------------------------------------
    */

    $orderNumber =
        'CM' .
        date('ymdHis') .
        rand(100, 999);


    /*
    |--------------------------------------------------------------------------
    | INSERT ORDER
    |--------------------------------------------------------------------------
    */

    $orderSql = "
        INSERT INTO orders
        (
            order_number,
            customer_name,
            customer_phone,
            customer_email,
            address,
            city,
            state,
            pincode,
            subtotal,
            shipping,
            total,
            payment_method,
            payment_status,
            order_status,
            razorpay_order_id,
            razorpay_payment_id,
            razorpay_signature
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";


    $orderStmt = mysqli_prepare(
        $conn,
        $orderSql
    );


    if (!$orderStmt) {
        throw new Exception(
            'Unable to prepare order.'
        );
    }


    $paymentMethod = 'ONLINE';

    $paymentStatus = 'paid';

    $orderStatus = 'confirmed';


    mysqli_stmt_bind_param(
        $orderStmt,
        'ssssssssdddssssss',
        $orderNumber,
        $customerName,
        $customerPhone,
        $customerEmail,
        $address,
        $city,
        $state,
        $pincode,
        $subtotal,
        $shipping,
        $total,
        $paymentMethod,
        $paymentStatus,
        $orderStatus,
        $razorpayOrderId,
        $razorpayPaymentId,
        $razorpaySignature
    );


    if (!mysqli_stmt_execute($orderStmt)) {

        throw new Exception(
            'Unable to create order.'
        );
    }


    $orderId = mysqli_insert_id($conn);


    mysqli_stmt_close($orderStmt);


    /*
    |--------------------------------------------------------------------------
    | INSERT ORDER ITEMS
    |--------------------------------------------------------------------------
    */

    $itemSql = "
        INSERT INTO order_items
        (
            order_id,
            product_id,
            product_name,
            product_image,
            quantity,
            price,
            item_total
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";


    $itemStmt = mysqli_prepare(
        $conn,
        $itemSql
    );


    if (!$itemStmt) {

        throw new Exception(
            'Unable to prepare order items.'
        );
    }


    foreach ($products as $product) {

        $productId = (int)$product['id'];

        $productName = $product['name'];

        $productImage =
            $product['main_image'] ?? '';

        $quantity =
            (int)$product['checkout_quantity'];

        $price =
            (float)$product['checkout_price'];

        $itemTotal =
            (float)$product['checkout_total'];


        mysqli_stmt_bind_param(
            $itemStmt,
            'iissidd',
            $orderId,
            $productId,
            $productName,
            $productImage,
            $quantity,
            $price,
            $itemTotal
        );


        if (!mysqli_stmt_execute($itemStmt)) {

            throw new Exception(
                'Unable to save order item.'
            );
        }
    }


    mysqli_stmt_close($itemStmt);


    /*
    |--------------------------------------------------------------------------
    | COMMIT
    |--------------------------------------------------------------------------
    */

    mysqli_commit($conn);


    /*
    |--------------------------------------------------------------------------
    | CLEAR CART ONLY AFTER VERIFIED PAYMENT
    |--------------------------------------------------------------------------
    */

    $_SESSION['mart_cart'] = [];

    $_SESSION['cart'] = [];


    /*
    |--------------------------------------------------------------------------
    | SUCCESS RESPONSE
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'success' => true,
        'message' => 'Payment verified and order created.',
        'order_id' => $orderId,
        'order_number' => $orderNumber
    ]);

    exit;


} catch (Throwable $e) {

    mysqli_rollback($conn);

    echo json_encode([
        'success' => false,
        'message' => 'Payment was verified, but the order could not be created. Please contact support.'
    ]);

    exit;
}