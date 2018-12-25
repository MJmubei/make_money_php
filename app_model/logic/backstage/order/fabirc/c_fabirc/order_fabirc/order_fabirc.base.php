<?php
class order_fabirc_base extends em_logic
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
            'length' => '0-32',
            'desc' => '面辅料名称',
        ),
        'cms_fabirc_attribute' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '面辅料属性，json格式',
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