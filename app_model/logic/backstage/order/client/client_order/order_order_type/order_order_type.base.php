<?php
/**
 * Created by PhpStorm.
 * User: fingal
 * Date: 2018/12/23
 * Time: 13:42
 */

//system_order_type_parent
class order_order_type_base extends em_logic
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
        'cms_category_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '父级类型id',
        ),
        'cms_type_id' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '基本类型id',
        ),
        'cms_type_name' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '类型名称',
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