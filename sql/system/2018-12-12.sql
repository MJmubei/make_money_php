-- ------------------------------------------------------------------------------------
-- Table Shop Order. By kan.yang@starcor.com. Date 2018-12-12 20:25:00
-- ------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `system_buy_order` (
  `cms_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `cms_user_id` INT(10) NOT NULL COMMENT '用户ID',
  `cms_order_name` VARCHAR(128) NOT NULL COMMENT '订单名称',
  `cms_order_price` DECIMAL(10,2) NOT NULL COMMENT '订单金额',
  `cms_order_type` TINYINT(1) NOT NULL COMMENT '订单类型。0批量订单；1面料小样；2样板订单；3样衣订单；4稀缺面料定金订单',
  `cms_order_state` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '订单状态。0未支付；1已支付；2已取消；3已过期；4退款中；5已退订；6订单异常',
  `cms_business_state` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '业务状态。0未完成；1完成',
  `cms_pay_order_id` CHAR(32) NOT NULL COMMENT '支付订单号',
  `cms_pay_partner_id` INT(11) NOT NULL COMMENT '支付商户ID',
  `cms_pay_channel_id` INT(4) NOT NULL COMMENT '支付渠道。1微信支付；2支付宝支付',
  `cms_pay_mode_id` INT(4) NOT NULL COMMENT '支付方式。10微信二维码；20支付宝二维码',
  `cms_create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `cms_refund_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '退订时间',
  `cms_refund_money` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT '退订金额',
  `cms_refund_state` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '退订状态。0暂无；1部分退款；2全额退款',
  `cms_uuid` CHAR(32) NOT NULL DEFAULT '' COMMENT 'GUUID，外部标识',
  PRIMARY KEY (`cms_id`),
  KEY `index_order_uuid` (`cms_uuid`),
  KEY `index_order_user_id` (`cms_user_id`),
  KEY `index_order_create_time` (`cms_create_time`),
  KEY `index_order_order_state` (`cms_business_state`,`cms_order_state`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table Shop Partner. By kan.yang@starcor.com. Date 2018-12-12 20:25:00
-- ------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `system_partner` (
  `cms_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '商户ID',
  `cms_name` VARCHAR(64) NOT NULL COMMENT '商户名称',
  `cms_secret` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '商户密钥',
  `cms_user_id` INT(10) NOT NULL COMMENT '用户ID',
  `cms_status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '商户状态，默认1。0:禁用；1启用',
  `cms_phone` VARCHAR(11) NOT NULL DEFAULT '' COMMENT '联系电话',
  `cms_contact` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '联系人',
  `cms_email` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '邮箱',
  `cms_desc` VARCHAR(256) NOT NULL DEFAULT '' COMMENT '商户描述',
  `cms_create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `cms_uuid` CHAR(32)  NOT NULL DEFAULT '' COMMENT 'GUUID，外部标识',
  PRIMARY KEY (`cms_id`),
  KEY `index_partner_uuid` (`cms_uuid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table Shop Channel. By kan.yang@starcor.com. Date 2018-12-12 20:25:00
-- ------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cms_channel` (
  `cms_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '支付渠道ID',
  `cms_name` VARCHAR(64) NOT NULL COMMENT '支付渠道名称',
  `cms_user_id` INT(10) NOT NULL COMMENT '用户ID',
  `cms_status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '渠道状态，默认1。0禁用；1启用',
  `cms_platform_id` INT(4) NOT NULL COMMENT '支付平台ID。1微信支付；2支付宝支付',
  `cms_platform_name` VARCHAR(32) NOT NULL DEFAULT '支付平台' COMMENT '支付平台名称',
  `cms_desc` VARCHAR(256) NOT NULL DEFAULT '' COMMENT '渠道描述',
  `cms_create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `cms_uuid` CHAR(32) NOT NULL DEFAULT '' COMMENT 'GUUID，外部标识',
  PRIMARY KEY (`cms_id`),
  KEY `index_partner_uuid` (`cms_uuid`)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table Shop Channel Mode. By kan.yang@starcor.com. Date 2018-12-12 20:25:00
-- ------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cms_channel_mode` (
  `cms_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '支付方式ID',
  `cms_channel_id` INT(11) NOT NULL COMMENT '支付渠道ID',
  `cms_pay_mode_name` VARCHAR(128) NOT NULL  DEFAULT '' COMMENT '支付方式名称',
  `cms_user_id` INT(10) NOT NULL COMMENT '用户ID',
  `cms_pay_appid` VARCHAR(64) NOT NULL  DEFAULT '' COMMENT '支付平台：APP ID',
  `cms_pay_partner_key` VARCHAR(64) NOT NULL  DEFAULT '' COMMENT '支付平台：商户KEY',
  `cms_pay_partner_id` VARCHAR(128) NOT NULL  DEFAULT '' COMMENT '支付平台：商户ID',
  `cms_pay_partner` VARCHAR(256) NOT NULL  DEFAULT '' COMMENT '支付平台：商户名称',
  `cms_qr_expire_time` INT(11) NOT NULL  DEFAULT 0 COMMENT '二维码过期时间',
  `cms_sign_type` TINYINT(1) NOT NULL DEFAULT 2 COMMENT '签名方式（支付宝），默认2。1：RSA1；2：RSA2（SHA256）',
  `cms_apiclient_cert` VARCHAR(256) NOT NULL COMMENT '密钥证书路径（微信）：apiclient_cert',
  `cms_apiclient_key` VARCHAR(256) NOT NULL COMMENT '密钥证书路径（微信）：apiclient_key',
  `cms_public_key` VARCHAR(256) NOT NULL COMMENT '密钥证书路径-公钥（支付宝）：public_key',
  `cms_private_key` VARCHAR(256) NOT NULL COMMENT '密钥证书路径-私钥（支付宝）：private_key',
  `cms_notify_url` VARCHAR(256) NOT NULL DEFAULT '' COMMENT '支付异步通知地址',
  `cms_error_notify_url` VARCHAR(256) NOT NULL DEFAULT '' COMMENT '异步错误通知地址',
  `cms_desc` VARCHAR(256) NOT NULL DEFAULT '' COMMENT '支付方式描述',
  `cms_create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `cms_uuid` CHAR(32) NOT NULL DEFAULT '' COMMENT 'GUUID，外部标识',
  PRIMARY KEY (`cms_id`),
  KEY `index_channel_mode_uuid` (`cms_uuid`),
  KEY `index_mode_channel_user` (`cms_channel_id`,`cms_user_id`)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table Shop WeChat Account. By kan.yang@starcor.com. Date 2018-12-12 20:25:00
-- ------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cms_wechat_accounts` (
  `cms_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '主键标识',
  `cms_account_id` CHAR(32) NOT NULL COMMENT '微信公众号ID',
  `cms_account_name` CHAR(32) NOT NULL COMMENT '微信公众号名称',
  `cms_user_id` INT(10) NOT NULL COMMENT '用户ID',
  `cms_add_auto_reply` VARCHAR(512) NOT NULL DEFAULT '' COMMENT '添加自动回复内容。如：用户关注此微信公众号时，将收到的一条回复内容',
  `cms_search_auto_reply` VARCHAR(512) NOT NULL DEFAULT '' COMMENT '搜索自动回复,是一个json字符串{type:’消息类型’,content:’内容’},type表示消息类型text，news，voice如果是text则为text内容，如果是多媒体则为消息id',
  `cms_auto_reply` VARCHAR(512) NOT NULL DEFAULT '' COMMENT '消息自动回复内容',
  `cms_token` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '公众号Token',
  `cms_app_id` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '微信公众号APP ID',
  `cms_app_secret` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '微信公众号APP密钥',
  `cms_access_token` VARCHAR(256) NOT NULL DEFAULT '' COMMENT '微信公众号APP访问Token',
  `cms_start_m_server_begin_keyword` CHAR(8) NOT NULL DEFAULT '' COMMENT '触发多客服开头关键词',
  `cms_start_search_vod_begin_keyword` CHAR(8) NOT NULL DEFAULT '' COMMENT '触发搜索配起始关键词',
  `cms_search_more_img` VARCHAR(128) NOT NULL DEFAULT '' COMMENT '‘更多’的标签图片地址',
  `cms_ad_img` VARCHAR(128) NOT NULL DEFAULT '' COMMENT '广告图片',
  `cms_create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `cms_access_token_create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '访问Token码生成时间',
  `cms_jsapi_ticket` VARCHAR(256) NOT NULL COMMENT 'JsApi Ticket',
  `cms_jsapi_ticket_create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'JsApi Ticket生成时间',
  PRIMARY KEY (`cms_id`),
  KEY `index_accounts_user` (`cms_user_id`),
  UNIQUE KEY `index_accounts_account_app` (`cms_account_id`,`cms_app_id`)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table system_order_type_parent gao 2018-12-13 14:21:47
-- ------------------------------------------------------------------------------------
CREATE TABLE `system_order_type_parent` (
`cms_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id' ,
`cms_category_parent_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单类型父级id' ,
`cms_category_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单类型id' ,
`cms_category_name`  varchar(255) NOT NULL DEFAULT '' COMMENT '类型栏目名称' ,
`cms_create_time`  datetime NOT NULL COMMENT '创建时间' ,
`cms_modify_time`  datetime NOT NULL COMMENT '修改时间' ,
PRIMARY KEY (`cms_id`),
INDEX `create_modify_time` (`cms_create_time`, `cms_modify_time`)
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table system_order_type gao 2018-12-13 14:21:47
-- ------------------------------------------------------------------------------------
CREATE TABLE `system_order_type` (
`cms_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id' ,
`cms_category_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单类型父级id' ,
`cms_type_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单类型id' ,
`cms_type_name`  varchar(255) NOT NULL DEFAULT '' COMMENT '类型名称' ,
`cms_create_time`  datetime NOT NULL COMMENT '创建时间' ,
`cms_modify_time`  datetime NOT NULL COMMENT '修改时间' ,
PRIMARY KEY (`cms_id`),
INDEX `create_modify_time` (`cms_create_time`, `cms_modify_time`)
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table order_fabirc zhiyong.luo 2018-12-13 14:21:47 面辅料表
-- ------------------------------------------------------------------------------------
CREATE TABLE `order_fabirc` (
  `cms_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `cms_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '面辅料名称',
  `cms_fabirc_attribute` varchar(256) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '面辅料属性，json存储格式',
  `cms_is_scarce` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否属于奇缺面辅料0普通1奇缺',
  `cms_create_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table order_fabirc_type zhiyong.luo 2018-12-13 14:21:47 面辅料订单类型表
-- ------------------------------------------------------------------------------------
CREATE TABLE `order_fabirc_type` (
  `cms_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `cms_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '面辅料类型名称',
  `cms_create_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table order_fabirc_map zhiyong.luo 2018-12-13 14:21:47 面辅料关系绑定表
-- ------------------------------------------------------------------------------------
CREATE TABLE `order_fabirc_map` (
  `cms_fabirc_type_id` int(11) unsigned NOT NULL COMMENT '面辅料类型ID',
  `cms_fabirc_id` int(11) unsigned NOT NULL COMMENT '面辅料ID',
  `cms_create_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  UNIQUE KEY `fabirc_unique` (`cms_fabirc_type_id`,`cms_fabirc_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------------------------------
-- Table Shop Change Column And Table Name. By kan.yang@starcor.com. Date 2018-12-12 20:25:00
-- ------------------------------------------------------------------------------------
ALTER TABLE `system_buy_order` MODIFY `cms_pay_order_id` VARCHAR(32) NOT NULL DEFAULT ''  COMMENT '支付订单号';
ALTER TABLE `system_buy_order` ADD COLUMN `nns_order_data` TEXT NOT NULL COMMENT '订单数据，以JSON格式存储';
ALTER TABLE `cms_wechat_accounts` RENAME TO `system_wechat_accounts`;
ALTER TABLE `cms_channel_mode` RENAME TO `system_channel_mode`;
ALTER TABLE `cms_channel` RENAME TO `system_channel`;

