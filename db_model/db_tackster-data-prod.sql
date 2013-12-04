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
# Data for the `bmk_entry` table  (LIMIT 0,500)
#

INSERT INTO `bmk_entry` (`uc_id`, `t_id`, `id`, `url`, `privacy`, `keyword`, `description`, `bmk_image`, `timestamp`) VALUES 
  (74,3,1,'http://failblog.org',0,'fail, fav fail','Failblog website.','https://i.chzbgr.com/rectangleW160H120/7933670912/22C9AE3F','2013-12-04 15:00:07'),
  (74,3,2,'http://www.cheezburger.com',0,'fail, CHEESEBURGER, ','Cheeze it up.','https://i.chzbgr.com/rectangleW160H120/7934888192/5E87F246','2013-12-04 15:01:17'),
  (74,2,3,'http://my.sjsu.edu',1,'sjsu, my portal, mysjsu','MySJSU','http://my.sjsu.edu/pics/mybuttons/mysjsu_button/button-mysjsu-normal.png','2013-12-04 15:04:41'),
  (73,1,4,'http://www.flickr.com',1,'flickr','Flickr is almost certainly the best online photo management and sharing application in the world. Show off your favorite photos and videos to the world, securely and privately show content to your friends and family, or blog the photos and videos you take with a cameraphone.','http://l.yimg.com/g/images/progress/balls-24x12-white.gif','2013-12-04 15:05:03'),
  (73,5,5,'http://www.dominos.com',0,'food, pizza','Domino''s Pizza lets you browse coupons and order online - try the all new hand tossed crust, robust sauce and shredded mozzarella cheese.','http://cache.dominos.com/nolo/us/en/013144/assets/build/images/img/coupons/larges/2M2T-PAN-upsell.jpg','2013-12-04 15:08:41'),
  (73,5,6,'http://www.subway.com',0,'food, subway','SUBWAY is the undisputed leader in providing consumers with choices, including many healthier meal options. View our menu, see nutritional info, locate restaurants, buy a franchise, apply for jobs, order catering and give us your feedback. ','http://www.subway.com/core/images/supernav15/supernav_catering_top2b.jpg','2013-12-04 15:10:42'),
  (76,7,7,'http://innout.com',0,'fast food','At In-N-Out Burger, quality is everything. That&amp;amp;#39;s why in a world where food is often over-processed, prepackaged and frozen, In-N-Out makes everything the old fashioned way.','http://innout.com/images/mainicon_locationfinder5.png','2013-12-04 15:10:44'),
  (76,6,8,'http://mcdonalds.com',0,'mcdonalds','McDonald''s in the USA: Food and nutrition info, franchise opportunities, job and career info, restaurant locations, promotional information, history, innovation and more.','http://mcdonalds.com/etc/designs/mcdonalds/en/_jcr_content/genericpage/genericpagecontent/sitelevelconfiguration/logoimage.img.png','2013-12-04 15:12:47'),
  (76,6,9,'http://quiznos.com',0,'','Quiznos Restaurants the home of the Toasted Sandwich - lunch food, sandwiches, subs, salads, soups, box lunches, catering, and other bold, toasty flavors','http://www.quiznos.com/Libraries/2013-redesign/quiznos-logo.sflb.ashx','2013-12-04 15:14:28'),
  (73,5,10,'http://www.cheesecakefactory.com',0,'food, cheese cake','The Cheesecake Factory Home','http://www.cheesecakefactory.com/resources/1027x471_PeppermintBark_Banner.jpg','2013-12-04 15:15:26'),
  (76,8,11,'http://quiznos.com',0,'food','Quiznos Restaurants the home of the Toasted Sandwich - lunch food, sandwiches, subs, salads, soups, box lunches, catering, and other bold, toasty flavors','http://www.quiznos.com/Libraries/2013-redesign/quiznos-logo.sflb.ashx','2013-12-04 15:15:31'),
  (73,5,12,'http://www.pandaexpress.com',0,'food, panda express','Asian-inspired cuisine in a fast casual environment. Search menu items and nutrition facts, find a location near you, learn about careers and more. ','https://s3.amazonaws.com/PandaExpressWebsite/files/food/dropdown-menu-food-feature.jpg','2013-12-04 15:18:36'),
  (76,14,13,'http://jalopnik.com',0,'cars','Drive Free or Die','http://img.gawkerassets.com/img/192oz5idtytaapng/blg-avatar.png','2013-12-04 15:20:49'),
  (76,14,15,'http://amazon.com',0,'books','Online shopping from the earth''s biggest selection of books, magazines, music, DVDs, videos, electronics, computers, software, apparel &amp;amp;amp; accessories, shoes, jewelry, tools &amp;amp;amp; hardware, housewares, furniture, sporting goods, beauty &amp;amp;amp; personal care, broadband &amp;amp;amp; dsl, gourmet food &amp;amp;amp; just about anything else.','http://g-ecx.images-amazon.com/images/G/01/gno/beacon/BeaconSprite-US-01-fw._V355247711_.png','2013-12-04 15:22:38'),
  (76,17,16,'http://amazon.com',0,'books','Online shopping from the earth''s biggest selection of books, magazines, music, DVDs, videos, electronics, computers, software, apparel &amp;amp;amp; accessories, shoes, jewelry, tools &amp;amp;amp; hardware, housewares, furniture, sporting goods, beauty &amp;amp;amp; personal care, broadband &amp;amp;amp; dsl, gourmet food &amp;amp;amp; just about anything else.','http://g-ecx.images-amazon.com/images/G/01/img13/toys-games/htl/htl-black-friday/17toys-games_htl-cyber-monday-deals_roto_300x75._V369045616_.png','2013-12-04 15:23:38'),
  (73,13,17,'http://www.alienware.com',0,'computer, laptop','Build a custom gaming PC at Alienware. Alienware manufactures the world''s best high-performance PC gaming laptop and desktop computers. Buy yours today.','http://image.alienware.com/images/homepage_eye/2013-11/alienware-banner-slide-dpa-20131111.png','2013-12-04 15:25:17'),
  (73,13,18,'http://www.apple.com',0,'computer, laptop, mac, apple','Apple designs and creates iPod and iTunes, Mac laptop and desktop computers, the OS X operating system, and the revolutionary iPhone and iPad.','http://images.apple.com/home/images/promo_macbook_pro.jpg','2013-12-04 15:28:20'),
  (73,18,19,'http://www.ign.com',1,'game, games, mario','IGN is your site for Xbox 360, PS3, Wii, PC, 3DS, PS Vita &amp;amp;amp;amp;amp;amp; iPhone games with expert reviews, news, previews, trailers, cheat codes, wiki guides &amp;amp;amp;amp;amp;amp; walkthroughs','http://assets1.ignimgs.com/vid/thumbnails/user/2013/11/14/96017_Enemy_7__compact.jpg','2013-12-04 15:31:58');
COMMIT;

#
# Data for the `track` table  (LIMIT 0,500)
#

INSERT INTO `track` (`uc_id`, `b_id`, `id`, `keyword`, `title`, `description`, `private`, `flag_default`) VALUES 
  (73,0,1,'','My Private Bookmarks','This is your default track with private bookmarks.','T',1),
  (74,0,2,'','My Private Bookmarks','This is your default track with private bookmarks.','T',1),
  (74,0,3,'','Fails','My fav fails.','F',0),
  (73,0,5,'','Food','This is a food track','F',0),
  (76,0,6,'','My Private Bookmarks','This is your default track with private bookmarks.','T',1),
  (76,0,7,'','In n out','In n out burgers are the best!','F',0),
  (76,0,8,'','Quiznos','have it your way','F',0),
  (77,0,9,'','My Private Bookmarks','This is your default track with private bookmarks.','T',1),
  (77,0,12,'','Clothes','Some cool clothes','F',0),
  (73,0,13,'','Computer','This is a computer Track','F',0),
  (76,0,14,'','Cars','nice cars are fun to drive','F',0),
  (78,0,15,'','My Private Bookmarks','This is your default track with private bookmarks.','T',1),
  (76,0,17,'','Books','Books from Amazon','F',0),
  (73,0,18,'','Private Games Track','Has video game in it. ','T',0);
COMMIT;

#
# Data for the `track_activity` table  (LIMIT 0,500)
#

INSERT INTO `track_activity` (`uc_id`, `trck_id`, `id`, `date`) VALUES 
  (74,7,1,'2013-12-04 15:12:40');
COMMIT;

#
# Data for the `user_credentials` table  (LIMIT 0,500)
#

INSERT INTO `user_credentials` (`id`, `email`, `password`, `state`, `fromFB`, `acct_created`) VALUES 
  (72,'test@tackster.com  ','d18539cf579aaf237784eebd65044b8f3c064f6981e57c6cdec47f3082797b46fac540d54d3de82cc7954fd270770c2e81eecd928c2c7c58751cedd79379eb22','p','I','2013-09-25 14:26:56'),
  (73,'randy.zaatri.sjsu@gmail.com','63097d4e76759d748f84cb2b03298bb96091507b52aa9935baa2b9b1e1f5a9b7dc0df2e64d140fc014af223251714fad782450274e020baba6f56df320548ac8','p','I','2013-12-04 14:52:21'),
  (74,'jp.questio@gmail.com','3e818eec51b45583b9881f5f2fe455413483848ab61ba10a0c4914d5cfb24a155dfc70b707b948c1ae7ce175b7ee6f0d54487d07fcc147f813e0283346bb023c','p','I','2013-12-04 14:52:24'),
  (76,'mevadadhruv90@gmail.com','9275e8778c1b3cd9a8a046e9ed914befeb98d7cbc22aab480a28d8bc8fbf9de1cad798d8335cdb8b66544151481f2e37a027823085cd64f56f159a7eca091a94','p','I','2013-12-04 15:09:01'),
  (77,'tackster@tackster.com','d7912df19553c2e60c3000c6e6e7a4446c6cf444df8d0b828dc2d9cbe19211d3db760835257bde52c5952cbd0aca2a4464d7b3c7684c0c1a4467cc32e8fc53f8','p','I','2013-12-04 15:13:43'),
  (78,'miguel@sjsu.com','5a0eadeae9f80066e0055e3967583a6ad2115856a1e3b0f6d0ee7357a44212d57b02ccb0cdf791b6a6d9501f75b984f17f1b5867c327b71128a1bf4021584653','p','I','2013-12-04 15:20:36');
COMMIT;

#
# Data for the `user_profile` table  (LIMIT 0,500)
#

INSERT INTO `user_profile` (`uc_id`, `id`, `first`, `last`, `username`, `sex`, `bio`, `photo`, `timestamp`) VALUES 
  (72,10,'Test','Account','TestAccount','m',NULL,NULL,'2013-11-19 02:42:19'),
  (73,11,'Randy','Zaatri','randyz','m',NULL,NULL,'2013-12-04 14:59:25'),
  (74,12,'JP','Questio','jp.questio@gmail.com','',NULL,NULL,'2013-12-04 14:54:56'),
  (76,13,'red','Varyant','mevadadhruv90@gmail.','',NULL,NULL,'2013-12-04 15:09:01'),
  (77,14,'r','lee','tackster@tackster.co','',NULL,NULL,'2013-12-04 15:13:43'),
  (78,15,'Miguel','Gonzalez','miguel@sjsu.com','',NULL,NULL,'2013-12-04 15:20:36');
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;