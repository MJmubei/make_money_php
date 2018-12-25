<?php
/**
 * Created by PhpStorm.
 * Use :商户业务类
 * User: kan.yang@starcor.com
 * Date: 18-12-15
 * Time: 下午4:30
 */

include_once 'logic_partner.base.php';
class partner_logic extends logic_partner_base
{

    /**
     * 默认构造函数
     */
    public function __construct($obj_controller,$table_name = '',$arr_params = null)
    {
        if(!empty($table_name))
        {
            $this->str_base_table = $table_name;
        }
        //初始化父级构造函数
        parent::__construct($obj_controller,$arr_params);
    }

    /**
     * 查询商户列表
     * @param array $arr_query_params array(
            'cms_id'            => '主键ID',
            'cms_user_id'       => '用户ID',
            'cms_start_time'    => '开始时间',
            'cms_end_time'      => '结束时间',
            'cms_name'          => '商户名称',
            'cms_status'        => '商户状态，默认1。0:禁用；1启用',
            'cms_uuid'          => '外部标识',
     * )
     * @param string $str_field     查询字段
     * @param array  $arr_limit     分页array('start','end')
     * @param string $str_join      联合查询（需要在外层拼装完成，这里只负责透传）
     * @param string $str_group     分组
     * @param string $str_order     排序
     * @return array array('ret' => 0/1,'reason' => '描述信息','data_info' => array(),'page_info' =>array())
     */
    public function get_list($arr_query_params = array(), $str_field = "*", $arr_limit = array(), $str_join = "", $str_group = '',$str_order = '')
    {
        //标准化入参
        $this->_init_logic($arr_query_params);
        //组装过滤条件
        $str_where_sql = '1=1';
        $this->_batch_comm_query_where($arr_query_params,array('cms_name','cms_start_time','cms_end_time'),'in',$str_where_sql);
        //商户名称
        if(isset($arr_query_params['cms_name']))
        {
            $str_where_sql .= ' and cms_name like \'%' . $arr_query_params['cms_name'] . '%\'';
        }
        //开始时间
        if(isset($arr_query_params['cms_start_time']))
        {
            $str_where_sql .= ' and cms_create_time >= \'' . $arr_query_params['cms_start_time'] . '\'';
        }
        //结束时间
        if(isset($arr_query_params['cms_end_time']))
        {
            $str_where_sql .= ' and cms_create_time <= \'' . $arr_query_params['cms_end_time'] . '\'';
        }
        //分页
        if(!empty($arr_limit))
        {
            $this->obj_controller->arr_page_params['cms_page_num'];
            $this->obj_controller->arr_page_params['cms_page_size'];
        }
        //分组
        if(!empty($str_group))
        {
            $str_where_sql .= ' group by ' . $str_group;
        }
        //排序
        if(!empty($str_order))
        {
            $str_where_sql .= ' order by ' . $str_order;
        }
        //联合查询
        if(!empty($str_join))
        {
            $this->str_base_table = $str_join;
        }
        return $this->make_query_sql($str_where_sql,$this->str_base_table,$str_field);
    }

    /**
     * 查询商户详情
     * @param array $arr_query_params array(
            'cms_id'            => '主键ID',
            'cms_user_id'       => '用户ID',
            'cms_name'          => '商户名称',
            'cms_status'        => '商户状态，默认1。0:禁用；1启用',
            'cms_uuid'          => '外部标识',
     * )
     * @param string $str_field     查询字段
     * @param string $str_join      联合查询（需要在外层拼装完成，这里只负责透传）
     * @param string $str_group     分组
     * @param string $str_order     排序
     * @return array array('ret' => 0/1,'reason' => '描述信息','data_info' => array())
     */
    public function get_one($arr_query_params = array(), $str_field = "*", $str_join = "", $str_group = '',$str_order = '')
    {
        //标准化入参
        $this->_init_logic($arr_query_params);
        //组装过滤条件
        $str_where_sql = '1=1';
        $this->_batch_comm_query_where($arr_query_params,array(),'=',$str_where_sql);
        //分组
        if(!empty($str_group))
        {
            $str_where_sql .= ' group by ' . $str_group;
        }
        //排序
        if(!empty($str_order))
        {
            $str_where_sql .= ' order by ' . $str_order;
        }
        //联合查询
        if(!empty($str_join))
        {
            $this->str_base_table = $str_join;
        }
        return $this->make_query_only_sql($str_where_sql,$this->str_base_table,$str_field);
    }

    /**
     * 添加商户
     * @param array$arr_add_params array(
            'cms_id'            => '主键ID',
            'cms_user_id'       => '用户ID',
            'cms_name'          => '商户名称',
            'cms_secret'        => '商户密钥
            'cms_status'        => '商户状态，默认1。0:禁用；1启用',
            'cms_phone'         => '联系电话',
            'cms_contact        => '联系人',
            'cms_email          => '邮箱',
            'cms_desc           => '商户描述',
            'cms_uuid'          => '外部标识',
     * )
     * @return array array('ret' => 0/1,'reason' => '描述信息','data_info' => array('cms_id' => '唯一标识','cms_uuid' => '外部标识'))
     */
    public function add($arr_add_params)
    {
        //缺省参数
        if(!isset($arr_add_params['cms_uuid']) || empty($arr_add_params['cms_uuid']))
        {
            $arr_add_params['cms_uuid'] = system_guid_rand();
        }
        //创建/修改时间
        if(empty($arr_add_params['cms_create_time']) || empty($arr_add_params['cms_modify_time']))
        {
            $arr_add_params['cms_create_time'] = $arr_add_params['cms_modify_time'] = date('Y-m-d H:i:s');
        }
        //标准化入参
        $this->_init_logic($arr_add_params);
        //添加
        $arr_add_ret = $this->make_insert_sql($this->except_useless_params($arr_add_params, $this->table_define,true),__LINE__);
        if($arr_add_ret['ret'] == 0)
        {
            $arr_add_ret['data_info']['cms_uuid'] = $arr_add_params['cms_uuid'];
        }
        return $arr_add_ret;
    }

    /**
     * 更新商户
     * @param array $arr_ids          主键ID集合
     * @param array $arr_edit_params  更新字段，请参照 $this->table_define
     * @return array array('ret' => 0/1,'reason' => '描述信息')
     */
    public function edit($arr_ids,$arr_edit_params)
    {
        if(isset($arr_edit_params['cms_id']))
        {
            unset($arr_edit_params);
        }
        //标准化入参
        $this->_init_logic($arr_edit_params);
        $str_params_where = 'cms_id in (' . $this->_handle_array_string_params($arr_ids) . ')';
        return $this->make_update_sql($arr_edit_params,$str_params_where);
    }

    /**
     * 删除商户
     * @param array $arr_ids          主键ID集合
     * @return array array('ret' => 0/1,'reason' => '描述信息')
     */
    public function del($arr_ids)
    {
        $str_params_where = 'cms_id in (' . $this->_handle_array_string_params($arr_ids) . ')';
        return $this->make_delete_sql($str_params_where);
    }


} 