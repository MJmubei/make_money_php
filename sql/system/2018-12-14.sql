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

