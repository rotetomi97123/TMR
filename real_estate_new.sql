-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2025 at 01:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `real_estate_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `transaction` enum('sale','rent') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `available_from` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `property_type_id` int(11) DEFAULT NULL,
  `is_active_property` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_id`, `user_id`, `title`, `description`, `address`, `city`, `zip_code`, `transaction`, `price`, `available_from`, `created_at`, `property_type_id`, `is_active_property`) VALUES
(1, 1, 'Modern Apartment in Belgrade', 'Modern apartment in the center of Belgrade with a great view.', 'Knez Mihailova 12', 'Belgrade', '11000', 'sale', 75000.00, '2025-07-15', '2025-02-01 06:00:00', 1, 0),
(2, 2, 'Family House in Novi Sad', 'Charming house with three bedrooms and a large backyard.', 'Futoška 45', 'Novi Sad', '21000', 'sale', 45000.00, '2025-07-20', '2025-02-02 07:00:00', 2, 0),
(3, 6, 'Luxury Studio for Rent', 'Furnished studio apartment with premium amenities.', 'Bulevar Oslobođenja 1', 'Niš', '18000', 'rent', 220.00, '2025-07-01', '2025-02-03 08:00:00', 3, 0),
(4, 7, 'Spacious Family House', 'Large house with 4 bedrooms, a basement, and a garage.', 'Zmaj Jovina 10', 'Subotica', '24000', 'sale', 55000.00, '2025-08-01', '2025-02-04 09:00:00', 2, 0),
(5, 10, 'Central Loft Apartment', 'Industrial-style loft with high ceilings and exposed brick.', 'Cara Dušana 202', 'Zrenjanin', '23000', 'rent', 350.00, '2025-07-10', '2025-02-05 10:00:00', 1, 0),
(6, 1, 'Studio on the Danube River', 'Small but charming studio just steps from the Danube.', 'Dunavska 15', 'Sremska Mitrovica', '22000', 'rent', 180.00, '2025-07-05', '2025-02-06 11:00:00', 3, 0),
(7, 2, 'Townhouse in Pančevo', 'Well-maintained house with access to pool and gym.', 'Vojvode Mišića 8', 'Pančevo', '26000', 'sale', 32000.00, '2025-08-15', '2025-02-07 12:00:00', 2, 0),
(8, 6, 'Historic House in Sombor', 'Restored historic house with modern upgrades.', 'Trg Svetog Trojstva 5', 'Sombor', '25000', 'sale', 120000.00, '2025-09-01', '2025-02-08 13:00:00', 2, 0),
(9, 7, 'New Build Apartment in Novi Sad', 'Luxury apartment with city view and concierge service.', 'Bulevar Evrope 7', 'Novi Sad', '21000', 'rent', 280.00, '2025-07-01', '2025-02-09 14:00:00', 1, 0),
(10, 10, 'Ground Floor Apartment with Garden', 'Apartment with private garden in a quiet neighborhood.', 'Petefi Šandora 21', 'Senta', '24400', 'rent', 190.00, '2025-07-15', '2025-02-10 15:00:00', 1, 0),
(15, 2, 'Spacious House in Novi Sad', 'Perfect family house close to the city center.', 'Futoška 88', 'Novi Sad', '21000', 'rent', 450.00, NULL, '2025-05-25 15:54:07', 2, 0),
(16, 14, 'Cozy Apartment in Vršac', 'Bright and cozy apartment near the city center, close to shops and park.', 'Nikole Pašića 8', 'Vršac', '26300', 'sale', 62000.00, '2025-07-25', '2025-07-05 13:30:00', 1, 0),
(17, 14, 'Detached House in Kikinda', 'Spacious house with garden and garage in a quiet neighborhood.', 'Žarka Zrenjanina 15', 'Kikinda', '23300', 'sale', 78000.00, '2025-08-10', '2025-07-05 13:45:00', 2, 0),
(18, 14, 'Modern Studio in Zaječar', 'Modern furnished studio ideal for singles or couples.', 'Kralja Petra 42', 'Zaječar', '19000', 'rent', 250.00, '2025-07-20', '2025-07-05 14:00:00', 3, 0),
(19, 14, 'Family House in Čačak', 'Large family house with a spacious yard and parking.', 'Dragačeva 12', 'Čačak', '32000', 'sale', 67000.00, '2025-08-01', '2025-07-05 14:15:00', 2, 0),
(20, 14, 'City Center Apartment in Užice', 'Fully furnished apartment close to main square and public transport.', 'Kralja Aleksandra 27', 'Užice', '31000', 'rent', 300.00, '2025-07-28', '2025-07-05 14:30:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_details`
--

CREATE TABLE `property_details` (
  `property_id` int(6) NOT NULL,
  `size` int(11) NOT NULL,
  `rooms` int(11) NOT NULL,
  `beds` int(11) DEFAULT NULL,
  `bathroom` int(11) DEFAULT NULL,
  `floor` int(11) DEFAULT NULL,
  `furnished` tinyint(1) NOT NULL,
  `heating_type` varchar(50) DEFAULT NULL,
  `parking` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_details`
--

INSERT INTO `property_details` (`property_id`, `size`, `rooms`, `beds`, `bathroom`, `floor`, `furnished`, `heating_type`, `parking`) VALUES
(15, 120, 2, 2, 1, NULL, 1, NULL, NULL),
(1, 850, 2, 2, 1, 12, 1, 'central', 1),
(2, 1800, 3, 3, 2, NULL, 0, 'forced air', 1),
(3, 550, 1, 1, 1, 5, 1, 'electric', 0),
(4, 2400, 4, 4, 2, NULL, 0, 'central', 1),
(5, 1100, 2, 2, 1, 8, 1, 'central', 1),
(6, 450, 1, 1, 1, 2, 1, 'electric', 0),
(7, 1600, 3, 3, 2, NULL, 0, 'forced air', 1),
(8, 2800, 5, 5, 3, NULL, 0, 'radiator', 1),
(9, 950, 2, 2, 1, 22, 1, 'central', 1),
(10, 750, 1, 1, 1, 1, 0, 'electric', 0),
(16, 850, 3, 2, 1, 4, 1, 'central', 1),
(17, 2000, 5, 4, 2, NULL, 0, 'gas', 1),
(18, 450, 1, 1, 1, 3, 1, 'electric', 0),
(19, 1800, 4, 3, 2, NULL, 0, 'central', 1),
(20, 700, 2, 2, 1, 5, 1, 'central', 0);

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `image_id` int(6) NOT NULL,
  `property_id` int(6) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_main` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`image_id`, `property_id`, `image_url`, `is_main`) VALUES
(1, 1, 'https://i.ibb.co/4RsqvzZp/pexels-binyaminmellish-106399.jpg', 1),
(2, 1, 'https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg', 0),
(3, 2, 'https://i.ibb.co/spGJ0HMK/pexels-binyaminmellish-1396122.jpg', 1),
(4, 2, 'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg', 0),
(5, 3, 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg', 1),
(6, 3, 'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg', 0),
(7, 4, 'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg', 1),
(8, 4, 'https://images.pexels.com/photos/210617/pexels-photo-210617.jpeg', 0),
(9, 5, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c', 1),
(10, 5, 'https://images.pexels.com/photos/259950/pexels-photo-259950.jpeg', 0),
(11, 6, 'https://images.unsplash.com/photo-1570129477492-45c003edd2be', 1),
(12, 6, 'https://images.pexels.com/photos/186077/pexels-photo-186077.jpeg', 0),
(13, 7, 'https://images.pexels.com/photos/280229/pexels-photo-280229.jpeg', 1),
(14, 7, 'https://images.pexels.com/photos/323775/pexels-photo-323775.jpeg', 0),
(16, 8, 'https://images.pexels.com/photos/439391/pexels-photo-439391.jpeg', 1),
(17, 9, 'https://images.unsplash.com/photo-1568605114967-8130f3a36994', 1),
(18, 9, 'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg', 0),
(19, 10, 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg', 1),
(20, 15, 'https://images.pexels.com/photos/2102587/pexels-photo-2102587.jpeg', 1),
(21, 16, 'https://images.unsplash.com/photo-1560448204-2f3b4b1eb85e', 1),
(22, 16, 'https://images.unsplash.com/photo-1501183638714-5c8c0e0bfe3e', 0),
(23, 17, 'https://images.pexels.com/photos/1643384/pexels-photo-1643384.jpeg', 1),
(24, 17, 'https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg', 0),
(25, 18, 'https://images.unsplash.com/photo-1502673530728-f79b4cab31b1', 1),
(26, 18, 'https://images.unsplash.com/photo-1494526585095-c41746248156', 0),
(27, 19, 'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg', 1),
(28, 19, 'https://images.pexels.com/photos/210617/pexels-photo-210617.jpeg', 0),
(29, 20, 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914', 1),
(30, 20, 'https://images.unsplash.com/photo-1572120360610-d971b9b6399e', 0);

-- --------------------------------------------------------

--
-- Table structure for table `property_types`
--

CREATE TABLE `property_types` (
  `property_type_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_types`
--

INSERT INTO `property_types` (`property_type_id`, `name`) VALUES
(1, 'apartment'),
(2, 'house'),
(3, 'studio');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('guest','user','admin') NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp(),
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `activation_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `phone`, `role`, `created_at`, `first_name`, `last_name`, `is_active`, `is_blocked`, `activation_token`, `reset_token`, `token_expiry`, `updated_at`) VALUES
(1, 'john_doe', 'john@example.com', 'hashedpassword1', '123456789', 'user', '2025-05-21 12:28:19', NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-07-05 09:55:54'),
(2, 'jane_smith', 'jane@example.com', 'hashedpassword2', '987654321', 'user', '2025-05-21 12:28:19', NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-07-05 09:55:54'),
(3, 'admin1', 'admin@example.com', 'hashedadmin', '555000111', 'admin', '2025-05-21 12:28:19', NULL, NULL, 1, 0, NULL, NULL, NULL, '2025-07-05 14:41:18'),
(4, 'sarah_williams', 'sarah@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0104', 'user', '2025-01-18 11:00:00', NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-07-05 09:55:54'),
(5, 'david_brown', 'david@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0105', 'admin', '2025-01-19 12:00:00', NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-07-05 09:55:54'),
(6, 'emily_davis', 'emily@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0106', 'user', '2025-01-20 13:00:00', NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-07-05 09:55:54'),
(7, 'robert_miller', 'robert@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0107', 'user', '2025-01-21 14:00:00', NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-07-05 09:55:54'),
(8, 'lisa_wilson', 'lisa@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0108', 'user', '2025-01-22 15:00:00', NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-07-05 09:55:54'),
(9, 'thomas_moore', 'thomas@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0109', 'user', '2025-01-23 16:00:00', NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-07-05 09:55:54'),
(10, 'jennifer_taylor', 'jennifer@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0110', 'user', '2025-01-24 17:00:00', NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-07-05 09:55:54'),
(14, 'rotetomi97123', 'tot.tamas04@gmail.com', '$2y$10$W4ctwmhScPj.3WQyARu2EewgVzSZmLo1a0PFHOWyJ33vvw1BU4Tq6', '06216216', 'admin', '2025-07-05 14:56:21', 'Tamas', 'Tothh', 1, 0, NULL, NULL, NULL, '2025-07-06 13:24:13'),
(15, 'brasnyokrisztian', 'krisztianbrasnyo@gmail.com', '$2y$10$dUzL7CjkKm6pRVtWcC4OFOvqXGXXVv5.gjQnO/pwIpmgVH.MY2UxK', '1234567890', 'admin', '2025-07-05 15:59:17', 'Krisztian', 'Brasnyo', 1, 0, NULL, NULL, NULL, '2025-07-05 16:02:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_property_type_id` (`property_type_id`);

--
-- Indexes for table `property_details`
--
ALTER TABLE `property_details`
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_types`
--
ALTER TABLE `property_types`
  ADD PRIMARY KEY (`property_type_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `image_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `property_types`
--
ALTER TABLE `property_types`
  MODIFY `property_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `fk_property_type_id` FOREIGN KEY (`property_type_id`) REFERENCES `property_types` (`property_type_id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `property_details`
--
ALTER TABLE `property_details`
  ADD CONSTRAINT `property_details_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`);

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
