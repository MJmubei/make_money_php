<?php

/**
 * 基本表定义参数用于排除非法字段，验证字段
 * @var array
 */
class order_producer_time_base extends em_logic
{
    public $table_define = array(
        'cms_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '主键id',
        ),
        'cms_manager_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '用户账号id',
        ),
        'cms_person_amount' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '工人数量',
        ),
        'cms_free_time' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '32',
            'desc' => '工期时间',
        ),
        'cms_status' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '0-2',
            'desc' => '空期信息状态；0有效1过期',
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

