# SQL Manager for MySQL 4.6.0.1
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : db_tackster


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

SET FOREIGN_KEY_CHECKS=0;

USE `db_tackster`;

#
# Truncate tables
#
TRUNCATE TABLE `bmk_activity`;
TRUNCATE TABLE `bmk_comment`;
TRUNCATE TABLE `bmk_entry`;
TRUNCATE TABLE `tkn_password_reset`;
TRUNCATE TABLE `track`;
TRUNCATE TABLE `track_activity`;
TRUNCATE TABLE `trck_comment`;
TRUNCATE TABLE `user_credentials`;
TRUNCATE TABLE `user_profile`;
COMMIT;

#
# Data for the `user_credentials` table  (LIMIT 0,500)
#

INSERT INTO `user_credentials` (`id`, `email`, `password`, `state`, `fromFB`, `acct_created`) VALUES 
  (72,'test@tackster.com  ','d18539cf579aaf237784eebd65044b8f3c064f6981e57c6cdec47f3082797b46fac540d54d3de82cc7954fd270770c2e81eecd928c2c7c58751cedd79379eb22','p','I','2013-09-25 14:26:56');
COMMIT;

#
# Data for the `user_profile` table  (LIMIT 0,500)
#

INSERT INTO `user_profile` (`uc_id`, `id`, `first`, `last`, `username`, `sex`, `bio`, `photo`, `timestamp`) VALUES 
  (72,10,'Test','Account','TestAccount','m',NULL,NULL,'2013-11-19 02:42:19');
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;