<?php
require_once __DIR__ . '/../includes/config.php';
if (!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container py-4">
  <h1>Admin Dashboard</h1>
  <ul>
    <li><a href="products.php">Products</a></li>
    <li><a href="orders.php">Orders</a></li>
    <li><a href="parties.php">Parties</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</div>
</body></html>
