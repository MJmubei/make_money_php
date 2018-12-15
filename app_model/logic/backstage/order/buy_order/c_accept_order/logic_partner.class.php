<?php
/**
 * Created by PhpStorm.
 * Use : 接收订单业务类
 * User: kan.yang@starcor.com
 * Date: 18-12-15
 * Time: 下午5:10
 */

class accept_order_logic extends logic_accept_order_base
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
     * 查询接受订单列表
     * @param array $arr_query_params array(
            'cms_id'            => '主键ID',
            'cms_accept_user_id'=> '接收订单用户ID',
            'cms_buy_order_id'  => '购买订单ID',
            'cms_start_time'    => '开始时间',
            'cms_end_time'      => '结束时间',
            'cms_status'        => '接收订单状态，默认0。0处理中；1完成；2终止，未完成',
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
        $this->_batch_comm_query_where($arr_query_params,array('cms_start_time','cms_end_time'),'in',$str_where_sql);
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
     * 查询接收订单详情
     * @param array $arr_query_params array(
            'cms_id'            => '主键ID',
            'cms_accept_user_id'=> '接收订单用户ID',
            'cms_buy_order_id'  => '购买订单ID',
            'cms_status'        => '接收订单状态，默认0。0处理中；1完成；2终止，未完成',
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
     * 添加接收订单
     * @param array$arr_add_params array(
            'cms_id'            => '主键ID',
            'cms_accept_user_id'=> '接收订单用户ID',
            'cms_buy_order_id'  => '购买订单ID',
            'cms_status'        => '接收订单状态，默认0。0处理中；1完成；2终止，未完成',
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
     * 更新接收订单
     * @param array $arr_ids          主键ID集合
     * @param array $arr_edit_params  更新字段，请参照 $this->table_define
     * @return array array('ret' => 0/1,'reason' => '描述信息')
     */
    public function edit($arr_ids,$arr_edit_params)
    {
        //标准化入参
        $this->_init_logic($arr_edit_params);
        $str_params_where = 'cms_id in (' . $this->_handle_array_string_params($arr_ids) . ')';
        return $this->make_update_sql($arr_edit_params,$str_params_where);
    }

    /**
     * 删除接收订单
     * @param array $arr_ids          主键ID集合
     * @return array array('ret' => 0/1,'reason' => '描述信息')
     */
    public function del($arr_ids)
    {
        $str_params_where = 'cms_id in (' . $this->_handle_array_string_params($arr_ids) . ')';
        return $this->make_delete_sql($str_params_where);
    }

    /**
     * 初始化入参
     * 1 统一字段头
     * 2 过滤空入参
     * 3 字段匹配
     */
    private function _init_logic(&$arr_query_params)
    {
        $arr_query_params = $this->make_em_pre($arr_query_params);
        $arr_query_params = $this->_except_empty_data($arr_query_params);
        $arr_query_params = $this->_check_query_params($this->table_define, $arr_query_params);
    }

    /**
     * 批量处理查询条件
     * @param array  $arr_where_items  字段
     * @param array  $arr_filter       排除字段
     * @param string $str_flag         连接字符。=、in、llike、rlike、like
     * @param string $str_where_sql    SQL语句
     */
    private function _batch_comm_query_where($arr_where_items,$arr_filter = array(),$str_flag = '=',&$str_where_sql = '')
    {
        if(empty($str_where_sql))
        {
            $str_where_sql = '1=1';
        }
        foreach($arr_where_items as $k => $v)
        {
            if(in_array($k,$arr_filter)) continue;
            switch($str_flag)
            {
                case 'llike':
                    $str_where_sql .= ' and ' . $k . ' like \'%' . $v . '\'';
                break;
                case 'rlike':
                    $str_where_sql .= ' and ' . $k . ' = \'' . $v . '%\'';
                break;
                case 'like':
                    $str_where_sql .= ' and ' . $k . ' = \'%' . $v . '%\'';
                break;
                case 'in':
                    $this->_handle_array_string_params($v);
                    $str_where_sql .= ' and ' . $k . ' in (' . $v . ')';
                    break;
                case '=':
                default:
                    $str_where_sql .= ' and ' . $k . ' = \'' . $v . '\'';
                break;
            }
        }
    }

    /**
     * 通用数组/字符串
     */
    private function _handle_array_string_params(&$obj_params)
    {
        if(is_string($obj_params))
        {
            $obj_params = explode(',',$obj_params);
        }
        $obj_params = '\'' . implode("','",$obj_params) . '\'';
    }
} 