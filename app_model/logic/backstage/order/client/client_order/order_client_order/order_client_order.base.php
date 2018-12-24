<?php
/**
 * Created by PhpStorm.
 * User: fingal
 * Date: 2018/12/23
 * Time: 13:42
 */

//system_order_type_parent
class order_client_order_base extends em_logic
{
    /**
     * 基本表定义参数用于排除非法字段，验证字段
     * @var array
     */
    public $table_define = array(
        'cms_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '主键id',
        ),
        'cms_order_type_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '订单类型id',
        ),
        'cms_process_type' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '订单加工类型id',
        ),
        'cms_material_list' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '面辅料',
        ),
        'cms_style' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '订单款式',
        ), 'cms_status' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '订单状态',
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
    );
}