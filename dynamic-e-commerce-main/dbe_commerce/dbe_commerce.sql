-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table dbe_commerce.admin: ~1 rows (approximately)
INSERT INTO `admin` (`login`) VALUES
	('root');

-- Dumping data for table dbe_commerce.cat: ~5 rows (approximately)
INSERT INTO `cat` (`cat_id`, `name`) VALUES
	(1, 'Appetizer'),
	(2, 'Dessert'),
	(3, 'Main course'),
	(4, 'Drinks'),
	(5, 'Sides');

-- Dumping data for table dbe_commerce.itm: ~22 rows (approximately)
INSERT INTO `itm` (`itm_id`, `name`, `stock`, `price`) VALUES
	(1, 'Garlic Bread', 34, 299),
	(2, 'Cheese Stick', 17, 70),
	(3, 'Pretzel', 14, 120),
	(4, 'Mini Burger', 15, 470),
	(5, 'Fish Cake', 45, 150),
	(6, 'String Beans', 13, 230),
	(7, 'California Roll', 46, 600),
	(15, 'Bulalo', 20, 1300),
	(23, 'Donut', 13, 550),
	(24, 'Adobong Manok', 7, 499),
	(25, 'Banana Split', 12, 270),
	(26, 'Halo-halo', 11, 250),
	(29, 'Kare kare', 13, 999),
	(32, 'Mango Graham', 12, 210),
	(35, 'Coke Zero', 20, 70),
	(36, 'Sinigang na Baboy', 6, 600),
	(37, 'Garlic Bread', 39, 90),
	(38, 'Sundae', 10, 110),
	(39, 'Mango Shake', 15, 99),
	(40, 'Iced Tea', 26, 70),
	(41, 'Watermelon Shake', 39, 99),
	(42, 'Kimchi', 30, 150);

-- Dumping data for table dbe_commerce.itm_cat: ~24 rows (approximately)
INSERT INTO `itm_cat` (`itm_id`, `cat_id`) VALUES
	(5, 5),
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(6, 5),
	(7, 5),
	(22, 5),
	(23, 1),
	(24, 3),
	(25, 2),
	(26, 2),
	(29, 3),
	(15, 3),
	(32, 2),
	(34, 5),
	(35, 4),
	(36, 3),
	(37, 1),
	(38, 2),
	(39, 4),
	(40, 4),
	(41, 4),
	(42, 5);

-- Dumping data for table dbe_commerce.usr: ~2 rows (approximately)
INSERT INTO `usr` (`login`, `name`, `surname`, `email`, `passwd`) VALUES
	('maimai', 'Mai', 'Mai', 'hafa@mail.com', 'c1ddeeaabf03bc4721082018a8c2f31b1bc952b0'),
	('Soki', 'Sopi', 'Cordero', 'hafa@mail.com', '7604b6b436b70db07141e129d36dec75192c274a');

-- Dumping data for table dbe_commerce.usr_itm: ~2 rows (approximately)
INSERT INTO `usr_itm` (`login`, `itm_id`, `amount`) VALUES
	('maimai', 1, 3),
	('maimai', 29, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
