<?php
session_start();

require_once 'includes/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Database connection error.');
}

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

$cartItems = $_SESSION['mart_cart'] ?? [];

if (!is_array($cartItems)) {
    $cartItems = [];
}

/*
|--------------------------------------------------------------------------
| EMPTY CART
|--------------------------------------------------------------------------
*/

if (empty($cartItems)) {
    header('Location: cart.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| GET PRODUCTS
|--------------------------------------------------------------------------
*/

$productIds = [];

foreach ($cartItems as $productId => $item) {
    $productIds[] = (int)$productId;
}

$productIds = array_values(array_unique(array_filter($productIds)));

if (empty($productIds)) {
    header('Location: cart.php');
    exit;
}

$ids = implode(',', $productIds);

$sql = "SELECT *
        FROM mart_products
        WHERE id IN ($ids)
        AND status = 'active'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Unable to load products.');
}

$products = [];
$subtotal = 0;

while ($product = mysqli_fetch_assoc($result)) {

    $productId = (int)$product['id'];

    $quantity = 1;

    if (isset($cartItems[$productId])) {
        if (is_array($cartItems[$productId])) {
            $quantity = (int)($cartItems[$productId]['quantity'] ?? 1);
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
| FORM SUBMISSION
|--------------------------------------------------------------------------
*/

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $customerName = trim($_POST['customer_name'] ?? '');
    $customerPhone = trim($_POST['customer_phone'] ?? '');
    $customerEmail = trim($_POST['customer_email'] ?? '');

    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');

    $paymentMethod = strtoupper(trim($_POST['payment_method'] ?? 'COD'));

if (!in_array($paymentMethod, ['COD', 'ONLINE'], true)) {
    $paymentMethod = 'COD';
}

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if ($customerName === '') {
        $errors[] = 'Please enter your full name.';
    }

    if ($customerPhone === '') {
        $errors[] = 'Please enter your mobile number.';
    } elseif (!preg_match('/^[0-9]{10}$/', preg_replace('/\D/', '', $customerPhone))) {
        $errors[] = 'Please enter a valid 10-digit mobile number.';
    }

    if ($customerEmail !== '' && !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($address === '') {
        $errors[] = 'Please enter your delivery address.';
    }

    if ($city === '') {
        $errors[] = 'Please enter your city.';
    }

    if ($pincode === '') {
        $errors[] = 'Please enter your pincode.';
    } elseif (!preg_match('/^[0-9]{6}$/', $pincode)) {
        $errors[] = 'Please enter a valid 6-digit pincode.';
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE ORDER
    |--------------------------------------------------------------------------
    */

    if (empty($errors)) {

        mysqli_begin_transaction($conn);

        try {

            /*
            | Generate unique order number
            */

            $orderNumber = 'CM' . date('ymdHis') . rand(100, 999);

            /*
            | Insert order
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
                    order_status
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $orderStmt = mysqli_prepare($conn, $orderSql);

            if (!$orderStmt) {
                throw new Exception('Unable to prepare order.');
            }

            $paymentStatus = 'pending';
            $orderStatus = 'pending';

            mysqli_stmt_bind_param(
                $orderStmt,
                'ssssssssdddsss',
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
                $orderStatus
            );

            if (!mysqli_stmt_execute($orderStmt)) {
                throw new Exception('Unable to create order.');
            }

            $orderId = mysqli_insert_id($conn);

            mysqli_stmt_close($orderStmt);

            /*
            |--------------------------------------------------------------------------
            | Insert order items
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

            $itemStmt = mysqli_prepare($conn, $itemSql);

            if (!$itemStmt) {
                throw new Exception('Unable to prepare order items.');
            }

            foreach ($products as $product) {

                $productId = (int)$product['id'];
                $productName = $product['name'];

                $productImage = $product['main_image'] ?? '';

                $quantity = (int)$product['checkout_quantity'];
                $price = (float)$product['checkout_price'];
                $itemTotal = (float)$product['checkout_total'];

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
                    throw new Exception('Unable to save order item.');
                }
            }

            mysqli_stmt_close($itemStmt);

            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            mysqli_commit($conn);
            
            $_SESSION['mart_cart'] = [];

            /*
            | Clear cart
            */

            $_SESSION['cart'] = [];

            /*
            | Redirect to success page later
            |
            | For now we display success on this page.
            */

            $orderSuccess = true;

        } catch (Throwable $e) {

            mysqli_rollback($conn);

            $errors[] = 'Something went wrong while placing your order. Please try again.';
        }
    }
}

require_once 'includes/header.php';
?>

<link rel="stylesheet" href="assets/css/cleanmart.css">

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
/* =========================================================
   CLEANMART CHECKOUT
========================================================= */

.cm-checkout-page {
    background: #f7faf8;
    min-height: 70vh;
    padding: 40px 0 70px;
}

.cm-checkout-container {
    width: min(1180px, calc(100% - 32px));
    margin: 0 auto;
}

.cm-checkout-breadcrumb {
    font-size: 14px;
    margin-bottom: 12px;
    color: #60706a;
}

.cm-checkout-breadcrumb a {
    color: #083d2b;
    text-decoration: none;
    font-weight: 600;
}

.cm-checkout-title {
    color: #083d2b;
    font-size: 36px;
    font-weight: 800;
    margin: 0 0 30px;
}

.cm-checkout-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 380px;
    gap: 28px;
    align-items: start;
}

.cm-checkout-card {
    background: #fff;
    border: 1px solid #e1e8e4;
    border-radius: 18px;
    padding: 28px;
    box-shadow: 0 8px 28px rgba(8, 61, 43, 0.06);
}

.cm-checkout-card h2 {
    color: #083d2b;
    font-size: 22px;
    margin: 0 0 22px;
    font-weight: 800;
}

.cm-form-group {
    margin-bottom: 18px;
}

.cm-form-group label {
    display: block;
    font-size: 14px;
    font-weight: 700;
    color: #18352b;
    margin-bottom: 7px;
}

.cm-form-group input,
.cm-form-group textarea {
    width: 100%;
    border: 1px solid #d7e1dc;
    border-radius: 10px;
    padding: 13px 14px;
    font-size: 15px;
    outline: none;
    transition: .2s ease;
    background: #fff;
    box-sizing: border-box;
}

.cm-form-group input:focus,
.cm-form-group textarea:focus {
    border-color: #083d2b;
    box-shadow: 0 0 0 3px rgba(8, 61, 43, .08);
}

.cm-form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.cm-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.cm-payment-box {
    border: 1px solid #dce7e1;
    border-radius: 12px;
    padding: 15px;
    background: #f8fbf9;
}

.cm-payment-box label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    color: #083d2b;
    cursor: pointer;
}

.cm-payment-box input {
    accent-color: #083d2b;
}

.cm-order-item {
    display: flex;
    gap: 13px;
    padding: 13px 0;
    border-bottom: 1px solid #edf1ef;
}

.cm-order-item:last-child {
    border-bottom: 0;
}

.cm-order-image {
    width: 62px;
    height: 62px;
    border-radius: 10px;
    background: #f7f9f8;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
}

.cm-order-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.cm-order-info {
    flex: 1;
    min-width: 0;
}

.cm-order-name {
    color: #123b2e;
    font-weight: 700;
    font-size: 14px;
    line-height: 1.4;
}

.cm-order-meta {
    color: #718078;
    font-size: 13px;
    margin-top: 4px;
}

.cm-order-price {
    color: #083d2b;
    font-weight: 800;
    font-size: 14px;
    white-space: nowrap;
}

.cm-summary-row {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    padding: 10px 0;
    color: #53635c;
}

.cm-summary-row strong {
    color: #083d2b;
}

.cm-summary-total {
    border-top: 1px solid #e5ebe7;
    margin-top: 10px;
    padding-top: 18px;
    font-size: 20px;
    font-weight: 800;
}

.cm-summary-total strong {
    color: #083d2b;
}

.cm-place-order {
    width: 100%;
    border: 0;
    border-radius: 11px;
    padding: 15px 20px;
    background: #083d2b;
    color: #fff;
    font-size: 16px;
    font-weight: 800;
    cursor: pointer;
    margin-top: 18px;
    transition: .2s ease;
}

.cm-place-order:hover {
    background: #062f22;
    transform: translateY(-1px);
}

.cm-free-delivery {
    margin-top: 14px;
    padding: 13px;
    border-radius: 10px;
    background: #f0f8f3;
    color: #38745d;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
}

.cm-alert {
    border-radius: 12px;
    padding: 15px 18px;
    margin-bottom: 20px;
    background: #fff4f3;
    border: 1px solid #ffd5d1;
    color: #b42318;
}

.cm-success {
    max-width: 700px;
    margin: 40px auto;
    text-align: center;
}

.cm-success-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 20px;
    border-radius: 50%;
    background: #e9f7ef;
    color: #083d2b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    font-weight: 800;
}

.cm-success h1 {
    color: #083d2b;
    font-size: 34px;
    margin-bottom: 12px;
}

.cm-success p {
    color: #60706a;
    line-height: 1.7;
}

.cm-order-number {
    display: inline-block;
    margin: 15px 0;
    padding: 10px 18px;
    border-radius: 8px;
    background: #fff8df;
    color: #725700;
    font-weight: 800;
}

.cm-back-shop {
    display: inline-block;
    margin-top: 15px;
    padding: 13px 22px;
    border-radius: 10px;
    background: #083d2b;
    color: #fff;
    text-decoration: none;
    font-weight: 700;
}

/* Mobile */
@media (max-width: 900px) {
    .cm-checkout-grid {
        grid-template-columns: 1fr;
    }

    .cm-checkout-title {
        font-size: 30px;
    }
}

@media (max-width: 600px) {
    .cm-checkout-page {
        padding: 28px 0 50px;
    }

    .cm-checkout-container {
        width: min(100% - 20px, 1180px);
    }

    .cm-checkout-card {
        padding: 20px;
        border-radius: 14px;
    }

    .cm-form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }

    .cm-checkout-title {
        font-size: 26px;
        margin-bottom: 22px;
    }
}
</style>

<main class="cm-checkout-page">

    <div class="cm-checkout-container">

        <?php if (!empty($orderSuccess)): ?>

            <div class="cm-checkout-card cm-success">

                <div class="cm-success-icon">✓</div>

                <h1>Order Placed Successfully!</h1>

                <p>
                    Thank you for shopping with CleanMart.
                    Your order has been received successfully.
                </p>

                <div class="cm-order-number">
                    Order #<?php echo htmlspecialchars($orderNumber); ?>
                </div>

                <p>
                    Payment Method: <strong>Cash on Delivery</strong>
                </p>

                <a href="cleanmart.php" class="cm-back-shop">
                    Continue Shopping
                </a>

            </div>

        <?php else: ?>

            <div class="cm-checkout-breadcrumb">
                <a href="cleanmart.php">CleanMart</a>
                /
                <a href="cart.php">Shopping Cart</a>
                /
                Checkout
            </div>

            <h1 class="cm-checkout-title">
                Checkout
            </h1>

            <?php if (!empty($errors)): ?>

                <div class="cm-alert">
                    <strong>Please fix the following:</strong>

                    <ul style="margin:8px 0 0 18px;">
                        <?php foreach ($errors as $error): ?>
                            <li>
                                <?php echo htmlspecialchars($error); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            <?php endif; ?>

            <form method="POST" action="checkout.php">

                <div class="cm-checkout-grid">

                    <!-- CUSTOMER DETAILS -->

                    <div class="cm-checkout-card">

                        <h2>Delivery Details</h2>

                        <div class="cm-form-group">
                            <label for="customer_name">
                                Full Name *
                            </label>

                            <input
                                type="text"
                                id="customer_name"
                                name="customer_name"
                                placeholder="Enter your full name"
                                value="<?php echo htmlspecialchars($_POST['customer_name'] ?? ''); ?>"
                                required
                            >
                        </div>

                        <div class="cm-form-row">

                            <div class="cm-form-group">

                                <label for="customer_phone">
                                    Mobile Number *
                                </label>

                                <input
                                    type="tel"
                                    id="customer_phone"
                                    name="customer_phone"
                                    placeholder="10-digit mobile number"
                                    maxlength="10"
                                    value="<?php echo htmlspecialchars($_POST['customer_phone'] ?? ''); ?>"
                                    required
                                >

                            </div>

                            <div class="cm-form-group">

                                <label for="customer_email">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="customer_email"
                                    name="customer_email"
                                    placeholder="you@example.com"
                                    value="<?php echo htmlspecialchars($_POST['customer_email'] ?? ''); ?>"
                                >

                            </div>

                        </div>

                        <div class="cm-form-group">

                            <label for="address">
                                Delivery Address *
                            </label>

                            <textarea
                                id="address"
                                name="address"
                                placeholder="House / Flat No., Street, Landmark"
                                required
                            ><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>

                        </div>

                        <div class="cm-form-row">

                            <div class="cm-form-group">

                                <label for="city">
                                    City *
                                </label>

                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    placeholder="City"
                                    value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>"
                                    required
                                >

                            </div>

                            <div class="cm-form-group">

                                <label for="state">
                                    State
                                </label>

                                <input
                                    type="text"
                                    id="state"
                                    name="state"
                                    placeholder="State"
                                    value="<?php echo htmlspecialchars($_POST['state'] ?? ''); ?>"
                                >

                            </div>

                        </div>

                        <div class="cm-form-group">

                            <label for="pincode">
                                Pincode *
                            </label>

                            <input
                                type="text"
                                id="pincode"
                                name="pincode"
                                placeholder="6-digit pincode"
                                maxlength="6"
                                value="<?php echo htmlspecialchars($_POST['pincode'] ?? ''); ?>"
                                required
                            >

                        </div>

                        <h2 style="margin-top:30px;">
                            Payment Method
                        </h2>

                       <div class="cm-payment-box">

    <label style="margin-bottom:12px;">
        <input
            type="radio"
            name="payment_method"
            value="COD"
            checked
        >

        Cash on Delivery
    </label>

    <div style="font-size:13px;color:#718078;margin:0 0 16px 27px;">
        Pay when your order is delivered.
    </div>

    <label>
        <input
            type="radio"
            name="payment_method"
            value="ONLINE"
        >

        Pay Online
    </label>

    <div style="font-size:13px;color:#718078;margin:8px 0 0 27px;">
        Pay securely using UPI, Card or Net Banking.
    </div>

</div>

                    </div>

                    <!-- ORDER SUMMARY -->

                    <div class="cm-checkout-card">

                        <h2>Order Summary</h2>

                        <?php foreach ($products as $product): ?>

                            <?php
                            $image = $product['main_image'] ?? '';

                            if (!empty($image)) {
                                if (strpos($image, 'assets/') === 0) {
                                    $imagePath = $image;
                                } else {
                                    $imagePath = 'assets/images/cleanmart/' . ltrim($image, '/');
                                }
                            } else {
                                $imagePath = 'assets/images/no-image.png';
                            }
                            ?>

                            <div class="cm-order-item">

                                <div class="cm-order-image">

                                    <img
                                        src="<?php echo htmlspecialchars($imagePath); ?>"
                                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                                    >

                                </div>

                                <div class="cm-order-info">

                                    <div class="cm-order-name">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </div>

                                    <div class="cm-order-meta">
                                        Qty: <?php echo (int)$product['checkout_quantity']; ?>
                                        ×
                                        ₹<?php echo number_format($product['checkout_price'], 0); ?>
                                    </div>

                                </div>

                                <div class="cm-order-price">
                                    ₹<?php echo number_format($product['checkout_total'], 0); ?>
                                </div>

                            </div>

                        <?php endforeach; ?>

                        <div style="margin-top:15px;">

                            <div class="cm-summary-row">
                                <span>Subtotal</span>

                                <strong>
                                    ₹<?php echo number_format($subtotal, 0); ?>
                                </strong>
                            </div>

                            <div class="cm-summary-row">

                                <span>Delivery</span>

                                <strong>
                                    <?php if ($shipping == 0): ?>
                                        FREE
                                    <?php else: ?>
                                        ₹<?php echo number_format($shipping, 0); ?>
                                    <?php endif; ?>
                                </strong>

                            </div>

                            <div class="cm-summary-row cm-summary-total">

                                <span>Total</span>

                                <strong>
                                    ₹<?php echo number_format($total, 0); ?>
                                </strong>

                            </div>

                        </div>

                        <button
    type="submit"
    class="cm-place-order"
    id="cmPlaceOrderBtn"
>
    Place Order →
</button>

                        <?php if ($subtotal < 499): ?>

                            <div class="cm-free-delivery">
                                Add ₹<?php echo number_format(499 - $subtotal, 0); ?>
                                more for FREE delivery.
                            </div>

                        <?php else: ?>

                            <div class="cm-free-delivery">
                                🚚 Free delivery on orders above ₹499
                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </form>

        <?php endif; ?>

    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const checkoutForm = document.querySelector('form[action="checkout.php"]');
    const placeOrderBtn = document.getElementById('cmPlaceOrderBtn');

    if (!checkoutForm || !placeOrderBtn) {
        return;
    }

    checkoutForm.addEventListener('submit', async function (event) {

        const paymentMethod = checkoutForm.querySelector(
            'input[name="payment_method"]:checked'
        );

        if (!paymentMethod) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | COD
        |--------------------------------------------------------------------------
        | Let the existing PHP checkout flow handle COD normally.
        */

        if (paymentMethod.value === 'COD') {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | ONLINE PAYMENT
        |--------------------------------------------------------------------------
        */

        event.preventDefault();

        placeOrderBtn.disabled = true;
        placeOrderBtn.textContent = 'Preparing Payment...';

        try {

            const response = await fetch(
                'includes/razorpay-create-order.php',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'create=1'
                }
            );

            const data = await response.json();

            if (!data.success) {
                throw new Error(
                    data.message || 'Unable to start online payment.'
                );
            }

            const options = {

                key: data.key_id,

                amount: data.amount,

                currency: data.currency,

                name: 'CleanMart',

                description: 'CleanMart Order',

                order_id: data.razorpay_order_id,

                prefill: {
                    name: document.getElementById('customer_name')?.value || '',
                    email: document.getElementById('customer_email')?.value || '',
                    contact: document.getElementById('customer_phone')?.value || ''
                },

                theme: {
                    color: '#083D2B'
                },

                handler: async function (paymentResponse) {

                    placeOrderBtn.textContent = 'Verifying Payment...';

                    const verifyFormData = new FormData();

                    verifyFormData.append(
                        'razorpay_payment_id',
                        paymentResponse.razorpay_payment_id
                    );

                    verifyFormData.append(
                        'razorpay_order_id',
                        paymentResponse.razorpay_order_id
                    );

                    verifyFormData.append(
                        'razorpay_signature',
                        paymentResponse.razorpay_signature
                    );

                    /*
                    | Send customer + delivery details
                    | to the verification endpoint.
                    */

                    verifyFormData.append(
                        'customer_name',
                        document.getElementById('customer_name')?.value || ''
                    );

                    verifyFormData.append(
                        'customer_phone',
                        document.getElementById('customer_phone')?.value || ''
                    );

                    verifyFormData.append(
                        'customer_email',
                        document.getElementById('customer_email')?.value || ''
                    );

                    verifyFormData.append(
                        'address',
                        document.getElementById('address')?.value || ''
                    );

                    verifyFormData.append(
                        'city',
                        document.getElementById('city')?.value || ''
                    );

                    verifyFormData.append(
                        'state',
                        document.getElementById('state')?.value || ''
                    );

                    verifyFormData.append(
                        'pincode',
                        document.getElementById('pincode')?.value || ''
                    );

                    const verifyResponse = await fetch(
                        'includes/razorpay-verify.php',
                        {
                            method: 'POST',
                            body: verifyFormData
                        }
                    );

                    const verifyData = await verifyResponse.json();

                    if (!verifyData.success) {
                        throw new Error(
                            verifyData.message ||
                            'Payment verification failed.'
                        );
                    }

                    window.location.href =
                        'checkout.php?payment=success&order=' +
                        encodeURIComponent(verifyData.order_number);
                },

                modal: {
                    ondismiss: function () {
                        placeOrderBtn.disabled = false;
                        placeOrderBtn.textContent = 'Place Order →';
                    }
                }
            };

            const razorpay = new Razorpay(options);

            razorpay.on('payment.failed', function () {
                placeOrderBtn.disabled = false;
                placeOrderBtn.textContent = 'Place Order →';

                alert(
                    'Payment failed. Please try again or choose Cash on Delivery.'
                );
            });

            razorpay.open();

        } catch (error) {

            console.error(error);

            alert(
                error.message ||
                'Unable to start online payment.'
            );

            placeOrderBtn.disabled = false;
            placeOrderBtn.textContent = 'Place Order →';
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>