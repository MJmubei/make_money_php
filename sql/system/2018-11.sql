
--------------------------------------
--
--------------------------------------
CREATE TABLE `order_manager` (
  `cms_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增序列号',
  `cms_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cms_password` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cms_state` int(4) NOT NULL DEFAULT '0' COMMENT '启用禁用状态,0启用，1禁用',
  `cms_role_id` mediumtext COLLATE utf8_unicode_ci COMMENT '角色ID,1系统管理员，2供应商，3订购商，4生产商',
  `cms_create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `cms_modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `cms_login_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '登录时间',
  `cms_login_count` int(4) DEFAULT '0' COMMENT '登陆次数',
  `cms_type` int(4) DEFAULT NULL,
  `cms_login_fail_numbers` tinyint(3) NOT NULL DEFAULT '0' COMMENT '登录账号失败次数',
  `cms_user_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '登录此账号的ip',
  `cms_password_modify_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '密码修改时间',
  `cms_telephone` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `cms_email` VARCHAR(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `cms_token` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户登录时生成的token',
  `cms_token_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '用户登录的token有效时间',
  `cms_desc` VARCHAR(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '描述信息',
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员表';