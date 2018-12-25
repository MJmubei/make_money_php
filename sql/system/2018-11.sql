
--------------------------------------
--用户表 xinxin.deng 2018/12/23 16:05
--------------------------------------
CREATE TABLE `order_manager` (
  `cms_id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cms_password` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cms_state` int(4) NOT NULL DEFAULT '0' COMMENT '启用禁用状态,0启用，1禁用',
  `cms_role_id` tinyint(4) DEFAULT NULL COMMENT '角色ID',
  `cms_create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `cms_login_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '登录时间',
  `cms_login_count` int(4) DEFAULT '0' COMMENT '登陆次数',
  `cms_type` int(4) DEFAULT NULL,
  `cms_login_fail_numbers` tinyint(3) NOT NULL DEFAULT '0' COMMENT '登录账号失败次数',
  `cms_user_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '登录此账号的ip',
  `cms_password_modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '密码修改时间',
  `cms_telephone` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `cms_email` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `cms_token` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户登录时生成的token',
  `cms_token_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '用户登录的token有效时间',
  `cms_desc` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '描述信息',
  `cms_sex` tinyint(1) DEFAULT '1' COMMENT '性别,1未知,2男,3女',
  `cms_country` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '国家',
  `cms_address` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `cms_establish_date` date DEFAULT '0000-00-00' COMMENT '成立时间',
  `cms_main_product` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '主营产品',
  `cms_sale_channels` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '销售渠道',
  `cms_bank_info` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '对公银行账号',
  `cms_courier_info` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '快递发货地址、电话、收件人',
  `cms_courier_big_info` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '大件发货地址、电话、收件人',
  `cms_company_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '企业名称(允许个人)',
  `cms_head_img` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `cms_user_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户余额',
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1246 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员表'