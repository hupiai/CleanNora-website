<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

// Agar cart session nahi hai to create karo
if (!isset($_SESSION['mart_cart'])) {
    $_SESSION['mart_cart'] = [];
}

// Request type
$action = $_POST['action'] ?? $_GET['action'] ?? '';


// =====================================================
// ADD TO CART
// =====================================================
if ($action === 'add') {

    $productId = isset($_POST['product_id'])
        ? (int)$_POST['product_id']
        : 0;

    if ($productId <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid product.'
        ]);
        exit;
    }

    // Product already cart mein hai?
    if (isset($_SESSION['mart_cart'][$productId])) {

        $_SESSION['mart_cart'][$productId]['quantity']++;

    } else {

        $_SESSION['mart_cart'][$productId] = [
            'product_id' => $productId,
            'quantity'   => 1
        ];
    }

    // Total unique products in cart
$cartCount = count($_SESSION['mart_cart']);

    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart.',
        'cart_count' => $cartCount
    ]);

    exit;
}


// =====================================================
// UPDATE QUANTITY
// =====================================================
if ($action === 'update') {

    $productId = isset($_POST['product_id'])
        ? (int)$_POST['product_id']
        : 0;

    $quantity = isset($_POST['quantity'])
        ? (int)$_POST['quantity']
        : 1;

    if ($productId > 0 && isset($_SESSION['mart_cart'][$productId])) {

        if ($quantity <= 0) {
            unset($_SESSION['mart_cart'][$productId]);
        } else {
            $_SESSION['mart_cart'][$productId]['quantity'] = $quantity;
        }
    }

    echo json_encode([
        'success' => true,
        'message' => 'Cart updated.'
    ]);

    exit;
}


// =====================================================
// REMOVE FROM CART
// =====================================================
if ($action === 'remove') {

    $productId = isset($_POST['product_id'])
        ? (int)$_POST['product_id']
        : 0;

    if ($productId > 0 && isset($_SESSION['mart_cart'][$productId])) {
        unset($_SESSION['mart_cart'][$productId]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Product removed.'
    ]);

    exit;
}


// =====================================================
// GET CART COUNT
// =====================================================
if ($action === 'count') {

    $cartCount = count($_SESSION['mart_cart']);

    echo json_encode([
        'success' => true,
        'cart_count' => $cartCount
    ]);

    exit;
}


// =====================================================
// DEFAULT RESPONSE
// =====================================================
echo json_encode([
    'success' => false,
    'message' => 'Invalid cart action.'
]);

exit;
?>