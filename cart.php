<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'includes/db.php';

/* =========================
   GET CART PRODUCTS
========================= */

$cartItems = isset($_SESSION['mart_cart']) ? $_SESSION['mart_cart'] : [];

$products = [];
$subtotal = 0;

if (!empty($cartItems)) {

    $productIds = array_keys($cartItems);
    $productIds = array_map('intval', $productIds);

    if (!empty($productIds)) {

        $ids = implode(',', $productIds);

        $query = "SELECT * FROM mart_products WHERE id IN ($ids)";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($product = mysqli_fetch_assoc($result)) {

                $productId = (int)$product['id'];
                $quantity = isset($cartItems[$productId]['quantity'])
                    ? (int)$cartItems[$productId]['quantity']
                    : 1;

                $price = (float)$product['sale_price'];
                $itemTotal = $price * $quantity;

                $product['cart_quantity'] = $quantity;
                $product['item_total'] = $itemTotal;

                $products[] = $product;
                $subtotal += $itemTotal;
            }
        }
    }
}

$shipping = $subtotal >= 499 ? 0 : ($subtotal > 0 ? 49 : 0);
$total = $subtotal + $shipping;

require_once 'includes/header.php';
?>

<link rel="stylesheet" href="assets/css/cleannart.css">

<style>
/* ========================================
   CLEANMART CART PAGE
======================================== */

.cm-cart-page {
    background: #f7f8f6;
    min-height: 100vh;
    padding: 45px 0 70px;
}

.cm-cart-container {
    max-width: 1280px;
    margin: auto;
    padding: 0 24px;
}

.cm-cart-breadcrumb {
    font-size: 14px;
    margin-bottom: 18px;
    color: #6b7280;
}

.cm-cart-breadcrumb a {
    color: #083D2B;
    text-decoration: none;
}

.cm-cart-title {
    font-size: 34px;
    font-weight: 800;
    color: #083D2B;
    margin-bottom: 30px;
}

.cm-cart-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 28px;
    align-items: start;
}

/* CART ITEMS */

.cm-cart-items {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.cm-cart-item {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 18px;
    display: grid;
    grid-template-columns: 120px 1fr auto;
    gap: 20px;
    align-items: center;
    box-shadow: 0 8px 30px rgba(8, 61, 43, 0.05);
}

.cm-cart-image {
    width: 120px;
    height: 120px;
    border-radius: 12px;
    background: #f8faf9;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.cm-cart-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.cm-cart-info h3 {
    font-size: 17px;
    font-weight: 700;
    color: #18352c;
    margin: 0 0 8px;
    line-height: 1.5;
}

.cm-cart-price {
    color: #083D2B;
    font-size: 19px;
    font-weight: 800;
    margin-bottom: 12px;
}

.cm-cart-qty {
    display: inline-flex;
    align-items: center;
    border: 1px solid #d9e0dc;
    border-radius: 9px;
    overflow: hidden;
}

.cm-cart-qty button {
    width: 38px;
    height: 38px;
    border: none;
    background: #083D2B;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
}

.cm-cart-qty span {
    width: 42px;
    text-align: center;
    font-weight: 700;
    color: #18352c;
}

.cm-cart-side {
    text-align: right;
    align-self: stretch;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.cm-cart-total {
    font-size: 19px;
    font-weight: 800;
    color: #083D2B;
}

.cm-cart-remove {
    border: none;
    background: transparent;
    color: #d9534f;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
}

/* ORDER SUMMARY */

.cm-order-summary {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 25px;
    position: sticky;
    top: 100px;
    box-shadow: 0 10px 35px rgba(8, 61, 43, 0.06);
}

.cm-order-summary h3 {
    font-size: 21px;
    font-weight: 800;
    color: #083D2B;
    margin-bottom: 22px;
}

.cm-summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 14px;
    font-size: 15px;
    color: #58645f;
}

.cm-summary-row strong {
    color: #18352c;
}

.cm-summary-free {
    color: #16824c !important;
    font-weight: 700;
}

.cm-summary-divider {
    border: none;
    border-top: 1px solid #e5e7eb;
    margin: 20px 0;
}

.cm-summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 20px;
    font-weight: 800;
    color: #083D2B;
    margin-bottom: 22px;
}

.cm-checkout-btn {
    width: 100%;
    height: 52px;
    border: none;
    border-radius: 10px;
    background: #083D2B;
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.3s ease;
}

.cm-checkout-btn:hover {
    background: #0d523b;
    transform: translateY(-2px);
}

.cm-delivery-note {
    margin-top: 18px;
    padding: 13px;
    background: #f4faf6;
    border-radius: 9px;
    font-size: 13px;
    color: #397052;
    text-align: center;
}

.cm-delivery-note i {
    color: #F4BF19;
    margin-right: 5px;
}

/* EMPTY CART */

.cm-empty-cart {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 80px 25px;
    text-align: center;
}

.cm-empty-cart i {
    font-size: 60px;
    color: #F4BF19;
    margin-bottom: 20px;
}

.cm-empty-cart h2 {
    color: #083D2B;
    font-size: 27px;
    font-weight: 800;
    margin-bottom: 10px;
}

.cm-empty-cart p {
    color: #6b7280;
    margin-bottom: 25px;
}

.cm-continue-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #083D2B;
    color: #fff;
    text-decoration: none;
    padding: 14px 25px;
    border-radius: 9px;
    font-weight: 700;
}

/* MOBILE */

@media (max-width: 900px) {

    .cm-cart-layout {
        grid-template-columns: 1fr;
    }

    .cm-order-summary {
        position: static;
    }
}

@media (max-width: 600px) {

    .cm-cart-page {
        padding: 25px 0 50px;
    }

    .cm-cart-container {
        padding: 0 15px;
    }

    .cm-cart-title {
        font-size: 27px;
        margin-bottom: 20px;
    }

    .cm-cart-item {
        grid-template-columns: 85px 1fr;
        gap: 14px;
        padding: 14px;
    }

    .cm-cart-image {
        width: 85px;
        height: 85px;
    }

    .cm-cart-side {
        grid-column: 1 / -1;
        flex-direction: row;
        align-items: center;
        margin-top: 5px;
    }

    .cm-cart-info h3 {
        font-size: 14px;
    }

    .cm-cart-price {
        font-size: 16px;
        margin-bottom: 9px;
    }

    .cm-order-summary {
        padding: 20px;
    }
}

.cm-cart-layout {
    padding-bottom: 40px;
}

</style>


<main class="cm-cart-page">

    <div class="cm-cart-container">

        <div class="cm-cart-breadcrumb">
            <a href="cleanmart.php">CleanMart</a>
            <span> / </span>
            <span>Shopping Cart</span>
        </div>

        <h1 class="cm-cart-title">
            Shopping Cart
            <span style="font-size:16px;font-weight:500;color:#7b8580;">
                (<?php echo count($products); ?> Items)
            </span>
        </h1>


        <?php if (!empty($products)): ?>

            <div class="cm-cart-layout">

                <!-- CART ITEMS -->
                <div class="cm-cart-items">

                    <?php foreach ($products as $product): ?>

                        <div class="cm-cart-item"
                             data-product-id="<?php echo (int)$product['id']; ?>">

<div class="cm-cart-image">
    <?php
    $image = !empty($product['main_image'])
        ? $product['main_image']
        : 'assets/images/no-image.png';
    ?>

    <img src="<?php echo htmlspecialchars($image); ?>"
         alt="<?php echo htmlspecialchars($product['name']); ?>">
</div>


                            <div class="cm-cart-info">

                                <h3>
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </h3>

                                <div class="cm-cart-price">
                                    ₹<?php echo number_format($product['sale_price']); ?>
                                </div>

                                <div class="cm-cart-qty">

                                    <button type="button"
                                            class="qty-btn"
                                            data-action="decrease">
                                        −
                                    </button>

                                    <span class="qty-value">
                                        <?php echo $product['cart_quantity']; ?>
                                    </span>

                                    <button type="button"
                                            class="qty-btn"
                                            data-action="increase">
                                        +
                                    </button>

                                </div>

                            </div>


                            <div class="cm-cart-side">

                                <div class="cm-cart-total">
                                    ₹<?php echo number_format($product['item_total']); ?>
                                </div>

                                <button type="button"
                                        class="cm-cart-remove">
                                    <i class="bi bi-trash3"></i>
                                    Remove
                                </button>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>


                <!-- ORDER SUMMARY -->
                <aside class="cm-order-summary">

                    <h3>Order Summary</h3>

                    <div class="cm-summary-row">
                        <span>Subtotal</span>
                        <strong id="cartSubtotal">
                            ₹<?php echo number_format($subtotal); ?>
                        </strong>
                    </div>

                    <div class="cm-summary-row">
                        <span>Delivery</span>

                        <?php if ($shipping == 0): ?>

                            <strong class="cm-summary-free">
                                FREE
                            </strong>

                        <?php else: ?>

                            <strong id="shippingCost">
                                ₹<?php echo number_format($shipping); ?>
                            </strong>

                        <?php endif; ?>

                    </div>

                    <hr class="cm-summary-divider">

                    <div class="cm-summary-total">
                        <span>Total</span>
                        <span id="cartTotal">
                            ₹<?php echo number_format($total); ?>
                        </span>
                    </div>

                    <button type="button"
                            class="cm-checkout-btn"
                            onclick="window.location.href='checkout.php'">

                        Proceed to Checkout
                        <i class="bi bi-arrow-right"></i>

                    </button>

                    <div class="cm-delivery-note">
                        <i class="bi bi-truck"></i>
                        Free delivery on orders above ₹499
                    </div>

                </aside>

            </div>


        <?php else: ?>

            <!-- EMPTY CART -->

            <div class="cm-empty-cart">

                <i class="bi bi-cart-x"></i>

                <h2>Your cart is empty</h2>

                <p>
                    Looks like you haven't added any CleanMart products yet.
                </p>

                <a href="cleanmart.php"
                   class="cm-continue-btn">

                    <i class="bi bi-arrow-left"></i>
                    Continue Shopping

                </a>

            </div>

        <?php endif; ?>

    </div>

</main>


<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.cm-cart-item').forEach(function (item) {

        const productId = item.dataset.productId;

        const decreaseBtn = item.querySelector('[data-action="decrease"]');
        const increaseBtn = item.querySelector('[data-action="increase"]');
        const removeBtn = item.querySelector('.cm-cart-remove');
        const qtyValue = item.querySelector('.qty-value');


        /* UPDATE QUANTITY */

        function updateQuantity(quantity) {

            if (quantity <= 0) {
                removeProduct();
                return;
            }

            const formData = new FormData();

            formData.append('action', 'update');
            formData.append('product_id', productId);
            formData.append('quantity', quantity);


            fetch('includes/mart-cart.php', {
                method: 'POST',
                body: formData
            })

            .then(response => response.json())

            .then(data => {

                if (data.success) {

                    window.location.reload();

                } else {

                    alert(data.message || 'Unable to update cart.');

                }

            })

            .catch(function () {

                alert('Something went wrong.');

            });

        }


        decreaseBtn.addEventListener('click', function () {

            let quantity = parseInt(qtyValue.textContent);

            updateQuantity(quantity - 1);

        });


        increaseBtn.addEventListener('click', function () {

            let quantity = parseInt(qtyValue.textContent);

            updateQuantity(quantity + 1);

        });


        /* REMOVE PRODUCT */

        function removeProduct() {

            const formData = new FormData();

            formData.append('action', 'remove');
            formData.append('product_id', productId);


            fetch('includes/mart-cart.php', {
                method: 'POST',
                body: formData
            })

            .then(response => response.json())

            .then(data => {

                if (data.success) {

                    window.location.reload();

                } else {

                    alert(data.message || 'Unable to remove product.');

                }

            })

            .catch(function () {

                alert('Something went wrong.');

            });

        }


        removeBtn.addEventListener('click', function () {

            if (confirm('Remove this product from your cart?')) {

                removeProduct();

            }

        });

    });

});

</script>

<?php require_once 'includes/footer.php'; ?>