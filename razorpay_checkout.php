<?php
require_once __DIR__ . '/../includes/config.php';
// Minimal Razorpay test integration
use \Razorpay\Api\Api;

$order_id = $_GET['order_id'] ?? null;
if (!$order_id) { echo 'Invalid order'; exit; }

// Fetch order total
$stmt = $pdo->prepare("SELECT o.*, c.name FROM orders o LEFT JOIN customers c ON c.id=o.customer_id WHERE o.id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();
if (!$order) { echo 'Order not found'; exit; }

// We will generate a simple checkout using Razorpay Checkout script
$amount = $order['total_amount'] * 100; // in paise

// NOTE: For full production you should create an order via Razorpay API server-side.
// Here we show a simple client-side checkout using key id placeholder.
?>
<!doctype html><html><head><meta charset="utf-8"><title>Razorpay Checkout</title>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head><body>
<h2>Pay ₹<?php echo $order['total_amount']; ?></h2>
<button id="rzp-button">Pay Now</button>
<script>
var options = {
    "key": "<?php echo RAZORPAY_KEY; ?>",
    "amount": "<?php echo $amount; ?>",
    "currency": "INR",
    "name": "My Shop",
    "description": "Order #<?php echo $order['id']; ?>",
    "handler": function (response){
        // On success, you should verify payment server-side and update order.payment_status=Paid
        alert('Payment successful. Payment ID: ' + response.razorpay_payment_id + '. Now update DB manually or implement verification.');
        window.location.href = 'index.php?order=paid';
    },
    "prefill": {"name": "<?php echo htmlspecialchars($order['name']); ?>"}
};
document.getElementById('rzp-button').onclick = function(e){
    var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
}
</script>
</body></html>
