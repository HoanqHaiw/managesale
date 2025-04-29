-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 05:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myphamstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(12, 4, 2, 1, 100000.00),
(13, 5, 1, 1, 200000.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_status` enum('pending','processing','completed','cancelled') DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `fullname`, `address`, `phone`, `total_amount`, `order_status`, `order_date`) VALUES
(4, 7, 'Tuấn Hưng', 'Hải Phòng', '0389816563', 100000.00, 'processing', '2025-04-26 04:09:13'),
(5, 7, 'Tuấn Hưng', 'Hải Phòng', '0389816564', 200000.00, 'pending', '2025-04-29 02:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(150) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `category`, `image`) VALUES
(1, 'Áo thun nam cổ tròn basic', 200000.00, 'Ao', 'https://th.bing.com/th/id/OIF.vF9KknE4jYtBZmPEwOvmKA?rs=1&pid=ImgDetMain'),
(2, 'Áo phông Nike Authentic', 100000.00, 'Ao', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQS6mSdTSBJ352E7GoATzAn29pOWei4j-AMjg&s'),
(3, 'Quần jeans skinny rách gối', 150000.00, 'Quần', 'https://th.bing.com/th/id/OIP.XSXpjhmnWmj3XyJadvE0AAHaHa?rs=1&pid=ImgDetMain'),
(4, 'Quần short kaki nam', 180000.00, 'Quần', 'https://th.bing.com/th/id/OIP.1WndOG3djancsLMcHJ-jngHaHa?rs=1&pid=ImgDetMain'),
(5, 'Áo khoác bomber lót nỉ', 250000.00, 'Áo Đông', 'https://th.bing.com/th/id/OIP.JJTl4d1mwu6_vGM4iBtYzQHaHa?rs=1&pid=ImgDetMain'),
(6, 'Áo khoác gió chống nước', 120000.00, 'Áo Đông', 'https://down-vn.img.susercontent.com/file/vn-11134207-7r98o-lminvh7vse73d9'),
(7, 'Áo polo thể thao phối màu', 130000.00, 'Ao', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNJnceIhd-igTSDMPiS1Lf3VuI3tnEYR2hAg&s'),
(8, 'Áo hoodie unisex in hình', 170000.00, 'Ao', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQBOujbyRHttAnc43OEzyG7B_4qg74iE9AWjA&s'),
(9, 'Áo măng tô dạ dáng dài', 220000.00, 'Áo Đông', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiajmDd5jcv_FfcgzRR0BVvry7GTkGgHSiIQ&s'),
(10, 'Quần jogger thể thao bo gấu', 200000.00, 'Quần', 'https://th.bing.com/th/id/OIP.t6d0HHn7zAiy7gt0ttP8DAHaHa?rs=1&pid=ImgDetMain'),
(11, 'Áo Nike Sportswear Tech Fleece Windrunner', 4600000.00, 'Ao', 'https://sneakerdaily.vn/wp-content/uploads/2023/09/Ao-Nike-Sportswear-Tech-Fleece-Windrunner-Mens-Full-Zip-Grey.jpg'),
(12, 'Áo Tshirts Thời Trang New Era New York Yankees', 1500000.00, 'Ao', 'https://bizweb.dktcdn.net/thumb/1024x1024/100/413/756/products/image-1721973876522.png?v=1721975217107'),
(13, 'Quần Jeans Classic Monogram Stripe Jacquard', 2500000.00, 'Quần', 'https://product.hstatic.net/200000642007/product/50nyd_3ldpm0424_1_db0c018f3dc94d24bae271f2a96991f6_9ba8bd1d11df4c6ca560385f449b096d.jpg'),
(14, 'Quần MLB POCKET LETTERING SHORTS BOSTON RED SOX 31SP08031-43M', 265000.00, 'Quần', 'https://chiinstore.com/media/product/2041_634x634.png'),
(15, 'MLB - Áo khoác bomber Diamond Monogram', 4500000.00, 'Áo Đông', 'https://product.hstatic.net/200000642007/product/43bgs_3ajpm0224_1_fa0cfe51a12a4cffac6635c0663377c5_46204266e0674ebda2bcd45b751effbe_master.jpg'),
(16, 'MLB - Áo khoác bomber Diamond Monogram Jacquard MLB Việt Nam', 6000000.00, 'Áo Đông', 'https://product.hstatic.net/200000642007/product/50bks_3ajpm0224_2_9d24a78232464e6eb76a245bdb81ecc9_d576da32ba6b4ad983d96927c03cd372_master.jpg'),
(17, 'MLB - Áo khoác cardigan unisex cổ V tay dài Boston Red Sox', 5200000.00, 'Áo Đông', 'https://product.hstatic.net/200000642007/product/43crd_3akcm0344_1_a1ccd49f53e44c1aa40960a9676ad381_e9813271c2854399ba31690e2ff16f5f_master.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity_in_stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `product_id`, `quantity_in_stock`) VALUES
(1, 1, 50),
(2, 2, 30),
(3, 3, 25),
(4, 4, 40),
(5, 5, 15),
(6, 6, 20),
(7, 7, 35),
(8, 8, 28),
(9, 9, 12),
(10, 10, 22),
(11, 11, 8),
(12, 12, 18),
(13, 13, 10),
(14, 14, 14),
(15, 15, 5),
(16, 16, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('member','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `phone`, `email`, `password`, `role`) VALUES
(6, 'hoang hai', '0389816563', 'theanh@gmail.com', '$2y$10$mGYXUoWIkLXdo2nJCieKmOf0uFKBwaFUBp/e.YJ7k6HQFloTXGzw6', 'admin'),
(7, 'Tuấn Hưng', '0389816566', 'haih2482@gmail.com', '$2y$10$kwpp6xpxv8JAjjkVP88sjuOHB1iXP.vLxDwzLKeOgeYsM2/3dw5u6', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
