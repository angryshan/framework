/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : chat

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-11-05 10:42:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lss_friend
-- ----------------------------
DROP TABLE IF EXISTS `lss_friend`;
CREATE TABLE `lss_friend` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `fid` int(11) NOT NULL COMMENT '朋友id',
  `del` tinyint(1) NOT NULL DEFAULT '1' COMMENT '删除，0是删除，1是不删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='好友表';

-- ----------------------------
-- Records of lss_friend
-- ----------------------------
INSERT INTO `lss_friend` VALUES ('1', '5', '1', '1');

-- ----------------------------
-- Table structure for lss_invited
-- ----------------------------
DROP TABLE IF EXISTS `lss_invited`;
CREATE TABLE `lss_invited` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(8) NOT NULL DEFAULT '0' COMMENT '发起人id',
  `fid` int(8) NOT NULL DEFAULT '0' COMMENT '收信人id',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `updatetime` int(11) NOT NULL COMMENT '修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0是未处理，1是同意，2是拒绝',
  `del` tinyint(1) NOT NULL DEFAULT '1' COMMENT '删除，0是删除，1是不删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='请求添加好友表';

-- ----------------------------
-- Records of lss_invited
-- ----------------------------
INSERT INTO `lss_invited` VALUES ('6', '5', '1', '1570778314', '1570778348', '1', '1');
INSERT INTO `lss_invited` VALUES ('7', '1', '5', '1572856964', '1572856964', '0', '1');

-- ----------------------------
-- Table structure for lss_member
-- ----------------------------
DROP TABLE IF EXISTS `lss_member`;
CREATE TABLE `lss_member` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(21) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `updatetime` int(11) NOT NULL COMMENT '修改时间',
  `identity` tinyint(1) NOT NULL DEFAULT '2' COMMENT '身份，0是超级管理员，1是管理员，2是普通用户',
  `del` tinyint(1) NOT NULL DEFAULT '1' COMMENT '删除，0是删除，1是不删除',
  `session_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否登录',
  `img` varchar(255) NOT NULL COMMENT '头像',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of lss_member
-- ----------------------------
INSERT INTO `lss_member` VALUES ('1', 'king', 'b2086154f101464aab3328ba7e060deb', '12@qq.com', '1549957523', '0', '1', '1', '1572850857', '/public/images/winter-soldier.jpg');
INSERT INTO `lss_member` VALUES ('5', 'good', 'e10adc3949ba59abbe56e057f20f883e', '1264689637@qq.com', '1565755196', '0', '2', '1', '1570777051', '/public/images/captain-america.jpg');
INSERT INTO `lss_member` VALUES ('2', 'mom', 'e10adc3949ba59abbe56e057f20f883e', '1264689637@qq.com', '1565755183', '0', '2', '1', '1570776941', '/public/images/black-widow.jpg');
