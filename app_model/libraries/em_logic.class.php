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
    public $arr_notice_params = null;
    
    
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
     * 判断是否是json
     * @param unknown $string
     * @return boolean
     */
    public function is_json($string)
    {
        if(!is_string($string))
        {
            return false;
        }
        $string = strlen($string) <1 ? '' : trim($string);
        if(strlen($string) <1)
        {
            return false;
        }
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    /**
     * 判断是否是xml
     * @param unknown $string
     * @return boolean
     */
    public function is_xml($string)
    {
        if(!is_string($string))
        {
            return false;
        }
        $string = strlen($string) < 1 ? '' : trim($string);
        if(strlen($string) <1)
        {
            return false;
        }
        $xml_parser = xml_parser_create();
        if (! xml_parse($xml_parser, $string, true))
        {
            xml_parser_free($xml_parser);
            return false;
        }
        return true;
    }
    
    
    /**
     * 添加的时候检查注入参数
     * @param array $data_model 数据模板参数
     * @param array $in_params 需要检查的注入参数
     * @return array('ret'=>'状态码','reason'=>'原因')
     * @author liangpan
     * @date 2016-03-12
     */
    public function _check_insert_params($data_model,$in_params)
    {
        if (!is_array($data_model) || empty($data_model))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:数据库基本表:[{$this->str_base_table}]字段验证结束",'sql','info');
            return em_return::return_data(1, '参数模板检查,参数非数组或者数组为空');
        }
        $last_params = null;
        $this->arr_notice_params['info']['in'] = $in_params;
        //去掉索引信息
        if(isset($data_model['index_info']))
        {
            unset($data_model['index_info']);
        }
        foreach ($data_model as $key => $val)
        {
            foreach ($val as $_params_key=>$_params)
            {
                $temp_in_params_data='';
                //如果设置了 去设置的值，如果未设置，默认为‘’
                if(isset($in_params[$_params_key]))
                {
                    if(!is_string($in_params[$_params_key]) && !is_int($in_params[$_params_key]) && !is_float($in_params[$_params_key]) && 
                        !is_array($in_params[$_params_key]))
                    {
                        $this->arr_notice_params['error'][$_params_key] = "注入的参数非字符串[".var_export($in_params[$_params_key],true)."]";
                        continue;
                    }
                    if(is_array($in_params[$_params_key]))
                    {
                        $in_params[$_params_key] = json_encode($in_params[$_params_key],JSON_UNESCAPED_UNICODE);
                    }
                    $temp_in_params_data = trim($in_params[$_params_key]);
                    unset($in_params[$_params_key]);
                }
                //值长度< 取默认值
                if(strlen($temp_in_params_data) <1)
                {
                    $temp_in_params_data = $_params['default'];
                    $this->arr_notice_params['notice'][$key][$_params_key] = "[默认值为:{$temp_in_params_data},设置为系统默认值]";
                }
                //如果设置有rule规则，
                if(!empty($_params['rule']))
                {
                    $flag = true;
                    $arr_rule = explode('|', $_params['rule']);
                    $arr_rule = array_filter($arr_rule);
                    if(is_array($arr_rule) && !empty($arr_rule) && strlen($_params['default']) >0 && in_array($_params['default'], $arr_rule))
                    {
                        switch ($_params['default'])
                        {
                            case "year":
                                $temp_in_params_data = date("Y");
                                break;
                            case "date":
                                $temp_in_params_data = date("Y-m-d");
                                break;
                            case "time":
                                $temp_in_params_data = date("H:i:s");
                                break;
                            case "datetime":
                                $temp_in_params_data = date("Y-m-d H:i:s");
                                break;
                            case "UUID":
                                $temp_in_params_data = em_guid::em_guid_rand($_params_key);
                                break;
                            case 'auto_increment':
                                $flag = false;
                                break;
                        }
                    }
                    if(!$flag)
                    {
                        $this->arr_notice_params['notice'][$key][$_params_key] = "[字段为自增长去除这个数组参数[{$key}][{$_params_key}]:{$temp_in_params_data}]";
                        continue;
                    }
                    $result_rule = $this->check_rule($_params['rule'], $temp_in_params_data, $_params_key, $key, $_params);
                    $temp_in_params_data = $result_rule['data_info'];
                }
                //如果设置有legth规则，
                if(strlen($_params['length']) >0)
                {
                    $result_length = $this->check_length($_params['length'], $temp_in_params_data, $_params_key, $key, $_params);
                    $temp_in_params_data = $result_length['data_info'];
                }
                if(isset($last_params[$_params_key]))
                {
                    $this->arr_notice_params['error'][$key][$_params_key] = "[基本字段存在重复请检查[{$key}][{$_params_key}]:{$temp_in_params_data}]";
                    continue;
                }
                $last_params[$_params_key] = $temp_in_params_data;
            }
        }
        if((is_array($in_params) && !empty($in_params)))
        {
            $this->arr_notice_params['notice']['leftout'] = $in_params;
        }
        $last_params = $this->mix_htmlspecialchars($last_params);
        $this->arr_notice_params['info']['out'] = $last_params;
        $temp_arr_notice_params = $this->arr_notice_params;
        $this->arr_notice_params = null;
        if (isset($temp_arr_notice_params['error']) && !empty($temp_arr_notice_params['error']))
        {
            return em_return::return_data(1, '参数传入错误', $temp_arr_notice_params);
        }
        if (!is_array($last_params) || empty($last_params))
        {
            return em_return::return_data(1, '参数检查反馈出的数据为非数组',$temp_arr_notice_params);
        }
        return em_return::return_data(0, '组装 OK', $temp_arr_notice_params);
    }
    
    
    
    /**
     * 添加的时候检查注入参数
     * @param array $data_model 数据模板参数
     * @param array $in_params 需要检查的注入参数
     * @return array('ret'=>'状态码','reason'=>'原因')
     * @author liangpan
     * @date 2016-03-12
     */
    public function _check_edit_del_params($data_model,$in_params)
    {
        if(!is_array($in_params) || empty($in_params))
        {
            return em_return::return_data(0, '参数传入的数据为非数组');
        }
        $this->arr_notice_params['info']['in'] = $in_params;
        //去掉索引信息
        if(isset($data_model['index_info']))
        {
            unset($data_model['index_info']);
        }
        $arr_fileds = $last_params = $temp_data_model = null;
        foreach ($data_model as $key=>$value)
        {
            if(!is_array($value) || empty($value))
            {
                continue;
            }
            foreach ($value as $_k=>$_v)
            {
                $arr_fileds[] = $_k;
                $_v['first_filed'] = $key;
                $temp_data_model[$_k] = $_v;
            }
        }
        if (!is_array($temp_data_model) || empty($temp_data_model))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:数据库基本表:[{$this->str_base_table}]字段验证结束",'sql','info');
            return em_return::return_data(1, '参数模板检查,参数非数组或者数组为空');
        }
        foreach ($in_params as $_key=>$_value)
        {
            $temp_in_params_data = $_value;
            if(!in_array($_key, $arr_fileds))
            {
                continue;
            }
            if(isset($temp_data_model[$_key]['rule']) && strlen($temp_data_model[$_key]['rule']))
            {
                $result_rule = $this->check_rule($temp_data_model[$_key]['rule'], $temp_in_params_data, $_key, $temp_data_model[$_key]['first_filed'], $temp_data_model[$_key]);
                $temp_in_params_data = $result_rule['data_info'];
            }
            //如果设置有legth规则，
            if(strlen($temp_data_model[$_key]['length']) >0)
            {
                $result_length = $this->check_length($temp_data_model[$_key]['length'], $temp_in_params_data, $_key, $temp_data_model[$_key]['first_filed'], $temp_data_model[$_key]);
                $temp_in_params_data = $result_length['data_info'];
            }
            $last_params[$_key] = $temp_in_params_data;
        }
        if((is_array($in_params) && !empty($in_params)))
        {
            $this->arr_notice_params['notice']['leftout'] = $in_params;
        }
        $last_params = $this->mix_htmlspecialchars($last_params);
        $this->arr_notice_params['info']['out'] = $last_params;
        $temp_arr_notice_params = $this->arr_notice_params;
        $this->arr_notice_params = null;
        if (isset($temp_arr_notice_params['error']) && !empty($temp_arr_notice_params['error']))
        {
            return em_return::return_data(1, '参数传入错误', $temp_arr_notice_params);
        }
        if (!is_array($last_params) || empty($last_params))
        {
            return em_return::return_data(1, '参数检查反馈出的数据为非数组',$temp_arr_notice_params);
        }
        return em_return::return_data(0, '组装xml OK', $temp_arr_notice_params);
    }
    
    
    /**
     * 添加的时候检查注入参数
     * @param array $data_model 数据模板参数
     * @param array $in_params 需要检查的注入参数
     * @return array('ret'=>'状态码','reason'=>'原因')
     * @author liangpan
     * @date 2016-03-12
     */
    public function _check_query_params($data_model,$in_params)
    {
        if(!is_array($in_params) || empty($in_params))
        {
            return em_return::return_data(0, '参数传入的数据为非数组');
        }
        $this->arr_notice_params['info']['in'] = $in_params;
        //去掉索引信息
        if(isset($data_model['index_info']))
        {
            unset($data_model['index_info']);
        }
        $arr_fileds = $last_params = $temp_data_model = null;
        foreach ($data_model as $key=>$value)
        {
            if(!is_array($value) || empty($value))
            {
                continue;
            }
            foreach ($value as $_k=>$_v)
            {
                $arr_fileds[] = $_k;
                $_v['first_filed'] = $key;
                $temp_data_model[$_k] = $_v;
            }
        }
        if (!is_array($temp_data_model) || empty($temp_data_model))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:数据库基本表:[{$this->str_base_table}]字段验证结束",'sql','info');
            return em_return::return_data(1, '参数模板检查,参数非数组或者数组为空');
        }
        foreach ($in_params as $_key=>$_value)
        {
            $temp_in_params_data = $_value;
            if(!in_array($_key, $arr_fileds))
            {
                continue;
            }
            $last_params[$_key] = $temp_in_params_data;
        }
        if((is_array($in_params) && !empty($in_params)))
        {
            $this->arr_notice_params['notice']['leftout'] = $in_params;
        }
        $last_params = $this->mix_htmlspecialchars($last_params);
        $this->arr_notice_params['info']['out'] = $last_params;
        $temp_arr_notice_params = $this->arr_notice_params;
        $this->arr_notice_params = null;
        if (isset($temp_arr_notice_params['error']) && !empty($temp_arr_notice_params['error']))
        {
            return em_return::return_data(1, '参数传入错误', $temp_arr_notice_params);
        }
        if (!is_array($last_params) || empty($last_params))
        {
            return em_return::return_data(1, '参数检查反馈出的数据为非数组',$temp_arr_notice_params);
        }
        return em_return::return_data(0, '组装xml OK', $temp_arr_notice_params);
    }
    
    /**
     * 底层实现sql添加bug
     * @param unknown $last_params
     * @return string
     */
    public function mix_htmlspecialchars($last_params)
    {
        $str_pregs = "/\'|\/\*|\#|\"|\--|\ --|\/|\*|\-|\+|\=|\~|\*@|\*!|\$|\%|\^|\&/";
        if(is_array($last_params))
        {
            foreach ($last_params as $key=>$value)
            {
                if(is_array($value))
                {
                    $last_params[$key] = $this->mix_htmlspecialchars($value);
                    continue;
                }
                else if(is_string($value) && preg_match($str_pregs, $value))
                {
                    $last_params[$key] = htmlspecialchars($value, ENT_QUOTES);
                }
            }
        }
        else if(is_string($last_params) && preg_match($str_pregs, $last_params))
        {
            $last_params = htmlspecialchars($last_params, ENT_QUOTES);
        }
        return $last_params;
    }
    
    /**
     * 验证字符串长度
     * @param string $str_length 长度验证规则
     * @param string $str_in_param 验证的值
     * @param string $_params_key 字段key
     * @param string $key 初始字段key
     * @param array $_params 数组
     * @return array:number |array('ret'=>'状态码','reason'=>'原因','data'=>'数据')
     */
    public function check_length($str_length,$str_in_param,$_params_key,$key,$_params)
    {
        $str_length =trim($str_length);
        if(strlen($str_length)<1)
        {
            return em_return::return_data(0,'ok',$str_in_param);
        }
        $arr_length = explode('-', $str_length);
        if(!is_array($arr_length) || empty($arr_length))
        {
            return em_return::return_data(0,'ok',$str_in_param);
        }
        $temp_str_legth = mb_strlen($str_in_param);
        $temp_count = count($arr_length);
        if($temp_count == 1)
        {
            if($temp_str_legth != $arr_length[0])
            {
                $this->arr_notice_params['error'][$key][$_params_key] = "[参数长度检查,入参值为:{$str_in_param},描述为:{$_params['desc']},值长度不为{$arr_length[0]},长度为{$temp_str_legth}]";
            }
        }
        else if($temp_count == 2)
        {
            if($temp_str_legth < $arr_length[0] || $temp_str_legth > $arr_length[1])
            {
                $this->arr_notice_params['error'][$key][$_params_key] = "[参数长度检查,入参值为:{$str_in_param},描述为:{$_params['desc']},值长度不在{$arr_length[0]}与{$arr_length[1]}之间，长度为{$temp_str_legth}]";
            }
        }
        unset($_params_key,$key,$_params,$arr_legth,$str_length);
        return em_return::return_data(0,'ok',$str_in_param);
    }
    
    /**
     * 验证字段规则
     * @param string $str_rule 验证规则
     * @param string $str_in_param 验证的值
     * @param string $_params_key 字段key
     * @param string $key 初始字段key
     * @param array $_params 数据数组
     * @return array:number |array('ret'=>'状态码','reason'=>'原因','data'=>'数据')
     */
    public function check_rule($str_rule,$str_in_param,$_params_key,$key,$_params)
    {
        $str_rule =trim($str_rule);
        if(strlen($str_rule)<1)
        {
            return em_return::return_data(0,'ok',$str_in_param);
        }
        $arr_rule = explode('|', $_params['rule']);
        $arr_rule = array_filter($arr_rule);
        if(!is_array($arr_rule) || empty($arr_rule))
        {
            return em_return::return_data(0,'ok',$str_in_param);
        }
        foreach ($arr_rule as $rule_val)
        {
            switch ($rule_val)
            {
                case 'noempty':
                    if (strlen($str_in_param) <1)
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},入参为空,规则:{$rule_val}]";
                    }
                    break;
                case 'noempty':
                    if (strlen($str_in_param) <1)
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},入参为空,规则:{$rule_val}]";
                    }
                    break;
                case 'tinyint':
                    if (is_numeric($str_in_param) && strpos($str_in_param, ".") === false)
                    {
                        if($str_in_param > 255 || $str_in_param < 0)
                        {
                            $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},值不在0-255之间,规则:{$rule_val}]";
                        }
                    }
                    else
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},不为数字类型,规则:{$rule_val}]";
                    }
                    break;
                case 'smallint':
                    if (is_numeric($str_in_param) && strpos($str_in_param, ".") === false)
                    {
                        if($str_in_param > 65535 || $str_in_param < 0)
                        {
                            $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},值不在0-65535之间,规则:{$rule_val}]";
                        }
                    }
                    else
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},不为数字类型,规则:{$rule_val}]";
                    }
                    break;
                case 'mediumint':
                    if (is_numeric($str_in_param) && strpos($str_in_param, ".") === false)
                    {
                        if($str_in_param > 16777215 || $str_in_param < 0)
                        {
                            $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},值不在0-16777215之间,规则:{$rule_val}]";
                        }
                    }
                    else
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},不为数字类型,规则:{$rule_val}]";
                    }
                    break;
                case 'int':
                    if (is_numeric($str_in_param) && strpos($str_in_param, ".") === false)
                    {
                        if($str_in_param > 4294967295 || $str_in_param < 0)
                        {
                            $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},值不在0-4294967295之间,规则:{$rule_val}]";
                        }
                    }
                    else
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},不为数字类型,规则:{$rule_val}]";
                    }
                    break;
                case 'bigint':
                    if (is_numeric($str_in_param) && strpos($str_in_param, ".") === false)
                    {
                        if($str_in_param > 18446744073709551615 || $str_in_param < 0)
                        {
                            $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},值不在0-18446744073709551615之间,规则:{$rule_val}]";
                        }
                    }
                    else
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},不为数字类型,规则:{$rule_val}]";
                    }
                    break;
                case 'year':
                    if (is_numeric($str_in_param) && strpos($str_in_param, ".") === false)
                    {
                        if($str_in_param > 2155 || $str_in_param < 1901)
                        {
                            $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},值不在1901-2155之间,规则:{$rule_val}]";
                        }
                    }
                    else
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},不为数字类型,规则:{$rule_val}]";
                    }
                    break;
                case 'date':
                    $str_in_param = (strlen($str_in_param) > 0) ? trim($str_in_param) : '';
                    if (preg_match ("/\d{4}-1[0-2]|0?[1-9]-0?[1-9]|[12][0-9]|3[01]/", $str_in_param))
                    {
                        $str_in_param = date("Y-m-d", strtotime($str_in_param));
                    }
                    else
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},不匹配日期,规则:{$rule_val}]";
                    }
                    break;
                case 'datetime':
                    $str_in_param = (strlen($str_in_param) > 0) ? trim($str_in_param) : '';
                    if (preg_match ("/\d{4}-1[0-2]|0?[1-9]-0?[1-9]|[12][0-9]|3[01]\s([0-1][0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9])/", $str_in_param))
                    {
                        $str_in_param = date("Y-m-d H:i:s", strtotime($str_in_param));
                    }
                    else if(preg_match ("/0000-00-00 00:00:00/", $str_in_param))
                    {
                        $str_in_param = '0000-00-00 00:00:00';
                    }
                    else
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},不匹配时间,规则:{$rule_val}]";
                    }
                    break;
                case 'time':
                    $str_in_param = (strlen($str_in_param) > 0) ? trim($str_in_param) : '';
                    if (preg_match ("/([0-1][0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9])/", $str_in_param))
                    {
                        $str_in_param = date("H:i:s", strtotime($str_in_param));
                    }
                    else
                    {
                        $this->arr_notice_params['error'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},不匹配时间,规则:{$rule_val}]";
                    }
                    break;
                default:
                    $this->arr_notice_params['notice'][$key][$_params_key] = "[参数规则检查,入参值为:{$str_in_param},描述为:{$_params['desc']},规则未知,规则:{$rule_val}]";
            }
        }
        unset($arr_rule,$_params_key,$key,$_params);
        return em_return::return_data(0,'ok',$str_in_param);
    }

    /**
     * 添加数据库参数前缀
     * @param null $params
     * @return array
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
        return em_return::_return_right_data('ok',array('cms_id'=>$this->obj_controller->db->insert_id(),'affected_rows'=>$this->obj_controller->db->affected_rows(),'data'=>$params));
    }
    
    
    /**
     * 组装 update sql语句 并执行
     * @param string $table 表
     * @param array $params 数据
     * @return string
     * @author liangpan
     * @date 2015-09-07
     */
    public function make_update_sql($params,$where=null)
    {
        if(empty($params) || !is_array($params))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql添加参数为空[".var_export($params,true)."]直接不执行sql语句",'sql','error');
            return em_return::_return_error_data('插入数据为空数组不执行'.var_export($params));
        }
        $sql = $this->_make_update_sql($params,$where);
        if(empty($sql))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql为空[{$sql}]直接不执行sql语句",'sql','error');
            return em_return::_return_error_data('sql empty:'.$sql);
        }
        $obj_query = $this->obj_controller->db->query($sql);
        if(!$obj_query)
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql执行失败:[{$sql}]",'sql','error');
            return em_return::_return_error_data('sql empty:'.$sql);
        }
        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql执行OK:[{$sql}]",'sql','info');
        return em_return::_return_right_data("sql ok[{$sql}]");
    }
    
    
    /**
     * 组装 delete sql语句
     * @param string $table 表
     * @param array $params 数据
     * @return string
     * @author liangpan
     * @date 2015-09-07
     */
    public function make_delete_sql($where,$other_params=null,$limit=null)
    {
        if(empty($where) || !is_array($where))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql删除参数为空[".var_export($where,true)."]直接不执行sql语句",'sql','error');
            return em_return::_return_error_data('插入数据为空数组不执行'.var_export($where));
        }
        $sql = $this->_make_delete_sql($where,$other_params,$limit);
        if(empty($sql))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql为空[{$sql}]直接不执行sql语句",'sql','error');
            return em_return::_return_error_data('sql empty:'.$sql);
        }
        $obj_query = $this->obj_controller->db->query($sql);
        if(!$obj_query)
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql执行失败:[{$sql}]",'sql','error');
            return em_return::_return_error_data('sql empty:'.$sql);
        }
        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql执行OK:[{$sql}]",'sql','info');
        return em_return::_return_right_data("sql ok[{$sql}]");
    }
    
    public function _make_query_sql($sql)
    {
        if(empty($sql))
        {
            em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:sql为空[{$sql}]直接不执行sql语句",'sql','error');
            return em_return::_return_error_data('sql empty:'.$sql);
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
    public function _make_update_sql($params, $where=null,$other_params=null)
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
    
    
    /**
     * 组装 update sql语句
     * @param string $table 表
     * @param array $params 数据
     * @return string
     * @author liangpan
     * @date 2015-09-07
     */
    public function _make_delete_sql($where,$other_params=null,$limit=null)
    {
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
        $sql = "delete from {$this->str_base_table} $where ";
        if($limit !== null && $limit >0)
        {
            $sql.=" limit {$limit} ";
        }
        return $sql;
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
    
    public function make_query_sql($params,$table='',$str_field = '*')
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
                else if($k == 'rlike' && is_array($v) && !empty($v))
                {
                    foreach ($v as $i=>$item)
                    {
                        $wh[] = "$i like '$item%' ";
                    }
                }
                else if($k == 'llike' && is_array($v) && !empty($v))
                {
                    foreach ($v as $i=>$item)
                    {
                        $wh[] = "$i like '%$item' ";
                    }
                }
                else if($k == 'like' && is_array($v) && !empty($v))
                {
                    foreach ($v as $i=>$item)
                    {
                        $wh[] = "$i like '%$item%' ";
                    }
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
        $sql = "select " . $str_field . " from {$this->str_base_table} $where ".$mix_limit['sql'];
//         echo $sql."<br/>";
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
    public function make_query_only_sql($params, $table='',$str_field = '*')
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

        
        $sql = "select " . $str_field . " from {$this->str_base_table} $where ".$limit;

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

    /**
     * 初始化入参
     * 1 统一字段头
     * 2 过滤空入参
     * 3 字段匹配
     */
    protected function _init_logic(&$arr_query_params)
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
    protected function _batch_comm_query_where($arr_where_items,$arr_filter = array(),$str_flag = '=',&$str_where_sql = '')
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
    protected function _handle_array_string_params(&$obj_params)
    {
        if(is_string($obj_params))
        {
            $obj_params = explode(',',$obj_params);
        }
        $obj_params = '\'' . implode("','",$obj_params) . '\'';
    }

}