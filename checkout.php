<?php
require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'] ?? 'Cash';

    $stmt = $pdo->prepare("INSERT INTO customers (name, address, phone, email) VALUES (?,?,?,?)");
    $stmt->execute([$name,$address,$phone,'']);
    $customer_id = $pdo->lastInsertId();

    $total = cartTotal();
    $stmt = $pdo->prepare("INSERT INTO orders (customer_id, total_amount, status, payment_method, payment_status) VALUES (?,?,?,?,?)");
    $payment_status = ($payment_method === 'Online') ? 'Paid' : 'Pending';
    $stmt->execute([$customer_id,$total,'Pending',$payment_method,$payment_status]);
    $order_id = $pdo->lastInsertId();

    foreach (getCartItems() as $it) {
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?,?,?,?)");
        $stmt->execute([$order_id,$it['id'],$it['quantity'],$it['price']]);
        $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?")->execute([$it['quantity'],$it['id']]);
    }

    unset($_SESSION['cart']);

    if ($payment_method === 'Online') {
        // Redirect to a simple Razorpay checkout page (test flow)
        header('Location: razorpay_checkout.php?order_id='.$order_id); exit;
    } else {
        header('Location: index.php?order=success'); exit;
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container py-4">
  <h1>Checkout</h1>
  <form method="post">
    <div class="mb-3"><label class="form-label">Full Name</label><input name="name" required class="form-control"></div>
    <div class="mb-3"><label class="form-label">Phone</label><input name="phone" required class="form-control"></div>
    <div class="mb-3"><label class="form-label">Address</label><textarea name="address" required class="form-control"></textarea></div>
    <div class="mb-3"><label class="form-label">Payment Method</label>
      <select name="payment_method" class="form-select">
        <option value="Cash">Cash on Delivery</option>
        <option value="Online">Online (Razorpay)</option>
      </select>
    </div>
    <button class="btn btn-success">Place Order</button>
  </form>
</div>
</body></html>
