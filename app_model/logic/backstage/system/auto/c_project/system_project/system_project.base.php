<?php
class system_project_base extends em_logic
{
    public $table_define = array(
        'base_info'     =>      array(
            'cms_id'                        =>      array (
                'rule'      => 'auto_increment',
                'default'   => 'auto_increment',
                'length'    => '',
                'desc'      => '项目ID',
            ),
            'cms_name'                      =>      array (
                'rule'      => 'noempty',
                'default'   => '',
                'length'     => '0-255',
                'desc'      => '项目名称',
            ),
            'cms_mark'                      =>      array (
                'rule'      => 'noempty',
                'default'   => '',
                'length'     => '1-24',
                'desc'      => '注入来源项目英文标示',
            ),
            'cms_mobilephone_number'        =>      array (
                'rule'      => '',
                'default'   => '',
                'length'     => '0-11',
                'desc'      => '手机号码',
            ),
            'cms_telphone_number'           =>      array (
                'rule'      => '',
                'default'   => '',
                'length'    => '0-11',
                'desc'      => '移动电话',
            ),
            'cms_remark'                    =>      array (
                'rule'      => '',
                'default'   => '',
                'length'    => '0-256',
                'desc'      => '备注',
            ),
            'cms_email'                    =>      array (
                'rule'      => '',
                'default'   => '',
                'length'    => '0-56',
                'desc'      => '邮箱URL地址',
            ),
            'cms_order'                     =>      array (
                'rule'      => 'float',
                'default'   => '0.000',
                'length'    => '',
                'desc'      => '排序权重',
            ),
            'cms_state'                     =>      array (
                'rule'      => 'int',
                'default'   => '1',
                'length'    => '',
                'desc'      => '拼音',
            ),
            'cms_create_time'               =>      array (
                'rule'      => 'datetime',
                'default'   => 'datetime',
                'length'    => '',
                'desc'      => '创建时间',
            ),
            'cms_modify_time'               =>      array (
                'rule'      => 'datetime',
                'default'   => 'datetime',
                'length'    => '',
                'desc'      => '修改时间',
            ),
        ),
        'index_info'                        =>      array(
            'PRIMARY'       =>      array (
                'rule'      => 'PRIMARY',
                'fields'    => array('cms_id'),
                'desc'      => '主键索引',
            ),
            'mark'                          =>      array (
                'rule'      => 'UNIQUE',
                'fields'    => array('cms_mark'),
                'desc'      => '唯一索引',
            ),
        ),
    );
}