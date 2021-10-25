-- MySQL dump 10.13  Distrib 8.0.26, for Win64 (x86_64)
--
-- Host: localhost    Database: cms_db
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Wattefalls'),(2,'Nature'),(3,'Woods');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `comment_user_role_id` int NOT NULL DEFAULT '5',
  `comment_author` varchar(255) NOT NULL,
  `comment_email_id` int NOT NULL,
  `comment_content` text NOT NULL,
  `comment_post_id` int NOT NULL,
  `comment_status` varchar(255) NOT NULL DEFAULT 'Unapproved',
  `comment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_user_id` int DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_user_role_id` (`comment_user_role_id`),
  KEY `comment_email_id` (`comment_email_id`),
  KEY `comment_post_id` (`comment_post_id`),
  KEY `comments_fk_4` (`comment_user_id`),
  CONSTRAINT `comments_fk_1` FOREIGN KEY (`comment_user_role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_fk_2` FOREIGN KEY (`comment_email_id`) REFERENCES `emails` (`email_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_fk_3` FOREIGN KEY (`comment_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_fk_4` FOREIGN KEY (`comment_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (17,1,'Mohamed DS',1,'z',3,'Approved','2021-10-05 08:56:26',3),(18,1,'Mohamed DS',1,'s',1,'Approved','2021-10-05 08:57:25',3),(19,5,'sdf',2,'dq',1,'Approved','2021-10-05 09:11:33',NULL),(20,5,'u',13,'sdsss',5,'Approved','2021-10-05 09:11:31',NULL),(21,5,'User 54',14,'sdffz',6,'Approved','2021-10-05 09:11:25',NULL);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emails` (
  `email_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emails`
--

LOCK TABLES `emails` WRITE;
/*!40000 ALTER TABLE `emails` DISABLE KEYS */;
INSERT INTO `emails` VALUES (1,'m.daddiouaissa12@gmail.com'),(2,'user@gmail.com'),(3,'s@gmail.com'),(4,'mdaddiouaissa@gmail.com'),(5,'mdaddiouaissa@gmail.com'),(6,'mdaddiouaissa@gmail.com'),(7,'mdaddiouaissa@gmail.com'),(8,'mdaddiouaissa@gmail.com'),(9,'mdaddiouaissa@gmail.com'),(10,'mdaddiouaissa@gmail.com'),(11,'mdaddiouaissa@gmail.com'),(12,''),(13,'qhrd@o.spamtrap.ro'),(14,'sdf@sdf.com');
/*!40000 ALTER TABLE `emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `post_author` varchar(255) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_category_id` int NOT NULL,
  `post_content` text NOT NULL,
  `post_image` text NOT NULL,
  `post_comments` int NOT NULL DEFAULT '0',
  `post_status` varchar(255) NOT NULL DEFAULT 'Draft',
  `post_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `post_category_id` (`post_category_id`),
  CONSTRAINT `posts_fk_1` FOREIGN KEY (`post_category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Maridav','Skógafoss',1,'At Skógafoss in Skógar, Iceland, the heavy amount of spray that the waterfall produces makes a sunny-day rainbow sighting very likely.\r\nSkógafoss flows from not one, but two glaciers (Eyjafjallajokull and Myrdalsjokull). According to legend, a viking named Thrasi hid his chest of gold under this stunning waterfall.','5b4e1386afb7751b008b45d1.jfif',2,'Published','2021-09-23 05:55:57'),(2,'WEBB SHOW','Thor\'s Well',1,'While it\'s named after a Norse god, the sinkhole is reminscent of the Greek mythological creature Charybdis, which drowned sailors trapped in its currents. Thor\'s Well probably formed when an undersea cave\'s roof collapsed, creating the sight of the sea sinking into itself. ','5e8375f22d41c1584e5b8d45.jfif',0,'Published','2021-09-23 02:07:55'),(3,'Alexander Demyanenko','The Na Pali Coast',2,'Between the colorful cliffs and the azure blue waters below, Hawaii\'s Na Pali Coast is sure to wow any visitor.\r\nHiking the cliffs will afford you 4,000-foot-high views of the Pacific Ocean and Kalalau Valley, as well as plenty of beautiful waterfalls along the way.','5b4e0ed5ba494366028b45c7.jfif',1,'Published','2021-10-05 08:56:20'),(4,'Sunsinger','White Sands National Monument',2,'The largest gypsum deposit in the world, White Sands National Monument is a serene expanse of glittering, white sand that\'s located in the Chihuahuan Desert, New Mexico.\r\nThe gypsum that forms these gently sloping dunes comes from a nearby ephemeral lake that has a high mineral content. As the water from this lake evaporates, minerals remain, which then form gypsum deposits that are carried by the wind.','5b4e2133ba4943fd088b45c6.jfif',0,'Published','2021-09-29 08:59:24'),(5,'Dennis van','El Yunque',3,'El Yunque National Forest in Puerto Rico earns the distinction of being the sole tropical rainforest in the US National Forest System.\r\nIt is situated outside of San Juan.','5b56043f51dfbedc058b45e2.jfif',1,'Published','2021-09-23 05:49:02'),(6,'Orxy','The Fairy Pools',1,'The Fairy Pools are incredibly clear pools on the Isle of Skye, Scotland.\r\nSkye\'s enchanting Fairy Pools are only accessible on foot via the Glen Brittle forest. ','591dcd521cc9c520008b45b8.jfif',1,'Published','2021-09-23 02:07:55'),(7,'Ropelato Photography','Fly Geyser',2,'The geyser formed after a geothermic energy company failed to reseal a test well, the geothermic heat forcing the water upward in a geyser. For the past 40 years, the water has brought minerals to the desert service creating the geyser\'s distinct mound. \r\nHuman error and geothermic activity collided to create the Fly Geyser in the Black Rock Desert, Nevada.','5f6a655e49479600287bda4a.jfif',0,'Published','2021-10-11 09:47:26');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrator'),(2,'Content Manager'),(3,'Content Editor'),(4,'Subscriber'),(5,'Unregistered User');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test` (
  `test_char` varchar(255) DEFAULT NULL,
  `test_int` int DEFAULT NULL,
  `test_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
INSERT INTO `test` VALUES (NULL,1,'2021-09-23 17:35:34');
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email_id` int NOT NULL,
  `user_role_id` int NOT NULL DEFAULT '4',
  `user_image` varchar(255) NOT NULL DEFAULT 'subscriber.png',
  `user_status` varchar(255) NOT NULL DEFAULT (_cp850'Logged out'),
  PRIMARY KEY (`user_id`),
  KEY `user_role_id` (`user_role_id`),
  KEY `users_fk_2` (`user_email_id`),
  CONSTRAINT `users_fk_1` FOREIGN KEY (`user_role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_fk_2` FOREIGN KEY (`user_email_id`) REFERENCES `emails` (`email_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'Mohamed','DS','mohamed_ds','3000',1,1,'administrator.png','Logged out');
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

-- Dump completed on 2021-10-25 12:15:08
