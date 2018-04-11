<?php
/**
 * LOGIC表em_role 操作类
 * @author pan.liang
 * @date 2016-12-19 23:48:45
 */
class role extends em_logic
{
    /**
     * 基本表定义参数用于排除非法字段，验证字段
     * @var params $table_define
     * @date 2016-12-19 23:48:45
     */
     public $table_define = array(
        'em_id' => array( 
            'type' => 'int',
            'isempty' => 'n',
            'length' => '',
            'desc' => '',
        ),
        'em_model_id' => array( 
            'type' => 'int',
            'isempty' => 'n',
            'length' => '',
            'desc' => '模板id',
        ),
        'em_role_name' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '128',
            'desc' => '角色名称',
        ),
        'em_roles' => array( 
            'type' => 'text',
            'isempty' => 'n',
            'length' => '65535',
            'desc' => '角色权限（json）',
        ),
        'em_desc' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '512',
            'desc' => '角色描述',
        ),
        'em_create_time' => array( 
            'type' => 'datetime',
            'isempty' => 'n',
            'length' => '',
            'desc' => '创建时间',
        ),
        'em_modify_time' => array( 
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
     * @date 2016-12-19 23:48:45
     */
    public function add()
    {
        return $this->make_insert_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 虚拟删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:48:45
     */
    public function del()
    {
        return $this->make_del_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 真实删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:48:45
     */
    public function rel_del()
    {
        return $this->make_rel_del_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 修改 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:48:45
     */
    public function edit()
    {
        return $this->make_edit_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 查询 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:48:45
     */
    public function query()
    {
        return $this->make_query_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 查询唯一 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:48:45
     */
    public function query_only()
    {
        return $this->make_query_only_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

}