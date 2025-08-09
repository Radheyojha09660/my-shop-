<?php
require_once __DIR__ . '/../includes/config.php';
if (!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

if (isset($_GET['mark']) && isset($_GET['id'])){
    $status = $_GET['mark']; $id = $_GET['id'];
    $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?')->execute([$status,$id]);
    header('Location: orders.php'); exit;
}

$orders = $pdo->query('SELECT o.*, c.name as customer_name FROM orders o LEFT JOIN customers c ON c.id=o.customer_id ORDER BY o.created_at DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Orders</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container py-4">
  <h1>Orders</h1>
  <table class="table"><thead><tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Payment</th><th>Actions</th></tr></thead><tbody>
  <?php foreach($orders as $o): ?>
    <tr>
      <td><?php echo $o['id']; ?></td>
      <td><?php echo htmlspecialchars($o['customer_name']); ?></td>
      <td>₹ <?php echo $o['total_amount']; ?></td>
      <td><?php echo $o['status']; ?></td>
      <td><?php echo $o['payment_status']; ?></td>
      <td>
        <a class="btn btn-sm btn-success" href="orders.php?mark=Shipped&id=<?php echo $o['id']; ?>">Mark Shipped</a>
        <a class="btn btn-sm btn-primary" href="orders.php?mark=Delivered&id=<?php echo $o['id']; ?>">Mark Delivered</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody></table>
</div>
</body></html>
