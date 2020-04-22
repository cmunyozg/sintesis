-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: sintesis
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

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
-- Current Database: `sintesis`
--


CREATE DATABASE /*!32312 IF NOT EXISTS*/ `sintesis` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `sintesis`;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Conciertos'),(2,'Fiesta Nocturna'),(3,'Gastronomía'),(4,'Teatro'),(5,'Monólogos'),(6,'Cultura y Arte'),(7,'Deporte y Salud'),(8,'Otros'),(9,'Prueba');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `hora` time NOT NULL,
  `ubicacion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coordenadas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` int(11) NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  `bloqueado` tinyint(1) NOT NULL,
  `mensaje_moderacion` longtext COLLATE utf8mb4_unicode_ci,
  `fecha_publicacion` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_47860B05DB38439E` (`usuario_id`),
  KEY `IDX_47860B053397707A` (`categoria_id`),
  CONSTRAINT `FK_47860B053397707A` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`),
  CONSTRAINT `FK_47860B05DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES (4,1,4,'Monólogo sobre el coronavirus título más largo','2015-01-01','2020-04-30','18:15:00','Teatro Real','1234 1234 1234',119,'Los Teatros La Latina y Bellas Artes informan de que, habiendo recibido instrucciones de los organismos y autoridades competentes ordenando el cierre de las salas las próximas semanas como medida de precaución para evitar la propagación del COVID-19, hemos procedido al cierre de los teatros. \r\n\r\nEstas medidas de las autoridades gubernativas en relación al COVID-19 son de carácter imperativo y por causa de fuerza mayor, por tanto, se exceden de la capacidad de disposición y decisión de la empresa. El cierre pretende evitar la concentración de personas en lugares cerrados y seguirá vigente mientras así lo consideren las autoridades. En los próximos días nos pondremos en contacto con todos los compradores para gestionar las entradas adquiridas para las funciones afectadas. Mientras estas gestiones se realizan, solicitamos a nuestros clientes la mayor colaboración posible y agradeceremos su paciencia con los tiempos de respuesta debido al gran volumen de peticiones y mensajes que hemos recibido y seguimos recibiendo. En el caso de las localidades adquiridas en la taquilla, rogamos a nuestros espectadores que conserven sus entradas y acudan a las taquillas del Teatro una vez se reanude la actividad. Los Teatros Bellas Artes y La Latina lamentan profundamente los perjuicios que este cierre pueda ocasionar al público y agradece la colaboración y comprensión de todos los ciudadanos. \r\nMientras tanto, PENTACION pone a disposición de todo el público algunas obras de forma gratuita para facilitar la cuarentena.',NULL,'http://google.es',1,0,NULL,'2020-04-18 20:21:39'),(6,1,3,'Otro evento más','2020-04-30',NULL,'18:20:00','Bar La Murta','123456',0,'Estamos en el centro del emblemático barrio de Benimaclet, antiguo pueblo de Valencia. Ofrecemos un ambiente agradable, informal, y cercano y productos valencianos y cervezas internacionales Tenemos terraza, aceptamos reservas y sobre todo, te aceptamos a ti :-) Ven a conocernos. Atendemos en valenciano, español e inglés.',NULL,'https://www.tripadvisor.es/ShowUserReviews-g187529-d6989471-r482571585-La_Murta_Vins_i_Tapes-Valencia_Province_of_Valencia_Valencian_Country.html#',1,0,NULL,'2020-04-22 18:06:08');
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20200321144526','2020-03-21 15:21:11'),('20200327195136','2020-03-27 19:52:05'),('20200418181422','2020-04-18 18:21:33');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte`
--

DROP TABLE IF EXISTS `reporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evento_id` int(11) NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5CB121487A5F842` (`evento_id`),
  CONSTRAINT `FK_5CB121487A5F842` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte`
--

LOCK TABLES `reporte` WRITE;
/*!40000 ALTER TABLE `reporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suscripcion`
--

DROP TABLE IF EXISTS `suscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suscripcion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_497FA0DB38439E` (`usuario_id`),
  KEY `IDX_497FA087A5F842` (`evento_id`),
  CONSTRAINT `FK_497FA087A5F842` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`),
  CONSTRAINT `FK_497FA0DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suscripcion`
--

LOCK TABLES `suscripcion` WRITE;
/*!40000 ALTER TABLE `suscripcion` DISABLE KEYS */;
/*!40000 ALTER TABLE `suscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `fecha_registro` datetime NOT NULL,
  `rol` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'cmg','Carlos','carlos@carlos.com','$argon2id$v=19$m=65536,t=4,p=1$c7A5M3IYGwJ7fZkn0T+G/g$pM5EF2Jij1U3PvO8a0+Zl+M8MdT+Ipi8idIauKWChOo','2015-01-01',NULL,'2020-04-07 19:42:58',0),(3,'AlbaDDR','Alba','albadomene1995@hotmail.com','$argon2id$v=19$m=65536,t=4,p=1$XdAzVl41+7RAgqlIWTF6Qg$kRVxTnRYoBV3jSpgAwetI2An4R2vQWNzQbKjraQwr70','2015-06-09',NULL,'2020-04-08 21:39:57',0),(4,'admin','admin','admin@admin.com','$argon2id$v=19$m=65536,t=4,p=1$8vJZIZQxcbgN22dc1yNQaw$l+Zm6LzLKvTCrU/qAQp4a+EUmJP0f02nW5f1uwHkgUM','2015-01-01',NULL,'2020-04-16 19:25:42',1);
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

-- Dump completed on 2020-04-22 18:25:54
