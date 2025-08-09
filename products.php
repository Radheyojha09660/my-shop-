<?php
require_once __DIR__ . '/../includes/config.php';
if (!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

$action = $_GET['action'] ?? '';
if ($action === 'delete' && isset($_GET['id'])){
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    header('Location: products.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])){
    $name = $_POST['name']; $price = $_POST['price']; $stock = $_POST['stock']; $desc = $_POST['description'];
    // handle simple image upload
    $imageName = '';
    if (!empty($_FILES['image']['name'])){
        $imageName = time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $imageName);
    }
    if (!empty($_POST['product_id'])){
        $stmt = $pdo->prepare('UPDATE products SET name=?, description=?, price=?, stock=?'.($imageName? ', image=?':'' ).' WHERE id=?');
        if ($imageName) $stmt->execute([$name,$desc,$price,$stock,$imageName,$_POST['product_id']]);
        else $stmt->execute([$name,$desc,$price,$stock,$_POST['product_id']]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO products (name, sku, description, price, stock, image) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$name,'', $desc, $price, $stock, $imageName]);
    }
    header('Location: products.php'); exit;
}

$products = $pdo->query('SELECT * FROM products ORDER BY created_at DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Products</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container py-4">
  <h1>Products <a class="btn btn-sm btn-primary" href="products.php?action=add">Add New</a></h1>
  <?php if(isset($_GET['action']) && $_GET['action']=='add'): ?>
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="save_product" value="1">
      <div class="mb-2"><input name="name" class="form-control" placeholder="Name" required></div>
      <div class="mb-2"><textarea name="description" class="form-control" placeholder="Description"></textarea></div>
      <div class="mb-2"><input name="price" class="form-control" placeholder="Price" required></div>
      <div class="mb-2"><input name="stock" class="form-control" placeholder="Stock" required></div>
      <div class="mb-2"><input type="file" name="image" class="form-control"></div>
      <button class="btn btn-success">Save</button>
    </form>
  <?php else: ?>
    <table class="table">
      <thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach($products as $p): ?>
      <tr>
        <td><?php echo $p['id']; ?></td>
        <td><?php echo htmlspecialchars($p['name']); ?></td>
        <td>₹ <?php echo $p['price']; ?></td>
        <td><?php echo $p['stock']; ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="products.php?action=edit&id=<?php echo $p['id']; ?>">Edit</a>
          <a class="btn btn-sm btn-danger" href="products.php?action=delete&id=<?php echo $p['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body></html>
