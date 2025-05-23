-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Máj 23. 15:04
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `real_estate`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `listings`
--

CREATE TABLE `listings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `city_area` varchar(100) DEFAULT NULL,
  `property_type` enum('house','apartment') NOT NULL,
  `rental_period` varchar(100) DEFAULT NULL,
  `rental_price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','rented') NOT NULL DEFAULT 'pending',
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `listings`
--

INSERT INTO `listings` (`id`, `user_id`, `title`, `description`, `city_area`, `property_type`, `rental_period`, `rental_price`, `image_url`, `status`, `is_visible`, `created_at`, `updated_at`) VALUES
(11, 1, 'Cozy apartment in downtown', 'A lovely 2-room apartment in the heart of the city.', 'Budapest - Belváros', 'apartment', 'monthly', 150000.00, 'images/apartment1.jpg', 'approved', 1, '2025-05-21 12:28:28', '2025-05-21 12:28:28'),
(12, 2, 'Spacious family house with garden', 'Perfect for a family, 4 bedrooms and a garden.', 'Debrecen - Újkert', 'house', 'monthly', 250000.00, 'images/house1.jpg', 'approved', 1, '2025-05-21 12:28:28', '2025-05-21 12:28:28'),
(13, 1, 'Small studio near university', 'Ideal for students, utilities included.', 'Szeged - Egyetemváros', 'apartment', 'monthly', 95000.00, 'images/studio.jpg', 'pending', 1, '2025-05-21 12:28:28', '2025-05-21 12:28:28');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `listing_id` int(11) NOT NULL,
  `renter_id` int(11) NOT NULL,
  `rental_start` date NOT NULL,
  `rental_end` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('guest','user','admin') NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `activation_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `first_name`, `last_name`, `phone`, `role`, `is_active`, `is_blocked`, `activation_token`, `reset_token`, `token_expiry`, `created_at`, `updated_at`) VALUES
(1, 'john_doe', 'john@example.com', 'hashedpassword1', 'John', 'Doe', '123456789', 'user', 1, 0, NULL, NULL, NULL, '2025-05-21 12:28:19', '2025-05-21 12:28:19'),
(2, 'jane_smith', 'jane@example.com', 'hashedpassword2', 'Jane', 'Smith', '987654321', 'user', 1, 0, NULL, NULL, NULL, '2025-05-21 12:28:19', '2025-05-21 12:28:19'),
(3, 'admin1', 'admin@example.com', 'hashedadmin', 'Admin', 'User', '555000111', 'admin', 1, 0, NULL, NULL, NULL, '2025-05-21 12:28:19', '2025-05-21 12:28:19');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listing_id` (`listing_id`),
  ADD KEY `renter_id` (`renter_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `listings`
--
ALTER TABLE `listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT a táblához `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `listings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`),
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`renter_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
