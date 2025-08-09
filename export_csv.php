<?php
require_once __DIR__ . '/../includes/config.php';
if (!isset($_SESSION['admin_id'])){ header('Location: login.php'); exit; }

$rows = $pdo->query('SELECT * FROM parties ORDER BY id DESC')->fetchAll();
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="parties.csv"');
$out = fopen('php://output','w');
fputcsv($out, ['id','party_name','shop_name','address','contact_number','transaction_date','product_details','total_amount','payment_received']);
foreach($rows as $r) fputcsv($out, $r);
fclose($out);
