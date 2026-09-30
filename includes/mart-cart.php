<?php

session_start();

header('Content-Type: application/json; charset=utf-8');


// =====================================================
// CREATE CART SESSION
// =====================================================

if (!isset($_SESSION['mart_cart']) || !is_array($_SESSION['mart_cart'])) {
    $_SESSION['mart_cart'] = [];
}


// =====================================================
// REQUEST ACTION
// =====================================================

$action = $_POST['action'] ?? $_GET['action'] ?? '';


// =====================================================
// CART COUNT
// Unique products count
// =====================================================

function getCartCount()
{
    return count($_SESSION['mart_cart']);
}


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


    // Product already exists?
    if (isset($_SESSION['mart_cart'][$productId])) {

        $_SESSION['mart_cart'][$productId]['quantity']++;

    } else {

        $_SESSION['mart_cart'][$productId] = [
            'product_id' => $productId,
            'quantity'   => 1
        ];
    }


    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart.',
        'cart_count' => getCartCount(),
        'quantity' => (int)$_SESSION['mart_cart'][$productId]['quantity']
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


    if ($productId <= 0) {

        echo json_encode([
            'success' => false,
            'message' => 'Invalid product.'
        ]);

        exit;
    }


    if (isset($_SESSION['mart_cart'][$productId])) {

        // Quantity zero or below = remove
        if ($quantity <= 0) {

            unset($_SESSION['mart_cart'][$productId]);

        } else {

            $_SESSION['mart_cart'][$productId]['quantity'] = $quantity;
        }
    }


    echo json_encode([
        'success' => true,
        'message' => 'Cart updated.',
        'cart_count' => getCartCount(),
        'quantity' => $quantity
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
        'message' => 'Product removed.',
        'cart_count' => getCartCount()
    ]);

    exit;
}


// =====================================================
// GET CART COUNT
// =====================================================

if ($action === 'count') {

    echo json_encode([
        'success' => true,
        'cart_count' => getCartCount()
    ]);

    exit;
}


// =====================================================
// DEFAULT
// =====================================================

echo json_encode([
    'success' => false,
    'message' => 'Invalid cart action.'
]);

exit;

?>