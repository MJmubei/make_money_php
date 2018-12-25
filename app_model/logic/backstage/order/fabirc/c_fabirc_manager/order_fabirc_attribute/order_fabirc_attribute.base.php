<?php
class order_fabirc_attribute_base extends em_logic
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
            'desc' => '面辅料类型名称',
        ),
        'cms_value' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-255',
            'desc' => '面辅料属性值范围json',
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