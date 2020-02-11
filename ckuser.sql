/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50643
 Source Host           : localhost:3306
 Source Schema         : ckuser

 Target Server Type    : MySQL
 Target Server Version : 50643
 File Encoding         : 65001

 Date: 13/11/2019 13:48:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ck_admin
-- ----------------------------
DROP TABLE IF EXISTS `ck_admin`;
CREATE TABLE `ck_admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '等级',
  `pwd` char(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `username` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `money` int(11) NOT NULL DEFAULT 0,
  `create_time` int(10) NOT NULL DEFAULT 0,
  `update_time` int(10) NOT NULL DEFAULT 0,
  `last_time` int(10) NOT NULL DEFAULT 0,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ck_admin
-- ----------------------------
INSERT INTO `ck_admin` VALUES (1, '1', '63a9f0ea7bb98050796b649e85481845', 'admin', 2324234, 1570524542, 1570524542, 1570524542, '超级管理员');
INSERT INTO `ck_admin` VALUES (7, '2', '1a100d2c0dab19c4430e7d73762b3423', 'name', 0, 1573267976, 1573291462, 1573291462, '超级管理员');
INSERT INTO `ck_admin` VALUES (24, '2', '96e79218965eb72c92a549dd5a330112', 'sunny', 0, 1573445553, 1573445553, 1573445553, '管理员');

-- ----------------------------
-- Table structure for ck_user
-- ----------------------------
DROP TABLE IF EXISTS `ck_user`;
CREATE TABLE `ck_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户ID号',
  `username` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `grade` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '层级',
  `money` int(11) NOT NULL DEFAULT 0,
  `create_time` int(10) NOT NULL DEFAULT 0,
  `update_time` int(10) NOT NULL DEFAULT 0,
  `last_time` int(10) NOT NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '备注',
  `parent_id` int(11) NOT NULL DEFAULT 1 COMMENT '所属那个会员',
  `phone` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  INDEX `own`(`parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8131 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
