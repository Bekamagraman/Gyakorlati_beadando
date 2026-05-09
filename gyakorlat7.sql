-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Máj 09. 22:42
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `gyakorlat7`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int(10) UNSIGNED NOT NULL,
  `csaladi_nev` varchar(45) NOT NULL DEFAULT '',
  `uto_nev` varchar(45) NOT NULL DEFAULT '',
  `bejelentkezes` varchar(12) NOT NULL DEFAULT '',
  `jelszo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `csaladi_nev`, `uto_nev`, `bejelentkezes`, `jelszo`) VALUES
(1, 'Családi_1', 'Utónév_1', 'Login1', 'd4b90f2dfafc736205a98bf3ae6541431bc77d8e'),
(2, 'Családi_2', 'Utónév_2', 'Login2', '6cf8efacae19431476020c1e2ebd2d8acca8f5c0'),
(3, 'Családi_3', 'Utónév_3', 'Login3', 'df4d8ad070f0d1585e172a2150038df5cc6c891a'),
(4, 'Családi_4', 'Utónév_4', 'Login4', 'b020c308c155d6bbd7eb7d27bd30c0573acbba5b'),
(5, 'Családi_5', 'Utónév_5', 'Login5', '9ab1a4743b30b5e9c037e6a645f0cfee80fb41d4'),
(6, 'Családi_6', 'Utónév_6', 'Login6', '7ca01f28594b1a06239b1d96fc716477d198470b'),
(7, 'Családi_7', 'Utónév_7', 'Login7', '41ad7e5406d8f1af2deef2ade4753009976328f8'),
(8, 'Családi_8', 'Utónév_8', 'Login8', '3a340fe3599746234ef89591e372d4dd8b590053'),
(9, 'Családi_9', 'Utónév_9', 'Login9', 'c0298f7d314ecbc5651da5679a0a240833a88238'),
(10, 'Családi_10', 'Utónév_10', 'Login10', 'a477427c183664b57f977661ac3167b64823f366'),
(11, 'Családi_11', 'Utónév_11', 'Login11', '6c7e2151d33968a02198f7e2073b1d7b9ee65ed9'),
(12, 'Családi_12', 'Utónév_12', 'Login12', '0722b3651be10eeb8df39cced958b74a98d18ce3'),
(27, 'Kincses', 'Ármin', 'asd', '$2y$10$OAXjtkp.8Tc7RhG8FWRMCulIrBqyB/ONt39jcvOnLQZtwL/4aWmim'),
(29, 'a', 'b', 'teszt4', '$2y$10$TQs6.bxs.bDBkARHuAMuiuaq/TPfH6xBmc/sVZi1/c9.cCb8PNeMG');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `megjegyzesek`
--

CREATE TABLE `megjegyzesek` (
  `id` int(10) UNSIGNED NOT NULL,
  `felhasznalo_id` int(10) UNSIGNED DEFAULT NULL,
  `tartalom` text NOT NULL,
  `letrehozva` datetime NOT NULL,
  `bejelentkezve` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- A tábla adatainak kiíratása `megjegyzesek`
--

INSERT INTO `megjegyzesek` (`id`, `felhasznalo_id`, `tartalom`, `letrehozva`, `bejelentkezve`) VALUES
(19, NULL, 'teszt1', '2026-05-09 21:32:49', 0),
(20, 27, 'teszt2', '2026-05-09 21:33:01', 1),
(21, 27, 'teszt3', '2026-05-09 22:40:38', 1),
(22, 29, 'teszt4', '2026-05-09 22:41:19', 1);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `megjegyzesek`
--
ALTER TABLE `megjegyzesek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_felhasznalo` (`felhasznalo_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT a táblához `megjegyzesek`
--
ALTER TABLE `megjegyzesek`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `megjegyzesek`
--
ALTER TABLE `megjegyzesek`
  ADD CONSTRAINT `fk_felhasznalo` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalok` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
