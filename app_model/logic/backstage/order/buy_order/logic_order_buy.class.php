<?php
/**
 * Created by PhpStorm.
 * Use : 购买订单业务类
 * User: kan.yang@starcor.com
 * Date: 18-12-13
 * Time: 下午7:36
 */

class order_buy_logic extends logic_order_buy_base
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
     * 查询订单列表
     * @param array $arr_query_params array(
            'cms_id'            => '主键ID',
            'cms_user_id'       => '用户ID',
            'cms_start_time'    => '开始时间',
            'cms_end_time'      => '结束时间',
            'cms_order_type'    => '订单类型。0批量订单；1面料小样；2样板订单；3样衣订单；4稀缺面料定金订单',
            'cms_order_state'   => '订单状态。0未支付；1已支付；2已取消；3已过期；4退款中；5已退订；6订单异常',
            'cms_business_state'=> '业务状态。0未完成；1完成',
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
        $this->_batch_comm_query_where($arr_query_params,array('cms_start_time','cms_end_time'),$str_where_sql);
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
     * 查询订单详情
     * @param array $arr_query_params array(
            'cms_id'            => '主键ID',
            'cms_user_id'       => '用户ID',
            'cms_order_type'    => '订单类型。0批量订单；1面料小样；2样板订单；3样衣订单；4稀缺面料定金订单',
            'cms_order_state'   => '订单状态。0未支付；1已支付；2已取消；3已过期；4退款中；5已退订；6订单异常',
            'cms_business_state'=> '业务状态。0未完成；1完成',
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
        $this->_batch_comm_query_where($arr_query_params,array('cms_start_time','cms_end_time'),'=',$str_where_sql);
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
    private function _handle_array_string_params($obj_params)
    {
        if(is_string($obj_params))
        {
            $obj_params = explode(',',$obj_params);
        }
        $obj_params = '\'' . implode("','",$obj_params) . '\'';
    }
} 