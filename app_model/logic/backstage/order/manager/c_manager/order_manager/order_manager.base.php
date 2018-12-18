<?php
/**
 * Created by <stacrcor.com>.
 * Author: xinxin.deng
 * Date: 2018/12/7 10:32
 */
class order_manager_base extends em_logic
{
    /**
     * 基本表定义参数用于排除非法字段，验证字段
     * @var array
     */
    public $table_define = array(
        'base_info' => array(
            'cms_id' => array(
                'type' => 'varchar',
                'default'   => '',
                'isempty' => '',
                'length' => '0-32',
                'desc' => 'UUID',
            ),
            'cms_name' => array(
                'type' => 'varchar',
                'default'   => '',
                'isempty' => '',
                'length' => '0-128',
                'desc' => '管理员账号名称',
            ),
            'cms_password' => array(
                'type' => 'varchar',
                'default'   => '',
                'isempty' => '',
                'length' => '0-32',
                'desc' => '登陆密码',
            ),
            'cms_role_id' => array(
                'type' => 'int',
                'default'   => '1',
                'isempty' => '',
                'length' => '',
                'desc' => '角色uuid',
            ),
            'cms_login_count' => array(
                'type' => 'int',
                'default'   => 0,
                'isempty' => '',
                'length' => '',
                'desc' => '登录次数',
            ),
            'cms_login_time' => array(
                'type' => 'datetime',
                'default'   => '0000-00-00 00:00',
                'isempty' => '',
                'length' => '',
                'desc' => '登录时间',
            ),
            'cms_state' => array(
                'type' => 'tinyint',
                'default'   => 0,
                'isempty' => '',
                'length' => '0-4',
                'desc' => '管理员状态  0 启用 | 1 禁用  默认禁用',
            ),
            'cms_create_time' => array(
                'type' => 'datetime',
                'default'   => '0000-00-00 00:00',
                'isempty' => '',
                'length' => '',
                'desc' => '创建时间',
            ),
            'cms_modify_time' => array(
                'type' => 'datetime',
                'default'   => '0000-00-00 00:00',
                'isempty' => '',
                'length' => '',
                'desc' => '修改时间',
            ),
            'cms_type' => array(
                'type' => 'varchar',
                'default'   => '',
                'isempty' => '',
                'length' => '',
                'desc' => '类型',
            ),
            'cms_login_fail_numbers' => array(
                'type' => 'int',
                'default'   => 0,
                'isempty' => '',
                'length' => '',
                'desc' => '登陆失败次数',
            ),
            'cms_user_ip' => array(
                'type' => 'varchar',
                'default'   => '',
                'isempty' => '',
                'length' => '',
                'desc' => '用户登陆IP',
            ),
            'cms_password_modify_time' => array(
                'type' => 'datetime',
                'default'   => '0000-00-00 00:00',
                'isempty' => '',
                'length' => '',
                'desc' => '密码修改时间',
            ),
            'cms_telephone' => array(
                'type' => 'varchar',
                'default'   => '',
                'isempty' => '',
                'length' => '11',
                'desc' => '手机号',
            ),
            'cms_email' => array(
                'type' => 'varchar',
                'default'   => '',
                'isempty' => '',
                'length' => '0-32',
                'desc' => '邮箱',
            ),
            'cms_token' => array(
                'type' => 'varchar',
                'default'   => '',
                'isempty' => '',
                'length' => '0-32',
                'desc' => '用户登录时生成的token',
            ),
            'cms_token_expire' => array(
                'type' => 'datetime',
                'default'   => '0000-00-00 00:00',
                'isempty' => '',
                'length' => '',
                'desc' => '用户登录的token有效时间',
            ),
            'cms_desc' => array(
                'type' => 'varchar',
                'default'   => '',
                'isempty' => '',
                'length' => '',
                'desc' => '描述信息',
            ),
            'cms_user_money' => array(
                'type' => 'DECIMAL',
                'isempty' => '',
                'length' => '',
                'desc' => '用户余额',
            ),
        ),
    );
}