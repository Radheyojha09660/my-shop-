<?php
require_once __DIR__ . '/../includes/functions.php';
$products = getAllProducts();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>My Shop</h1>
    <div><a class="btn btn-outline-primary" href="cart.php">Cart (<?php echo array_sum($_SESSION['cart'] ?? []); ?>)</a></div>
  </div>
  <div class="row">
    <?php foreach($products as $p): ?>
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          <img src="<?php echo $p['image']? '../uploads/'.$p['image'] : 'assets/images/no-image.png'; ?>" class="card-img-top" style="height:200px;object-fit:cover;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo htmlspecialchars($p['name']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars(substr($p['description'],0,120)); ?>...</p>
            <div class="mt-auto">
              <p class="h5">₹ <?php echo $p['price']; ?></p>
              <a href="product.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-primary">View</a>
              <form method="post" action="cart.php" class="d-inline-block ms-2">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                <input type="number" name="qty" value="1" min="1" style="width:60px" class="form-control d-inline-block">
                <button type="submit" class="btn btn-sm btn-success mt-1">Add to Cart</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>
