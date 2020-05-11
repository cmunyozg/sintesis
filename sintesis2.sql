-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: localhost    Database: sintesis
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.18.04.1

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES (4,1,4,'Título de evento de prueba','2015-01-01','2020-04-30','18:15:00','La Peligro, Plaza Honduras, Valencia, España','39.4741311, -0.3449752',1534,'Los Teatros La Latina y Bellas Artes informan de que, habiendo recibido instrucciones de los organismos y autoridades competentes ordenando el cierre de las salas las próximas semanas como medida de precaución para evitar la propagación del COVID-19, hemos procedido al cierre de los teatros. Estas medidas de las autoridades gubernativas en relación al COVID-19 son de carácter imperativo y por causa de fuerza mayor, por tanto, se exceden de la capacidad de disposición y decisión de la empresa. El cierre pretende evitar la concentración de personas en lugares cerrados y seguirá vigente mientras así lo consideren las autoridades. En los próximos días nos pondremos en contacto con todos los compradores para gestionar las entradas adquiridas para las funciones afectadas. Mientras estas gestiones se realizan, solicitamos a nuestros clientes la mayor colaboración posible y agradeceremos su paciencia con los tiempos de respuesta debido al gran volumen de peticiones y mensajes que hemos recibido y seguimos recibiendo. En el caso de las localidades adquiridas en la taquilla, rogamos a nuestros espectadores que conserven sus entradas y acudan a las taquillas del Teatro una vez se reanude la actividad. Los Teatros Bellas Artes y La Latina lamentan profundamente los perjuicios que este cierre pueda ocasionar al público y agradece la colaboración y comprensión de todos los ciudadanos. Mientras tanto, PENTACION pone a disposición de todo el público algunas obras de forma gratuita para facilitar la cuarentena.',NULL,'http://google.es',1,0,NULL,'2020-04-18 20:21:39'),(6,1,3,'Comida en La Murta','2021-04-30',NULL,'18:20:00','La Murta vins i tapes, Carrer de la Murta, Valencia, España','39.485995, -0.3577568999999999',0,'Estamos en el centro del emblemático barrio de Benimaclet, antiguo pueblo de Valencia. Ofrecemos un ambiente agradable, informal, y cercano y productos valencianos y cervezas internacionales Tenemos terraza, aceptamos reservas y sobre todo, te aceptamos a ti :-) Ven a conocernos. Atendemos en valenciano, español e inglés.','lamurta-5ea6c16b580b3.jpeg','https://www.tripadvisor.es/ShowUserReviews-g187529-d6989471-r482571585-La_Murta_Vins_i_Tapes-Valencia_Province_of_Valencia_Valencian_Country.html#',1,0,NULL,'2020-04-22 18:06:08'),(8,1,2,'Coordenadas','2020-04-17',NULL,'00:00:00','Plaza Cedro, Valencia, España','39.4715818, -0.3467752',0,'Descripcion.\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Debitis, explicabo magnam. Labore reiciendis ut explicabo neque, consequatur, nam officia voluptates cum aliquid vitae dolor quam quaerat vero doloribus earum sint.','ciervogeometrico-5eb7e8bbbc776.jpeg','http://google.es',1,0,'','2020-04-29 20:57:49'),(9,1,1,'Otro evento','2020-04-04',NULL,'04:00:00','Plaza del Ayuntamiento, Valencia, España','39.47079019999999, -0.3764522999999999',0,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis, explicabo magnam. Labore reiciendis ut explicabo neque, consequatur, nam officia voluptates cum aliquid vitae dolor quam quaerat vero doloribus earum sint.\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Debitis, explicabo magnam. Labore reiciendis ut explicabo neque, consequatur, nam officia voluptates cum aliquid vitae dolor quam quaerat vero doloribus earum sint.\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Debitis, explicabo magnam. Labore reiciendis ut explicabo neque, consequatur, nam officia voluptates cum aliquid vitae dolor quam quaerat vero doloribus earum sint.',NULL,NULL,1,1,'gf','2020-04-29 21:40:51'),(10,1,1,'Lorem ipsum','2020-07-21',NULL,'00:00:00','Ghecko, Plaza Negrito, València, España','39.476222, -0.377294',0,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis, explicabo magnam. Labore reiciendis ut explicabo neque, consequatur, nam officia voluptates cum aliquid vitae dolor quam quaerat vero doloribus earum sint.','lamurta-5eac3c511d597.jpeg',NULL,1,0,NULL,'2020-04-29 21:59:58'),(12,4,1,'Monólogo en La Gramola','2020-09-24',NULL,'20:00:00','La Gramola, Calle Barón S Petrillo, Valencia, España','39.4850705, -0.3606297',300,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis, explicabo magnam. Labore reiciendis ut explicabo neque, consequatur, nam officia voluptates cum aliquid vitae dolor quam quaerat vero doloribus earum sint. Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis, explicabo magnam. Labore reiciendis ut explicabo neque, consequatur, nam officia voluptates cum aliquid vitae dolor quam quaerat vero doloribus earum sint. Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis, explicabo magnam. Labore reiciendis ut explicabo neque, consequatur, nam officia voluptates cum aliquid vitae dolor quam quaerat vero doloribus earum sint.',NULL,NULL,1,0,NULL,'2020-05-09 20:15:55'),(13,4,1,'Otro evento','2020-04-24',NULL,'00:00:00','Plaça de Benimaclet, Valencia, España','39.4862381, -0.3591347',0,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis, explicabo magnam. Labore reiciendis ut explicabo neque, consequatur, nam officia voluptates cum aliquid vitae dolor quam quaerat vero doloribus earum sint.',NULL,NULL,1,0,NULL,'2020-05-09 20:18:19'),(14,1,5,'Prueba subida imagen','2020-05-23',NULL,'00:00:00','McDonald\'s Ronda Norte, Calle PRI Cm Moncada juan XXIII, Valencia, España','39.49757209999999, -0.3834245',0,'Ejemplo','verde-5eb7ea7cc4cad.jpeg',NULL,1,0,NULL,'2020-05-10 13:50:20');
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fad`
--

DROP TABLE IF EXISTS `fad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fad`
--

LOCK TABLES `fad` WRITE;
/*!40000 ALTER TABLE `fad` DISABLE KEYS */;
/*!40000 ALTER TABLE `fad` ENABLE KEYS */;
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
INSERT INTO `migration_versions` VALUES ('20200327195136','2020-03-27 19:52:05'),('20200418181422','2020-04-18 18:21:33'),('20200423192423','2020-04-23 19:24:53'),('20200501121357','2020-05-01 12:16:05'),('20200501123353','2020-05-01 12:37:22');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prec`
--

DROP TABLE IF EXISTS `prec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prec`
--

LOCK TABLES `prec` WRITE;
/*!40000 ALTER TABLE `prec` DISABLE KEYS */;
/*!40000 ALTER TABLE `prec` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte`
--

LOCK TABLES `reporte` WRITE;
/*!40000 ALTER TABLE `reporte` DISABLE KEYS */;
INSERT INTO `reporte` VALUES (4,9,'Reporte'),(5,9,'fgsfg'),(7,9,'Reporte'),(9,12,'Creo que el evento incumple las normas'),(10,10,'reporte');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suscripcion`
--

LOCK TABLES `suscripcion` WRITE;
/*!40000 ALTER TABLE `suscripcion` DISABLE KEYS */;
INSERT INTO `suscripcion` VALUES (12,4,8),(13,1,12),(14,1,13);
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
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'cmg','Carlos','carlos@carlos.com','$argon2id$v=19$m=65536,t=4,p=1$OnutN4Mgsv3doHlL/8lQMg$XlvOMytWfgWwBCGvF/KpoxV91yLBnQ/GLUPCBYyRGko','2004-01-01',NULL,'2020-04-07 19:42:58',0,'ciervogeometrico-5eb7e8a8527a7.jpeg'),(3,'AlbaDDR','Alba','albadomene1995@hotmail.com','$argon2id$v=19$m=65536,t=4,p=1$XdAzVl41+7RAgqlIWTF6Qg$kRVxTnRYoBV3jSpgAwetI2An4R2vQWNzQbKjraQwr70','2015-06-09',NULL,'2020-04-08 21:39:57',0,NULL),(4,'admin','admin','admin@admin.com','$argon2id$v=19$m=65536,t=4,p=1$8vJZIZQxcbgN22dc1yNQaw$l+Zm6LzLKvTCrU/qAQp4a+EUmJP0f02nW5f1uwHkgUM','2015-01-01',NULL,'2020-04-16 19:25:42',1,NULL),(5,'user1','User 1','user1@user1.com','$argon2id$v=19$m=65536,t=4,p=1$xiaNettpEx/pwWNWcQhBYw$Rkrq8OI18R1CIdNuGKBWhf3Mk4Y7g2ULXZ+rN/Uy498','2020-04-30',NULL,'2020-04-27 20:20:55',0,NULL),(6,'carlosmugar','Carlos','carlosmugar@hotmail.com','$argon2id$v=19$m=65536,t=4,p=1$VSLiGOFcEc3pdvUcWK/F1A$PyjTbeoFm4i7rEz78id5EFAGkwF0fh9Qr57bO7OF1cY','1995-04-05',NULL,'2020-04-30 14:18:08',0,NULL);
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

-- Dump completed on 2020-05-11 11:27:39
