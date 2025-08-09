<?php
require_once __DIR__ . '/../includes/config.php';
if (!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_party'])){
    $stmt = $pdo->prepare('INSERT INTO parties (party_name, shop_name, address, contact_number, transaction_date, product_details, total_amount, payment_received) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->execute([$_POST['party_name'], $_POST['shop_name'], $_POST['address'], $_POST['contact_number'], $_POST['transaction_date'], $_POST['product_details'], $_POST['total_amount'], $_POST['payment_received']]);
    header('Location: parties.php'); exit;
}

$parties = $pdo->query('SELECT * FROM parties ORDER BY created_at DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Parties</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container py-4">
  <h1>Parties</h1>
  <h4>Add Party Transaction</h4>
  <form method="post">
    <input type="hidden" name="save_party" value="1">
    <div class="mb-2"><input name="party_name" class="form-control" placeholder="Party Name" required></div>
    <div class="mb-2"><input name="shop_name" class="form-control" placeholder="Shop Name"></div>
    <div class="mb-2"><textarea name="address" class="form-control" placeholder="Address"></textarea></div>
    <div class="mb-2"><input name="contact_number" class="form-control" placeholder="Contact Number"></div>
    <div class="mb-2"><input type="date" name="transaction_date" class="form-control"></div>
    <div class="mb-2"><textarea name="product_details" class="form-control" placeholder="Product details (text or JSON)"></textarea></div>
    <div class="mb-2"><input name="total_amount" class="form-control" placeholder="Total amount"></div>
    <div class="mb-2">
      <select name="payment_received" class="form-select">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
      </select>
    </div>
    <button class="btn btn-success">Save</button>
  </form>
  <hr>
  <h4>Recent Parties</h4>
  <table class="table"><thead><tr><th>ID</th><th>Party</th><th>Shop</th><th>Total</th><th>Paid</th></tr></thead><tbody>
  <?php foreach($parties as $p): ?>
    <tr><td><?php echo $p['id']; ?></td><td><?php echo htmlspecialchars($p['party_name']); ?></td><td><?php echo htmlspecialchars($p['shop_name']); ?></td><td>₹ <?php echo $p['total_amount']; ?></td><td><?php echo $p['payment_received']; ?></td></tr>
  <?php endforeach; ?>
  </tbody></table>
</div>
</body></html>
