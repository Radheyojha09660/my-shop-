MyShop - Local XAMPP + Razorpay (test) package - README (हिंदी)

1) Requirements
   - XAMPP installed (Apache + MySQL)
   - PHP 7.4+

2) Steps
   a) Extract this package to: C:\xampp\htdocs\myshop  (Windows) or /opt/lampp/htdocs/myshop (Linux)
   b) Start Apache और MySQL via XAMPP control panel.
   c) Open phpMyAdmin (http://localhost/phpmyadmin) and import db.sql
   d) Open includes/config.php और DB credentials सही कर लें (default root with empty password)
   e) Razorpay के लिए आपकी Test API keys को includes/config.php में डालें:
      define('RAZORPAY_KEY', 'YOUR_RAZORPAY_KEY_ID');
      define('RAZORPAY_SECRET', 'YOUR_RAZORPAY_KEY_SECRET');
   f) Visit: http://localhost/myshop/public/index.php

3) Admin
   - Login page: http://localhost/myshop/admin/login.php
   - Default admin credentials: username: admin , password: admin123
     (पहली बार login के बाद password बदल दें)

4) Notes
   - Razorpay integration included as a simple client-side checkout (test). For production, create server-side orders & verify payments.
   - Uploads folder is writable and stores product images.
   - Change DB password and secure the site before production.
