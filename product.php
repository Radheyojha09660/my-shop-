<?php
require_once __DIR__ . '/../includes/functions.php';
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }
$p = getProduct($id);
if (!$p) { echo 'Product not found'; exit; }
?>
<!doctype html><html><head><meta charset="utf-8"><title><?php echo htmlspecialchars($p['name']); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container py-4">
  <a href="index.php" class="btn btn-link">&larr; Back to shop</a>
  <div class="row">
    <div class="col-md-6">
      <img src="<?php echo $p['image']? '../uploads/'.$p['image'] : 'assets/images/no-image.png'; ?>" class="img-fluid" alt="">
    </div>
    <div class="col-md-6">
      <h2><?php echo htmlspecialchars($p['name']); ?></h2>
      <p><?php echo htmlspecialchars($p['description']); ?></p>
      <p class="h4">₹ <?php echo $p['price']; ?></p>
      <form method="post" action="cart.php">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
        <div class="mb-2">Quantity: <input type="number" name="qty" value="1" min="1" class="form-control" style="width:100px;display:inline-block"></div>
        <button class="btn btn-success">Add to Cart</button>
      </form>
    </div>
  </div>
</div>
</body></html>
