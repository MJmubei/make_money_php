<?php
/**
 * LOGIC表em_project_model 操作类
 * @author pan.liang
 * @date 2016-12-19 22:15:19
 */
class project_model extends em_logic
{
    /**
     * 基本表定义参数用于排除非法字段，验证字段
     * @var params $table_define
     * @date 2016-12-19 22:15:19
     */
     public $table_define = array(
        'em_id' => array( 
            'type' => 'int',
            'isempty' => 'n',
            'length' => '',
            'desc' => 'uuID',
        ),
        'em_stage' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '32',
            'desc' => '前后台模板',
        ),
        'em_stage_name' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '128',
            'desc' => '前后台模板名称',
        ),
        'em_stage_desc' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '256',
            'desc' => '前后台模板描述',
        ),
        'em_model' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '32',
            'desc' => '模块',
        ),
        'em_model_name' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '128',
            'desc' => '模块名称',
        ),
        'em_model_desc' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '256',
            'desc' => '模块描述',
        ),
        'em_class' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '32',
            'desc' => '类标示',
        ),
        'em_class_name' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '128',
            'desc' => '类名称',
        ),
        'em_class_desc' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '256',
            'desc' => '类描述',
        ),
        'em_method' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '32',
            'desc' => '方法',
        ),
        'em_method_name' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '128',
            'desc' => '方法名称',
        ),
        'em_method_desc' => array( 
            'type' => 'varchar',
            'isempty' => 'n',
            'length' => '256',
            'desc' => '方法描述',
        ),
        'em_deleted' => array( 
            'type' => 'tinyint',
            'isempty' => 'n',
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
     * @date 2016-12-19 22:15:19
     */
    public function add()
    {
        return $this->make_insert_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 虚拟删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 22:15:19
     */
    public function del()
    {
        return $this->make_del_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 真实删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 22:15:19
     */
    public function rel_del()
    {
        return $this->make_rel_del_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 修改 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 22:15:19
     */
    public function edit()
    {
        return $this->make_edit_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 查询 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 22:15:19
     */
    public function query()
    {
        return $this->make_query_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

    /**
     * LOGIC 查询唯一 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-19 22:15:19
     */
    public function query_only()
    {
        return $this->make_query_only_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }

}