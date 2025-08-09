<?php
require_once __DIR__ . '/../includes/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: dashboard.php'); exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center"><div class="col-md-4">
    <h3>Admin Login</h3>
    <?php if(!empty($error)) echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>'; ?>
    <form method="post">
      <div class="mb-2"><input name="username" class="form-control" placeholder="Username" required></div>
      <div class="mb-2"><input name="password" type="password" class="form-control" placeholder="Password" required></div>
      <button class="btn btn-primary">Login</button>
    </form>
  </div></div>
</div>
</body></html>
