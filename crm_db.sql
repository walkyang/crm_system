

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理用户ID 主键自增',
  `admin_name` varchar(32) NOT NULL COMMENT '用户名',
  `admin_pwd` varchar(32) NOT NULL COMMENT '密码',
  `real_name` varchar(32) DEFAULT NULL COMMENT '姓名',
  `admin_sex` char(1) DEFAULT NULL,
  `admin_mobile` varchar(20) DEFAULT NULL,
  `admin_address` varchar(64) DEFAULT NULL,
  `is_quit` varchar(1) NOT NULL DEFAULT '0' COMMENT '是否离职 1：离职，0：未离职',
  `quit_time` datetime DEFAULT NULL COMMENT '离职日期',
  `created_by_id` int(11) DEFAULT NULL COMMENT '创建人',
  `created_time` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_by_id` int(11) DEFAULT NULL COMMENT '更新人',
  `updated_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=333 DEFAULT CHARSET=utf8 COMMENT='管理信息 ';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '123456', '张三', null, null, null, '0', null, null, '2020-05-31 09:35:21', '1', '2020-06-01 02:12:59');

-- ----------------------------
-- Table structure for `admin_power`
-- ----------------------------
DROP TABLE IF EXISTS `admin_power`;
CREATE TABLE `admin_power` (
  `power_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理权限ID 主键自增',
  `admin_id` int(11) NOT NULL COMMENT '管理用户ID',
  `power_name` varchar(32) DEFAULT NULL COMMENT '权限名称',
  `power_name_en` varchar(32) DEFAULT NULL COMMENT '权限名称_en',
  `is_power` varchar(1) NOT NULL DEFAULT '0' COMMENT '是否拥有权限 1：有，0：无',
  `created_by_id` int(11) DEFAULT NULL COMMENT '创建人',
  `created_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`power_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='管理权限 ';

-- ----------------------------
-- Records of admin_power
-- ----------------------------
INSERT INTO `admin_power` VALUES ('22', '1', '浏览员工信息', 'admin_view', '1', '0', '2020-06-01 06:28:44');
INSERT INTO `admin_power` VALUES ('23', '1', '新增员工信息', 'admin_add', '1', '0', '2020-06-01 06:28:44');
INSERT INTO `admin_power` VALUES ('24', '1', '编辑员工信息', 'admin_edit', '1', '0', '2020-06-01 06:28:44');
INSERT INTO `admin_power` VALUES ('25', '1', '删除员工信息', 'admin_delete', '1', '0', '2020-06-01 06:28:44');
INSERT INTO `admin_power` VALUES ('26', '1', '导入员工信息', 'admin_import', '1', '0', '2020-06-01 06:28:44');
INSERT INTO `admin_power` VALUES ('27', '1', '导出员工信息', 'admin_export', '1', '0', '2020-06-01 06:28:44');
INSERT INTO `admin_power` VALUES ('28', '1', '员工权限', 'admin_power', '1', '0', '2020-06-01 06:28:44');

-- ----------------------------
-- Table structure for `admin_view_setting`
-- ----------------------------
DROP TABLE IF EXISTS `admin_view_setting`;
CREATE TABLE `admin_view_setting` (
  `view_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `view_name` varchar(32) DEFAULT NULL COMMENT '页面名称',
  `view_name_en` varchar(32) DEFAULT NULL COMMENT '页面',
  `hidden_attribute` varchar(300) DEFAULT NULL COMMENT '隐藏字段',
  `created_time` datetime DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`view_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_view_setting
-- ----------------------------
INSERT INTO `admin_view_setting` VALUES ('1', '1', '员工信息', 'admin_info', 'admin_sex,', '2020-05-31 09:08:20', '2020-05-31 15:55:19');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客户ID唯一标识 自增列',
  `user_name` varchar(32) DEFAULT NULL COMMENT '客户姓名',
  `id_card_no` varchar(32) DEFAULT NULL COMMENT '身份证号码',
  `user_mobile` varchar(32) DEFAULT NULL COMMENT '手机号码',
  `bank_card_no` varchar(32) DEFAULT NULL COMMENT '银行卡号',
  `admin_id` int(11) DEFAULT NULL COMMENT '所属经理ID',
  `created_by_id` int(11) DEFAULT NULL COMMENT '创建人',
  `created_time` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_by_id` int(11) DEFAULT NULL COMMENT '更新人',
  `updated_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户信息 ';

-- ----------------------------
-- Records of user
-- ----------------------------
