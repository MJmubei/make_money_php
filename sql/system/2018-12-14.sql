-- ------------------------------------------------------------------------------------
-- Table Shop Add Order Parent Flag. By kan.yang@starcor.com. Date 2018-12-14 11:30:00
-- ------------------------------------------------------------------------------------
ALTER TABLE `system_buy_order` DROP `cms_pay_mode_id`;
ALTER TABLE `system_buy_order` ADD COLUMN `nns_order_parent` INT(11) NOT NULL DEFAULT 0 COMMENT '父级订单ID';
ALTER TABLE `system_buy_order` ADD COLUMN `cms_pay_channel_mode` INT(4) NOT NULL DEFAULT 0 COMMENT '支付渠道模式。10微信二维码；20支付宝二维码';
ALTER TABLE `system_buy_order` ADD COLUMN `cms_pay_mode_type` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '支付方式。0余额支付；1实时支付';

-- ------------------------------------------------------------------------------------
-- Table Shop Add Channel Mode Status. By kan.yang@starcor.com. Date 2018-12-15 16:15:00
-- ------------------------------------------------------------------------------------
ALTER TABLE `system_channel_mode` ADD COLUMN `cms_status` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '支付方式状态，默认0：0开启；1禁止';

-- ------------------------------------------------------------------------------------
-- Table Shop Add WeChat Status. By kan.yang@starcor.com. Date 2018-12-15 16:50:00
-- ------------------------------------------------------------------------------------
ALTER TABLE `system_wechat_accounts` ADD COLUMN `cms_status` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '微信公众号状态，默认0：0开启；1禁止';

-- ------------------------------------------------------------------------------------
-- Table Shop Accept Order. By kan.yang@starcor.com. Date 2018-12-15 17:05:00
-- ------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cms_accept_order` (
  `cms_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `cms_accept_user_id` INT(10) NOT NULL COMMENT '接收订单用户ID',
  `cms_buy_order_id` INT(10) NOT NULL COMMENT '购买订单ID',
  `cms_status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '接收订单状态，默认0。0处理中；1完成；2终止，未完成',
  `cms_desc` VARCHAR(256) NOT NULL DEFAULT '' COMMENT '接收订单描述',
  `cms_create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `cms_uuid` CHAR(32) NOT NULL DEFAULT '' COMMENT 'GUUID，外部标识',
  PRIMARY KEY (`cms_id`),
  KEY `index_accept_order_uuid` (`cms_uuid`),
  KEY `index_accept_user_order` (`cms_accept_user_id`,`cms_buy_order_id`)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table Shop User Money. By kan.yang@starcor.com. Date 2018-12-16 13:00:00
-- ------------------------------------------------------------------------------------
ALTER TABLE `order_manager` ADD COLUMN `cms_user_money` DECIMAL(10,2) NOT NULL DEFAULT 0.00 COMMENT '用户余额';

-- ------------------------------------------------------------------------------------
-- Table Shop Buy Order Column. By kan.yang@starcor.com. Date 2018-12-16 15:00:00
-- ------------------------------------------------------------------------------------
ALTER TABLE `system_buy_order` ADD COLUMN `cms_order_desc` VARCHAR(256) NOT NULL DEFAULT '' COMMENT '订单描述';
ALTER TABLE `system_buy_order` ADD COLUMN `cms_pay_order_code` INT(11) NOT NULL COMMENT '购买订单ID（订单系统对应主键）';
ALTER TABLE `system_buy_order` DROP COLUMN nns_order_data;

-- ------------------------------------------------------------------------------------
-- Table Shop Channel Column. By kan.yang@starcor.com. Date 2018-12-22 12:30:00
-- ------------------------------------------------------------------------------------
ALTER TABLE `system_channel_mode` ADD COLUMN `cms_input_charset` VARCHAR(64) NOT NULL DEFAULT '' COMMENT '输入字符集';
ALTER TABLE `system_channel_mode` ADD COLUMN `nns_transport` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '传输协议';
ALTER TABLE `system_channel` ADD COLUMN `nns_partner_id` INT(11) NOT NULL COMMENT '商户ID';
ALTER TABLE `system_channel_mode` ADD COLUMN `nns_channel_mode_flag` TINYINT(1) NOT NULL COMMENT '支付渠道类型：0二维码；1APP；2WAP';

-- ------------------------------------------------------------------------------------
-- Table order_client_order gao
-- ------------------------------------------------------------------------------------
CREATE TABLE `order_client_order` (
  `cms_id` int(11) NOT NULL,
  `cms_order_type_id` int(11) NOT NULL COMMENT '订单类型id',
  `cms_process_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '订单加工类型',
  `cms_material_list` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '订单面辅料选择',
  `cms_style` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '订单款式',
  `cms_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态：0订单未完成1订单审核2订单确认',
  `cms_create_time` datetime DEFAULT NULL COMMENT '创建订单时间',
  `cms_modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cms_id`),
  KEY `modify_create_time` (`cms_modify_time`,`cms_create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- ------------------------------------------------------------------------------------
-- Alter table name gao
-- ------------------------------------------------------------------------------------
alter table system_order_type_parent RENAME order_order_type_parent;
alter table system_order_type RENAME order_order_type;


