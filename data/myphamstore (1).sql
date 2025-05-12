-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 11:29 AM
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
  `size` varchar(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `size`, `quantity`) VALUES
(18, 8, 3, 'L', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`order_detail_id`, `order_id`, `product_id`, `size`, `quantity`, `price`) VALUES
(12, 4, 2, NULL, 1, 100000.00),
(13, 5, 1, NULL, 1, 200000.00),
(14, 6, 2, NULL, 1, 100000.00),
(15, 7, 1, NULL, 1, 200000.00),
(16, 8, NULL, NULL, 2, 100000.00),
(17, 9, 1, NULL, 1, 200000.00),
(20, 12, 11, NULL, 3, 4600000.00),
(21, 13, 1, NULL, 1, 800000.00),
(22, 14, 7, NULL, 1, 1300000.00),
(23, 14, 2, NULL, 1, 750000.00);

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
(4, 7, 'Tuấn Hưng', 'Hải Phòng', '0389816563', 100000.00, 'completed', '2025-04-26 04:09:13'),
(5, 7, 'Tuấn Hưng', 'Hải Phòng', '0389816564', 200000.00, 'pending', '2025-04-29 02:06:10'),
(6, 7, 'Tuấn Hưng', 'Hải Phòng', '0389816563', 100000.00, 'pending', '2025-05-05 10:20:43'),
(7, 7, 'hoang hai', 'hà nội', '0388411512', 200000.00, 'pending', '2025-05-05 10:22:33'),
(8, 7, 'Tuấn Hưng', 'Đà Nẵng', '0388411512', 100000.00, 'pending', '2025-05-07 15:50:58'),
(9, 7, 'Tuấn Hưng', 'Đà Nẵng', '0389816564', 200000.00, 'processing', '2025-05-08 10:28:37'),
(10, 8, 'Ha Nguyen', 'Hải Phòng', '0389816566', 0.00, 'cancelled', '2025-05-11 05:21:42'),
(11, 7, 'Tran Xuan Dat', 'Bac Giang', '55', 0.00, 'cancelled', '2025-05-12 08:48:01'),
(12, 7, 'Tran Xuan Dat', 'Bac Giang', '0373847707', 13800000.00, 'completed', '2025-05-12 08:52:41'),
(13, 7, 'Justin', 'Phu Cat', '0389816563', 800000.00, 'completed', '2025-05-12 08:55:01'),
(14, 7, 'Phi Huu Phong', 'Yen Noi', '04012004', 2050000.00, 'completed', '2025-05-12 08:57:24');

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
(1, 'Áo Phông MLB Logo Chữ LA 3ATSM1133-07CBL Màu Xanh Blue', 700000.00, 'Ao', 'https://bizweb.dktcdn.net/100/479/837/products/ao-thun-mlb-logo-t-shirts-la-dodgers-3atsm1133-07cbl-jpg-1678265959-08032023155919-1680580974647.jpg?v=1688704193757'),
(2, 'MLB - Áo thun unisex cổ tròn tay ngắn Basic Mega Logo', 750000.00, 'Ao', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSbeUPcQnPx5xDZtVyIdzX7ONQJsXbHS5L2Mw&s'),
(3, 'MLB - Quần jeans nam ống rộng phối họa tiết monogram', 2500000.00, 'Quần', 'https://product.hstatic.net/200000642007/product/50ins_3fdpb0141_1_48616a2a2c944db2be5de90f0a12bc96_master.jpg'),
(4, 'MLB - Quần jeans nam ống rộng phối logo thời trang Style Code: 3FDPR0134', 180000.00, 'Quần', 'https://product.hstatic.net/200000642007/product/50ins_3fdpr0134_1_4eca0efb2328416d9f63a53eafc50157_218b47255c274a04a031934fb7717bb5_master.jpg'),
(5, 'Áo khoác phao MLB New York Yankees 3ADJI0126-50NYD xanh navy', 250000.00, 'Áo Đông', 'https://chiaki.vn/upload/product/2022/09/ao-khoac-phao-mlb-new-york-yankees-3adji0126-50nyd-xanh-navy-631aa0b83acde-09092022091104.jpg'),
(6, 'Áo Khoác MLB Varsity Shoulder Block Heavy Short Down New York Yankees', 1200000.00, 'Áo Đông', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTmKsmWlZbPpg5-UNrkVKCE6r4PnCnKG9_OMw&s'),
(7, 'Áo thun MLB Classic Monogram T-Shirts Boston Red Sox 3ATSM1133-43SAL', 1300000.00, 'Ao', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRpUhncRthBrOKSblOkH8Cxg7bK2chqHUXnCw&s'),
(8, 'Áo hoodie unisex in hình', 170000.00, 'Ao', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQBOujbyRHttAnc43OEzyG7B_4qg74iE9AWjA&s'),
(9, 'MLB - Áo khoác thể thao unisex Classic Monogram', 2200000.00, 'Áo Đông', 'https://product.hstatic.net/200000642007/product/50bks_3atrm0134_1_3c461f017e484e9abf24e5b02017f596_9405119c11e64d6cb47a6ea25f04b2cb_master.jpg'),
(10, 'Quần Shorts MLB Classic Monogram Front Panel Pattern 5 Woven Boston Red Sox L.Beige ', 200000.00, 'Quần', 'https://bizweb.dktcdn.net/100/446/974/products/quan-short-mlb-basic-big-small-logo-5-shorts-new-york-yankees-black-3aspb0133-50bks-1.jpg?v=1687066867150'),
(11, 'Áo Nike Sportswear Tech Fleece Windrunner', 4600000.00, 'Ao', 'https://sneakerdaily.vn/wp-content/uploads/2023/09/Ao-Nike-Sportswear-Tech-Fleece-Windrunner-Mens-Full-Zip-Grey.jpg'),
(12, 'Áo Tshirts Thời Trang New Era New York Yankees', 1500000.00, 'Ao', 'https://bizweb.dktcdn.net/thumb/1024x1024/100/413/756/products/image-1721973876522.png?v=1721975217107'),
(13, 'Quần Jeans Classic Monogram Stripe Jacquard', 2500000.00, 'Quần', 'https://product.hstatic.net/200000642007/product/50nyd_3ldpm0424_1_db0c018f3dc94d24bae271f2a96991f6_9ba8bd1d11df4c6ca560385f449b096d.jpg'),
(14, 'Quần MLB POCKET LETTERING SHORTS BOSTON RED SOX 31SP08031-43M', 265000.00, 'Quần', 'https://chiinstore.com/media/product/2041_634x634.png'),
(15, 'MLB - Áo khoác bomber Diamond Monogram', 4500000.00, 'Áo Đông', 'https://product.hstatic.net/200000642007/product/43bgs_3ajpm0224_1_fa0cfe51a12a4cffac6635c0663377c5_46204266e0674ebda2bcd45b751effbe_master.jpg'),
(16, 'MLB - Áo khoác bomber Diamond Monogram Jacquard MLB Việt Nam', 6000000.00, 'Áo Đông', 'https://product.hstatic.net/200000642007/product/50bks_3ajpm0224_2_9d24a78232464e6eb76a245bdb81ecc9_d576da32ba6b4ad983d96927c03cd372_master.jpg'),
(17, 'MLB - Áo khoác cardigan unisex cổ V tay dài Boston Red Sox', 5200000.00, 'Áo Đông', 'https://product.hstatic.net/200000642007/product/43crd_3akcm0344_1_a1ccd49f53e44c1aa40960a9676ad381_e9813271c2854399ba31690e2ff16f5f_master.jpg'),
(18, 'Áo Nỉ MLB Diamond Monogram Jacquard Overfit Sweatshirt New York Yankees', 1500000.00, 'Áo Đông', 'https://caostore.vn/wp-content/uploads/2022/08/z3682032679769-466715f5c1b8cc9fe335db6f10c5fd3f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity_in_stock` int(11) DEFAULT 0,
  `size` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `product_id`, `quantity_in_stock`, `size`) VALUES
(1, 1, 48, 'S'),
(2, 2, 29, 'M'),
(3, 3, 25, 'L'),
(4, 4, 40, 'XL'),
(5, 5, 15, 'S'),
(6, 6, 20, 'M'),
(7, 7, 34, 'L'),
(8, 8, 28, 'XL'),
(9, 9, 12, 'S'),
(10, 10, 22, 'M'),
(11, 11, 5, 'L'),
(12, 12, 18, 'XL'),
(13, 13, 10, 'S'),
(14, 14, 14, 'M'),
(15, 15, 5, 'L'),
(16, 16, 3, 'XL'),
(17, 1, 52, 'S'),
(18, 1, 48, 'M'),
(19, 1, 48, 'L'),
(20, 2, 29, 'S'),
(21, 2, 29, 'M'),
(22, 2, 29, 'L'),
(23, 3, 25, 'S'),
(24, 3, 25, 'M'),
(25, 3, 25, 'L'),
(26, 4, 40, 'S'),
(27, 4, 40, 'M'),
(28, 4, 40, 'L'),
(29, 5, 15, 'S'),
(30, 5, 15, 'M'),
(31, 5, 15, 'L'),
(32, 6, 20, 'S'),
(33, 6, 20, 'M'),
(34, 6, 20, 'L'),
(35, 7, 34, 'S'),
(36, 7, 34, 'M'),
(37, 7, 34, 'L'),
(38, 8, 28, 'S'),
(39, 8, 28, 'M'),
(40, 8, 28, 'L'),
(41, 9, 12, 'S'),
(42, 9, 12, 'M'),
(43, 9, 12, 'L'),
(44, 10, 22, 'S'),
(45, 10, 22, 'M'),
(46, 10, 22, 'L'),
(47, 11, 5, 'S'),
(48, 11, 5, 'M'),
(49, 11, 5, 'L'),
(50, 12, 6, 'S'),
(51, 12, 6, 'M'),
(52, 12, 6, 'L'),
(53, 13, 10, 'S'),
(54, 13, 10, 'M'),
(55, 13, 10, 'L'),
(56, 14, 10, 'S'),
(57, 14, 10, 'M'),
(58, 14, 10, 'L'),
(59, 15, 5, 'S'),
(60, 15, 5, 'M'),
(61, 15, 5, 'L'),
(62, 16, 3, 'S'),
(63, 16, 3, 'M'),
(64, 16, 3, 'L'),
(65, 18, 20, 'S'),
(66, 18, 15, 'M'),
(67, 18, 10, 'L'),
(68, 18, 45, 'XL');

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
(7, 'Tuấn Hưng', '0389816566', 'haih2482@gmail.com', '$2y$10$kwpp6xpxv8JAjjkVP88sjuOHB1iXP.vLxDwzLKeOgeYsM2/3dw5u6', 'member'),
(8, 'Ha Nguyen', '0389816566', 'hairius@gmail.com', '$2y$10$FmMjBXIlr/gMWlemP/0iAO1FNn.ai6FcK90c/SEaFkwjqlqqA3.di', 'member');

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
