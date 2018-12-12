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
        'cms_id' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => 'UUID',
        ),
        'cms_name' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-128',
            'desc' => '管理员账号名称',
        ),
        'cms_password' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '登陆密码',
        ),
        'cms_login_pass' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '登录密码',
        ),
        'cms_role_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '',
            'desc' => '角色uuid',
        ),
        'cms_login_count' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '',
            'desc' => '登录次数',
        ),
        'cms_login_time' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '登录时间',
        ),
        'cms_state' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '',
            'desc' => '管理员状态  0 启用 | 1 禁用  默认禁用',
        ),
        'cms_create_time' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '创建时间',
        ),
        'cms_modify_time' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '修改时间',
        ),
        'cms_type' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '',
            'desc' => '类型',
        ),
        'cms_login_fail_numbers' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '',
            'desc' => '登陆失败次数',
        ),
        'cms_user_ip' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '',
            'desc' => '用户登陆IP',
        ),
        'cms_password_modify_time' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '密码修改时间',
        ),
        'cms_telephone' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '11',
            'desc' => '手机号',
        ),
        'cms_email' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '32',
            'desc' => '邮箱',
        ),
        'cms_token' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '32',
            'desc' => '用户登录时生成的token',
        ),
        'cms_token_expire' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '用户登录的token有效时间',
        ),
        'cms_desc' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '',
            'desc' => '描述信息',
        ),
    );
}