<?php
/**
 * LOGIC表order_manager 操作类
 * Created by <stacrcor.com>.
 * Author: xinxin.deng
 * Date: 2018/11/29 14:45
 */
class order_manager extends em_logic
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
            'length' => '0-128',
            'desc' => '管理员账号名称',
        ),
        'cms_password' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '登陆密码',
        ),
        'cms_login_pass' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '登录密码',
        ),
        'cms_role_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '',
            'desc' => '角色uuid',
        ),
        'cms_login_count' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '',
            'desc' => '登录次数',
        ),
        'cms_login_time' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '登录时间',
        ),
        'cms_state' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '',
            'desc' => '管理员状态  0 启用 | 1 禁用  默认禁用',
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
        'cms_type' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '',
            'desc' => '类型',
        ),
        'cms_login_fail_numbers' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '',
            'desc' => '登陆失败次数',
        ),
        'cms_user_ip' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '',
            'desc' => '用户登陆IP',
        ),
        'cms_password_modify_time' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '密码修改时间',
        ),
        'cms_telephone' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '11',
            'desc' => '手机号',
        ),
        'cms_email' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '32',
            'desc' => '邮箱',
        ),
        'cms_token' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '32',
            'desc' => '用户登录时生成的token',
        ),
        'cms_token_expire' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '用户登录的token有效时间',
        ),
        'cms_desc' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '',
            'desc' => '描述信息',
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
        return $this->make_query_only_sql($this->except_useless_params($this->arr_params, $this->table_define,true),$this->str_base_table);
    }

}