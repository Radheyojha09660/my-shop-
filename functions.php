<?php
require_once __DIR__ . '/config.php';

function getAllProducts() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

function getProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function addToCart($productId, $qty=1) {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $productId = (int)$productId;
    $qty = (int)$qty;
    if ($qty < 1) $qty = 1;
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $qty;
    } else {
        $_SESSION['cart'][$productId] = $qty;
    }
}

function getCartItems() {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) return [];
    global $pdo;
    $ids = array_keys($_SESSION['cart']);
    $in  = str_repeat('?,', count($ids) - 1) . '?';
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($in)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();
    $result = [];
    foreach ($products as $p) {
        $p['quantity'] = $_SESSION['cart'][$p['id']];
        $result[] = $p;
    }
    return $result;
}

function cartTotal() {
    $items = getCartItems();
    $total = 0;
    foreach ($items as $it) {
        $total += $it['price'] * $it['quantity'];
    }
    return $total;
}
