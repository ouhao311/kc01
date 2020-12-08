/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2020-12-08 21:44:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for hx_govent_detail_list
-- ----------------------------
DROP TABLE IF EXISTS `hx_govent_detail_list`;
CREATE TABLE `hx_govent_detail_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goventid` varchar(11) NOT NULL COMMENT '任务id',
  `qustion` varchar(255) NOT NULL COMMENT '描述问题',
  `content` varchar(255) NOT NULL COMMENT '处理结果',
  `transaction` varchar(255) NOT NULL COMMENT '办理人员',
  `revtime` int(11) DEFAULT NULL COMMENT '审核时间',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `revstatus` int(2) DEFAULT '1' COMMENT '审批状态 1未审核 2审核通过 3审核退回',
  `revuid` int(5) DEFAULT NULL COMMENT '审批人员',
  `revcontent` varchar(255) DEFAULT NULL COMMENT '审核内容',
  `attachment` varchar(255) DEFAULT NULL COMMENT '用户传的附件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hx_govent_detail_list
-- ----------------------------
INSERT INTO `hx_govent_detail_list` VALUES ('1', '3', '描述问题', '处理内容', '办理人员', null, '1607434708', '0', '0', null, null);
INSERT INTO `hx_govent_detail_list` VALUES ('2', '3', '描述问题', '处理内容', '办理人员', null, '1607434708', '0', '0', null, null);
INSERT INTO `hx_govent_detail_list` VALUES ('3', '5', '测试', '完成', '怡卫茹', null, '1607434708', '0', '0', null, null);
INSERT INTO `hx_govent_detail_list` VALUES ('4', '6', '', 'ok', 'wei', null, '1607434708', '0', '0', null, null);
INSERT INTO `hx_govent_detail_list` VALUES ('5', '8', '测试', '测试', '王斌', null, '1607434708', '0', '0', null, null);
INSERT INTO `hx_govent_detail_list` VALUES ('20', '10', '123', 'ok', 'ywr', null, '1607434708', '0', '0', null, null);
INSERT INTO `hx_govent_detail_list` VALUES ('21', '12', 'rwerewrwreewr', '', '', null, '1607434708', '1', '18', null, null);
INSERT INTO `hx_govent_detail_list` VALUES ('28', '16', '', '', '80', null, '1607434708', '1', null, null, '{\"url\":\"/data/upload/attachment/20201208/3989105.docx\",\"realname\":null,\"model\":\"docx\",\"size\":\"612.7978515625\",\"ref_url\":\"\"}');

-- ----------------------------
-- Table structure for hx_govent_list
-- ----------------------------
DROP TABLE IF EXISTS `hx_govent_list`;
CREATE TABLE `hx_govent_list` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '工作事项',
  `managerid` varchar(255) NOT NULL COMMENT '安排负责人',
  `memberid` varchar(255) NOT NULL COMMENT '完成负责人',
  `startdate` varchar(20) NOT NULL COMMENT '开始时间',
  `enddate` varchar(20) NOT NULL COMMENT '结束时间',
  `addtime` varchar(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `isdel` int(2) NOT NULL DEFAULT '0' COMMENT '是否删除 默认0否 1是',
  `departid` int(11) DEFAULT NULL COMMENT '安排部门',
  `itself` int(11) NOT NULL DEFAULT '0' COMMENT '是否主动 0主动',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hx_govent_list
-- ----------------------------
INSERT INTO `hx_govent_list` VALUES ('1', '任务1', '8', '11', '2020-08-12', '2020-08-18', '1597637277', '0', '0', null, '0');
INSERT INTO `hx_govent_list` VALUES ('2', '任务2', '8', '12', '2020-07-15', '2020-08-19', '1597637336', '0', '0', null, '0');
INSERT INTO `hx_govent_list` VALUES ('3', '任务3', '8', '8', '2020-08-16 00:00:00', '2020-08-19 00:00:00', '1597644742', '0', '0', null, '0');
INSERT INTO `hx_govent_list` VALUES ('4', '任务4', '8', '8', '2020-08-16 00:00:00', '2020-08-18 00:00:00', '1597644766', '0', '0', null, '0');
INSERT INTO `hx_govent_list` VALUES ('5', '任务5', '8', '14', '2020-08-19 10:45:53', '2020-08-19 10:45:56', '1597805188', '0', '0', null, '0');
INSERT INTO `hx_govent_list` VALUES ('6', '任务6', '14', '14', '2020-08-20 13:50:38', '2020-08-20 13:50:40', '1597902673', '0', '0', null, '0');
INSERT INTO `hx_govent_list` VALUES ('7', '测试霍鹏的任务', '8', '13', '2020-08-21 00:00:00', '2020-08-31 00:00:00', '1597990308', '0', '0', null, '0');
INSERT INTO `hx_govent_list` VALUES ('8', '测试霍鹏', '15', '15', '2020-08-21 00:00:00', '2020-08-24 00:00:00', '1597990408', '0', '1', null, '0');
INSERT INTO `hx_govent_list` VALUES ('9', '测试', '14', '8', '2020-08-21 15:28:12', '2020-08-21 15:28:16', '1601028634', '1', '0', null, '0');
INSERT INTO `hx_govent_list` VALUES ('10', '创意盒子检查水表', '14', '14', '2020-09-03 00:00:00', '2020-09-09 00:00:00', '1599542407', '1', '0', null, '0');
INSERT INTO `hx_govent_list` VALUES ('11', '自我分配任务', '14', '14', '2020-09-08 00:00:00', '2020-09-30 00:00:00', '1599546126', '1', '0', null, '0');
INSERT INTO `hx_govent_list` VALUES ('12', '自我测试分配任务管理', '8', '8', '2020-09-08 00:00:00', '2020-09-26 00:00:00', '1600596220', '1', '1', null, '0');
INSERT INTO `hx_govent_list` VALUES ('13', '走访任务test', '80', '13', '2020-12-08 00:00:00', '2020-12-31 00:00:00', '1607321175', '0', '1', null, '0');
INSERT INTO `hx_govent_list` VALUES ('14', 'renwutest', '77', '', '', '2020-12-31 00:00:00', '1607340894', '0', '1', '0', '0');
INSERT INTO `hx_govent_list` VALUES ('15', '任务1', '8', '80', '', '2020-12-08 19:00:00', '1607345793', '1', '0', '1', '0');
INSERT INTO `hx_govent_list` VALUES ('16', '任务2', '8', '80', '', '2020-12-08 20:12:00', '1607345793', '1', '0', '1', '0');
