-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: bd_pokedex
-- ------------------------------------------------------
-- Server version	8.0.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tipo`
--

DROP TABLE IF EXISTS `tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `tipo` varchar(50) NOT NULL,
                        `imagen` varchar(255) NOT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo`
--

LOCK TABLES `tipo` WRITE;
/*!40000 ALTER TABLE `tipo` DISABLE KEYS */;
INSERT INTO `tipo` VALUES (1,'FUEGO','fuego.png'),(2,'AGUA','agua.png'),(3,'ELECTRICO','electrico.png'),(4,'PLANTA','planta.png');
/*!40000 ALTER TABLE `tipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pokemones`
--

DROP TABLE IF EXISTS `pokemones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pokemones` (
    `id` int NOT NULL AUTO_INCREMENT,
    `id_unico` varchar(10) NOT NULL,
    `nombre` varchar(100) NOT NULL,
    `imagen` varchar(255) NOT NULL,
    `descripcion` text NOT NULL,
    `tipo_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `tipo_id` (`tipo_id`),
    CONSTRAINT `pokemones_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pokemones`
--

LOCK TABLES `pokemones` WRITE;
/*!40000 ALTER TABLE `pokemones` DISABLE KEYS */;
INSERT INTO `pokemones` VALUES (1,'P001','Pikachu','pikachu.png','Pikachu es un Pokémon eléctrico.',3),(2,'P002','Charmander','charmander.png','Charmander es un Pokémon de tipo fuego.',1),(3,'P003','Squirtle','squirtle.png','Squirtle es un Pokémon de tipo agua.',2),(4,'P004','Bulbasaur','bulbasaur.png','Bulbasaur es un Pokémon de tipo planta.',4),(5,'P005','Vulpix','vulpix.png','Vulpix tiene seis colas que crecen conforme envejece.',1),(6,'P006','Growlithe','growlithe.png','Growlithe es muy leal y valiente en las batallas.',1),(7,'P007','Magmar','magmar.png','Magmar emana calor intenso y su cuerpo parece estar en llamas.',1),(8,'P008','Psyduck','psyduck.png','Psyduck sufre constantes dolores de cabeza que liberan su energía psíquica.',2),(9,'P009','Poliwag','poliwag.png','Poliwag tiene una piel fina por la que se ven sus órganos.',2),(10,'P010','Vaporeon','vaporeon.png','Vaporeon puede convertirse en agua para camuflarse.',2),(11,'P011','Chikorita','chikorita.png','Chikorita agita su hoja para liberar una fragancia calmante.',4),(12,'P012','Bellsprout','bellsprout.png','Bellsprout usa su cuerpo flexible para esquivar ataques.',4),(13,'P013','Oddish','oddish.png','Oddish se planta en el suelo para absorber nutrientes.',4),(14,'P014','Magnemite','magnemite.png','Magnemite se alimenta de electricidad y flota gracias al magnetismo.',3),(15,'P015','Voltorb','voltorb.png','Voltorb se asemeja a una Pokébola y puede explotar si es agitado.',3),(16,'P016','Electabuzz','electabuzz.png','Electabuzz causa apagones al absorber electricidad de las centrales eléctricas.',3);
/*!40000 ALTER TABLE `pokemones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','$2y$10$ruh6n9.Hlfs96W.vEimTzOB.HWwe4k3xjitGMSZNB5xpFl23rOq6y');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-27 12:41:58
