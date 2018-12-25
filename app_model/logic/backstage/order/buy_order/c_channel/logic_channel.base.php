<?php
/**
 * Created by PhpStorm.
 * Use : 支付渠道
 * User: kan.yang@starcor.com
 * Date: 18-12-15
 * Time: 下午3:30
 */

class logic_channel_base extends em_logic
{

    //数据表名称
    public $str_base_table = 'system_channel';

    //基本表定义参数用于排除非法字段，验证字段
    public $table_define = array(
        'cms_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-11',
            'desc' => '支付渠道ID',
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
            'desc' => '支付渠道名称',
        ),
        'cms_status' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '1',
            'desc' => '渠道状态，默认1。0禁用；1启用',
        ),
        'cms_platform_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-4',
            'desc' => '支付平台ID。1微信支付；2支付宝支付',
        ),
        'cms_platform_name' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '支付平台名称',
        ),
        'cms_business_state' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '1',
            'desc' => '业务状态。0未完成；1完成',
        ),
        'cms_desc' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '渠道描述',
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
        'nns_partner_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-11',
            'desc' => '商户ID',
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