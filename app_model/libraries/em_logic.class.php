<?php
/**
 * 数据库公共操作类
 * @author pan.liang
 */
class em_logic
{
    public $str_where = "where";
    public $str_base_table = null;
    public $obj_controller = null;
    public $arr_params = null;
    
    
    
    public function __construct($obj_controller,$table_name,$arr_params=null)
    {
        $this->str_base_table = $table_name;
        $this->obj_controller = $obj_controller;
        $this->arr_params = $arr_params;
        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"begin---{{{公共-数据库公共操作类开始;加载文件:[".__FILE__."]}}}---begin",'message','info');
    }
    
    /**
     * @param string $str_where
     */
    public function init_where($str_where='where')
    {
        $this->str_where=$str_where;
    }
    
    /**
     * 排除非法参数
     * @param array $in_params 需要检查的参数
     * @param array $define_params 标准数据库参照参数
     * @param bool $flag false 不检查参数值  | true 检查参数值
     * @return multitype:|multitype:unknown
     * @author liangpan
     * @date 2015-09-07
     */
    public function except_useless_params($in_params,$define_params,$flag=false)
    {
        $arr_in_params=array();
        if((empty($in_params) && !is_array($in_params)))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:数据内库排除非法参数的时候输入数据为非数组参数为:".var_export($in_params,true),'sql','notice');
            return $arr_in_params;
        }
        if((empty($define_params) && !is_array($define_params)))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:数据内库排除非法参数的时候规则数据为非数组参数为:".var_export($define_params,true),'sql','notice');
            return $arr_in_params;
        }
        if(!isset($in_params[0]) || !is_array($in_params[0]) || empty($in_params[0]))
        {
            $result = $this->_except_useless_params($this->make_em_pre($in_params),$define_params);
            if(empty($result) || !is_array($result))
            {
                return $arr_in_params;
            }
            return $flag ? $this->_check_params($result, $define_params) ? $result : $arr_in_params : $result;
        }

        foreach ($in_params as $key=>$val)
        {
            $result = $this->_except_useless_params($this->make_em_pre($val),$define_params);
            $result = $flag ? $this->_check_params($result, $define_params) ? $result : array() : $result;
            if(empty($result) || !is_array($result))
            {
                continue;
            }
            $arr_in_params[] = $result;
        }
        return $arr_in_params;
    }
    
    /**
     * 排除不需要的参数
     * @param unknown $in_params
     * @param unknown $define_params
     */
    public function _except_useless_params($in_params,$define_params)
    {
        $arr_in_params=array();
        if(empty($in_params) || !is_array($in_params))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:参数传入就为空:[".var_export($in_params,true)."]",'sql','notice');
            return $arr_in_params;
        }
        $temp_params_name = array_keys($define_params);
        foreach ($in_params as $key=>$val)
        {
            (in_array($key, $temp_params_name)) ? $arr_in_params[$key]=$val : em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:传入参数key:[{$key}];val:[{$val}]排除了",'sql','notice');
        }
        unset($define_params);
        unset($in_params);
        if(empty($arr_in_params) || !is_array($arr_in_params))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:参数传入输出结果为空:[".var_export($arr_in_params,true)."]",'sql','notice');
        }
        return $arr_in_params;
    }
    
    /**
     * 参数验证（初步）
     * @param unknown $in_params
     * @param unknown $define_params
     */
    public function _check_params($in_params,$define_params)
    {
        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:数据库基本表:[{$this->str_base_table}]字段验证开始",'sql','info');
        $flag=true;
        foreach ($define_params as $key=>$val)
        {
            if($key == 'cms_id')
            {
                continue;
            }
            $in_params[$key] = isset($in_params[$key]) ? $in_params[$key] : '';
            $val['type'] = strtolower($val['type']);
            $val['isempty'] = strtolower($val['isempty']);
            $val['length'] = trim(trim($val['length'],'-'));
            if (in_array($val['type'], array('int','tinyint','smallint','mediumint','bigint')))
            {
                if(!is_numeric($in_params[$key]))
                {
                    em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:字段[{$key}]为空:[{$in_params[$key]}];字段类型为:[{$val['type']}]不能为空;值为[{$in_params[$key]}]非数字",'sql','error');
                    $flag = false;
                    continue;
                }
                $in_params[$key] = (int)$in_params[$key];
                if($val['isempty'] == 'n' && strlen($in_params[$key]) <1)
                {
                    em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:字段[{$key}]为空:[{$in_params[$key]}];字段类型为:[{$val['type']}]不能为空;值为[{$in_params[$key]}]",'sql','error');
                    $flag = false;
                    continue;
                }
                $str_length = strlen($in_params[$key]);
                if(isset($val['length']) && strlen($val['length']) >0 && $str_length >0)
                {
                    if (strpos($val['length'], '-') === FALSE)
                    {
                        $arr_length = explode('-', $val['length']);
                        $pre_length = isset($arr_length[0]) ? (int)$arr_length[0] : 0;
                        $next_length = isset($arr_length[1]) ? (int)$arr_length[1] : 0;
                        if($pre_length > $next_length)
                        {
                            $pre_length=$pre_length^$next_length;
                            $next_length=$next_length^$pre_length;
                            $pre_length=$pre_length^$next_length;
                        }
                        if($in_params[$key] > $next_length || $in_params[$key] < $pre_length)
                        {
                            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:字段[{$key}]错误:[{$in_params[$key]}];字段类型为:[{$val['type']}]不能为空;值为[{$in_params[$key]}]应该在[{$pre_length}]与[{$next_length}]之间",'sql','notice');
                        }
                    }
                    else
                    {
                        $val['length'] = (int)$val['length'];
                        if($in_params[$key] > $val['length'])
                        {
                            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:字段[{$key}]错误:[{$in_params[$key]}];字段类型为:[{$val['type']}]不能为空;值为[{$in_params[$key]}]应该小于等于[{$val['length']}]",'sql','notice');
                        }
                    }
                }
            }
            else if (in_array($val['type'], array('varchar','char','text','tinytext','tinyblob','blob','mediumblob','mediumbtext','longblob','longtext')))
            {
                $in_params[$key] = (string)$in_params[$key];
                if($val['isempty'] == 'n' && strlen($in_params[$key]) <1)
                {
                    em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:字段[{$key}]为空:[{$in_params[$key]}];字段类型为:[{$val['type']}]不能为空;值为[{$in_params[$key]}]",'sql','notice');
                    continue;
                }
                $str_length = strlen($in_params[$key]);
                if(isset($val['length']) && strlen($val['length']) >0 && $str_length >0)
                {
                    if (strpos($val['length'], '-') === FALSE)
                    {
                        $arr_length = explode('-', $val['length']);
                        $pre_length = isset($arr_length[0]) ? (int)$arr_length[0] : 0;
                        $next_length = isset($arr_length[1]) ? (int)$arr_length[1] : 0;
                        if($pre_length > $next_length)
                        {
                            $pre_length=$pre_length^$next_length;
                            $next_length=$next_length^$pre_length;
                            $pre_length=$pre_length^$next_length;
                        }
                        if($str_length > $next_length || $str_length < $pre_length)
                        {
                            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:字段[{$key}]错误:[{$in_params[$key]}];字段类型为:[{$val['type']}]不能为空;值为[{$in_params[$key]}]长度:[{$str_length}]应该在[{$pre_length}]与[{$next_length}]之间",'sql','notice');
                        }
                    }
                    else
                    {
                        $val['length'] = (int)$val['length'];
                        if($str_length > $val['length'])
                        {
                            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:字段[{$key}]错误:[{$in_params[$key]}];字段类型为:[{$val['type']}]不能为空;值为[{$in_params[$key]}]长度:[{$str_length}]应该小于等于[{$val['length']}]",'sql','notice');
                        }
                    }
                }
            }
            else if(in_array($val['type'], array('date','datetime','time','year')))
            {
                $arr_preg = em_preg::preg_date_time($in_params[$key],$val['type']);
                if(strlen($in_params[$key]) <1 || empty($arr_preg) || !is_array($arr_preg))
                {
                    em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:字段[{$key}]为空:[{$in_params[$key]}];字段类型为:[{$val['type']}]值错误;值为[{$in_params[$key]}]时间参数必须不能为空",'sql','error');
                    $flag = false;
                    continue;
                }
            }
        }
        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:数据库基本表:[{$this->str_base_table}]字段验证结束",'sql','info');
        return $flag;
    }
    
    /**
     * 添加数据库参数前缀
     * @param string $params
     * @return NULL|multitype:unknown
     * @author liangpan
     * @date 2016-09-24
     */
    public function make_em_pre($params=null)
    {
        $return_params = array();
        if(!is_array($params) || empty($params))
        {
            return $return_params;
        }
        if(!isset($params[0]) || !is_array($params[0]) || empty($params[0]))
        {
            foreach ($params as $key=>$val)
            {
                if (strpos($key, 'cms_') === FALSE)
                {
                    $key = 'cms_' . $key;
                }
                $return_params[$key] = $val;
            }
            unset($params);
            return $return_params;
        }
        foreach ($params as $val)
        {
            $temp_data = array();
            foreach ($val as $_k=>$_v)
            {
                if (strpos($_k, 'cms_') === FALSE)
                {
                    $_k = 'cms_' . $_k;
                }
                $temp_data[$_k] = $_v;
            }
            $return_params[]=$temp_data;
        }
        unset($params);
        return $return_params;
    }
    
    /**
     * 组装 insert sql语句
     * @param string $table 表
     * @param array $params 数据
     * @return string
     * @author liangpan
     * @date 2015-09-07
     */
    public function make_insert_sql($params)
    {
        if(empty($params) || !is_array($params))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql添加参数为空[".var_export($params,true)."]直接不执行sql语句",'sql','error');
            return em_return::_return_error_data('插入数据为空数组不执行'.var_export($params));
        }
        if(!isset($params[0]) || !is_array($params[0]) || empty($params[0]))
        {
            $result = $this->obj_controller->db->insert($this->str_base_table,$params);
        }
        else
        {
            $result = $this->obj_controller->db->insert_batch($this->str_base_table,$params);
        }
        $sql = $this->obj_controller->db->last_query();
        if(!$result)
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql添加执行失败:[{$sql}]",'sql','error');
            return em_return::_return_error_data('insert sql error:'.$sql);
        }
        return em_return::_return_right_data('ok',array('em_id'=>$this->obj_controller->db->insert_id(),'affected_rows'=>$this->obj_controller->db->affected_rows()));
    }
    
    public function _make_query_sql($sql)
    {
        if(empty($sql))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql为空[{$sql}]直接不执行sql语句",'sql','error');
        }
        $obj_query = $this->obj_controller->db->query($sql);
        return em_return::_return_right_data('ok',$obj_query->result_array());
    }
    
    /**
     * 组装 insert sql语句
     * @param string $table 表
     * @param array $params 数据
     * @return string
     * @author liangpan
     * @date 2015-09-07
     */
    public function make_replace_sql($params)
    {
        $str_value = $str_key='';
        if(empty($params) || !is_array($params))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql添加参数为空[".var_export($params,true)."]直接不执行sql语句",'sql','error');
            return false;
        }
        if(!isset($params[0]) || !is_array($params[0]) || empty($params[0]))
        {
            foreach ($params as $key=>$val)
            {
                if(strlen($val) <1)
                {
                    $val='';
                }
                $str_key.="{$key},";
                $str_value.="'{$val}',";
            }
        }
        else
        {
            foreach ($params as $key=>$val)
            {
                $str_value_in = '';
                foreach ($val as $_k=>$_v)
                {
                    if($key == 0)
                    {
                        $str_key.="{$_k},";
                    }
                    $str_value_in.="'{$_v}',";
                }
                $str_value_in = rtrim($str_value_in,',');
                $str_value.= "({$str_value_in}),";
            }
            $str_value = rtrim($str_value,',');
            $str_value = ltrim(rtrim($str_value,')'),'(');
        }
        $str_key = rtrim($str_key,',');
        $str_value = rtrim($str_value,',');
        $sql = "replace into {$this->str_base_table} ({$str_key}) values ($str_value) ";
        if(!$this->obj_controller->db->query($sql))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql添加执行失败:[{$sql}]",'sql','error');
            return em_return::_return_error_data('insert sql error:'.$sql);
        }
        return em_return::_return_right_data('ok',array('em_id'=>$this->obj_controller->db->insert_id(),'affected_rows'=>$this->obj_controller->db->affected_rows()));
    }
    
    
    /**
     * 组装 update sql语句
     * @param string $table 表
     * @param array $params 数据
     * @return string
     * @author liangpan
     * @date 2015-09-07
     */
    public function make_edit_sql($params, $where=null,$other_params=null)
    {
        $set_str = '';
        if (is_string($params))
        {
            $set_str .= $params;
        }
        else if (is_array($params))
        {
            foreach ($params as $k => $v)
            {
                $set_str .= "$k='$v',";
            }
        }
        if (is_string($other_params) && !empty($other_params))
        {
            $set_str .= $other_params.',';
        }
        else if (is_array($other_params))
        {
            foreach ($other_params as $v)
            {
                $set_str .= "$v,";
            }
        }
        $set_str = rtrim($set_str, ',');
        $wh = array ();
        if (is_array($where))
        {
            foreach ($where as $k => $v)
            {
                if(is_string($v) || is_int($v))
                {
                    $wh[] = "$k='$v'";
                }
                else if(is_array($v))
                {
                    if(!empty($v))
                    {
                        $wh[] = "$k in ('" . implode("','", $v) . "') ";
                    }
                }
            }
            !empty($wh) && $where = implode(' and ', $wh);
        }
        if (is_string($where) && $where)
        {
            $where = "where $where";
        }
        $sql = "update {$this->str_base_table} set $set_str  $where";
        return $sql;
    }
    
    public function make_rel_del_sql($params,$limit)
    {
    
    }
    
    public function _except_empty_data($array)
    {
        $last_data = null;
        if(!is_array($array) || empty($array))
        {
            return $last_data;
        }
        foreach ($array as $key=>$value)
        {
            if(is_string($value) || is_int($value))
            {
                if(strlen($value) <1)
                {
                    continue;
                }
                $last_data[$key] = $value;
            }
            elseif (is_array($value) && !empty($value))
            {
                $temp_value = $this->_except_empty_data($value);
                if(empty($temp_value) || !is_array($temp_value))
                {
                    continue;
                }
                $last_data[$key] = $temp_value;
            }
        }
        return $last_data;
    }
    
    public function make_query_sql($params,$table='')
    {
        if(isset($table) && strlen($table) >0)
        {
            $this->str_base_table = $table;
        }
        $wh = array ();
        $where = null;
        if (is_array($params))
        {
            foreach ($params as $k => $v)
            {
                if(is_string($v) || is_int($v))
                {
                    $wh[] = "$k='$v'";
                }
                else if(is_array($v))
                {
                    if(!empty($v))
                    {
                        $wh[] = "$k in ('" . implode("','", $v) . "') ";
                    }
                }
            }
            !empty($wh) && $where = implode(' and ', $wh);
        }
        else if(is_string($params) && strlen($params) >0)
        {
            $where = $params;
        }
        if (is_string($where) && $where)
        {
            $where = "where $where";
        }
        $mix_limit = $this->make_page_limit();
        if(strlen($mix_limit['sql'])>0 && strpos($mix_limit['sql'], ',') !== FALSE)
        {
            $sql_count = "select count(*) as count from {$this->str_base_table} $where ";
            $data_count = $this->_make_query_sql($sql_count);
            if($data_count['ret'] !=0)
            {
                return $data_count;
            }
            $mix_limit['cms_data_count'] = isset($data_count['data_info'][0]['count']) ? $data_count['data_info'][0]['count'] : 0;
        }
        $sql = "select * from {$this->str_base_table} $where ".$mix_limit['sql'];
        unset($mix_limit['sql']);
        $data =  $this->_make_query_sql($sql);
        if($data['ret'] !=0)
        {
            return $data_count;
        }
        return em_return::_return_right_data('ok',isset($data['data_info']) ? $data['data_info'] : null,$mix_limit);
    }

    /**
     * 查询一条数据
     * @param $params
     * @param string $table
     * @return array
     */
    public function make_query_only_sql($params, $table='')
    {
        if(isset($table) && strlen($table) >0)
        {
            $this->str_base_table = $table;
        }
        $wh = array ();
        $where = null;
        if (is_array($params))
        {
            foreach ($params as $k => $v)
            {
                if(is_string($v) || is_int($v))
                {
                    $wh[] = "$k='$v'";
                }
                else if(is_array($v))
                {
                    if(!empty($v))
                    {
                        $wh[] = "$k in ('" . implode("','", $v) . "') ";
                    }
                }
            }
            !empty($wh) && $where = implode(' and ', $wh);
        }
        else if(is_string($params) && strlen($params) >0)
        {
            $where = $params;
        }
        if (is_string($where) && $where)
        {
            $where = "where $where";
        }
        $limit = " limit 1";

        $sql = "select * from {$this->str_base_table} $where ".$limit;

        $data =  $this->_make_query_sql($sql);
        if($data['ret'] !=0)
        {
            return em_return::_return_error_data($data);
        }
        return em_return::_return_right_data('ok',isset($data['data_info'][0]) ? $data['data_info'][0] : null);
    }
    
    /**
     * 分页信息组装
     * @param array $page_info 分页信息
     * @return string
     * @author liangpan
     * @date 2015-09-07
     */
    public function make_page_limit()
    {
        $str_limit = '';
        $cms_page_num = isset($this->obj_controller->arr_page_params['cms_page_num']) ? (int)$this->obj_controller->arr_page_params['cms_page_num'] : 0;
        $cms_page_size = isset($this->obj_controller->arr_page_params['cms_page_size']) ? (int)$this->obj_controller->arr_page_params['cms_page_size'] : 0;
        if($cms_page_num >0 && $cms_page_size>0)
        {
            $int_start = ($cms_page_num - 1) * $cms_page_size;
            $str_limit = " limit {$int_start} , {$cms_page_size} ";
        }
        else if($cms_page_num >0)
        {
            $str_limit = " limit {$cms_page_num}";
        }
        else if($cms_page_size >0)
        {
            $str_limit = " limit {$cms_page_size}";
        }
        return array(
            'sql'=>$str_limit,
            'cms_page_num'=>$cms_page_num,
            'cms_page_size'=>$cms_page_size,
            'cms_data_count'=>0,
        );
    }
    
    /**
     * 排序组装
     * @param string $order_info
     * @return string
     * @author liangpan
     * @date 2015-09-07
     */
    public function make_order($order_info=null)
    {
        $str_order='';
        if(empty($order_info))
        {
            return $str_order;
        }
        $str_order = "order by";
        if(is_array($order_info))
        {
            foreach ($order_info as $order_val)
            {
                $str_order.=" {$order_val},";
            }
        }
        else if(is_string($order_info))
        {
            $str_order.=" {$order_info},";
        }
        else
        {
            return '';
        }
        $str_order = trim($order_info,',');
        if(strlen($str_order) > 8)
        {
            return $str_order;
        }
        return '';
    }
    /**
     * 分组组装
     * @param string $group_info
     * @return string
     * @author liangpan
     * @date 2015-09-07
     */
    public function make_group($group_info=null)
    {
        $str_group='';
        if(empty($group_info))
        {
            return $str_group;
        }
        $str_group = "group by";
        if(is_array($group_info))
        {
            foreach ($group_info as $group_val)
            {
                $str_group.=" {$group_val},";
            }
        }
        else if(is_string($group_info))
        {
            $str_group.=" {$group_info},";
        }
        else
        {
            return '';
        }
        $str_group = trim($str_group,',');
        if(strlen($str_group) > 8)
        {
            return $str_group;
        }
        return '';
    }
    
    public function __destruct()
    {
        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"begin---{{{公共-数据库公共操作类结束}}}---begin",'message','info');
        unset($this->str_base_table);
        unset($this->obj_controller);
    }
}