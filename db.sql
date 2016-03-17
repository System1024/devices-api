-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.6.14


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;



--
-- Definition of table `browser`
--

DROP TABLE IF EXISTS `browser`;
CREATE TABLE `browser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `browser`
--

/*!40000 ALTER TABLE `browser` DISABLE KEYS */;
INSERT INTO `browser` (`id`,`name`) VALUES 
 (1,'Opera'),
 (2,'IE'),
 (3,'Mozilla'),
 (5,'Yandex');
/*!40000 ALTER TABLE `browser` ENABLE KEYS */;


--
-- Definition of table `browserversion`
--

DROP TABLE IF EXISTS `browserversion`;
CREATE TABLE `browserversion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(45) NOT NULL,
  `browser_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_browserversion_1` (`browser_id`),
  CONSTRAINT `FK_browserversion_1` FOREIGN KEY (`browser_id`) REFERENCES `browser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `browserversion`
--

/*!40000 ALTER TABLE `browserversion` DISABLE KEYS */;
INSERT INTO `browserversion` (`id`,`version`,`browser_id`) VALUES 
 (8,'129',1),
 (11,'9.0',2),
 (12,'34',3),
 (13,'36',3);
/*!40000 ALTER TABLE `browserversion` ENABLE KEYS */;


--
-- Definition of table `device`
--

DROP TABLE IF EXISTS `device`;
CREATE TABLE `device` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `devicetype_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_device_1` (`devicetype_id`),
  CONSTRAINT `FK_device_1` FOREIGN KEY (`devicetype_id`) REFERENCES `devicetypes` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `device`
--

/*!40000 ALTER TABLE `device` DISABLE KEYS */;
INSERT INTO `device` (`id`,`name`,`description`,`devicetype_id`) VALUES 
 (1,'Device 1','Description for device 1',1),
 (19,'Samsung','nice tv',2),
 (20,'Asus','Asustec1',3),
 (22,'Sony','SonyPc',3);
/*!40000 ALTER TABLE `device` ENABLE KEYS */;


--
-- Definition of table `device_browser`
--

DROP TABLE IF EXISTS `device_browser`;
CREATE TABLE `device_browser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `browserversion_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_device_browser_1` (`device_id`),
  KEY `FK_device_browser_2` (`browserversion_id`),
  CONSTRAINT `FK_device_browser_1` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_device_browser_2` FOREIGN KEY (`browserversion_id`) REFERENCES `browserversion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `device_browser`
--

/*!40000 ALTER TABLE `device_browser` DISABLE KEYS */;
INSERT INTO `device_browser` (`id`,`device_id`,`browserversion_id`) VALUES 
 (10,20,12),
 (11,1,13);
/*!40000 ALTER TABLE `device_browser` ENABLE KEYS */;


--
-- Definition of table `devicetypes`
--

DROP TABLE IF EXISTS `devicetypes`;
CREATE TABLE `devicetypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `devicetypes`
--

/*!40000 ALTER TABLE `devicetypes` DISABLE KEYS */;
INSERT INTO `devicetypes` (`id`,`name`,`description`) VALUES 
 (1,'Mobile phones','Phones, Smartphones'),
 (2,'TV','TV sets'),
 (3,'PC','Personal computers');
/*!40000 ALTER TABLE `devicetypes` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
