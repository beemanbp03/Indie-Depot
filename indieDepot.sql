-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: localhost    Database: indieDepot
-- ------------------------------------------------------
-- Server version	8.0.22-0ubuntu0.20.04.3

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `ownerId` int NOT NULL,
  `gameId` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gameId` (`gameId`),
  KEY `ownerId` (`ownerId`),
  CONSTRAINT `comments_ibfk_5` FOREIGN KEY (`gameId`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_ibfk_6` FOREIGN KEY (`ownerId`) REFERENCES `user_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (7,'I hope everyone likes my game!',1,22),(8,'Hello?',1,22),(13,'This game looks interesting. I\'ll try it out and report back.',2,22),(14,'Thoughts: I see where you are trying to go with this and I think it\'s a great start.  I ran into a few bugs, but other than that. Great work!',2,22),(15,'THis game looks really cool. Can\'t wait to play it.',1,20),(16,'Blah Blah',1,20),(17,'I played the game and it is really cool I dig the art style! Great work!',1,20);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ownerId` int NOT NULL,
  `title` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `author` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `pubDate` date DEFAULT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gameLink` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ownerId` (`ownerId`),
  CONSTRAINT `games_ibfk_2` FOREIGN KEY (`ownerId`) REFERENCES `user_login` (`id`) ON DELETE CASCADE,
  CONSTRAINT `games_ibfk_3` FOREIGN KEY (`ownerId`) REFERENCES `user_login` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (18,5,'Pacman Clone','Chukobyte','An open source Pacman clone...','2020-09-08','Pacman_Icon.png','https://chukobyte.itch.io/pacman-clone'),(19,4,'Galaga (Remake)','ChristianB','Galaga Remake is a project develoved for \"Modelos y Algoritmos I\" at Escuela Da Vinci.\r\n\r\nFeatures: \r\n\r\n1. Design Patterns\r\n\r\n2. Correct usage of SOLID principles','2019-05-15','Galaga_Icon.png','https://cristianb.itch.io/galaga-remake'),(20,6,'Columns N Coffins','Pokitto','Columns & Coffins is a Roguelike  coded by talk.pokitto.com community members for the Pokitto opensource game console*\r\n\r\n(*Pokitto was kickstarted 1 month ago on Kickstarter, KS units shipping August. Pokitto Webshop opening soon! )\r\n\r\nPOKITTO & CGAjam\r\n\r\nPokitto is a tiny game console based on an ARM Cortex-M0+ core. It has 36 kB of RAM, 256 kB of program memory and runs at 48 Mhz.\r\n\r\nIt has 2 display modes (110x88 @ 16 colors) and (220 x 176 @ 4 colors)\r\n\r\nColor palette for different modes is freely selectable, so Pokitto was ideal device for #CGAjam !!!\r\n\r\nThanks to the Pokitto Sim, the code that runs on the device can be run in Windows as well ! (Native Linux version will be added soon. You should be able to play this in Wine with no problems.)\r\n\r\nTo raise awareness about Pokitto, the community team Pokitteam is submitting this game to the CGAjam!','2020-02-19','Rogue_Icon.png','https://pokitto.itch.io/columnscoffins-roguelike-for-pokitto'),(22,1,'Spaceman Sam','Boulder Beeman','Spaceman Sam is a 2D action platformer with roguelite elements.  This is a hobby project and it is currently under development. You will encounter bugs.','2020-12-08','SpacemanSamIcon.png','https://bpbeeman03.itch.io/spaceman-sam-demo');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_favorites`
--

DROP TABLE IF EXISTS `user_favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_favorites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `game_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `game_id` (`game_id`),
  KEY `userId` (`userId`),
  CONSTRAINT `user_favorites_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  CONSTRAINT `user_favorites_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user_login` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_favorites`
--

LOCK TABLES `user_favorites` WRITE;
/*!40000 ALTER TABLE `user_favorites` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstName` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `lastName` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `gender` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `newPicture` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `oldPicture` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `userId` int DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `user_info_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user_login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (1,'boulder','Boulder','Beeman','2020-12-03','M',NULL,'boulder.jpg',NULL,'My name is Boulder, and I like to make video games in my free time.  I also enjoy hiking with my girlfriend, playing golf, playing video games, and learning programming.  I am currently going to school for Web Software Development at MATC, and I am looking forward to starting an exciting new career!  I also have a cat named Dexter. He\'s the best.'),(2,'cerina','Cerina','Colon','1990-08-19','F',NULL,'girl2.jpg',NULL,'My name is Cerina and I am new to video games.  I used to play Super Mario Bros on the old Nintendo consoles back in the day.  I like to play retro style games a lot! My cat Oscar loves to watch me play Galaga!'),(3,'dexter','Dexter','Beeman','2016-07-05','M',NULL,'DexterKitty.jpg',NULL,'MEow MEOW MEOWW!  MEOW MEOW. MEOW!!!!!'),(4,'oscar','Oscar','Colon','2014-03-24','M',NULL,'Oscarkitty.jpg',NULL,'MEEOOOWWWW!'),(5,'ZeldaFan2020','Jason','Statham','2000-04-03','M',NULL,'jasonStatham.jpg',NULL,'My name is Jason Statham.  I am an action movie star, but in my free time I like to play video games, especially the old looking ones.  I guess they take me back to a simpler time before I started saving the world one B movie at a time.'),(6,'FreaksAndGeeks','Paula','Anderson','1985-03-28','M',NULL,'Webp.net-resizeimage.png',NULL,'Hi! My name is Paula and I love to play indie games! I also like swimming, kickboxing, and horror movies.  The reason why I am a member is because I like to play test games for indie game developers at any level.'),(7,'user','John','Doe','1985-05-13','M',NULL,'man.jpg',NULL,'I am John Doe');
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_login`
--

DROP TABLE IF EXISTS `user_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_login`
--

LOCK TABLES `user_login` WRITE;
/*!40000 ALTER TABLE `user_login` DISABLE KEYS */;
INSERT INTO `user_login` VALUES (1,'boulder','82b384ce62e22ad7baf5959c3cdcc048a18f5703'),(2,'cerina','58cd8387a66ba13b338a5aa88cfea6f77d91770d'),(3,'dexter','efce8cd161897feeaa7979d892dc26a8a8d8eea3'),(4,'oscar','2dff4fc90e2973f54d62e257480de234bc59e2c4'),(5,'ZeldaFan2020','5a2fa4da9967553d347c13a61017f93facfcc025'),(6,'FreaksAndGeeks','8be9bc2b60344e0bfc36f08e8b9d91300a8c1664'),(7,'user','12dea96fec20593566ab75692c9949596833adc9');
/*!40000 ALTER TABLE `user_login` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-11 17:24:20
