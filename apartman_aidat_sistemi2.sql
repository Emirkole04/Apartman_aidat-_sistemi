-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 Ara 2024, 16:39:22
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
(5, 2, 100, '2024-01-01', 'ödenmedi'),
(6, 2, 150, '2024-02-01', 'ödendi'),
(7, 3, 200, '2024-01-01', 'ödenmedi'),
(8, 3, 250, '2024-02-01', 'ödendi'),
(9, 4, 300, '2024-12-29', 'ödendi'),
(10, 5, 200, '2024-12-24', 'ödenmedi');

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
(5, 'Fatih', 'efe123', 'Yönetici', '45');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `users2`
--
ALTER TABLE `users2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
