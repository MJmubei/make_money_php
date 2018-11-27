<?php
/**
 * LOGIC表em_global_system_params 操作类
 * @author pan.liang
 * @date 2016-12-20 00:16:47
 */
class global_system_params extends em_logic
{
    /**
     * 基本表定义参数用于排除非法字段，验证字段
     * @var params $table_define
     * @date 2016-12-20 00:16:47
     */
     public $table_define = array(
        'em_id' => array( 
            'type' => 'int',
            'isempty' => 'n',
            'length' => '',
            'desc' => 'uuID',
        ),
        'em_global_name' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '128',
            'desc' => '全局参数名称',
        ),
        'em_global_model' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '32',
            'desc' => '全局参数模板',
        ),
        'em_project_model' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '64',
            'desc' => '项目模板标示',
        ),
        'em_config' => array( 
            'type' => 'text',
            'isempty' => 'n',
            'length' => '65535',
            'desc' => '配置json',
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
     * @date 2016-12-20 00:16:47
     */
    public function add()
    {
        return $this->make_insert_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 虚拟删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-20 00:16:47
     */
    public function del()
    {
        return $this->make_del_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 真实删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-20 00:16:47
     */
    public function rel_del()
    {
        return $this->make_rel_del_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 修改 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-20 00:16:47
     */
    public function edit()
    {
        return $this->make_edit_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 查询 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-20 00:16:47
     */
    public function query()
    {
        return $this->make_query_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 查询唯一 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-20 00:16:47
     */
    public function query_only()
    {
        return $this->make_query_only_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

}