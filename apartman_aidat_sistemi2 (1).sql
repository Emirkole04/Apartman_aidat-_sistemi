-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 11 Oca 2025, 15:41:33
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `apartman_aidat_sistemi2`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aidatlar2`
--

CREATE TABLE `aidatlar2` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `due_date` date NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `aidatlar2`
--

INSERT INTO `aidatlar2` (`id`, `user_id`, `amount`, `due_date`, `status`) VALUES
(18, 20, 1000, '2025-01-30', 'ödenmedi'),
(19, 20, 1000, '2025-03-02', 'ödenmedi'),
(20, 20, 1000, '2025-03-30', 'ödenmedi'),
(21, 20, 1000, '2025-04-30', 'ödenmedi'),
(22, 20, 1000, '2025-05-30', 'ödenmedi'),
(23, 20, 1000, '2025-06-30', 'ödenmedi'),
(24, 20, 1000, '2025-07-30', 'ödenmedi'),
(25, 20, 1000, '2025-08-30', 'ödenmedi'),
(26, 20, 1000, '2025-09-30', 'ödenmedi'),
(27, 20, 1000, '2025-10-30', 'ödenmedi'),
(28, 20, 1000, '2025-11-30', 'ödenmedi'),
(29, 20, 1000, '2025-12-30', 'ödenmedi'),
(30, 1, 800, '2025-01-15', 'ödendi'),
(31, 1, 800, '2025-02-15', 'ödenmedi'),
(32, 1, 800, '2025-03-15', 'ödenmedi'),
(33, 1, 800, '2025-04-15', 'ödenmedi'),
(34, 1, 800, '2025-05-15', 'ödenmedi'),
(35, 1, 800, '2025-06-15', 'ödenmedi'),
(36, 1, 800, '2025-07-15', 'ödenmedi'),
(37, 1, 800, '2025-08-15', 'ödenmedi'),
(38, 1, 800, '2025-09-15', 'ödenmedi'),
(39, 1, 800, '2025-10-15', 'ödenmedi'),
(40, 1, 800, '2025-11-15', 'ödenmedi'),
(41, 1, 800, '2025-12-15', 'ödenmedi'),
(42, 2, 750, '2025-01-27', 'ödendi'),
(43, 2, 750, '2025-02-27', 'ödenmedi'),
(44, 2, 750, '2025-03-27', 'ödenmedi'),
(45, 2, 750, '2025-04-27', 'ödenmedi'),
(46, 2, 750, '2025-05-27', 'ödenmedi'),
(47, 2, 750, '2025-06-27', 'ödenmedi'),
(48, 2, 750, '2025-07-27', 'ödenmedi'),
(49, 2, 750, '2025-08-27', 'ödenmedi'),
(50, 2, 750, '2025-09-27', 'ödenmedi'),
(51, 2, 750, '2025-10-27', 'ödenmedi'),
(52, 2, 750, '2025-11-27', 'ödenmedi'),
(53, 2, 750, '2025-12-27', 'ödenmedi'),
(54, 3, 800, '2025-01-20', 'ödendi'),
(55, 3, 800, '2025-02-20', 'ödenmedi'),
(56, 3, 800, '2025-03-20', 'ödenmedi'),
(57, 3, 800, '2025-04-20', 'ödenmedi'),
(58, 3, 800, '2025-05-20', 'ödenmedi'),
(59, 3, 800, '2025-06-20', 'ödenmedi'),
(60, 3, 800, '2025-07-20', 'ödenmedi'),
(61, 3, 800, '2025-08-20', 'ödenmedi'),
(62, 3, 800, '2025-09-20', 'ödenmedi'),
(63, 3, 800, '2025-10-20', 'ödenmedi'),
(64, 3, 800, '2025-11-20', 'ödenmedi'),
(65, 3, 800, '2025-12-20', 'ödenmedi'),
(66, 4, 900, '2025-01-25', 'ödendi'),
(67, 4, 900, '2025-02-25', 'ödenmedi'),
(68, 4, 900, '2025-03-25', 'ödenmedi'),
(69, 4, 900, '2025-04-25', 'ödenmedi'),
(70, 4, 900, '2025-05-25', 'ödenmedi'),
(71, 4, 900, '2025-06-25', 'ödenmedi'),
(72, 4, 900, '2025-07-25', 'ödenmedi'),
(73, 4, 900, '2025-08-25', 'ödenmedi'),
(74, 4, 900, '2025-09-25', 'ödenmedi'),
(75, 4, 900, '2025-10-25', 'ödenmedi'),
(76, 4, 900, '2025-11-25', 'ödenmedi'),
(77, 4, 900, '2025-12-25', 'ödenmedi'),
(102, 21, 1200, '2025-03-25', 'ödendi'),
(103, 21, 1200, '2025-04-25', 'ödenmedi'),
(104, 21, 1200, '2025-05-25', 'ödenmedi'),
(105, 21, 1200, '2025-06-25', 'ödenmedi'),
(106, 21, 1200, '2025-07-25', 'ödenmedi'),
(107, 21, 1200, '2025-08-25', 'ödenmedi'),
(108, 21, 1200, '2025-09-25', 'ödenmedi'),
(109, 21, 1200, '2025-10-25', 'ödenmedi'),
(110, 21, 1200, '2025-11-25', 'ödenmedi'),
(111, 21, 1200, '2025-12-25', 'ödenmedi'),
(112, 21, 1200, '2026-01-25', 'ödenmedi'),
(113, 21, 1200, '2026-02-25', 'ödenmedi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users2`
--

CREATE TABLE `users2` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `daire_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users2`
--

INSERT INTO `users2` (`id`, `username`, `password`, `role`, `daire_no`) VALUES
(1, 'Emir', '1234', 'Yönetici', '56'),
(2, 'Efe', 'abcd', 'Kiracı', '45'),
(3, 'Davut', '5678', 'Kiracı', '12'),
(4, 'Bedriye', 'emir123', 'Kiracı', '34'),
(20, 'Melike', '5678', 'Kiracı', '54'),
(21, 'Fatih', 'admin', 'Yönetici', '2');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `aidatlar2`
--
ALTER TABLE `aidatlar2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `users2`
--
ALTER TABLE `users2`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `aidatlar2`
--
ALTER TABLE `aidatlar2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- Tablo için AUTO_INCREMENT değeri `users2`
--
ALTER TABLE `users2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `aidatlar2`
--
ALTER TABLE `aidatlar2`
  ADD CONSTRAINT `aidatlar2_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users2` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
