/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : epiboly_model

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2018-12-12 11:03:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for system_global_error
-- ----------------------------
DROP TABLE IF EXISTS `system_global_error`;
CREATE TABLE `system_global_error` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cms_stage` varchar(12) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '框架前后台',
  `cms_project` varchar(24) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '项目ID',
  `cms_model` varchar(24) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '模块名称',
  `cms_class` varchar(24) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '类名称',
  `cms_method` varchar(24) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '方法名称',
  `cms_error_type` varchar(12) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '错误消息类型',
  `cms_error_info` text COLLATE utf8_unicode_ci COMMENT '错误日志',
  `cms_error_file` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '错误文件位置',
  `cms_deleted` tinyint(3) unsigned DEFAULT '0' COMMENT '是否删除 0 未删除 | 1已删除',
  `cms_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=307 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_global_params
-- ----------------------------
DROP TABLE IF EXISTS `system_global_params`;
CREATE TABLE `system_global_params` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'uuID',
  `cms_global_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '全局参数名称',
  `cms_global_model` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '全局参数模板',
  `cms_project_model` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '项目模板标示',
  `cms_config` text COLLATE utf8_unicode_ci NOT NULL COMMENT '配置json',
  `cms_create_time` datetime NOT NULL COMMENT '创建时间',
  `cms_modify_time` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_manager
-- ----------------------------
DROP TABLE IF EXISTS `system_manager`;
CREATE TABLE `system_manager` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UUID',
  `cms_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员名称',
  `cms_parent_manager` int(10) unsigned DEFAULT NULL COMMENT '父级管理员',
  `cms_login_account` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员登录账号',
  `cms_login_pass` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '登录密码',
  `cms_role_id` int(10) unsigned NOT NULL COMMENT '角色uuid',
  `cms_login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `cms_login_time` datetime NOT NULL COMMENT '登录时间',
  `cms_state` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '管理员状态  0 启用 | 1 禁用  默认禁用',
  `cms_deleted` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0 未删除  | 1 已删除',
  `cms_create_time` datetime NOT NULL COMMENT '创建时间',
  `cms_modify_time` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_menu
-- ----------------------------
DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE `system_menu` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UUID',
  `cms_project_id` int(10) unsigned DEFAULT NULL COMMENT '项目ID',
  `cms_mark` varchar(32) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '项目栏目标示',
  `cms_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cms_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cms_level` tinyint(3) unsigned DEFAULT '0' COMMENT '菜单层级 0 为1级，默认1级',
  `cms_parent_id` int(10) unsigned DEFAULT '0' COMMENT '父级菜单ID',
  `cms_order` float(10,3) unsigned DEFAULT '0.000' COMMENT '菜单排序权重',
  `cms_is_top` tinyint(1) unsigned zerofill DEFAULT '0' COMMENT '是否到底端 0 否 1 是',
  `cms_state` tinyint(3) unsigned DEFAULT '0' COMMENT '菜单状态  0 启用  1 禁用',
  `cms_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_project
-- ----------------------------
DROP TABLE IF EXISTS `system_project`;
CREATE TABLE `system_project` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目ID',
  `cms_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '项目名称',
  `cms_mark` varchar(24) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '项目英文标示',
  `cms_mobilephone_number` char(11) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '手机号码',
  `cms_telphone_number` char(11) COLLATE utf8_unicode_ci DEFAULT '',
  `cms_email` varchar(56) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '邮箱地址',
  `cms_remark` varchar(1024) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '备注',
  `cms_order` float(6,3) unsigned DEFAULT '0.000' COMMENT '排序权重',
  `cms_state` tinyint(3) unsigned DEFAULT '0' COMMENT '状态 0 启用 | 1 禁用',
  `cms_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`),
  UNIQUE KEY `mark` (`cms_mark`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_project_child_model
-- ----------------------------
DROP TABLE IF EXISTS `system_project_child_model`;
CREATE TABLE `system_project_child_model` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UUID',
  `cms_project_id` int(10) unsigned DEFAULT NULL COMMENT '项目ID',
  `cms_mark` varchar(24) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '模板标示',
  `cms_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '模板名称',
  `cms_state` tinyint(3) unsigned DEFAULT '0' COMMENT '状态 0 启用 | 1 禁用',
  `cms_remark` varchar(1024) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '备注',
  `cms_order` float(6,3) unsigned DEFAULT '0.000' COMMENT '排序权重',
  `cms_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`),
  UNIQUE KEY `unique_project_mark` (`cms_project_id`,`cms_mark`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_project_class
-- ----------------------------
DROP TABLE IF EXISTS `system_project_class`;
CREATE TABLE `system_project_class` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UUID',
  `cms_project_id` int(10) unsigned DEFAULT NULL COMMENT '项目ID',
  `cms_project_model_id` int(10) unsigned DEFAULT NULL COMMENT '模板ID',
  `cms_mark` varchar(24) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '类标示',
  `cms_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '类名称',
  `cms_state` tinyint(3) unsigned DEFAULT '0' COMMENT '状态 0 启用 | 1 禁用',
  `cms_remark` varchar(1024) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '备注',
  `cms_order` float(6,3) unsigned DEFAULT '0.000' COMMENT '排序权重',
  `cms_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`),
  UNIQUE KEY `unique_project_mark_class` (`cms_project_id`,`cms_mark`,`cms_project_model_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_project_func
-- ----------------------------
DROP TABLE IF EXISTS `system_project_func`;
CREATE TABLE `system_project_func` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UUID',
  `cms_project_id` int(10) unsigned DEFAULT NULL COMMENT '项目ID',
  `cms_project_model_id` int(10) unsigned DEFAULT NULL COMMENT '模板ID',
  `cms_project_class_id` int(10) unsigned DEFAULT NULL COMMENT '类ID',
  `cms_mark` varchar(24) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '方法标示',
  `cms_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '方法名称',
  `cms_state` tinyint(3) unsigned DEFAULT '0' COMMENT '状态 0 启用 | 1 禁用',
  `cms_remark` varchar(1024) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '备注',
  `cms_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'URL地址',
  `cms_order` float(6,3) unsigned DEFAULT '0.000' COMMENT '排序权重',
  `cms_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`),
  UNIQUE KEY `unique_project_mark_class_func` (`cms_project_id`,`cms_project_model_id`,`cms_project_class_id`,`cms_mark`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_project_model
-- ----------------------------
DROP TABLE IF EXISTS `system_project_model`;
CREATE TABLE `system_project_model` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UUID',
  `cms_project_id` int(10) unsigned DEFAULT NULL COMMENT '项目ID',
  `cms_mark` varchar(24) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '模板标示',
  `cms_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '模板名称',
  `cms_state` tinyint(3) unsigned DEFAULT '0' COMMENT '状态 0 启用 | 1 禁用',
  `cms_remark` varchar(1024) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '备注',
  `cms_order` float(6,3) unsigned DEFAULT '0.000' COMMENT '排序权重',
  `cms_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`),
  UNIQUE KEY `unique_project_mark` (`cms_project_id`,`cms_mark`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_project_url
-- ----------------------------
DROP TABLE IF EXISTS `system_project_url`;
CREATE TABLE `system_project_url` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UUID',
  `cms_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'URL名称',
  `cms_project_id` int(10) unsigned DEFAULT NULL COMMENT '项目ID',
  `cms_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '项目路径',
  `cms_desc` varchar(1024) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '描述',
  `cms_state` tinyint(3) unsigned DEFAULT '0' COMMENT '状态 0 启用 | 1 禁用',
  `cms_create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for system_role
-- ----------------------------
DROP TABLE IF EXISTS `system_role`;
CREATE TABLE `system_role` (
  `cms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cms_project_id` int(10) unsigned NOT NULL COMMENT '项目id',
  `cms_role_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `cms_roles` text COLLATE utf8_unicode_ci NOT NULL COMMENT '角色权限（json）',
  `cms_desc` varchar(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '角色描述',
  `cms_create_time` datetime NOT NULL COMMENT '创建时间',
  `cms_modify_time` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
