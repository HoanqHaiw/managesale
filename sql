CREATE DATABASE myphamstore;
USE myphamstore;

CREATE TABLE users (
    user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100),
    phone VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('member', 'admin')
);

CREATE TABLE products (
    product_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(150),
    product_price DECIMAL(10,2),
    category VARCHAR(100),
    image VARCHAR(255)
);

CREATE TABLE cart (
    cart_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    product_id INT(11),
    quantity INT(11),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

CREATE TABLE orders (
    order_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    fullname VARCHAR(100),
    address TEXT,
    phone VARCHAR(15),
    total_amount DECIMAL(10,2),
    order_status ENUM('pending', 'processing', 'completed', 'cancelled'),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE orderdetails (
    order_detail_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    order_id INT(11),
    product_id INT(11),
    quantity INT(11),
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

CREATE TABLE payments (
    payment_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    fullname VARCHAR(100),
    address TEXT,
    phone VARCHAR(15),
    total_amount DECIMAL(10,2),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
