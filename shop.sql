-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Haz 2024, 11:10:54
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
-- Veritabanı: `onlineshopuyelik`
--

DELIMITER $$
--
-- Yordamlar
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Urun_Ekleme` (IN `urunadi` VARCHAR(200) CHARSET utf8, IN `urunfiyati` INT, IN `urunsayisi` INT)   BEGIN
    INSERT INTO urunler (urunadi,urunfiyati,urunsayisi) VALUES (urunadi,urunfiyati,urunsayisi);
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Urun_Guncelleme` (IN `urunid1` INT, IN `urunadi1` VARCHAR(60), IN `urunfiyati1` INT, IN `urunsayisi1` INT)   BEGIN
 UPDATE urunler
 SET urunadi= urunadi1, urunfiyati= urunfiyati1,urunsayisi= urunsayisi1
 where urunid = urunid1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Urun_Silme` (IN `urunid2` INT)   BEGIN
    DELETE FROM `urunler`
    WHERE `urunid` = urunid2;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis`
--

CREATE TABLE `siparis` (
  `siparisid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `miktar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tetikleyiciler `siparis`
--
DELIMITER $$
CREATE TRIGGER `Siparis` AFTER INSERT ON `siparis` FOR EACH ROW BEGIN
 UPDATE urunler
 SET urunsayisi = urunsayisi  - miktar
 WHERE urunid = NEW.urunid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `urunid` int(11) NOT NULL,
  `urunadi` varchar(200) NOT NULL,
  `urunfiyati` int(50) NOT NULL,
  `urunsayisi` int(200) NOT NULL,
  `uruneklenmetarihi` datetime NOT NULL DEFAULT current_timestamp(),
  `resim` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`urunid`, `urunadi`, `urunfiyati`, `urunsayisi`, `uruneklenmetarihi`, `resim`) VALUES
(104, 'Kadın Bileklik', 20, 199, '2024-06-09 11:54:35', ''),
(105, 'Bileklik Mavi', 100, 25, '2024-06-09 12:07:28', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwordxd` varchar(75) NOT NULL,
  `sign_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwordxd`, `sign_date`) VALUES
(64, 'Mikleo18', 'seyupaltas02@gmail.com', '$2y$10$F9q5F4x6IUU3hYgNOjJiuuezKQ6fOdM6HdZ066X4/v8wf7z/TRCrm', '2024-06-01 21:10:12'),
(67, 'Mikleo19', 'seyupaltas02@gmail.com', '$2y$10$q7pWnsSqRFmsU5MsaItIrevtGF753KGhR9ohi6jM0ySKHTnjN.w/C', '2024-06-07 21:01:42'),
(68, 'RidvanKeskin', 'seyupaltas02@gmail.com', '$2y$10$f/SeSrr0JqLqVfsTLVMuPuRJBSd.WsGdHJjZby3b2aQkO1gU2ZBei', '2024-06-08 19:39:22'),
(69, 'Lisbeth18', 'seyupaltas02@gmail.com', '$2y$10$FtibWX0ooxuCgkiWVrIvAObro5NmvZLQDNSIhhwQv5hop1FQ.6FYu', '2024-06-09 11:57:25'),
(70, 'Lisbeth19', 'seyupaltas02@gmail.com', '$2y$10$EExs1Odtiq1mFebKgwU9EuUBL9gAH0m1dCZ3BLSvkvTxfzMRphRgK', '2024-06-09 12:00:59'),
(71, 'RidvanKeskin12', 'seyupaltas02@gmail.com', '$2y$10$eJ1xPc98pEA.5x6pGMjV6O0uF/wN7XYnskpAGHrqe1itXgBY4ynZy', '2024-06-09 12:06:21');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `siparis`
--
ALTER TABLE `siparis`
  ADD PRIMARY KEY (`siparisid`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`urunid`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `siparis`
--
ALTER TABLE `siparis`
  MODIFY `siparisid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `urunid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
