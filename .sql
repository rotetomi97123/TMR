-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Máj 26. 16:46
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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `address` text DEFAULT NULL,
  `beds` int(11) DEFAULT NULL,
  `bathroom` int(11) DEFAULT NULL,
  `square_meters` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `listings`
--

INSERT INTO `listings` (`id`, `user_id`, `title`, `description`, `city_area`, `property_type`, `rental_period`, `rental_price`, `image_url`, `status`, `is_visible`, `created_at`, `updated_at`, `address`, `beds`, `bathroom`, `square_meters`) VALUES
(15, 2, 'Spacious house near Novi Sad', 'Perfect family house close to Novi Sad center.', 'Novi Sad', 'house', 'monthly', 45000.00, 'https://i.ibb.co/4RsqvzZp/pexels-binyaminmellish-106399.jpg', 'approved', 1, '2025-05-25 19:54:07', '2025-05-26 12:27:03', 'Futoška 88,  NS', 2, 2, 120),
(18, 2, 'Modern apartment in Subotica', 'Close to all amenities.', 'Subotica', 'house', 'monthly', 30000.00, 'https://i.ibb.co/spGJ0HMK/pexels-binyaminmellish-1396122.jpg', 'approved', 1, '2025-05-25 19:54:07', '2025-05-26 13:29:41', 'Maksima Gorkog 6,  SU', 3, 2, 130),
(25, 1, 'Modern apartment in Novi Sad', 'Bright apartment near city center, fully furnished.', 'Novi Sad', 'house', 'monthly', 40000.00, 'https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg', 'approved', 1, '2025-05-20 10:15:00', '2025-05-26 13:38:29', 'Žarka Zrenjanina 15, Novi Sad', 2, 1, 70),
(26, 2, 'Cozy house in Subotica', 'Family house with garden and garage.', 'Subotica', 'house', 'monthly', 55000.00, 'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg', 'approved', 1, '2025-05-21 14:30:00', '2025-05-26 13:35:38', 'Kralja Petra 22, Subotica', 3, 2, 130),
(27, 3, 'Studio apartment in Beograd', 'Affordable studio close to public transport.', 'Beograd', 'apartment', 'monthly', 25000.00, 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=800&q=80', 'approved', 1, '2025-05-22 09:45:00', '2025-05-26 13:41:38', 'Bulevar Kralja Aleksandra 75, Beograd', 1, 1, 35),
(28, 1, 'Spacious house in Novi Sad', 'Ideal for families, large backyard.', 'Novi Sad', 'apartment', 'monthly', 60000.00, 'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg', 'approved', 1, '2025-05-23 16:00:00', '2025-05-26 13:38:24', 'Rumenačka 18, Novi Sad', 4, 2, 180),
(29, 2, 'Apartment near Subotica center', 'Close to shops and public transport.', 'Subotica', 'apartment', 'monthly', 38000.00, 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg', 'approved', 1, '2025-05-24 11:20:00', '2025-05-26 13:40:04', 'Josipa Jurja Strossmayera 9, Subotica', 2, 1, 60),
(30, 3, 'Modern apartment in Beograd', 'Luxury apartment with great city views.', 'Beograd', 'apartment', 'monthly', 70000.00, 'https://images.pexels.com/photos/210617/pexels-photo-210617.jpeg', 'approved', 1, '2025-05-25 13:45:00', '2025-05-26 13:40:27', 'Savski Trg 5, Beograd', 3, 2, 95),
(31, 1, 'Moderan stan u Beogradu', 'Stan u centru grada, blizu svih sadržaja.', 'Beograd', 'apartment', 'monthly', 60000.00, 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-26 14:27:55', 'Knez Mihailova 10, Beograd', 2, 1, 65),
(32, 2, 'Porodična kuća u Nišu', 'Mirna lokacija, idealna za porodicu.', 'Niš', 'house', 'monthly', 40000.00, 'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-26 14:27:55', 'Bulevar Nemanjića 23, Niš', 3, 2, 110),
(33, 3, 'Luks stan u Novom Sadu', 'Luksuzan stan u novoj zgradi.', 'Novi Sad', 'apartment', 'monthly', 70000.00, 'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-26 14:27:55', 'Bulevar Oslobođenja 45, Novi Sad', 2, 2, 75),
(34, 1, 'Kuća sa dvorištem u Subotici', 'Prostrana kuća sa velikim dvorištem.', 'Subotica', 'house', 'monthly', 35000.00, 'https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-26 14:27:55', 'Horgoški put 12, Subotica', 4, 2, 150),
(35, 2, 'Stan u centru Kragujevca', 'Blizina univerziteta i autobuske stanice.', 'Kragujevac', 'apartment', 'monthly', 28000.00, 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-26 14:27:55', 'Nikole Pašića 19, Kragujevac', 1, 1, 50),
(36, 3, 'Nov stan u Zrenjaninu', 'Renoviran stan sa novim nameštajem.', 'Zrenjanin', 'apartment', 'monthly', 32000.00, 'https://images.pexels.com/photos/2102587/pexels-photo-2102587.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-26 14:27:55', 'Cara Dušana 14, Zrenjanin', 2, 1, 60),
(37, 1, 'Kuća u Somboru', 'Kuća sa velikim placem, pogodna za vikendicu.', 'Sombor', 'house', 'monthly', 30000.00, 'https://images.pexels.com/photos/280229/pexels-photo-280229.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-26 14:27:55', 'Venac Petra Bojovića 5, Sombor', 3, 1, 140),
(38, 2, 'Mali stan u Pančevu', 'Idealno za par ili studenta.', 'Pančevo', 'apartment', 'monthly', 20000.00, 'https://images.pexels.com/photos/1571459/pexels-photo-1571459.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-26 14:27:55', 'Trg Kralja Petra 8, Pančevo', 1, 1, 45),
(39, 3, 'Kuća u Leskovcu', 'Povoljna kuća na mirnoj lokaciji.', 'Leskovac', 'house', 'monthly', 25000.00, 'https://images.pexels.com/photos/323775/pexels-photo-323775.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-26 14:27:55', 'Južnomoravskih brigada 3, Leskovac', 2, 1, 100),
(40, 1, 'Stan u Užicu', 'Stan sa pogledom na reku.', 'Užice', 'apartment', 'monthly', 27000.00, 'https://images.pexels.com/photos/186077/pexels-photo-186077.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-26 14:27:55', 'Nikole Tesle 1, Užice', 2, 1, 55);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
