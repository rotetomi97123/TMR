-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Máj 28. 14:59
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
  `listing_type` varchar(50) NOT NULL,
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

INSERT INTO `listings` (`id`, `user_id`, `title`, `description`, `city_area`, `property_type`, `listing_type`, `rental_price`, `image_url`, `status`, `is_visible`, `created_at`, `updated_at`, `address`, `beds`, `bathroom`, `square_meters`) VALUES
(15, 2, 'Spacious house near Novi Sad', 'Perfect family house close to Novi Sad center.', 'Novi Sad', 'house', 'rent', 45000.00, 'https://i.ibb.co/4RsqvzZp/pexels-binyaminmellish-106399.jpg', 'approved', 1, '2025-05-25 19:54:07', '2025-05-28 08:31:47', 'Futoška 88,  NS', 2, 2, 120),
(18, 2, 'Modern apartment in Subotica', 'Close to all amenities.', 'Subotica', 'house', 'rent', 30000.00, 'https://i.ibb.co/spGJ0HMK/pexels-binyaminmellish-1396122.jpg', 'approved', 1, '2025-05-25 19:54:07', '2025-05-28 08:31:47', 'Maksima Gorkog 6,  SU', 3, 2, 130),
(25, 1, 'Modern apartment in Novi Sad', 'Bright apartment near city center, fully furnished.', 'Novi Sad', 'house', 'rent', 40000.00, 'https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg', 'approved', 1, '2025-05-20 10:15:00', '2025-05-28 08:31:47', 'Žarka Zrenjanina 15, Novi Sad', 2, 1, 70),
(26, 2, 'Cozy house in Subotica', 'Family house with garden and garage.', 'Subotica', 'house', 'rent', 55000.00, 'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg', 'approved', 1, '2025-05-21 14:30:00', '2025-05-28 08:31:47', 'Kralja Petra 22, Subotica', 3, 2, 130),
(27, 3, 'Studio apartment in Beograd', 'Affordable studio close to public transport.', 'Beograd', 'apartment', 'rent', 25000.00, 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=800&q=80', 'approved', 1, '2025-05-22 09:45:00', '2025-05-28 08:31:47', 'Bulevar Kralja Aleksandra 75, Beograd', 1, 1, 35),
(28, 1, 'Spacious house in Novi Sad', 'Ideal for families, large backyard.', 'Novi Sad', 'apartment', 'rent', 60000.00, 'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg', 'approved', 1, '2025-05-23 16:00:00', '2025-05-28 08:31:47', 'Rumenačka 18, Novi Sad', 4, 2, 180),
(29, 2, 'Apartment near Subotica center', 'Close to shops and public transport.', 'Subotica', 'apartment', 'rent', 38000.00, 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg', 'approved', 1, '2025-05-24 11:20:00', '2025-05-28 08:31:47', 'Josipa Jurja Strossmayera 9, Subotica', 2, 1, 60),
(30, 3, 'Modern apartment in Beograd', 'Luxury apartment with great city views.', 'Beograd', 'apartment', 'rent', 70000.00, 'https://images.pexels.com/photos/210617/pexels-photo-210617.jpeg', 'approved', 1, '2025-05-25 13:45:00', '2025-05-28 08:31:47', 'Savski Trg 5, Beograd', 3, 2, 95),
(31, 1, 'Moderan stan u Beogradu', 'Stan u centru grada, blizu svih sadržaja.', 'Beograd', 'apartment', 'rent', 60000.00, 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-28 08:31:47', 'Knez Mihailova 10, Beograd', 2, 1, 65),
(32, 2, 'Porodična kuća u Nišu', 'Mirna lokacija, idealna za porodicu.', 'Niš', 'house', 'rent', 40000.00, 'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-28 08:31:47', 'Bulevar Nemanjića 23, Niš', 3, 2, 110),
(33, 3, 'Luks stan u Novom Sadu', 'Luksuzan stan u novoj zgradi.', 'Novi Sad', 'apartment', 'rent', 70000.00, 'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-28 08:31:47', 'Bulevar Oslobođenja 45, Novi Sad', 2, 2, 75),
(34, 1, 'Kuća sa dvorištem u Subotici', 'Prostrana kuća sa velikim dvorištem.', 'Subotica', 'house', 'rent', 35000.00, 'https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-28 08:31:47', 'Horgoški put 12, Subotica', 4, 2, 150),
(35, 2, 'Stan u centru Kragujevca', 'Blizina univerziteta i autobuske stanice.', 'Kragujevac', 'apartment', 'rent', 28000.00, 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-28 08:31:47', 'Nikole Pašića 19, Kragujevac', 1, 1, 50),
(36, 3, 'Nov stan u Zrenjaninu', 'Renoviran stan sa novim nameštajem.', 'Zrenjanin', 'apartment', 'rent', 32000.00, 'https://images.pexels.com/photos/2102587/pexels-photo-2102587.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-28 08:31:47', 'Cara Dušana 14, Zrenjanin', 2, 1, 60),
(37, 1, 'Kuća u Somboru', 'Kuća sa velikim placem, pogodna za vikendicu.', 'Sombor', 'house', 'rent', 30000.00, 'https://images.pexels.com/photos/280229/pexels-photo-280229.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-28 08:31:47', 'Venac Petra Bojovića 5, Sombor', 3, 1, 140),
(38, 2, 'Mali stan u Pančevu', 'Idealno za par ili studenta.', 'Pančevo', 'apartment', 'rent', 20000.00, 'https://images.pexels.com/photos/1571459/pexels-photo-1571459.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-28 08:31:47', 'Trg Kralja Petra 8, Pančevo', 1, 1, 45),
(39, 3, 'Kuća u Leskovcu', 'Povoljna kuća na mirnoj lokaciji.', 'Leskovac', 'house', 'rent', 25000.00, 'https://images.pexels.com/photos/323775/pexels-photo-323775.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-28 08:31:47', 'Južnomoravskih brigada 3, Leskovac', 2, 1, 100),
(40, 1, 'Stan u Užicu', 'Stan sa pogledom na reku.', 'Užice', 'apartment', 'rent', 27000.00, 'https://images.pexels.com/photos/186077/pexels-photo-186077.jpeg', 'approved', 1, '2025-05-26 14:27:55', '2025-05-28 08:31:47', 'Nikole Tesle 1, Užice', 2, 1, 55),
(41, 1, 'Elegant Villa in Novi Sad', 'Spacious villa with modern amenities in a quiet neighborhood.', 'Novi Sad', 'house', 'sale', 28000000.00, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c', 'approved', 1, '2025-05-27 10:00:00', '2025-05-27 10:00:00', 'Fruskogorska 12, Novi Sad', 4, 3, 200),
(42, 2, 'Modern Apartment in Belgrade', 'Contemporary apartment located in the heart of the city.', 'Beograd', 'apartment', 'sale', 12500000.00, 'https://images.pexels.com/photos/259950/pexels-photo-259950.jpeg', 'approved', 1, '2025-05-27 11:00:00', '2025-05-28 10:07:43', 'Knez Mihailova 20, Belgrade', 2, 1, 85),
(43, 3, 'Cozy House in Niš', 'Charming house with a beautiful garden, perfect for families.', 'Niš', 'house', 'sale', 14500000.00, 'https://images.unsplash.com/photo-1572120360610-d971b9b6399e', 'approved', 1, '2025-05-27 12:00:00', '2025-05-27 12:00:00', 'Bulevar Nemanjića 45, Niš', 3, 2, 120),
(44, 1, 'Luxury Penthouse in Subotica', 'Penthouse offering panoramic views and top-notch facilities.', 'Subotica', 'apartment', 'sale', 21500000.00, 'https://images.pexels.com/photos/439391/pexels-photo-439391.jpeg', 'approved', 1, '2025-05-27 13:00:00', '2025-05-27 13:00:00', 'Korzo 5, Subotica', 3, 2, 150),
(45, 2, 'Family Home in Kragujevac', 'Spacious family home with a large backyard and garage.', 'Kragujevac', 'house', 'sale', 18000000.00, 'https://images.unsplash.com/photo-1568605114967-8130f3a36994', 'approved', 1, '2025-05-27 14:00:00', '2025-05-27 14:00:00', 'Svetozara Markovića 10, Kragujevac', 4, 2, 180),
(46, 3, 'Downtown Apartment in Pančevo', 'Modern apartment close to all amenities and public transport.', 'Pančevo', 'apartment', 'sale', 9000000.00, 'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg', 'approved', 1, '2025-05-27 15:00:00', '2025-05-27 15:00:00', 'Trg Kralja Petra 8, Pančevo', 2, 1, 90),
(47, 1, 'Rustic Cottage in Sombor', 'A peaceful retreat surrounded by nature, ideal for relaxation.', 'Sombor', 'house', 'sale', 9500000.00, 'https://images.unsplash.com/photo-1600585154205-2c2b6a4f7c5e', 'approved', 1, '2025-05-27 16:00:00', '2025-05-27 16:00:00', 'Venac Petra Bojovića 5, Sombor', 3, 1, 110),
(48, 2, 'Stylish Loft in Zrenjanin', 'Loft apartment with modern design and open space concept.', 'Zrenjanin', 'apartment', 'sale', 10200000.00, 'https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg', 'approved', 1, '2025-05-27 17:00:00', '2025-05-27 17:00:00', 'Cara Dušana 14, Zrenjanin', 2, 1, 95),
(49, 3, 'Traditional Home in Užice', 'Well-maintained traditional house with a spacious yard.', 'Užice', 'house', 'sale', 13000000.00, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c', 'approved', 1, '2025-05-27 18:00:00', '2025-05-27 18:00:00', 'Nikole Tesle 1, Užice', 3, 2, 130),
(50, 1, 'Compact Studio in Leskovac', 'Affordable studio apartment, perfect for singles or students.', 'Leskovac', 'apartment', 'sale', 5700000.00, 'https://images.pexels.com/photos/1571459/pexels-photo-1571459.jpeg', 'approved', 1, '2025-05-27 19:00:00', '2025-05-27 19:00:00', 'Južnomoravskih brigada 3, Leskovac', 1, 1, 45),
(51, 2, 'Duplex in Novi Beograd', 'Spacious duplex apartment near schools and shopping centers.', 'Beograd', 'apartment', 'sale', 15500000.00, 'https://images.unsplash.com/photo-1600585154095-7cde3c1f8b6e', 'approved', 1, '2025-05-28 10:00:00', '2025-05-28 10:07:43', 'Jurija Gagarina 76, Belgrade', 3, 2, 105),
(52, 1, 'House with Yard in Zemun', 'Renovated house with a private backyard and garage.', 'Beograd', 'house', 'sale', 19800000.00, 'https://images.pexels.com/photos/37347/house-dusk-evening-modern.jpg', 'approved', 1, '2025-05-28 10:10:00', '2025-05-28 10:07:43', 'Glavna 11, Zemun', 4, 2, 160),
(53, 3, 'Central Apartment in Čačak', 'Sunny apartment close to the city center, newly refurbished.', 'Čačak', 'apartment', 'sale', 8800000.00, 'https://images.pexels.com/photos/2089698/pexels-photo-2089698.jpeg', 'approved', 1, '2025-05-28 10:20:00', '2025-05-28 10:20:00', 'Gospodar Jovanova 7, Čačak', 2, 1, 75),
(54, 2, 'Townhouse in Jagodina', 'Well-maintained townhouse with attic space and garden.', 'Jagodina', 'house', 'sale', 12100000.00, 'https://images.unsplash.com/photo-1599423300746-b62533397364', 'approved', 1, '2025-05-28 10:30:00', '2025-05-28 10:30:00', 'Braće Dirak 4, Jagodina', 3, 2, 140),
(55, 1, 'Modern Flat in Novi Pazar', 'Newly built apartment with a balcony and private parking.', 'Novi Pazar', 'apartment', 'sale', 9300000.00, 'https://images.pexels.com/photos/1029599/pexels-photo-1029599.jpeg', 'approved', 1, '2025-05-28 10:40:00', '2025-05-28 10:40:00', 'Generala Živkovića 23, Novi Pazar', 2, 1, 78),
(56, 2, 'Family House in Vranje', 'Large family house with basement and green space.', 'Vranje', 'house', 'sale', 14200000.00, 'https://images.unsplash.com/photo-1560185127-6ed189bf08c5', 'approved', 1, '2025-05-28 10:50:00', '2025-05-28 10:50:00', 'Partizanska 9, Vranje', 4, 2, 170),
(57, 3, 'Compact Flat in Valjevo', 'Ideal for couples or singles, close to local amenities.', 'Valjevo', 'apartment', 'sale', 6100000.00, 'https://images.pexels.com/photos/1571457/pexels-photo-1571457.jpeg', 'approved', 1, '2025-05-28 11:00:00', '2025-05-28 11:00:00', 'Karađorđeva 18, Valjevo', 1, 1, 50),
(58, 1, 'House Near Danube in Smederevo', 'Beautiful location, near river walk and schools.', 'Smederevo', 'house', 'sale', 11700000.00, 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914', 'approved', 1, '2025-05-28 11:10:00', '2025-05-28 11:10:00', 'Dunavska 3, Smederevo', 3, 2, 135),
(59, 2, 'Luxury Apartment in Vršac', 'Top-floor apartment with two terraces and a great view.', 'Vršac', 'apartment', 'sale', 14300000.00, 'https://images.pexels.com/photos/1571463/pexels-photo-1571463.jpeg', 'approved', 1, '2025-05-28 11:20:00', '2025-05-28 11:20:00', 'Žarka Zrenjanina 12, Vršac', 3, 2, 100),
(60, 3, 'Affordable Home in Požarevac', 'Budget-friendly house needing some renovation.', 'Požarevac', 'house', 'sale', 7900000.00, 'https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg', 'approved', 1, '2025-05-28 11:30:00', '2025-05-28 11:30:00', 'Nemanjina 6, Požarevac', 2, 1, 95);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
