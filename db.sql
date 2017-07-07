/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : admintpl

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-03-01 09:29:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) DEFAULT NULL COMMENT '关联分类id',
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='基本信息表，包含公告，关于我们，公司简介等信息';

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', null, '公告1', '公告1公告1公告1公告1', '2016-09-22 08:28:48');

-- ----------------------------
-- Table structure for article_cate
-- ----------------------------
DROP TABLE IF EXISTS `article_cate`;
CREATE TABLE `article_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article_cate
-- ----------------------------
INSERT INTO `article_cate` VALUES ('1', '通知公告', '2016-09-22 08:41:31');

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL COMMENT '所属权限组',
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('1', '1', 'admin', '7c6c9647c39b4c9d9504281231a01568', '2014-09-18 04:16:56');
INSERT INTO `member` VALUES ('2', '2', 'user11', '7c6c9647c39b4c9d9504281231a01568', '2014-07-24 00:11:41');
INSERT INTO `member` VALUES ('3', '1', 'test2', '9c6b99216f462f373fe8eebf56f2644e', '2016-09-23 02:57:16');

-- ----------------------------
-- Table structure for member_group
-- ----------------------------
DROP TABLE IF EXISTS `member_group`;
CREATE TABLE `member_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `privilege` varchar(255) DEFAULT NULL COMMENT '拥有权限的菜单id，用逗号分隔',
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member_group
-- ----------------------------
INSERT INTO `member_group` VALUES ('1', '超级管理员', '1,22,24,29,7,10,27,28,38,30,31,32,33,48,37,23,39,25,40,45,41,42,43,44,49,50,51,6,11,12,13,14,15,47,20,21,26', '2014-07-04 10:27:40');
INSERT INTO `member_group` VALUES ('2', '普通员工', '1,5,9', '2014-07-04 11:27:31');
INSERT INTO `member_group` VALUES ('4', '销售专员', '5', null);

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `level` tinyint(4) DEFAULT '0' COMMENT '记录层级，1为顶级，最多为3级',
  `parent_id` int(6) unsigned NOT NULL DEFAULT '0',
  `module` varchar(20) DEFAULT NULL,
  `controller` varchar(20) DEFAULT '',
  `method` varchar(20) DEFAULT '',
  `component` varchar(50) DEFAULT NULL COMMENT 'react组件名称,使用api方式实现，首先在页面前端react/views/Views.js定义好相应组件，再把名称填写到这里',
  `params` varchar(100) DEFAULT NULL COMMENT '附加参数，格式： ?a=1&b=2',
  `url` varchar(200) DEFAULT '',
  `sort` int(2) unsigned DEFAULT '0',
  `type` varchar(5) DEFAULT NULL COMMENT 'url原生链接方式，api使用react接口方式',
  `addtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parentid` (`parent_id`),
  KEY `model` (`controller`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COMMENT='后台管理和会员管理 栏目表';

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '常用管理', '0', '0', '', '', '', null, null, '', '0', null, '2016-08-31 07:49:52');
INSERT INTO `menu` VALUES ('21', '分类管理', '0', '20', '', 'article_cate', '', null, '', '', '0', null, '2016-09-22 07:37:00');
INSERT INTO `menu` VALUES ('6', '系统管理', '0', '0', '', '', '', null, null, '', '0', null, '2016-08-31 07:50:06');
INSERT INTO `menu` VALUES ('55', '文章列表', '0', '20', '', 'article', '', null, null, '', '0', null, '2016-12-02 09:51:22');
INSERT INTO `menu` VALUES ('11', '权限管理', '0', '6', '', '', '', null, null, '', '0', null, '2016-09-01 00:32:55');
INSERT INTO `menu` VALUES ('12', '栏目管理', '0', '11', '', 'menu', '', null, null, '', '0', null, '2016-09-01 00:33:22');
INSERT INTO `menu` VALUES ('13', '权限组管理', '0', '11', '', 'member_group', '', null, null, '', '0', null, '2016-09-01 00:41:28');
INSERT INTO `menu` VALUES ('14', '工具', '0', '6', '', '', '', null, null, '', '0', null, '2016-09-01 00:42:31');
INSERT INTO `menu` VALUES ('15', '表单生成器', '0', '14', '', 'view_builder', 'form', '', '', '', '0', '', '2016-09-01 00:42:49');
INSERT INTO `menu` VALUES ('20', '文章管理', '0', '1', '', '', '', null, '', '', '0', null, '2016-09-22 07:35:25');
INSERT INTO `menu` VALUES ('52', '测试', '0', '14', '', 'test', '', '', '', '', '0', '', '2016-09-01 00:42:49');
