CREATE DATABASE IF NOT EXISTS myshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE myshop;

CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  sku VARCHAR(100),
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  stock INT DEFAULT 0,
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  address TEXT,
  phone VARCHAR(50),
  email VARCHAR(150),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT,
  total_amount DECIMAL(10,2) NOT NULL,
  status ENUM('Pending','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  payment_method ENUM('Cash','Online') DEFAULT 'Cash',
  payment_status ENUM('Pending','Paid') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_id INT,
  quantity INT,
  price DECIMAL(10,2),
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

CREATE TABLE parties (
  id INT AUTO_INCREMENT PRIMARY KEY,
  party_name VARCHAR(255),
  shop_name VARCHAR(255),
  address TEXT,
  contact_number VARCHAR(50),
  transaction_date DATE,
  product_details TEXT,
  total_amount DECIMAL(10,2),
  payment_received ENUM('Yes','No') DEFAULT 'No',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin (username, password_hash) VALUES ('admin', '$2y$10$u1s1Gz1h9e/3d6YpMZyF6u6cQv1Qe8jZfXbYH9mOq1wKk3nAq7Z6');

INSERT INTO products (name, sku, description, price, stock, image) VALUES
('Sample Product A','SKU-A','यह एक नमूना प्रोडक्ट है।',100.00,10,''),
('Sample Product B','SKU-B','दूसरा नमूना प्रोडक्ट।',250.00,5,'');
