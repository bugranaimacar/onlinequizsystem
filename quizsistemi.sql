-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 10 Ara 2020, 13:07:48
-- Sunucu sürümü: 10.4.17-MariaDB
-- PHP Sürümü: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `quizsistemi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `answers`
--

CREATE TABLE `answers` (
  `answerid` int(11) NOT NULL,
  `answerto` int(12) DEFAULT NULL,
  `answerby` varchar(24) DEFAULT NULL,
  `answer` varchar(4096) DEFAULT ' '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `answers`
--

INSERT INTO `answers` (`answerid`, `answerto`, `answerby`, `answer`) VALUES
(16, 11, 'admin', '\"answer1\":\"A\",\"answer2\":\"A\",\"answer3\":\"A\",\"answer4\":\"A\",\"answer5\":\"A\",'),
(17, 11, 'evrimhoca', '\"answer1\":\"E\",\"answer2\":\"E\",\"answer3\":\"E\",\"answer4\":\"E\",\"answer5\":\"A\",'),
(21, 11, 'naim', ' \"answer1\":\"A\",\"answer2\":\"B\",\"answer3\":\"C\",\"answer4\":\"D\",\"answer5\":\"A\",');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exams`
--

CREATE TABLE `exams` (
  `examid` int(11) NOT NULL,
  `questioncount` int(6) NOT NULL DEFAULT 5,
  `startdate` timestamp(1) NULL DEFAULT current_timestamp(1),
  `deadline` timestamp(1) NULL DEFAULT current_timestamp(1),
  `answerkey` varchar(512) NOT NULL DEFAULT 'AAAAA',
  `active` int(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `exams`
--

INSERT INTO `exams` (`examid`, `questioncount`, `startdate`, `deadline`, `answerkey`, `active`) VALUES
(11, 5, '2020-12-08 14:00:00.0', '2020-12-12 19:00:00.0', 'AAAAA', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `results`
--

CREATE TABLE `results` (
  `resultid` int(11) NOT NULL,
  `examid` int(24) DEFAULT NULL,
  `answerby` varchar(24) NOT NULL DEFAULT '',
  `correct` int(6) DEFAULT 0,
  `wrong` int(6) NOT NULL DEFAULT 0,
  `empty` int(6) NOT NULL DEFAULT 0,
  `score` varchar(6) NOT NULL DEFAULT '0',
  `report` varchar(2048) NOT NULL DEFAULT 'No Info'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `results`
--

INSERT INTO `results` (`resultid`, `examid`, `answerby`, `correct`, `wrong`, `empty`, `score`, `report`) VALUES
(25, 11, 'admin', 5, 0, 0, '20', ''),
(26, 11, 'evrimhoca', 1, 4, 0, '0', '1 - E (Correct: A) 2 - E (Correct: A) 3 - E (Correct: A) 4 - E (Correct: A) '),
(30, 11, 'naim', 2, 3, 0, '5', '2 - B (Correct: A) 3 - C (Correct: A) 4 - D (Correct: A) ');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(24) NOT NULL DEFAULT '',
  `password` varchar(24) NOT NULL DEFAULT '',
  `isadmin` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `isadmin`) VALUES
(1, 'admin', '123456', 1),
(2, 'naim', '123456', 0),
(11, 'evrimhoca', '123456', 1),
(12, 'hamza', '123456', 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answerid`);

--
-- Tablo için indeksler `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`examid`);

--
-- Tablo için indeksler `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`resultid`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `answers`
--
ALTER TABLE `answers`
  MODIFY `answerid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `exams`
--
ALTER TABLE `exams`
  MODIFY `examid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `results`
--
ALTER TABLE `results`
  MODIFY `resultid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
