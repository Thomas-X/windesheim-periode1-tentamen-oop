# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17)
# Database: db-barrista-app
# Generation Time: 2018-11-06 09:32:38 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Schema baristaapp
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `baristaapp`;

-- -----------------------------------------------------
-- Schema baristaapp
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `baristaapp` DEFAULT CHARACTER SET utf8 ;

use `baristaapp`;

# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lastTimeStamp` DATE NULL DEFAULT '2000-01-01',
  `postid` int(11) DEFAULT NULL,
  `creatorid` int(11) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `votes` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;

INSERT INTO `comments` (`id`, `postid`, `comment`)
VALUES
	(1,1,'Ristretto coffee java doppio, seasonal con panna at a organic. Café au lait, as aromatic acerbic cream extra beans bar whipped so cultivar.'),
	(2,1,'Ristretto coffeedoppio, seasonal con panna at a organic. Café au lait, as aromatic acerbic cream extra beans bar whipped so cultivar.');

/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `creatorid` INT(11) DEFAULT NULL,
  `lastTimeStamp` DATE NULL DEFAULT '2000-01-01',
  `name` varchar(150) NOT NULL DEFAULT '',
  `description` varchar(1250) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`id`, `name`, `description`)
VALUES
	(1,'great brizillian coffee','Strong wings in as grounds chicory galão redeye french press cortado sugar. Mug spoon ristretto foam aroma iced to go redeye extra kopi-luwak. Lungo latte decaffeinated, con panna caffeine half and half organic lungo. Steamed, wings seasonal fair trade rich that con panna organic.');

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table recipees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `recipees`;

CREATE TABLE `recipees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `isApproved` INT(11) NULL DEFAULT 0,
  `lastUpdate` DATE NULL DEFAULT '2000-01-01',
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(250) DEFAULT NULL,
  `step01` varchar(250) DEFAULT NULL,
  `ingredient01` varchar(250) DEFAULT NULL,
  `step02` varchar(250) DEFAULT NULL,
  `ingredient02` varchar(250) DEFAULT NULL,
  `step03` varchar(250) DEFAULT NULL,
  `ingredient03` varchar(250) DEFAULT NULL,
  `step04` varchar(250) DEFAULT NULL,
  `ingredient04` varchar(250) DEFAULT NULL,
  `step05` varchar(250) DEFAULT NULL,
  `ingredient05` varchar(250) DEFAULT NULL,
  `step06` varchar(250) DEFAULT NULL,
  `ingredient06` varchar(250) DEFAULT '',
  `timeToPrep` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `recipees` WRITE;
/*!40000 ALTER TABLE `recipees` DISABLE KEYS */;

INSERT INTO `recipees` (`id`, `isApproved`, `name`, `description`, `step01`, `ingredient01`, `step02`, `ingredient02`, `step03`, `ingredient03`, `step04`, `ingredient04`, `step05`, `ingredient05`, `step06`, `ingredient06`, `timeToPrep`)
VALUES
	(1, 1, 'Cappocinno Brazilian','This dark full flavoured cappocino is perfect after a juicy steak','slowly bring the milk to a heat of 60degree celsius, use a whisker to create the perfect layer of foam','milk 50ml','Bring the water to a temprature of 85degrees celsius and use your machine to create the coffee','water 150ml','distibute the coffee clearly over the compressor for the fine tast.','brazillian darkroast 50gr',NULL,NULL,NULL,NULL,NULL,NULL,3),
	(3, 1,'Cappocinno Brazilian','This dark full flavoured cappocino is perfect after a juicy steak','slowly bring the milk to a heat of 60degree celsius, use a whisker to create the perfect layer of foam','milk 50ml','Bring the water to a temprature of 85degrees celsius and use your machine to create the coffee','water 150ml','distibute the coffee clearly over the compressor for the fine tast.','brazillian dark roast 60gr',NULL,NULL,NULL,NULL,NULL,'',61);

/*!40000 ALTER TABLE `recipees` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `role`)
VALUES
	(1,'Administrator'),
	(2,'user');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `email` varchar(200) NOT NULL DEFAULT '',
  `mobile` varchar(20) DEFAULT NULL,
  `rememberMeToken` varchar(1024) DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `roleid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

# dont insert because unencrypted pwd
# INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `mobile`, `password`, `roleid`)
# VALUES
# 	(2,'Stephan','Hoeksema','s.hoeksema@windesheimflevoland.nl','0641612525','ietsie!0*0',1);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
