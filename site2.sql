/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : site2

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 01/11/2019 13:36:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `loginname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '账号',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '昵称',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `mobile` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机',
  `img` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `group_id` mediumint(8) NULL DEFAULT NULL COMMENT '分组id',
  `is_open` tinyint(2) NULL DEFAULT 1 COMMENT '审核状态',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `sex` int(1) NULL DEFAULT 0 COMMENT '性别',
  `shop_id` int(11) NULL DEFAULT 0 COMMENT '门店ID',
  PRIMARY KEY (`admin_id`) USING BTREE,
  UNIQUE INDEX `loginname`(`loginname`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限用户表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'admin', '测试管理员', '0192023a7bbd73250516f069df18b500', '13322223333', 'http://localhost:8081/public/admin/images/0.jpg', 1, 1, 1535705042, 0, 0);
INSERT INTO `admin` VALUES (5, 'test1', '测试门店', '5a105e8b9d40e1329780d62ea2265d8a', '132', NULL, 3, 1, 1572327553, 0, 5);

-- ----------------------------
-- Table structure for auth_group
-- ----------------------------
DROP TABLE IF EXISTS `auth_group`;
CREATE TABLE `auth_group`  (
  `group_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '全新ID',
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `desc` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '描述',
  `status` tinyint(1) NULL DEFAULT 0 COMMENT '状态',
  `rules` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '规则',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员分组' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_group
-- ----------------------------
INSERT INTO `auth_group` VALUES (1, '超级管理员', '超级管理员', 1, '0,1,2,338,15,16,119,120,121,145,17,149,116,117,118,151,181,18,108,114,112,109,110,111,355,3,5,127,128,126,4,129,347,348,349,351,', 1535804148);
INSERT INTO `auth_group` VALUES (3, '门店管理员', '门店订单管理', 0, '0,15,16,421,422,', 1568790475);

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `href` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否启用',
  `authopen` tinyint(2) NOT NULL DEFAULT 1 COMMENT '是否验证',
  `icon` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '样式',
  `condition` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `pid` int(5) NOT NULL DEFAULT 0 COMMENT '父栏目ID',
  `sort` int(11) NULL DEFAULT 0 COMMENT '排序',
  `addtime` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `zt` int(1) NULL DEFAULT 1,
  `menustatus` tinyint(1) NULL DEFAULT NULL COMMENT '菜单是否显示',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 454 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限节点' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------
INSERT INTO `auth_rule` VALUES (181, 'Auth/groupState', '操作-状态', 1, 0, 0, '', '', 17, 50, 1461834340, 1, 0);
INSERT INTO `auth_rule` VALUES (180, 'System/source_edit', '操作-修改', 1, 0, 0, '', '', 43, 20, 1461832933, 1, 0);
INSERT INTO `auth_rule` VALUES (153, 'System/bxgs_runadd', '操作-添存', 1, 0, 0, '', '', 66, 1, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (151, 'Auth/groupRunaccess', '操作-权存', 1, 0, 0, '', '', 17, 50, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (149, 'Auth/groupAdd', '操作-添加', 1, 0, 0, '', '', 17, 1, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (145, 'Auth/adminState', '操作-状态', 1, 0, 0, '', '', 16, 5, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (134, 'System/myinfo_runedit', '个人资料修改', 1, 0, 0, '', '', 68, 1, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (132, 'System/bxgs_runedit', '操作-改存', 1, 0, 0, '', '', 67, 2, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (131, 'System/bxgs_edit', '操作-修改', 1, 0, 0, '', '', 67, 1, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (130, 'System/bxgs_state', '操作-状态', 1, 0, 0, '', '', 67, 5, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (129, 'Database/delSqlFiles', '操作-删除', 1, 0, 0, '', '', 4, 3, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (128, 'Database/repair', '操作-修复', 1, 0, 0, '', '', 5, 1, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (127, 'Database/optimize', '操作-优化', 1, 0, 0, '', '', 5, 1, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (126, 'Database/export', '操作-备份', 1, 0, 0, '', '', 5, 1, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (125, 'System/source_del', '操作-删除', 1, 0, 0, '', '', 43, 40, 146103934, 1, 0);
INSERT INTO `auth_rule` VALUES (124, 'System/source_runedit', '操作-改存', 1, 0, 0, '', '', 43, 30, 1461039346, 1, 0);
INSERT INTO `auth_rule` VALUES (123, 'System/source_order', '操作-排序', 1, 0, 0, '', '', 43, 50, 1461037680, 1, 0);
INSERT INTO `auth_rule` VALUES (122, 'System/source_runadd', '操作-添加', 1, 0, 0, '', '', 43, 10, 1461036331, 1, 0);
INSERT INTO `auth_rule` VALUES (121, 'Auth/adminDel', '操作-删除', 1, 0, 0, '', '', 16, 4, 1461554152, 1, 0);
INSERT INTO `auth_rule` VALUES (120, 'Auth/adminEdit', '操作-修改', 1, 0, 0, '', '', 16, 2, 1461554130, 1, 0);
INSERT INTO `auth_rule` VALUES (119, 'Auth/adminAdd', '操作-添加', 1, 0, 0, '', '', 16, 0, 1461553162, 1, 0);
INSERT INTO `auth_rule` VALUES (118, 'Auth/groupAccess', '操作-权限', 1, 0, 0, '', '', 17, 40, 1461552404, 1, 0);
INSERT INTO `auth_rule` VALUES (117, 'Auth/groupDel', '操作-删除', 1, 0, 0, '', '', 17, 30, 1461552349, 1, 0);
INSERT INTO `auth_rule` VALUES (116, 'Auth/groupEdit', '操作-修改', 1, 0, 0, '', '', 17, 3, 1461552326, 1, 0);
INSERT INTO `auth_rule` VALUES (114, 'Auth/ruleEdit', '操作-修改', 1, 0, 0, '', '', 18, 2, 1461551913, 1, 0);
INSERT INTO `auth_rule` VALUES (112, 'Auth/ruleDel', '操作-删除', 1, 0, 0, '', '', 18, 4, 1461551536, 1, 0);
INSERT INTO `auth_rule` VALUES (111, 'Auth/ruleorder', '操作-排序', 1, 0, 0, '', '', 18, 7, 1461551263, 1, 0);
INSERT INTO `auth_rule` VALUES (110, 'Auth/ruleTz', '操作-验证', 1, 0, 0, '', '', 18, 6, 1461551129, 1, 0);
INSERT INTO `auth_rule` VALUES (109, 'Auth/ruleState', '操作-状态', 1, 0, 0, '', '', 18, 5, 1461550949, 1, 0);
INSERT INTO `auth_rule` VALUES (108, 'Auth/ruleAdd', '操作-添加', 1, 0, 0, '', '', 18, 0, 1461550835, 1, 0);
INSERT INTO `auth_rule` VALUES (107, 'System/runemail', '操作-保存', 1, 0, 0, '', '', 19, 50, 1461039346, 1, 0);
INSERT INTO `auth_rule` VALUES (106, 'System/runwesys', '操作-保存', 1, 0, 0, '', '', 10, 50, 1461037680, 0, 0);
INSERT INTO `auth_rule` VALUES (105, 'System/runsys', '操作-保存', 1, 0, 0, '', '', 6, 50, 1461036331, 1, 0);
INSERT INTO `auth_rule` VALUES (18, 'admin/AuthRule/index', '权限管理', 1, 1, 0, '', '', 15, 2, 1446535750, 1, 1);
INSERT INTO `auth_rule` VALUES (17, 'admin/AuthGroup/index', '角色管理', 1, 1, 0, '', '', 15, 1, 1446535750, 1, 1);
INSERT INTO `auth_rule` VALUES (16, 'admin/admin/index', '用户管理', 1, 1, 0, '', '', 15, 0, 1446535750, 1, 1);
INSERT INTO `auth_rule` VALUES (15, 'javascript:;', '权限管理', 1, 1, 0, '', '', 0, 1, 1446535750, 1, 1);
INSERT INTO `auth_rule` VALUES (421, 'javascript:;', '会员管理', 1, 1, 0, '', '', 0, 50, 1568876451, 1, 1);
INSERT INTO `auth_rule` VALUES (422, 'admin/user/index', '会员管理', 1, 1, 0, '', '', 421, 50, 1568876477, 1, 1);
INSERT INTO `auth_rule` VALUES (447, 'javascript:;', '汽车参数', 1, 1, 0, '', '', 0, 50, 1572579030, 1, 1);
INSERT INTO `auth_rule` VALUES (448, 'admin/CarParam/index', '参数管理', 1, 1, 0, '', '', 447, 50, 1572579068, 1, 1);
INSERT INTO `auth_rule` VALUES (453, 'admin/CarParamOption/index', '参数选项', 1, 1, 0, '', '', 447, 50, 1572585799, 1, 1);

-- ----------------------------
-- Table structure for car_param
-- ----------------------------
DROP TABLE IF EXISTS `car_param`;
CREATE TABLE `car_param`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `pid` int(11) NULL DEFAULT NULL COMMENT '类型',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '0字符1选项',
  `hide` tinyint(1) NULL DEFAULT NULL COMMENT '0显示1隐藏',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for car_param_option
-- ----------------------------
DROP TABLE IF EXISTS `car_param_option`;
CREATE TABLE `car_param_option`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `param_id` int(11) NULL DEFAULT NULL COMMENT '参数ID',
  `hide` tinyint(1) NULL DEFAULT NULL COMMENT '0显示1隐藏',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `shop_id` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `totalMoney` decimal(10, 2) NULL DEFAULT NULL COMMENT '订单总金额',
  `realTotalMoney` decimal(10, 2) NULL DEFAULT NULL COMMENT '实际付款金额',
  `payType` int(11) NULL DEFAULT NULL COMMENT '1:线上支付单，2:线下预约单',
  `payFrom` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '支付来源：1:微信，2:支付宝',
  `user_name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_mobile` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `orderScore` int(11) NULL DEFAULT NULL COMMENT '所得积分',
  `isInvoice` tinyint(4) NULL DEFAULT 1 COMMENT '是否需要发票：1:需要，0:不需要',
  `invoiceClient` tinyint(4) NULL DEFAULT 1 COMMENT '发票抬头1:需要，0:不需要',
  `orderRemarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单备注',
  `orderSrc` int(11) NULL DEFAULT 1 COMMENT '0:商城，1:微信，2：手机版，3：安卓app，4：苹果app',
  `isRefund` tinyint(4) NULL DEFAULT 0 COMMENT '是否退款1:是，0:否',
  `isAppraise` tinyint(4) NULL DEFAULT 0 COMMENT '是否点评，1:已点评，0:未点评',
  `cancelReason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '取消原因',
  `tradeNo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '在线交易流水号',
  `order_status` int(11) NULL DEFAULT NULL COMMENT '-1:已取消，1:已下单，2:服务中，5:预约单 服务完成(待支付)，3:订单完成，4:退款售后',
  `is_coupon` tinyint(4) NULL DEFAULT 1 COMMENT '是否支持优惠卷',
  `is_discount` tinyint(4) NULL DEFAULT 1 COMMENT '是否支持会员打折',
  `valid` tinyint(4) NULL DEFAULT 1,
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `serve_id` int(11) NULL DEFAULT NULL,
  `serve_title` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `serve_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '服务列表图',
  `shop_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '门店标题',
  `pay_time` int(11) NULL DEFAULT NULL COMMENT '付款时间',
  `finish_time` int(11) NULL DEFAULT NULL COMMENT '完成时间',
  `cancel_time` int(11) NULL DEFAULT NULL COMMENT '取消时间',
  `isPay` tinyint(1) NULL DEFAULT 0 COMMENT '0:未支付，1:已支付',
  `car_full_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '车辆全名',
  `car_purchase_time` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '购车日期',
  `car_number` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '车牌号',
  `car_mileage` int(11) NULL DEFAULT NULL COMMENT '里程数/km',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `order_no`(`order_no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 505 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES (469, '62478320191016180349', 5, 3060, 6666.00, 6666.00, 2, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571220229341068', 5, 1, 1, 1, 1571220229, 2, '测试', NULL, '门店1', NULL, NULL, NULL, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (470, '73885320191016181115', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, '5555555', 1, 0, 0, NULL, '1571220675832312', -1, 1, 1, 1, 1571220675, 3, '标准精洗', NULL, '门店1', 1571220688, NULL, 1571221015, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (471, '42893620191016181221', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571220741164276', 3, 1, 1, 1, 1571220741, 3, '标准精洗', NULL, '门店1', NULL, 1571220844, NULL, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (472, '64504220191016181710', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571221030640182', 3, 1, 1, 0, 1571221030, 3, '标准精洗', NULL, '门店1', 1571221042, 1571221531, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (473, '37900320191016183234', 5, 3060, 0.02, 0.02, 2, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571221954335451', 3, 1, 1, 0, 1571221954, 2, '测试', NULL, '门店1', 1571277046, 1571277022, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (474, '88068020191017083810', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571272690440416', 3, 1, 1, 1, 1571272690, 3, '标准精洗', NULL, '门店1', 1571272704, 1571272727, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (475, '22002920191017085141', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571273501376081', 3, 1, 1, 0, 1571273501, 3, '标准精洗', NULL, '门店1', 1571273515, 1571273525, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (476, '11129820191017085237', 5, 3060, 30.00, 30.00, 2, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571273557766606', 5, 1, 1, 1, 1571273557, 2, '测试', NULL, '门店1', NULL, 1571274468, NULL, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (477, '96431220191017093156', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571275916256810', 4, 1, 1, 1, 1571275916, 3, '标准精洗', NULL, '门店1', 1571275932, NULL, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (478, '43937220191017093420', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'mkljmklm', 1, 0, 0, NULL, '1571276060842961', 4, 1, 1, 0, 1571276060, 3, '标准精洗', NULL, '门店1', 1571276073, NULL, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (479, '11335120191017093731', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, '好好', 1, 0, 0, NULL, '1571276251924850', 4, 1, 1, 1, 1571276251, 3, '标准精洗', NULL, '门店1', 1571276269, NULL, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (480, '55911020191017093921', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, '好好', 1, 0, 0, NULL, '1571276361438290', 4, 1, 1, 1, 1571276361, 3, '标准精洗', NULL, '门店1', 1571276374, NULL, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (481, '83450320191017094119', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571276479428555', 4, 1, 1, 0, 1571276479, 3, '标准精洗', NULL, '门店1', 1571276500, NULL, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (482, '83982720191017094940', 5, 3060, 222.00, 222.00, 2, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571276980357274', 2, 1, 1, 1, 1571276980, 2, '测试', NULL, '门店1', NULL, NULL, NULL, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (483, '29317420191017095659', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571277419676545', -1, 1, 1, 1, 1571277419, 3, '标准精洗', NULL, '门店1', NULL, NULL, 1571277429, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (484, '75967720191017100136', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571277697121597', -1, 1, 1, 1, 1571277696, 3, '标准精洗', NULL, '门店1', NULL, NULL, 1571277705, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (485, '73285720191017100228', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571277748689308', -1, 1, 1, 1, 1571277748, 3, '标准精洗', NULL, '门店1', NULL, NULL, 1571279371, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (486, '13274420191017100336', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571277816682084', 4, 1, 1, 1, 1571277816, 3, '标准精洗', NULL, '门店1', 1571277828, NULL, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (487, '18102020191017103637', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, '原因4', '1571279797413769', -1, 1, 1, 1, 1571279797, 3, '标准精洗', NULL, '门店1', NULL, NULL, 1571280034, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (488, '83753820191018103413', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, '好好的', 1, 0, 0, NULL, '1571366053851020', 4, 1, 1, 1, 1571366053, 3, '标准精洗', NULL, '门店1', 1571366062, NULL, NULL, 1, '福特 蒙迪欧Energi 2018款 2.0 PHEV 智控时尚型 国VI', '2019-10', 'S23423', 12341);
INSERT INTO `order` VALUES (489, '59771620191018105831', 5, 3062, 300.00, 300.00, 1, 0, '龙舌兰', '18895688956', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571367511905585', 1, 1, 1, 1, 1571367511, 1, '全套保养', NULL, '门店1', NULL, NULL, NULL, 0, '奥迪 奥迪Q5L 2018款 45 TFSI 尊享风雅型 国VI', '2016-10', '皖DGT530', 20000);
INSERT INTO `order` VALUES (490, '38476920191018105852', 5, 3062, 0.01, 0.01, 1, 0, '龙舌兰', '18895688956', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571367532711669', 4, 1, 1, 1, 1571367532, 3, '标准精洗', NULL, '门店1', 1571367539, NULL, NULL, 1, '奥迪 奥迪Q5L 2018款 45 TFSI 尊享风雅型 国VI', '2016-10', '皖DGT530', 20000);
INSERT INTO `order` VALUES (491, '18346620191018112030', 5, 3062, 0.01, 0.01, 1, 0, '龙舌兰', '18895688956', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571368830116292', 1, 1, 1, 1, 1571368830, 3, '标准精洗', NULL, '门店1', 1571368843, NULL, NULL, 1, '奥迪 奥迪Q5L 2018款 45 TFSI 尊享风雅型 国VI', '2016-10', '皖DGT530', 20000);
INSERT INTO `order` VALUES (492, '60865120191018112927', 5, 3064, 2000.00, 2000.00, 1, 0, 'Xxxxxxx', '17681139493', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571369367665799', -1, 1, 1, 1, 1571369367, 4, '全车贴膜', NULL, '门店1', NULL, NULL, 1571369478, 0, '日产 天籁 2015款 2.5L XL-UpperNAVI Tech欧冠尊贵版', '2019-10', '皖ADF032', 50000);
INSERT INTO `order` VALUES (493, '70431220191018112953', 5, 3064, 0.01, 0.01, 1, 0, 'Xxxxxxx', '17681139493', NULL, 1, 1, '九点到店', 1, 0, 0, NULL, '1571369393746529', 4, 1, 1, 1, 1571369393, 3, '标准精洗', NULL, '门店1', 1571369401, NULL, NULL, 1, '日产 天籁 2015款 2.5L XL-UpperNAVI Tech欧冠尊贵版', '2019-10', '皖ADF032', 50000);
INSERT INTO `order` VALUES (494, '22392020191018113617', 5, 3070, 0.01, 0.01, 1, 0, '123', '15256978245', NULL, 1, 1, '你好，测试', 1, 0, 0, NULL, '1571369777422246', 1, 1, 1, 1, 1571369777, 3, '标准精洗', NULL, '门店1', 1571369800, NULL, NULL, 1, '别克 英朗 2019款 15T 双离合互联精英型 国VI', '2019-08', '1', 2000);
INSERT INTO `order` VALUES (495, '52102320191018113933', 5, 3070, 0.01, 0.01, 1, 0, '123', '15256978245', NULL, 1, 1, '测试2', 1, 0, 0, NULL, '1571369973183478', -1, 1, 1, 1, 1571369973, 3, '标准精洗', NULL, '门店1', NULL, NULL, 1571369986, 0, '别克 英朗 2019款 15T 双离合互联精英型 国VI', '2019-08', '1', 2000);
INSERT INTO `order` VALUES (496, '96996920191018114101', 5, 3060, 0.00, 0.00, 2, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571370061320514', -1, 1, 1, 0, 1571370061, 2, '保养套餐', NULL, '门店1', NULL, NULL, 1571370113, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (497, '59417820191018114219', 5, 3064, 0.01, 0.01, 1, 0, 'Xxxxxxx', '17681139493', NULL, 1, 1, '五点到店！', 1, 0, 0, NULL, '1571370139859676', 1, 1, 1, 1, 1571370139, 3, '标准精洗', NULL, '门店1', 1571370147, NULL, NULL, 1, 'ALPINA ALPINA B4 2016款 B4 BITURBO Coupe', '2017-10', '啦啦啦啦啦啦啦', 666);
INSERT INTO `order` VALUES (498, '84060220191018114839', 5, 3062, 60.00, 60.00, 1, 0, '龙舌兰', '18895688956', NULL, 1, 1, 'undefined', 1, 0, 0, '不想下单了', '1571370519576948', -1, 1, 1, 1, 1571370519, 4, '全车贴膜', NULL, '门店1', NULL, NULL, 1571370727, 0, '奥迪 奥迪Q5L 2018款 45 TFSI 尊享风雅型 国VI', '2016-10', '皖DGT530', 20000);
INSERT INTO `order` VALUES (499, '24180720191018133848', 5, 3060, 0.00, 0.00, 2, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, '', '1571377128629560', -1, 1, 1, 0, 1571377128, 2, '保养套餐', NULL, '门店1', NULL, NULL, 1571379275, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (500, '99128520191018141616', 5, 3060, 0.00, 0.00, 2, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, '店家太忙，无法接单', '1571379376675030', -1, 1, 1, 0, 1571379376, 2, '保养套餐', NULL, '门店1', NULL, NULL, 1571379513, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (501, '62134620191018143835', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571380715695468', 1, 1, 1, 1, 1571380715, 3, '标准精洗', NULL, '门店1', 1571380733, NULL, NULL, 1, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (502, '86429920191018143901', 5, 3060, 0.01, 0.01, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, '', '1571380741174326', -1, 1, 1, 1, 1571380741, 3, '标准精洗', NULL, '门店1', NULL, NULL, 1571624914, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (503, '68502620191018153542', 5, 3060, 0.00, 0.00, 2, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571384142893381', 1, 1, 1, 1, 1571384142, 2, '保养套餐', NULL, '门店1', NULL, NULL, NULL, 0, '法拉利 法拉利FF 2012款 6.3L V12', '2019-10', '皖B23423', 12);
INSERT INTO `order` VALUES (504, '58838420191018160944', 5, 3060, 40.00, 40.00, 1, 0, 'kinglege', '13906146271', NULL, 1, 1, 'undefined', 1, 0, 0, NULL, '1571386184141056', 1, 1, 1, 1, 1571386184, 5, '镀晶', NULL, '门店1', NULL, NULL, NULL, 0, '福特 蒙迪欧 2018款 EcoBoost 180 智控时尚型 国VI', '2019-10', 'Gj43534', 4234);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '用户名',
  `headImg` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '电子邮箱',
  `mobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '手机号',
  `status` int(11) NULL DEFAULT 10 COMMENT '状态(0:冻结 10:激活中)',
  `open_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) NULL DEFAULT NULL COMMENT '最后修改时间',
  `orderScore` int(11) NULL DEFAULT 0 COMMENT '积分',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
