CREATE DATABASE  IF NOT EXISTS `kultura` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `kultura`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: kultura
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.30-MariaDB

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'NE BRISATI (Lažni admin zbog anketa.)','sdfagdfgdfgnhgmplf,ćčlsd,fćksdf'),(2,'admin','admin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anketa`
--

DROP TABLE IF EXISTS `anketa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anketa` (
  `id_anketa` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` varchar(45) NOT NULL,
  `vreme_postavljanja` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vreme_isticanja` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor` varchar(45) NOT NULL,
  `organizacija_id_organizacija` int(11) NOT NULL,
  `admin_id_admin` int(11) NOT NULL DEFAULT '1',
  `brisanje` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_anketa`),
  KEY `fk_anketa_organizacija1_idx` (`organizacija_id_organizacija`),
  KEY `fk_anketa_admin1_idx` (`admin_id_admin`),
  CONSTRAINT `fk_anketa_admin1` FOREIGN KEY (`admin_id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_anketa_organizacija1` FOREIGN KEY (`organizacija_id_organizacija`) REFERENCES `organizacija` (`id_organizacija`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anketa`
--

LOCK TABLES `anketa` WRITE;
/*!40000 ALTER TABLE `anketa` DISABLE KEYS */;
INSERT INTO `anketa` VALUES (2,'Glupa anketa','2018-04-11 15:28:12','2018-10-11 15:28:12','Majmunčina',1,1,0),(3,'Druga anketa','2018-08-11 15:28:12','2018-12-11 16:28:12','Anketar Anketić',1,1,1);
/*!40000 ALTER TABLE `anketa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dogadjaj`
--

DROP TABLE IF EXISTS `dogadjaj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dogadjaj` (
  `id_dogadjaj` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` varchar(45) NOT NULL,
  `tekst` varchar(10000) NOT NULL,
  `vreme_dogadjaja` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vreme_postavljanja` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vreme_isticanja` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mesto` varchar(45) NOT NULL,
  `autor` varchar(45) NOT NULL,
  `organizacija_id_organizacija` int(11) NOT NULL,
  `brisanje` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_dogadjaj`),
  KEY `fk_dogadjaj_organizacija1_idx` (`organizacija_id_organizacija`),
  CONSTRAINT `fk_dogadjaj_organizacija1` FOREIGN KEY (`organizacija_id_organizacija`) REFERENCES `organizacija` (`id_organizacija`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dogadjaj`
--

LOCK TABLES `dogadjaj` WRITE;
/*!40000 ALTER TABLE `dogadjaj` DISABLE KEYS */;
INSERT INTO `dogadjaj` VALUES (1,'Filmski festival','Festival umetničkog filma Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mattis commodo lacus, eget porttitor dolor vulputate ac. Vivamus porta, elit et iaculis auctor, ante enim consequat eros, nec faucibus metus est sed arcu. Nam finibus enim at euismod eleifend. Ut sagittis, elit et lacinia semper, enim ex congue nisl, vel vulputate orci mauris a enim. Fusce at metus sit amet quam dignissim molestie. Ut accumsan arcu eu risus rutrum aliquet. Aliquam suscipit dolor sit amet luctus congue. Quisque pharetra egestas sagittis. Fusce sed velit tellus. Proin ultricies lorem at nunc mattis, in placerat neque finibus. Etiam maximus eros nec ligula faucibus luctus. Praesent euismod, neque sit amet egestas aliquet, ipsum erat tincidunt nisi, at tempus ex lacus in magna. Vivamus ut mollis odio. Duis vel varius eros, ut egestas lectus. Etiam accumsan dolor quis tellus semper, nec iaculis felis ornare. Vestibulum aliquet quam massa, a interdum ex porta eu. Pellentesque luctus ac metus. Nulla finibus fringilla tortor, eu laoreet eros condimentum ut. Duis varius iaculis lacus, in malesuada enim molestie maximus. Suspendisse potenti. Mauris ultrices scelerisque interdum. Phasellus efficitur nec velit in imperdiet. Aliquam nec maximus ante. Donec at sodales erat. In vel lobortis nisi. Mauris at mi sit amet ante pretium bibendum. Donec accumsan quis lectus id semper.','2018-05-23 15:25:23','2018-05-10 14:36:15','2018-10-24 11:56:00','Sava Centar','Petar Petrović',1,1),(2,'Fudbalsko prvenstvo','Takmičenje juniora Srbije u malom fudbalu Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mattis commodo lacus, eget porttitor dolor vulputate ac. Vivamus porta, elit et iaculis auctor, ante enim consequat eros, nec faucibus metus est sed arcu. Nam finibus enim at euismod eleifend. Ut sagittis, elit et lacinia semper, enim ex congue nisl, vel vulputate orci mauris a enim. Fusce at metus sit amet quam dignissim molestie. Ut accumsan arcu eu risus rutrum aliquet. Aliquam suscipit dolor sit amet luctus congue. Quisque pharetra egestas sagittis. Fusce sed velit tellus. Proin ultricies lorem at nunc mattis, in placerat neque finibus. Etiam maximus eros nec ligula faucibus luctus. Praesent euismod, neque sit amet egestas aliquet, ipsum erat tincidunt nisi, at tempus ex lacus in magna. Vivamus ut mollis odio. Duis vel varius eros, ut egestas lectus. Etiam accumsan dolor quis tellus semper, nec iaculis felis ornare. Vestibulum aliquet quam massa, a interdum ex porta eu. Pellentesqus. Nulla finibus fringilla tortor, eu laoreet eros condimentum ut. Duis varius iaculis lacus, in malesuada enim molestie maximus. Suspendisse potenti. Mauris ultrices scelerisque interdum. Phasellus efficitur nec velit in imperdiet. Aliquam nec maximus ante. Donec at sodales erat. In vel lobortis nisi. Mauris at mi sit amet ante pretium bibendum. Donec accumsan quis lectus id semper.','2018-08-02 15:53:44','2018-05-10 15:27:15','2018-08-20 14:37:15','Hala Sportova na Novom Beogradu','Jovan Jovanović',1,1),(3,'Beerfest','Ispijanje hektolitara piva uz slušanje dobre muzike. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mattis commodo lacus, eget porttitor dolor vulputate ac. Vivamus porta, elit et iaculis auctor, ante enim consequat eros, nec faucibus metus est sed arcu. Nam finibus enim at euismod eleifend. Ut sagittis, elit et lacinia semper, enim ex congue nisl, vel vulputate orci mauris a enim. Fusce at metus sit amet quam dignissim molestie. Ut accumsan arcu eu risus rutrum aliquet. Aliquam suscipit dolor sit amet luctus congue. Quisque pharetra egestas sagittis. Fusce sed velit tellus. Proin ultricies lorem at nunc mattis, in placerat neque finibus. Etiam maximus eros nec ligula faucibus luctus. Praesent euismod, neque sit amet egestas aliquet, ipsum erat tincidunt nisi, at tempus ex lacus in magna. Vivamus ut mollis odio. Duis vel varius eros, ut egestas lectus. Etiam accumsan dolor quis tellus semper, nec iaculis felis ornare. Vestibulum aliquet quam massa, a interdum ex porta euus. Nulla finibus fringilla tortor, eu laoreet eros condimentum ut. Duis varius iaculis lacus, in malesuada enim molestie maximus. Suspendisse potenti. Mauris ultrices scelerisque interdum. Phasellus efficitur nec velit in imperdiet. Aliquam nec maximus ante. Donec at sodales erat. In vel lobortis nisi. Mauris at mi sit amet ante pretium bibendum. Donec accumsan quis lectus id semper.','2018-05-23 16:29:51','2018-05-10 15:30:01','2018-05-22 06:00:21','Ušće','Angela Merkel',1,0),(4,'Neki kulturni događaj','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat, magna sit amet fermentum dapibus, mi leo imperdiet odio, at egestas nisi velit eu mauris. Cras at odio et purus sagittis posuere. Suspendisse porta urna tortor, sed faucibus enim ornare ac. Fusce quis tincidunt diam. Donec vestibulum malesuada ante, nec vehicula lectus porta at. Nullam et tortor imperdiet, ullamcorper ipsum eu, mattis lacus. Curabitur egestas justo id massa sagittis, sit amet finibus lectus dapibus. Vestibulum varius, eros sed pretium tristique, erat risus mattis lectus, feugiat efficitur mauris quam ut eros. In sollicitudin arcu non mauris venenatis varius. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer sit amet finibus eros. Ut maximus tortor nunc, vitae hendrerit ante bibendum at. Mauris sed laoreet eros, volutpat lobortis augue. Aenean malesuada imperdiet est ac faucibus. Phasellus placerat, dolor in lobortis ultricies, purus tellus scelerisque metus, et vestibulum ipsum nibh sit amet augue. Pellentesque sollicitudin dapibus dui.','2018-06-15 15:16:15','2018-05-23 13:45:05','2018-06-24 21:48:05','Zemunski kej','Miloš Milošević',2,1),(20,'Pozorište na otvorenom','Nunc odio risus, efficitur vel pretium interdum, congue et nibh. Donec et mi venenatis, tincidunt mauris ut, bibendum ipsum. Quisque tempor diam sit amet mollis hendrerit. Donec vestibulum est eu maximus malesuada. Pellentesque hendrerit purus leo, non finibus ante rhoncus ac. Praesent erat augue, mattis vel odio ut, finibus aliquet ligula. Cras augue felis, fermentum tincidunt metus a, scelerisque varius urna. Maecenas ullamcorper mollis velit, id placerat ante convallis malesuada. Sed vitae quam ultricies, cursus metus faucibus, maximus tellus. Etiam mattis posuere vulputate. Integer elementum erat ante, et consequat dui mollis non. Quisque eros massa, vulputate sit amet quam nec, tempor efficitur magna.','2018-05-29 15:55:10','2018-05-29 15:20:23','2018-07-25 01:07:33','Ada Ciganlija','Bob Rock',1,0),(21,'Pecanje slobodnim stilom','Nulla lacinia lobortis porta. Curabitur suscipit augue quis magna commodo pharetra. In sed sem in dolor blandit dictum. Nunc dapibus velit sed nibh fermentum, ut finibus dolor fringilla. In at risus vitae mi consequat volutpat id pharetra sapien. Suspendisse vulputate dapibus arcu eget luctus. Aliquam neque lectus, venenatis scelerisque tincidunt ut, pharetra a sem. Pellentesque euismod nec est vitae vulputate. Aliquam erat volutpat. Praesent neque risus, efficitur ut justo eget, molestie efficitur arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis diam non augue cursus blandit. Suspendisse at suscipit sapien, vel varius neque. Integer ac libero a est dignissim blandit vitae ac ipsum. Etiam ut accumsan nibh. Integer eu posuere nisi, ut varius purus.','2018-06-22 00:06:50','2018-05-30 12:28:25','2018-06-23 00:06:12','Ispod Pančevačkog mosta','Sunđer Bob',1,1),(22,'Nemam više ideja','Quisque facilisis nisl eu metus iaculis condimentum. Praesent feugiat arcu vitae ex suscipit, eget tincidunt lectus ultricies. Pellentesque elit ligula, ultricies a pharetra vitae, mollis in diam. Ut vel quam faucibus, malesuada velit at, lacinia nunc. Integer fringilla sit amet felis sed molestie. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu ligula tempus justo dictum pretium. Sed vestibulum augue risus, non tempus erat luctus sed. Cras felis eros, feugiat et maximus sit amet, cursus sit amet enim. Sed pellentesque tellus gravida iaculis viverra. Morbi rutrum leo at arcu luctus tempor ut quis arcu. Nam pharetra ultricies ipsum. Curabitur ut ex tempor, placerat augue quis, semper leo. Proin iaculis, tortor sed dapibus aliquam, velit enim bibendum leo, quis finibus dolor felis sit amet est. Vivamus ex felis, cursus vel viverra eu, viverra at neque. Sed placerat sapien neque, suscipit maximus dui aliquam in.','2018-06-23 01:06:08','2018-05-30 13:44:32','2018-06-24 01:06:15','Tu negde','Hašim Tači',1,1);
/*!40000 ALTER TABLE `dogadjaj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dogadjaj_stavka`
--

DROP TABLE IF EXISTS `dogadjaj_stavka`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dogadjaj_stavka` (
  `dogadjaj_id_dogadjaj` int(11) NOT NULL,
  `stavka_sifarnik_id_stavka` int(11) NOT NULL,
  PRIMARY KEY (`dogadjaj_id_dogadjaj`,`stavka_sifarnik_id_stavka`),
  KEY `fk_dogadjaj_stavka_dogadjaj1_idx` (`dogadjaj_id_dogadjaj`),
  KEY `fk_dogadjaj_stavka_stavka_sifarnik1_idx` (`stavka_sifarnik_id_stavka`),
  CONSTRAINT `fk_dogadjaj_stavka_dogadjaj1` FOREIGN KEY (`dogadjaj_id_dogadjaj`) REFERENCES `dogadjaj` (`id_dogadjaj`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dogadjaj_stavka_stavka_sifarnik1` FOREIGN KEY (`stavka_sifarnik_id_stavka`) REFERENCES `stavka_sifarnik` (`id_stavka`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dogadjaj_stavka`
--

LOCK TABLES `dogadjaj_stavka` WRITE;
/*!40000 ALTER TABLE `dogadjaj_stavka` DISABLE KEYS */;
INSERT INTO `dogadjaj_stavka` VALUES (1,1),(1,5),(1,8),(2,1),(2,2),(2,3),(2,4),(3,1),(3,2),(3,3),(3,7),(3,8),(3,9),(4,1),(4,6);
/*!40000 ALTER TABLE `dogadjaj_stavka` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gost`
--

DROP TABLE IF EXISTS `gost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gost` (
  `id_gost` int(10) NOT NULL,
  `vreme_prijavljivanja` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_gost`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gost`
--

LOCK TABLES `gost` WRITE;
/*!40000 ALTER TABLE `gost` DISABLE KEYS */;
INSERT INTO `gost` VALUES (1234567890,'2018-10-11 15:28:12'),(1528216498,'2018-06-05 04:34:58'),(1528380472,'2018-06-07 02:07:52'),(1528468229,'2018-06-08 02:30:29');
/*!40000 ALTER TABLE `gost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `izvestaj`
--

DROP TABLE IF EXISTS `izvestaj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `izvestaj` (
  `id_izvestaj` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(45) DEFAULT NULL,
  `period` varchar(100) DEFAULT NULL,
  `admin_id_admin` int(11) NOT NULL,
  PRIMARY KEY (`id_izvestaj`),
  KEY `fk_izvestaj_admin1_idx` (`admin_id_admin`),
  CONSTRAINT `fk_izvestaj_admin1` FOREIGN KEY (`admin_id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `izvestaj`
--

LOCK TABLES `izvestaj` WRITE;
/*!40000 ALTER TABLE `izvestaj` DISABLE KEYS */;
/*!40000 ALTER TABLE `izvestaj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `odgovori`
--

DROP TABLE IF EXISTS `odgovori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `odgovori` (
  `id_odgovor` int(11) NOT NULL AUTO_INCREMENT,
  `odgovor` varchar(50) NOT NULL DEFAULT '0',
  `pitanja_id_pitanja` int(11) NOT NULL,
  `broj_odgovora` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_odgovor`),
  KEY `fk_odgovori_pitanja1_idx` (`pitanja_id_pitanja`),
  CONSTRAINT `fk_odgovori_pitanja1` FOREIGN KEY (`pitanja_id_pitanja`) REFERENCES `pitanja` (`id_pitanja`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `odgovori`
--

LOCK TABLES `odgovori` WRITE;
/*!40000 ALTER TABLE `odgovori` DISABLE KEYS */;
INSERT INTO `odgovori` VALUES (1,'Da',1,8),(2,'Ne',1,4),(3,'Šta je to češanje?',1,6),(4,'Nemam pojma',2,7),(5,'Hmmm...',2,1),(6,'Ogovor broj 1.',3,4),(7,'Ogovor broj 2.',3,1),(8,'Ogovor broj 3',3,0),(9,'Prvi odgovor.',4,4),(10,'Drugi odgovor.',4,0),(11,'Treći odgvor.',4,1),(12,'1. Da',5,4),(13,'2. Ne',5,0),(14,'3. Možda',5,1),(15,'4. Kako da ne',5,0);
/*!40000 ALTER TABLE `odgovori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oglas`
--

DROP TABLE IF EXISTS `oglas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oglas` (
  `id_oglas` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` varchar(45) NOT NULL,
  `tekst` varchar(1000) NOT NULL,
  `vreme_postavljanja` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vreme_isticanja` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor` varchar(45) NOT NULL,
  `organizacija_id_organizacija` int(11) NOT NULL,
  `brisanje` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_oglas`),
  KEY `fk_oglas_organizacija1_idx` (`organizacija_id_organizacija`),
  CONSTRAINT `fk_oglas_organizacija1` FOREIGN KEY (`organizacija_id_organizacija`) REFERENCES `organizacija` (`id_organizacija`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oglas`
--

LOCK TABLES `oglas` WRITE;
/*!40000 ALTER TABLE `oglas` DISABLE KEYS */;
INSERT INTO `oglas` VALUES (1,'Prodajem cincilator','Prodajem malo korišćen cincilator u odličnom stanju. Cijena, prava sitnica.','2018-05-12 17:45:34','2018-12-11 16:28:12','Šahbaz',1,1),(2,'Oglašavam oglas :op','Odličan oglas za svakoga','2018-05-12 17:45:34','2018-06-27 15:28:12','Autorčina',1,0),(3,'Oglaščina do jaja','Prodajem svašta nešto iz kulture.','2018-05-30 03:05:02','2018-06-21 03:06:40','Tasmanijski đavo',1,1);
/*!40000 ALTER TABLE `oglas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organizacija`
--

DROP TABLE IF EXISTS `organizacija`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organizacija` (
  `id_organizacija` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `nivo` tinyint(1) NOT NULL DEFAULT '0',
  `naziv_organizacije` varchar(100) NOT NULL,
  `sediste` varchar(100) NOT NULL,
  `kontakt_osoba` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `tekst_organizacije` text NOT NULL,
  `oblast_delovanja` varchar(45) NOT NULL,
  `web_adresa` varchar(45) NOT NULL,
  `vreme_prijavljivanja` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_organizacija`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizacija`
--

LOCK TABLES `organizacija` WRITE;
/*!40000 ALTER TABLE `organizacija` DISABLE KEYS */;
INSERT INTO `organizacija` VALUES (1,'organizacija','o',1,'Humanitarna organizacija','Bulevar Kralja Aleksandra 10 Beograd','Petar Petrović','humanitarna@gmail.com','Ovo je neki tekst za humanitarnu organizaciju.','Humanitarstvo','www.humanitarnost.com','2018-05-10 14:04:48'),(2,'b','b',1,'Beta','Neki Bulevar 333 Beograd','Alan Ford','todor@sbb.rs','Grupa TNT','Tajni agenti','www.beta.com','2018-05-16 16:22:28'),(3,'c','c',1,'Gama','Sindjeliceva 10 Pancevo','Gervasijus Tvinkleminkleson','c@yahoo.com','Sta god bilo bice.','Nemam pojma','www.gama.com','2018-05-16 16:27:39'),(6,'d','d',0,'Delta','Ruzveltova 11 Novi Sad','Miroslav Mišković','d@sbb.rs','Krademo sve što možemo.','Šta ne radi?','www.delta.net','2018-05-16 17:06:16'),(40,'epsilon','e',0,'Epsilon','5. ulica 45 Surdulica','Novica Tončev','epsilon@mail.org','Gradimo sve i svašta.','Građevinarstvo','www.epsilon.org','2018-05-17 16:21:59'),(56,'gama','g',0,'Gama','Peta Avenija 222 Albukerki','Duško Dugouško','gama@hotmail.ru','Pravimo i prikazujemo crtane filmove.','Jedenje šargarepe','www.gama.rs','2018-05-17 17:24:15'),(60,'t','t',0,'Teta','Južni Bulevar 45 Niš','Sir Oliver','t@gmail.com','Daj šta daš { ;op','Nemam pojma','www.teta.net','2018-05-18 13:08:30'),(78,'omega','o',0,'Omega','Užička 23 Ćićevac','Jeremija Lešina','omega@sbb.rs','Isključivo beremo šljive i kruške. Ostalo ne diramo ni motkom.','Beremo šljive i kruške.','www.omega.rs','2018-05-25 16:26:02');
/*!40000 ALTER TABLE `organizacija` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pitanja`
--

DROP TABLE IF EXISTS `pitanja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pitanja` (
  `id_pitanja` int(11) NOT NULL AUTO_INCREMENT,
  `pitanje` varchar(100) NOT NULL,
  `anketa_id_anketa` int(11) NOT NULL,
  PRIMARY KEY (`id_pitanja`),
  KEY `fk_pitanja_anketa1_idx` (`anketa_id_anketa`),
  CONSTRAINT `fk_pitanja_anketa1` FOREIGN KEY (`anketa_id_anketa`) REFERENCES `anketa` (`id_anketa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pitanja`
--

LOCK TABLES `pitanja` WRITE;
/*!40000 ALTER TABLE `pitanja` DISABLE KEYS */;
INSERT INTO `pitanja` VALUES (1,'Da li volite da se češete?',2),(2,'Šta je to kultura?',2),(3,'Pitanje broj 1?',3),(4,'Pitanje broj 2?',3),(5,'Pitanje broj 3?',3);
/*!40000 ALTER TABLE `pitanja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podaci_o_sajtu`
--

DROP TABLE IF EXISTS `podaci_o_sajtu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podaci_o_sajtu` (
  `kontakt_osoba` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefon1` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefon2` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefon3` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`kontakt_osoba`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podaci_o_sajtu`
--

LOCK TABLES `podaci_o_sajtu` WRITE;
/*!40000 ALTER TABLE `podaci_o_sajtu` DISABLE KEYS */;
INSERT INTO `podaci_o_sajtu` VALUES ('Admin Adminović','admin@kulturologija.com','011/123-4567','011/000-0000','064/987-6543');
/*!40000 ALTER TABLE `podaci_o_sajtu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `popunjena_anketa`
--

DROP TABLE IF EXISTS `popunjena_anketa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `popunjena_anketa` (
  `anketa_id_anketa` int(11) NOT NULL,
  `gost_id_gost` int(10) NOT NULL,
  PRIMARY KEY (`anketa_id_anketa`,`gost_id_gost`),
  KEY `fk_id_gost_idx` (`gost_id_gost`),
  CONSTRAINT `fk_id_anketa` FOREIGN KEY (`anketa_id_anketa`) REFERENCES `anketa` (`id_anketa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_id_gost` FOREIGN KEY (`gost_id_gost`) REFERENCES `gost` (`id_gost`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `popunjena_anketa`
--

LOCK TABLES `popunjena_anketa` WRITE;
/*!40000 ALTER TABLE `popunjena_anketa` DISABLE KEYS */;
INSERT INTO `popunjena_anketa` VALUES (2,1528216498),(2,1528468229),(3,1528216498),(3,1528468229);
/*!40000 ALTER TABLE `popunjena_anketa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posete`
--

DROP TABLE IF EXISTS `posete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posete` (
  `datum` date NOT NULL,
  `broj_poseta` int(6) DEFAULT '1',
  PRIMARY KEY (`datum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posete`
--

LOCK TABLES `posete` WRITE;
/*!40000 ALTER TABLE `posete` DISABLE KEYS */;
INSERT INTO `posete` VALUES ('2018-05-22',3),('2018-05-23',1),('2018-05-25',1),('2018-05-28',1),('2018-05-29',1),('2018-05-30',4),('2018-05-31',1),('2018-06-01',1),('2018-06-04',1),('2018-06-05',6),('2018-06-06',2),('2018-06-07',2),('2018-06-08',2);
/*!40000 ALTER TABLE `posete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sifarnik`
--

DROP TABLE IF EXISTS `sifarnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sifarnik` (
  `id_sifra` int(11) NOT NULL AUTO_INCREMENT,
  `kategorija_sifre` varchar(45) NOT NULL,
  `odobreno` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_sifra`),
  UNIQUE KEY `kategorija_sifre_UNIQUE` (`kategorija_sifre`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sifarnik`
--

LOCK TABLES `sifarnik` WRITE;
/*!40000 ALTER TABLE `sifarnik` DISABLE KEYS */;
INSERT INTO `sifarnik` VALUES (1,'Ulice',1),(2,'Mesta',1),(3,'Oblast delovanja',1),(4,'Starosno doba posetilaca',1),(5,'Vrsta događaja',1),(6,'Karakteristike prostora',1),(7,'Neka nova šifra',0),(25,'Proba šifre',0);
/*!40000 ALTER TABLE `sifarnik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stavka`
--

DROP TABLE IF EXISTS `stavka`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stavka` (
  `id_stavka` int(11) NOT NULL AUTO_INCREMENT,
  `broj_organizacija` int(11) DEFAULT NULL,
  `broj_dogadjaja` int(11) DEFAULT NULL,
  `broj_gostiju` int(11) DEFAULT NULL,
  `izvestaj_id_izvestaj` int(11) NOT NULL,
  PRIMARY KEY (`id_stavka`),
  KEY `fk_stavka_izvestaj1_idx` (`izvestaj_id_izvestaj`),
  CONSTRAINT `fk_stavka_izvestaj1` FOREIGN KEY (`izvestaj_id_izvestaj`) REFERENCES `izvestaj` (`id_izvestaj`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stavka`
--

LOCK TABLES `stavka` WRITE;
/*!40000 ALTER TABLE `stavka` DISABLE KEYS */;
/*!40000 ALTER TABLE `stavka` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stavka_sifarnik`
--

DROP TABLE IF EXISTS `stavka_sifarnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stavka_sifarnik` (
  `id_stavka` int(11) NOT NULL AUTO_INCREMENT,
  `stavka` varchar(45) NOT NULL,
  `vreme_postavljanja` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `vreme_isticanja` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sifarnik_id_sifra` int(11) NOT NULL,
  PRIMARY KEY (`id_stavka`),
  KEY `fk_stavka_sifarnik_sifarnik1_idx` (`sifarnik_id_sifra`),
  CONSTRAINT `fk_stavka_sifarnik_sifarnik1` FOREIGN KEY (`sifarnik_id_sifra`) REFERENCES `sifarnik` (`id_sifra`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stavka_sifarnik`
--

LOCK TABLES `stavka_sifarnik` WRITE;
/*!40000 ALTER TABLE `stavka_sifarnik` DISABLE KEYS */;
INSERT INTO `stavka_sifarnik` VALUES (1,'Prilagođeno Za Invalide','2018-05-23 15:25:23','2019-05-23 15:25:23',6),(2,'Pet-frendli','2018-05-23 15:25:23','2019-05-23 15:25:23',6),(3,'Slobodan Parking','2018-05-23 15:25:23','2019-05-23 15:25:23',6),(4,'Sportski','2018-05-23 15:25:23','2019-05-23 15:25:23',5),(5,'Filmski','2018-05-23 15:25:23','2019-05-23 15:25:23',5),(6,'Pozorišni','2018-05-23 15:25:23','2019-05-23 15:25:23',5),(7,'Muzički','2018-05-23 15:25:23','2019-05-23 15:25:23',5),(8,'Festival','2018-05-23 15:25:23','2019-05-23 15:25:23',5),(9,'Promotivni','2018-05-23 15:25:23','2019-05-23 15:25:23',5),(10,'Stavka za novu šifru','2018-05-23 15:25:23','2019-05-23 15:25:23',7),(11,'Beograd','2018-06-06 02:06:43','2018-06-22 02:06:47',2),(12,'Novi Sad','2018-06-12 04:06:24','2018-06-30 04:06:26',2);
/*!40000 ALTER TABLE `stavka_sifarnik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefon`
--

DROP TABLE IF EXISTS `telefon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telefon` (
  `id_telefoni` int(11) NOT NULL AUTO_INCREMENT,
  `telefon` varchar(45) DEFAULT NULL,
  `organizacija_id_organizacija` int(11) NOT NULL,
  PRIMARY KEY (`id_telefoni`),
  KEY `fk_telefoni_organizacija1_idx` (`organizacija_id_organizacija`),
  CONSTRAINT `fk_telefoni_organizacija1` FOREIGN KEY (`organizacija_id_organizacija`) REFERENCES `organizacija` (`id_organizacija`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefon`
--

LOCK TABLES `telefon` WRITE;
/*!40000 ALTER TABLE `telefon` DISABLE KEYS */;
INSERT INTO `telefon` VALUES (1,'011/159-1238',1),(3,'011/654-987',56),(14,'018/615-159',60),(15,'018/476-1256',60),(16,'069/438-9641',60),(17,'064/123-4587',60),(18,'069/999-8888',1),(27,'066/125-5555',78),(28,'069/444-8888',78),(33,'013/156-7856',2),(34,'023/46-9871',6),(35,'021/324-9654',40);
/*!40000 ALTER TABLE `telefon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vest`
--

DROP TABLE IF EXISTS `vest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vest` (
  `id_vest` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` varchar(45) NOT NULL,
  `tekst` varchar(10000) NOT NULL,
  `vreme_postavljanja` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vreme_isticanja` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor` varchar(45) NOT NULL,
  `organizacija_id_organizacija` int(11) NOT NULL,
  `brisanje` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_vest`),
  KEY `fk_vest_organizacija1_idx` (`organizacija_id_organizacija`),
  CONSTRAINT `fk_vest_organizacija1` FOREIGN KEY (`organizacija_id_organizacija`) REFERENCES `organizacija` (`id_organizacija`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vest`
--

LOCK TABLES `vest` WRITE;
/*!40000 ALTER TABLE `vest` DISABLE KEYS */;
INSERT INTO `vest` VALUES (1,'Prva vest iz kulture','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam justo neque, rhoncus id blandit id, malesuada a ex. Nulla et interdum ipsum. Nullam fringilla sollicitudin purus a suscipit. Nam tristique, felis quis finibus condimentum, justo tellus consectetur justo, vitae ornare lacus lacus nec quam. Duis pharetra felis sed massa vestibulum elementum. Quisque dapibus pharetra eros convallis rutrum. Nam imperdiet tortor sed orci fringilla consequat. Proin consequat, elit eu blandit facilisis, eros odio faucibus nulla, in sodales arcu eros et felis. In id nisl et erat venenatis tempor. Nulla molestie nulla at sapien semper ullamcorper. Mauris dignissim euismod lorem. Ut vulputate varius faucibus.','2018-04-11 15:28:12','2018-08-30 01:08:50','Donald Tramp',1,1),(2,'Bez veze vest iz kulture','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam justo neque, rhoncus id blandit id, malesuada a ex. Nulla et interdum ipsum. Nullam fringilla sollicitudin purus a suscipit. Nam tristique, felis quis finibus condimentum, justo tellus consectetur justo, vitae ornare lacus lacus nec quam. Duis pharetra felis sed massa vestibulum elementum. Quisque dapibus pharetra eros convallis rutrum. Nam imperdiet tortor sed orci fringilla consequat. Proin consequat, elit eu blandit facilisis, eros odio faucibus nulla, in sodales arcu eros et felis. In id nisl et erat venenatis tempor. Nulla molestie nulla at sapien semper ullamcorper. Mauris dignissim euismod lorem. Ut vulputate varius faucibus.','2018-05-22 06:33:00','2018-06-02 23:28:12','Nepoznat Autor',1,0),(3,'Sportska vest','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam justo neque, rhoncus id blandit id, malesuada a ex. Nulla et interdum ipsum. Nullam fringilla sollicitudin purus a suscipit. Nam tristique, felis quis finibus condimentum, justo tellus consectetur justo, vitae ornare lacus lacus nec quam. Duis pharetra felis sed massa vestibulum elementum. Quisque dapibus pharetra eros convallis rutrum. Nam imperdiet tortor sed orci fringilla consequat. Proin consequat, elit eu blandit facilisis, eros odio faucibus nulla, in sodales arcu eros et felis. In id nisl et erat venenatis tempor. Nulla molestie nulla at sapien semper ullamcorper. Mauris dignissim euismod lorem. Ut vulputate varius faucibus.','2018-05-15 06:33:00','2018-10-01 13:33:12','Kuče Dragoljupče',2,1),(4,'Filmska vest','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam justo neque, rhoncus id blandit id, malesuada a ex. Nulla et interdum ipsum. Nullam fringilla sollicitudin purus a suscipit. Nam tristique, felis quis finibus condimentum, justo tellus consectetur justo, vitae ornare lacus lacus nec quam. Duis pharetra felis sed massa vestibulum elementum. Quisque dapibus pharetra eros convallis rutrum. Nam imperdiet tortor sed orci fringilla consequat. Proin consequat, elit eu blandit facilisis, eros odio faucibus nulla, in sodales arcu eros et felis. In id nisl et erat venenatis tempor. Nulla molestie nulla at sapien semper ullamcorper. Mauris dignissim euismod lorem. Ut vulputate varius faucibus.','2018-05-17 08:33:00','2018-12-13 21:01:12','Terminator',3,1),(8,'Neki naslov neke vesti','Morbi pharetra massa eget tortor semper, interdum bibendum lorem mollis. Ut vel dui ut orci aliquet rutrum eu sed urna. In tempor hendrerit nisl, id molestie nunc maximus at. Donec sodales diam eu erat egestas efficitur. Mauris ante leo, porttitor non elementum nec, aliquam sed ligula. Nulla eleifend ac dui id suscipit. Suspendisse quis diam sed neque tempor imperdiet ut sit amet leo.','2018-05-31 02:05:33','2018-06-30 02:06:37','Sir Oliver',1,1);
/*!40000 ALTER TABLE `vest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vest_stavka`
--

DROP TABLE IF EXISTS `vest_stavka`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vest_stavka` (
  `stavka_sifarnik_id_stavka` int(11) NOT NULL,
  `vest_id_vest` int(11) NOT NULL,
  PRIMARY KEY (`stavka_sifarnik_id_stavka`,`vest_id_vest`),
  KEY `fk_vest_stavka_stavka_sifarnik1_idx` (`stavka_sifarnik_id_stavka`),
  KEY `fk_vest_stavka_vest1_idx` (`vest_id_vest`),
  CONSTRAINT `fk_vest_stavka_stavka_sifarnik1` FOREIGN KEY (`stavka_sifarnik_id_stavka`) REFERENCES `stavka_sifarnik` (`id_stavka`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vest_stavka_vest1` FOREIGN KEY (`vest_id_vest`) REFERENCES `vest` (`id_vest`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vest_stavka`
--

LOCK TABLES `vest_stavka` WRITE;
/*!40000 ALTER TABLE `vest_stavka` DISABLE KEYS */;
INSERT INTO `vest_stavka` VALUES (1,1),(2,2),(3,1),(5,1),(8,2),(9,2);
/*!40000 ALTER TABLE `vest_stavka` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-08 19:20:10
