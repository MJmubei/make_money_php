<?php
/**
 * Created by PhpStorm.
 * Use : 商户基础类
 * User: kan.yang@starcor.com
 * Date: 18-12-15
 * Time: 下午4:30
 */

class logic_partner_base extends em_logic
{

    //数据表名称
    public $str_base_table = 'system_partner';

    //基本表定义参数用于排除非法字段，验证字段
    public $table_define = array(
        'cms_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-11',
            'desc' => '订单id',
        ),
        'cms_user_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-10',
            'desc' => '用户ID',
        ),
        'cms_name' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-64',
            'desc' => '商户名称',
        ),
        'cms_secret' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '商户密钥',
        ),
        'cms_status' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '1',
            'desc' => '商户状态，默认1。0:禁用；1启用',
        ),
        'cms_phone' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-11',
            'desc' => '联系电话',
        ),
        'cms_contact' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '联系人',
        ),
        'cms_email' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '邮箱',
        ),
        'cms_desc' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '商户描述',
        ),
        'cms_create_time' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '创建时间',
        ),
        'cms_modify_time' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '',
            'desc' => '修改时间',
        ),
        'cms_uuid' => array(
            'type' => 'char',
            'isempty' => '',
            'length' => '32',
            'desc' => 'GUUID，外部标识',
        ),
    );

    /**
     * 默认构造函数
     */
    public function __construct($obj_controller,$arr_params = null)
    {
        //初始化父级构造函数
        parent::__construct($obj_controller,$this->str_base_table,$arr_params);
    }

} 