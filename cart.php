<?php
require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        addToCart((int)$_POST['product_id'], max(1,(int)$_POST['qty']));
        header('Location: cart.php'); exit;
    } elseif ($action === 'update') {
        foreach ($_POST['qty'] as $pid => $q) {
            if ($q <= 0) unset($_SESSION['cart'][$pid]);
            else $_SESSION['cart'][$pid] = (int)$q;
        }
        header('Location: cart.php'); exit;
    } elseif ($action === 'clear') {
        unset($_SESSION['cart']);
        header('Location: cart.php'); exit;
    }
}
$items = getCartItems();
$total = cartTotal();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Cart</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container py-4">
  <h1>Your Cart</h1>
  <?php if(empty($items)): ?>
    <p>Cart is empty. <a href="index.php">Continue shopping</a></p>
  <?php else: ?>
  <form method="post" action="cart.php">
  <input type="hidden" name="action" value="update">
  <table class="table">
  <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
  <tbody>
  <?php foreach($items as $it): ?>
  <tr>
    <td><?php echo htmlspecialchars($it['name']); ?></td>
    <td>₹ <?php echo $it['price']; ?></td>
    <td><input type="number" name="qty[<?php echo $it['id']; ?>]" value="<?php echo $it['quantity']; ?>" min="0" class="form-control" style="width:100px"></td>
    <td>₹ <?php echo $it['price'] * $it['quantity']; ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
  <button type="submit" class="btn btn-primary">Update Cart</button>
  </form>
  <p class="h4 mt-3">Total: ₹ <?php echo $total; ?></p>
  <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
  <form method="post" style="display:inline"><input type="hidden" name="action" value="clear"><button class="btn btn-danger">Clear Cart</button></form>
  <?php endif; ?>
</div>
</body></html>
