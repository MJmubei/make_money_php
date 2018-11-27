<?php
/**
 * LOGIC表em_manager 操作类
 * @author pan.liang
 * @date 2016-12-30 13:51:33
 */
class system_manager extends em_logic
{
    /**
     * 基本表定义参数用于排除非法字段，验证字段
     * @var params $table_define
     * @date 2016-12-30 13:51:33
     */
     public $table_define = array(
        'cms_id' => array( 
            'type' => 'int',
            'isempty' => 'n',
            'length' => '',
            'desc' => 'UUID',
        ),
        'cms_name' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '128',
            'desc' => '管理员名称',
        ),
        'cms_login_name' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '32',
            'desc' => '管理员登录账号',
        ),
        'cms_login_pass' => array( 
            'type' => 'char',
            'isempty' => 'n',
            'length' => '32',
            'desc' => '登录密码',
        ),
        'cms_role_id' => array( 
            'type' => 'int',
            'isempty' => 'n',
            'length' => '',
            'desc' => '角色uuid',
        ),
        'cms_login_count' => array( 
            'type' => 'int',
            'isempty' => 'n',
            'length' => '',
            'desc' => '登录次数',
        ),
        'cms_login_time' => array( 
            'type' => 'datetime',
            'isempty' => 'n',
            'length' => '',
            'desc' => '登录时间',
        ),
        'cms_state' => array( 
            'type' => 'tinyint',
            'isempty' => 'n',
            'length' => '',
            'desc' => '管理员状态  0 启用 | 1 禁用  默认禁用',
        ),
        'cms_deleted' => array( 
            'type' => 'tinyint',
            'isempty' => 'n',
            'length' => '',
            'desc' => '0 未删除  | 1 已删除',
        ),
        'cms_create_time' => array( 
            'type' => 'datetime',
            'isempty' => 'n',
            'length' => '',
            'desc' => '创建时间',
        ),
        'cms_modify_time' => array( 
            'type' => 'datetime',
            'isempty' => 'n',
            'length' => '',
            'desc' => '修改时间',
        ),
     );

    /**
     * LOGIC 添加 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-30 13:51:33
     */
    public function add()
    {
        return $this->make_insert_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 虚拟删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-30 13:51:33
     */
    public function del()
    {
        return $this->make_del_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 真实删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-30 13:51:33
     */
    public function rel_del()
    {
        return $this->make_rel_del_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 修改 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-30 13:51:33
     */
    public function edit()
    {
        return $this->make_edit_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 查询 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-30 13:51:33
     */
    public function query()
    {
        return $this->make_query_sql($this->except_useless_params($this->arr_params, $this->table_define,true));
    }

    /**
     * LOGIC 查询唯一 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-30 13:51:33
     */
    public function query_only()
    {
        return $this->make_query_only_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

}