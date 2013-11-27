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

CREATE DATABASE `db_tackster`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `db_tackster`;

#
# Structure for the `bmk_entry` table : 
#

DROP TABLE IF EXISTS `bmk_entry`;

CREATE TABLE `bmk_entry` (
  `uc_id` bigint(11) NOT NULL COMMENT 'user credential id to tie bookmark back to',
  `t_id` bigint(20) NOT NULL COMMENT 'Track ID this bookmark is associated with.',
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID of bookmark',
  `url` varchar(45) NOT NULL COMMENT 'URL of referenced bookmark',
  `privacy` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=private, 1=public',
  `keyword` varchar(45) NOT NULL COMMENT 'Keywords to index bookmark by.',
  `description` text NOT NULL COMMENT 'Description of bookmark.',
  `bmk_image` tinytext NOT NULL COMMENT 'Path to bookmark image on file system.',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uc_id` (`uc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=16384 PACK_KEYS=0 ROW_FORMAT=COMPACT;

#
# Structure for the `bmk_activity` table : 
#

DROP TABLE IF EXISTS `bmk_activity`;

CREATE TABLE `bmk_activity` (
  `be_id` bigint(20) NOT NULL COMMENT 'Bookmark entry ID',
  `uc_id` int(11) NOT NULL COMMENT 'ID of user who liked the bookmark',
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique record ID',
  `likes` tinyint(4) DEFAULT NULL COMMENT 'Like flag: 1=yes',
  `repin` tinyint(4) DEFAULT NULL COMMENT 'Repin flag: 1=yes',
  PRIMARY KEY (`id`),
  KEY `be_id` (`be_id`),
  KEY `uc_id` (`uc_id`),
  CONSTRAINT `bmk_like_fk` FOREIGN KEY (`be_id`) REFERENCES `bmk_entry` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

#
# Structure for the `bmk_comment` table : 
#

DROP TABLE IF EXISTS `bmk_comment`;

CREATE TABLE `bmk_comment` (
  `be_id` bigint(20) NOT NULL COMMENT 'ID of bookmark entry being commented on.',
  `uc_id` bigint(20) NOT NULL COMMENT 'User ID of peron making comment.',
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
  `comment` text NOT NULL COMMENT 'Comment for bookmark',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `be_id` (`be_id`),
  KEY `uc_id` (`uc_id`),
  CONSTRAINT `bmk_comment_fk` FOREIGN KEY (`be_id`) REFERENCES `bmk_entry` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Structure for the `lkup_keyword` table : 
#

DROP TABLE IF EXISTS `lkup_keyword`;

CREATE TABLE `lkup_keyword` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for keyword',
  `keyword` varchar(20) DEFAULT NULL COMMENT 'The keyword',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `keyword` (`keyword`)
) ENGINE=MyISAM AUTO_INCREMENT=584984 DEFAULT CHARSET=utf8 COMMENT='These are predefined keywords. Any number of keywords can be';

#
# Structure for the `user_credentials` table : 
#

DROP TABLE IF EXISTS `user_credentials`;

CREATE TABLE `user_credentials` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'User ID - base all records off this UID.',
  `email` varchar(40) NOT NULL COMMENT 'User''s email',
  `password` varchar(128) NOT NULL COMMENT 'SHA2 256-bit encrypted password',
  `state` char(1) NOT NULL DEFAULT 'p' COMMENT 'a=active, p=pending, d=deactivated',
  `fromFB` char(1) NOT NULL DEFAULT 'I' COMMENT '''I'' for internal and ''F'' for facebook',
  `acct_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`),
  UNIQUE KEY `email_3` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8;

#
# Structure for the `tkn_password_reset` table : 
#

DROP TABLE IF EXISTS `tkn_password_reset`;

CREATE TABLE `tkn_password_reset` (
  `uc_id` bigint(20) NOT NULL COMMENT 'User credential ID',
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique record ID',
  `token` text NOT NULL COMMENT 'Token string',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_id` (`uc_id`),
  KEY `token` (`token`(1)),
  CONSTRAINT `tkn_password_reset_fk` FOREIGN KEY (`uc_id`) REFERENCES `user_credentials` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

#
# Structure for the `track` table : 
#

DROP TABLE IF EXISTS `track`;

CREATE TABLE `track` (
  `uc_id` bigint(11) NOT NULL COMMENT 'User Credential ID',
  `b_id` bigint(22) NOT NULL COMMENT 'NOT NEEDED?: Bookmark ID',
  `id` bigint(22) NOT NULL AUTO_INCREMENT COMMENT 'Track ID',
  `keyword` tinytext NOT NULL COMMENT 'Comma separted keywords',
  `title` varchar(22) NOT NULL COMMENT 'Title of bookmark',
  `description` text COMMENT 'Description of track',
  `private` char(1) NOT NULL DEFAULT 'F',
  `flag_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Set if this is the default track for the user.',
  PRIMARY KEY (`id`),
  KEY `uc_id` (`uc_id`),
  KEY `b_id` (`b_id`),
  KEY `keyword` (`keyword`(1)),
  CONSTRAINT `track_fk` FOREIGN KEY (`uc_id`) REFERENCES `user_credentials` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8 PACK_KEYS=0 ROW_FORMAT=COMPACT;

#
# Structure for the `track_activity` table : 
#

DROP TABLE IF EXISTS `track_activity`;

CREATE TABLE `track_activity` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `uc_id` bigint(20) NOT NULL,
  `trck_id` bigint(22) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Structure for the `trck_comment` table : 
#

DROP TABLE IF EXISTS `trck_comment`;

CREATE TABLE `trck_comment` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `uc_id` bigint(11) NOT NULL,
  `comment` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `user_profile` table : 
#

DROP TABLE IF EXISTS `user_profile`;

CREATE TABLE `user_profile` (
  `uc_id` bigint(20) NOT NULL COMMENT 'User credential ID to reference profile into back to.',
  `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of user''s profile.',
  `first` varchar(20) DEFAULT NULL COMMENT 'First name',
  `last` varchar(20) DEFAULT NULL COMMENT 'Last name',
  `username` varchar(20) DEFAULT NULL COMMENT 'Username - not used but available for the future if needed.',
  `sex` char(1) DEFAULT NULL COMMENT 'm=male, f=female',
  `bio` text COMMENT 'NOT USED: Available in future if needed.\r\nThe user can add a short bio about themself.',
  `photo` blob COMMENT 'NOT SUPPORTED: Profile picture stored in the DB as a binary file.',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_id` (`uc_id`),
  UNIQUE KEY `uc_id_2` (`uc_id`),
  CONSTRAINT `user_profile_fk` FOREIGN KEY (`uc_id`) REFERENCES `user_credentials` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

#
# Definition for the `delete_oldPassToken` procedure : 
#

DROP PROCEDURE IF EXISTS `delete_oldPassToken`;

CREATE DEFINER = 'tackster'@'%' PROCEDURE `delete_oldPassToken`()
    NOT DETERMINISTIC
    CONTAINS SQL
    SQL SECURITY DEFINER
    COMMENT '敒潭敶漠摬琠歯湥⁳牦浯琠敨䐠⹂'
BEGIN
	DELETE LOW_PRIORITY FROM tkn_password_reset WHERE TIMESTAMPDIFF(MINUTE, `timestamp`, NOW()) > 30;
END;

