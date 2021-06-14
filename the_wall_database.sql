-- MySQL dump 10.13  Distrib 8.0.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: the_wall_database
-- ------------------------------------------------------
-- Server version	8.0.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `comment` text,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (8,5,2,'Did the ahead operation really employ the sample?','2021-04-18 14:46:43','2021-04-18 14:46:43'),(9,8,1,'What if the diminutive thanks ate the library?','2021-04-18 14:47:35','2021-04-18 14:47:35'),(10,5,1,'Did the misguided cut really satisfy the possession?','2021-04-18 14:47:45','2021-04-18 14:47:45'),(11,9,2,'Is the examine picture better than the twist?','2021-04-18 15:15:29','2021-04-18 15:15:29'),(12,9,2,'Did the symptomatic junior really tow the metal?\r\n','2021-04-18 15:23:47','2021-04-18 15:23:47'),(13,11,2,'What if the aboriginal dad ate the save?','2021-04-18 15:24:13','2021-04-18 15:24:13'),(14,11,1,'The sordid bitter cannot intends the attempt.','2021-04-18 15:26:55','2021-04-18 15:26:55'),(15,12,2,'Is the deceive word better than the stage?','2021-04-18 15:27:25','2021-04-18 15:27:25'),(16,11,2,'It was then the permissible shoot met the last dish.','2021-04-18 15:27:37','2021-04-18 15:27:37'),(17,9,3,'What if the charming manner ate the tackle?','2021-04-18 16:01:58','2021-04-18 16:01:58'),(18,12,3,'The supportive surround cannot spell the floor.','2021-04-18 16:02:34','2021-04-18 16:02:34');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `message` text,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (9,1,'Is the itch term better than the muscle?','2021-04-18 14:47:15','2021-04-18 14:47:15'),(11,2,'Is the spark broad better than the addition?','2021-04-18 15:23:59','2021-04-18 15:23:59'),(12,1,'The eager comment floods into the shut simple.','2021-04-18 15:26:24','2021-04-18 15:26:24'),(15,3,'Did the everlasting occasion really rejoice the conversation?','2021-04-18 16:02:58','2021-04-18 16:02:58');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ronoaldo','Urbino','ron.urbino@gmail.com','5f4dcc3b5aa765d61d8327deb882cf99','2021-04-17 18:48:20','2021-04-17 18:48:20'),(2,'Jennie Lynn','Masdo','jen.masdo@gmail.com','fa3733c647dca53a66cf8df953c2d539','2021-04-17 20:36:36','2021-04-17 20:36:36'),(3,'Jean','Fernando','jean.fernando@gmail.com','e80b53313a44bd098e3d5d5025f845f6','2021-04-18 16:00:59','2021-04-18 16:00:59');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-18 16:10:12
