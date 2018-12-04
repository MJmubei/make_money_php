<?php
class system_menu_base extends em_logic
{
    public $table_define = array(
        'base_info'     =>      array(
            'cms_id'                        =>      array (
                'rule'      => 'auto_increment',
                'default'   => 'auto_increment',
                'length'    => '',
                'desc'      => '项目ID',
            ),
            'cms_project_id'                      =>      array (
                'rule'      => 'int',
                'default'   => '',
                'length'     => '',
                'desc'      => '项目ID',
            ),
            'cms_mark'                      =>      array (
                'rule'      => 'noempty',
                'default'   => '',
                'length'     => '1-32',
                'desc'      => '项目栏目标示',
            ),
            'cms_name'                      =>      array (
                'rule'      => 'noempty',
                'default'   => '',
                'length'     => '1-255',
                'desc'      => '注入来源项目英文标示',
            ),
            'cms_url'        =>      array (
                'rule'      => '',
                'default'   => '',
                'length'     => '0-255',
                'desc'      => 'url链接地址',
            ),
            'cms_level'           =>      array (
                'rule'      => '',
                'default'   => '',
                'length'    => '1-11',
                'desc'      => '菜单层级',
            ),
            'cms_parent_id'                    =>      array (
                'rule'      => 'int',
                'default'   => '',
                'length'    => '',
                'desc'      => '父级菜单ID',
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
                'desc'      => '菜单状态  0 启用  1 禁用',
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