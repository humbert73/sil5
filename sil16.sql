-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: sil16
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E6612469DE2` (`category_id`),
  CONSTRAINT `FK_23A0E6612469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (1,1,'Harry Potter and the Sorcerer\'s Stone',15.00,0,'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTUAjNjMjoY4jAmkF2TBApqQQpbN-XUHl57tCoaMYzvekOEhSF6Mm9l0i7upi6U-0YrqP3V'),(2,1,'Harry Potter and the Chamber of Secrets',15.00,6,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKvBcz_NdBSkpBah5l9GfJmTncAWf_iMMhPrMwSpMFeHnaO9ZZr565AhO6iHbmNI2pynGw'),(3,1,'Harry Potter and the Prisoner of Azkaban',15.00,9,'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQOMFareX78LFZG18i6nlodJcm8OZkiFXvZlcK_ZyMdGN942TsxDKPNB96wWtmRP5Mr3zug'),(4,1,'Harry Potter and the Goblet of Fire',15.00,10,'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcT2I6Zaol07BIYgv303BY3RkiVtI4OnFV-dAku892LhyPA-ulnYWDCfs7sIXnhWKXJX7AbV'),(5,1,'Harry Potter and the Order of the Phoenix',15.00,10,'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRBBBGceyXVSkpMg5fYnL2A9kO5hAMjVi1xI31aGNpj0yZzOusvQk2ZlTD6fpcJYks231rY'),(6,1,'Harry Potter and the Half-Blood Prince',15.00,10,'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQjhMUSP_y5rGcgQsboKNdnA8olkLlK0jFAcZ2rGry3hQJwY1yhrEdEPvViS1GBhJydosZ8'),(7,1,'Harry Potter and the Deathly Hallows – Part 1',10.00,10,'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcR0g7cZ2H98uLIDMZF30Mmhg_3mIz7VD1S39PJQZLIsd1zNalUgjTRrxE6nSUPuByMU9bmN'),(8,1,'Harry Potter and the Deathly Hallows – Part 2',10.00,10,'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRgOTAfvJ9CurS45hjainb4mQpLL9sCgy8gvw9X1EF1Gnbb3u1OdPql7Hd9D0MPlMm46-NT'),(9,2,'Télévision LG',999.00,2,'http://www.shopandreview.com/wp-content/uploads/2015/06/lg-televisions-4.jpg'),(10,2,'Télévision samsung',999.99,10,'https://d3nevzfk7ii3be.cloudfront.net/igi/DFlfFtyxfPQGP2vC.standard');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Films'),(2,'High Tech');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'admin','admin@mail.com','$2y$12$yfMNzonMDjb4jPHGkjU/ouo8XNLd6te6GlVQ/r4we80pPyc.Qeroy'),(2,'colineless','coline@mail.com','$2y$12$2pXvRv2OMQ4Li3PkmvBhje872QJdcTz2Ptv.vF.GD3IYBOTQmCeIi'),(3,'julien','julien@mail.com','$2y$12$jFSzGfdHiLQVOwDCvYZW/O4U5txGvU634qMxkhcXPuk7NZPv4r2o2'),(4,'etienne2','etienne2@mail.com','$2y$12$VtK55BwEUEysy5jJUuGfmOaEp5LPn77JPGkZjJplOgqv2.O4wRh2G'),(5,'moreaux','moreaux.humbert@gmail.com','$2y$12$uWLWPbSxNVVHivH9OYM/qeQIWYqGYPm/Yj1YrhzScumvMRJgkPThm');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commande`
--

DROP TABLE IF EXISTS `commande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `etat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6EEAA67D19EB6921` (`client_id`),
  CONSTRAINT `FK_6EEAA67D19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande`
--

LOCK TABLES `commande` WRITE;
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` VALUES (1,2,'2017-01-22',1),(2,2,'2017-01-22',0),(3,1,'2017-01-27',0),(4,3,'2017-01-27',0),(5,4,'2017-01-27',0),(6,5,'2017-01-27',0),(7,1,'2017-01-27',0);
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ligneDeCommande`
--

DROP TABLE IF EXISTS `ligneDeCommande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ligneDeCommande` (
  `commande_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `quantite` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`commande_id`,`article_id`),
  KEY `IDX_12E8BE9082EA2E54` (`commande_id`),
  KEY `IDX_12E8BE907294869C` (`article_id`),
  CONSTRAINT `FK_12E8BE907294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `FK_12E8BE9082EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ligneDeCommande`
--

LOCK TABLES `ligneDeCommande` WRITE;
/*!40000 ALTER TABLE `ligneDeCommande` DISABLE KEYS */;
INSERT INTO `ligneDeCommande` VALUES (1,1,'1',15.00),(2,2,'1',15.00),(2,3,'1',15.00),(3,1,'1',15.00),(4,1,'1',15.00),(5,1,'1',15.00),(5,2,'2',30.00),(6,1,'6',90.00),(7,2,'1',15.00);
/*!40000 ALTER TABLE `ligneDeCommande` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-27 12:33:17
