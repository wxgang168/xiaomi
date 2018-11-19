/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : myidashu.cc

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2018-11-19 17:11:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dsc_ad
-- ----------------------------
DROP TABLE IF EXISTS `dsc_ad`;
CREATE TABLE `dsc_ad` (
  `ad_id` varchar(255) DEFAULT NULL,
  `position_id` varchar(255) DEFAULT NULL,
  `media_type` varchar(255) DEFAULT NULL,
  `ad_name` varchar(255) DEFAULT NULL,
  `ad_link` varchar(255) DEFAULT NULL,
  `link_color` varchar(255) DEFAULT NULL,
  `b_title` varchar(255) DEFAULT NULL,
  `s_title` varchar(255) DEFAULT NULL,
  `ad_code` varchar(255) DEFAULT NULL,
  `ad_bg_code` varchar(255) DEFAULT NULL,
  `start_time` varchar(255) DEFAULT NULL,
  `end_time` varchar(255) DEFAULT NULL,
  `link_man` varchar(255) DEFAULT NULL,
  `link_email` varchar(255) DEFAULT NULL,
  `link_phone` varchar(255) DEFAULT NULL,
  `click_count` varchar(255) DEFAULT NULL,
  `enabled` varchar(255) DEFAULT NULL,
  `is_new` varchar(255) DEFAULT NULL,
  `is_hot` varchar(255) DEFAULT NULL,
  `is_best` varchar(255) DEFAULT NULL,
  `public_ruid` varchar(255) DEFAULT NULL,
  `ad_type` varchar(255) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dsc_ad
-- ----------------------------

-- ----------------------------
-- Table structure for ecs_ad
-- ----------------------------
DROP TABLE IF EXISTS `ecs_ad`;
CREATE TABLE `ecs_ad` (
  `ad_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `position_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `media_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ad_name` varchar(60) NOT NULL DEFAULT '',
  `ad_link` varchar(255) NOT NULL DEFAULT '',
  `ad_code` text NOT NULL,
  `start_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `link_man` varchar(60) NOT NULL DEFAULT '',
  `link_email` varchar(60) NOT NULL DEFAULT '',
  `link_phone` varchar(60) NOT NULL DEFAULT '',
  `click_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`ad_id`),
  KEY `position_id` (`position_id`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ecs_ad
-- ----------------------------
INSERT INTO `ecs_ad` VALUES ('11', '5', '0', '大家都喜欢左边广告', '#', '1437091450567936588.jpg', '1437033600', '1597478400', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('10', '4', '0', '新品上架左边广告', '#', '1437081494946827817.jpg', '1437033600', '1597478400', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('8', '3', '0', '首页轮播下广告2', '#', '1439235672175247984.jpg', '1437033600', '1597478400', '', '', '', '9', '1');
INSERT INTO `ecs_ad` VALUES ('9', '3', '0', '首页轮播下广告3', '#', '1439235663686851046.jpg', '1437033600', '1597478400', '', '', '', '7', '1');
INSERT INTO `ecs_ad` VALUES ('7', '3', '0', '首页轮播下广告1', '#', '1439235680072464326.jpg', '1437033600', '1597478400', '', '', '', '4', '1');
INSERT INTO `ecs_ad` VALUES ('5', '2', '0', '日化清洁分类下商品左广告', '', '1418945930438785320.jpg', '1418889600', '1547712000', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('27', '11', '0', '团购页顶部广告1', '', '1440453088903649388.jpg', '1440403200', '1442995200', '', '', '', '4', '1');
INSERT INTO `ecs_ad` VALUES ('15', '0', '0', '购买电视与平板分类下商品左广告', '', '1439243111683292287.jpg', '1439193600', '1568016000', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('16', '8', '0', '路由器与智能硬件分类下商品左侧广告大', '#', '1439256935405590666.jpg', '1439193600', '1820476800', '', '', '', '1', '1');
INSERT INTO `ecs_ad` VALUES ('17', '9', '0', '插线板、移动电源与电池分类下商品左侧广告小1', '', '1439257063359182674.jpg', '1439193600', '1788940800', '', '', '', '2', '1');
INSERT INTO `ecs_ad` VALUES ('18', '9', '0', '插线板、移动电源与电池分类下商品左侧广告小2', '#', '1439257083300448761.jpg', '1439193600', '1725868800', '', '', '', '2', '1');
INSERT INTO `ecs_ad` VALUES ('19', '9', '0', '耳机音箱与存储卡分类下商品左侧广告小1', '', '1439257211458415529.jpg', '1439193600', '1599638400', '', '', '', '1', '1');
INSERT INTO `ecs_ad` VALUES ('20', '9', '0', '耳机音箱与存储卡分类下商品左侧广告小2', '', '1439257230078103078.jpg', '1439193600', '1599638400', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('21', '9', '0', '小米生活方式分类下商品左侧广告小1', '', '1439257305251304063.jpg', '1439193600', '1631174400', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('22', '9', '0', '小米生活方式分类下商品左侧广告小2', '', '1439257325691545396.jpg', '1439193600', '1694246400', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('1', '1', '0', '首页倒计时广告1', '', '1416768092332228240.jpg', '1416729600', '1577088000', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('2', '1', '0', '首页倒计时广告2', '', '1416768116149461443.jpg', '1416729600', '1545552000', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('3', '2', '0', '护肤分类下商品左广告', '', '1418945852395048180.jpg', '1418889600', '1516176000', '', '', '', '1', '1');
INSERT INTO `ecs_ad` VALUES ('4', '2', '0', '彩妆分类下商品左广告', '', '1418945889355542340.jpg', '1418889600', '1516176000', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('6', '2', '0', '化妆工具分类下商品左广告', '', '1418945942250564060.jpg', '1418889600', '1579248000', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('28', '255', '0', '1', '', 'http://www.ectouch.cn/data/assets/images/ectouch2_ad1.png', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('29', '255', '0', '2', '', 'http://www.ectouch.cn/data/assets/images/ectouch2_ad2.png', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('30', '255', '0', '3', '', 'http://www.ectouch.cn/data/assets/images/ectouch2_ad3.png', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('31', '256', '0', '1', '', 'themes/xiaomi/images/index-theme-icon1.gif', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('32', '256', '0', '1', '', 'themes/xiaomi/images/index-theme-icon2.gif', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('33', '256', '0', '1', '', 'themes/xiaomi/images/index-theme-icon3.gif', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('34', '256', '0', '1', '', 'themes/xiaomi/images/index-theme-icon4.gif', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('35', '256', '0', '1', '', 'themes/xiaomi/images/index-theme-icon5.gif', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('36', '256', '0', '1', '', 'themes/xiaomi/images/index-theme-icon6.gif', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('37', '256', '0', '1', '', 'themes/xiaomi/images/index-theme-icon7.gif', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('38', '256', '0', '1', '', 'themes/xiaomi/images/index-theme-icon8.gif', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('39', '256', '0', '1', '', 'themes/xiaomi/images/index-theme-icon9.gif', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('40', '256', '0', '1', '', 'themes/xiaomi/images/index-theme-icon10.gif', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('41', '257', '0', '1', '', 'http://img30.360buyimg.com/mobilecms/jfs/t1285/301/224079095/27270/fbbc1f40/555c6c90Ncb4fe515.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('42', '258', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t2500/354/5004119/28206/c13fa182/55e5a38fN0b84386b.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('43', '258', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t1951/303/313107422/21311/5bc233db/55ffda9bN7c81adbe.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('44', '259', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t1786/20/1237061297/11292/32fb2a76/55e41b2aN73bcf4d3.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('45', '259', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t1660/172/1178175164/12107/b84acf01/55e41becN110f0639.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('46', '260', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t1753/282/1346478890/16937/b0c72fa9/55e41ca6N55f0952e.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('47', '261', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t1339/42/1033573654/18650/85fb7e47/55e41d25Ne7fd71e7.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('48', '262', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t1825/226/1292630398/9320/a7003c2f/55e42185N8d6eb615.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('49', '262', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t1753/288/1310409506/7943/7beba973/55e4221bN9857b1f4.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('50', '263', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t2293/126/6325541/15463/885e77f2/55e5a839N76e8a8ab.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('51', '263', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t2101/138/4648025/12171/7f46ddb9/55e5ac15N3f33b3cd.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
INSERT INTO `ecs_ad` VALUES ('52', '264', '0', '1', '', 'http://m.360buyimg.com/mobilecms/jfs/t2317/6/7126462/28018/ea8767a/55e5a70bNb1ffd2fe.jpg', '1396339200', '1525161600', '', '', '', '0', '1');
