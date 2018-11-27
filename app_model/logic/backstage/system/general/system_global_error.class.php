<?php
/**
 * LOGIC表em_global_error 操作类
 * @author pan.liang
 * @date 2016-12-19 23:45:39
 */
class system_global_error extends em_logic
{
    /**
     * 基本表定义参数用于排除非法字段，验证字段
     * @var params $table_define
     * @date 2016-12-19 23:45:39
     */
     public $table_define = array(
        'em_id' => array( 
            'type' => 'int',
            'isempty' => 'n',
            'length' => '',
            'desc' => '',
        ),
        'em_stage' => array( 
            'type' => 'varchar',
            'isempty' => 'y',
            'length' => '12',
            'desc' => '框架前后台',
        ),
        'em_model' => array( 
            'type' => 'varchar',
            'isempty' => 'y',
            'length' => '24',
            'desc' => '项目名称',
        ),
        'em_model' => array( 
            'type' => 'varchar',
            'isempty' => 'y',
            'length' => '24',
            'desc' => '模块名称',
        ),
        'em_class' => array( 
            'type' => 'varchar',
            'isempty' => 'y',
            'length' => '24',
            'desc' => '类名称',
        ),
        'em_method' => array( 
            'type' => 'varchar',
            'isempty' => 'y',
            'length' => '24',
            'desc' => '方法名称',
        ),
        'em_error_type' => array( 
            'type' => 'varchar',
            'isempty' => 'y',
            'length' => '12',
            'desc' => '错误消息类型',
        ),
        'em_error_info' => array( 
            'type' => 'text',
            'isempty' => 'y',
            'length' => '65535',
            'desc' => '错误日志',
        ),
        'em_error_file' => array( 
            'type' => 'varchar',
            'isempty' => 'y',
            'length' => '255',
            'desc' => '错误文件位置',
        ),
        'em_deleted' => array( 
            'type' => 'tinyint',
            'isempty' => 'y',
            'length' => '',
            'desc' => '是否删除 0 未删除 | 1已删除',
        ),
        'em_create_time' => array( 
            'type' => 'datetime',
            'isempty' => 'y',
            'length' => '',
            'desc' => '创建时间',
        ),
        'em_modify_time' => array( 
            'type' => 'datetime',
            'isempty' => 'y',
            'length' => '',
            'desc' => '修改时间',
        ),
     );

    /**
     * LOGIC 添加 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:45:39
     */
    public function add()
    {
        return $this->make_insert_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 虚拟删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:45:39
     */
    public function del()
    {
        return $this->make_del_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 真实删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:45:39
     */
    public function rel_del()
    {
        return $this->make_rel_del_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 修改 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:45:39
     */
    public function edit()
    {
        return $this->make_edit_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 查询 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:45:39
     */
    public function query()
    {
        return $this->make_query_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 查询唯一 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 23:45:39
     */
    public function query_only()
    {
        return $this->make_query_only_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

}