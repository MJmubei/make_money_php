<?php
/**
 * Created by PhpStorm.
 * Use : 接收订单基础类
 * User: kan.yang@starcor.com
 * Date: 18-12-15
 * Time: 下午5:10
 */

class logic_accept_order_base extends em_logic
{

    //数据表名称
    public $str_base_table = 'system_accept_order';

    //基本表定义参数用于排除非法字段，验证字段
    public $table_define = array(
        'cms_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-11',
            'desc' => '主键ID',
        ),
        'cms_accept_user_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-10',
            'desc' => '接收订单用户ID',
        ),
        'cms_buy_order_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-11',
            'desc' => '购买订单ID',
        ),
        'cms_status' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '1',
            'desc' => '接收订单状态，默认0。0处理中；1完成；2终止，未完成',
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