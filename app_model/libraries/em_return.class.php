<?php

/**
 * 公共return方法
 * @author pan.liang
 *
 */
class em_return
{
    public static $timer_operation = 'timer';
    public static $manual_operation = 'manual';
    public static $last_file_log_path = '';
    public static $arr_model = array(
        'message',
        'sql',
        'debug'
    );
    
    public static $arr_error_level = array(
        'info',
        'notice',
        'error'
    );
    
    public static $str_model = '';
    public static $ci_flow_desc = null;

    /**
     * @param field_type $ci_error_desc            
     */
    public static function set_ci_flow_desc($str_directory=null,$ci_flow_desc = null,$str_model = 'message',$error_level='info')
    {
        if ($ci_flow_desc === null || empty($ci_flow_desc)) 
        {
            return;
        }
        $str_model = strtolower($str_model);
        $error_level = strtolower($error_level);
        self::$ci_flow_desc[][$error_level] = $ci_flow_desc;
        self::write_log_message($str_directory, $ci_flow_desc, $str_model, $error_level);
        return;
    }

    /**
     *
     * @return the $ci_error_desc
     */
    public static function get_ci_error_desc()
    {
        $array_info = null;
        if(!is_array(self::$ci_flow_desc) || empty(self::$ci_flow_desc))
        {
            return $array_info;
        }
        foreach (self::$ci_flow_desc as $key=>$val)
        {
            if(isset($val['error']))
            {
                $array_info['error'][] = $val;
            }
            else if(isset($val['notice']))
            {
                $array_info['notice'][] = $val;
            }
        }
        return $array_info;
    }

    /**
     *
     * @param unknown $var            
     * @param string $is_str            
     */
    public static function ci_var_export($var, $is_str = false)
    {
        $rtn = preg_replace(array(
            '/Array\s+\(/',
            '/\[(\d+)\] => (.*)\n/',
            '/\[([^\d].*)\] => (.*)\n/'
        ), array(
            'array (',
            '\1 => \'\2\'' . "\n",
            '\'\1\' => \'\2\'' . "\n"
        ), substr(print_r($var, true), 0, - 1));
        $rtn = strtr($rtn, array(
            "=> 'array ('" => '=> array ('
        ));
        $rtn = strtr($rtn, array(
            ")\n\n" => ")\n"
        ));
        $rtn = strtr($rtn, array(
            "'\n" => "',\n",
            ")\n" => "),\n"
        ));
        $rtn = preg_replace(array(
            '/\n +/e'
        ), array(
            'strtr(\'\0\', array(\'    \'=>\'  \'))'
        ), $rtn);
        $rtn = strtr($rtn, array(
            " Object'," => " Object'<-"
        ));
        return $rtn;
    }

    /**
     */
    public static function _return_error_data($data=null)
    {
        return self::return_data(1, ($data === null) ? self::get_ci_error_desc() : $data);
    }

    
    /**
     */
    public static function _return_log_data($data=null)
    {
        return self::return_data(1, ($data === null) ? self::$ci_flow_desc : $data);
    }
    /**
     *
     * @param string $reason            
     * @param string $data            
     * @param string $page_data            
     * @param string $other_data            
     */
    public static function _return_right_data($reason = null, $data = null, $page_data = null, $other_data = null)
    {
        return self::return_data(0, $reason, $data, $page_data, $other_data);
    }

    /**
     * 公共返回数据
     *
     * @param number $ret
     *            状态码
     * @param string $reason
     *            原因描述
     * @param array|string $data
     *            返回数据
     * @param array $page_data
     *            分页数据
     * @param array $other_data
     *            其他扩展数据
     * @return array('ret'=>'状态码','reason'=>'原因','data'=>'数据')
     * @author liangpan
     *         @date 2015-09-07
     */
    public static function return_data($ret, $reason = null, $data = null, $page_data = null, $other_data = null)
    {
        return array(
            'ret' => (int) $ret,
            'reason' => $reason,
            'data_info' => $data,
            'page_info' => $page_data,
            'other_info' => $other_data
        );
    }
    
    
    /**
     * 把log日志逻辑处理写入相应的日志文件中
     *
     * @param string $main_model
     *            主处理模块
     * @param string $message
     *            消息log信息 如果是debug模块 则消息为空
     * @param string $sp_id
     *            运营商id 如果为空 则不会创建文件路径
     * @param string $video_type
     *            媒资类型 如果为空 则不会创建文件路径
     * @param string $model
     *            日志模块 默认为message消息模块
     * @return
     *
     * @author liangpan
     *         @date 2015-07-28
     */
    public static function write_log_message($str_directory=null, $message = null, $str_model = 'message', $error_level = 'info')
    {
        $str_model = strtolower($str_model);
        $error_level = strtolower($error_level);
        $str_error_level = in_array($error_level, self::$arr_error_level) ? $error_level : 'error';
        $str_model_info = in_array($str_model, self::$arr_model) ? $str_model : 'message';
        self::$str_model = "[{$str_error_level}] [{$str_model_info}]";
        $relative_log_dir = strtolower(trim(trim((strlen($str_directory) <1) ? 'default_log' : $str_directory, '\\'), '\/')) . '/' . date('Y-m-d').'/'.date('H');
        $file_name = (string)((int)substr(date('i'), 0,1)+1) . '.txt';
        $base_log_dir = dirname(dirname(dirname(__FILE__))) . '/data_model/log/' . $relative_log_dir;
        if (! is_dir($base_log_dir))
        {
            @mkdir($base_log_dir, 0777, true);
        }
        $base_log_file_path = $base_log_dir . '/' . $file_name;
        self::$last_file_log_path = $relative_log_dir . '/' . $file_name;
        ($str_model == 'debug') ? self::get_debug_print_backtrace(2, $message, $base_log_file_path) : self::write_log_message_em(var_export($message,true), $base_log_file_path);
        unset($message);
        unset($base_log_file_path);
        return ;
    }
    
    /**
     * 把php的debug追踪
     *
     * @param string $str
     * @param string $model
     * @return
     *
     * @author liangpan
     *         @date 2015-07-28
     */
    private static function get_debug_print_backtrace($ignore = 2, $message, $file_path)
    {
        $str_backtracel = '';
        $str_backtracel_params = '';
        if (! empty($message))
        {
            $str_meaasge = "调试自定义信息：" . var_export($message, true);
            self::write_log_message_em($str_meaasge, $file_path);
            unset($message);
            unset($str_meaasge);
        }
        foreach (debug_backtrace() as $k => $v)
        {
            if ($k < $ignore)
            {
                continue;
            }
            if ($v['function'] == "include" || $v['function'] == "include_once" || $v['function'] == "require_once" || $v['function'] == "require")
            {
                $str_backtracel = "#" . ($k - $ignore) . " " . $v['function'] . "(" . $v['args'][0] . ") called at [" . $v['file'] . ":" . $v['line'] . "]";
            }
            else
            {
                $str_backtracel = "#" . ($k - $ignore) . " " . $v['function'] . "() called at [" . $v['file'] . ":" . $v['line'] . "]";
            }
            self::write_log_message_em($str_backtracel, $file_path);
            if (empty($v['args']) || ! is_array($v['args'])) {
                continue;
            }
            foreach ($v['args'] as $__k => $__v)
            {
                $str_backtracel_params = "#" . ($k - $ignore) . "__{$__k} 第" . ($__k + 1) . "个参数值是：" . var_export($__v, true);
                self::write_log_message_em($str_backtracel_params, $file_path);
            }
        }
        unset($str_backtracel);
        unset($str_backtracel_params);
        return;
    }
    
    /**
     * 把log日志写入相应的日志文件中
     *
     * @param string $str
     * @param string $model
     * @return
     *
     * @author liangpan
     *         @date 2015-07-28
     */
    private static function write_log_message_em($str, $file_path)
    {
        if (empty($str) || empty($file_path))
        {
            return;
        }
        $msg = '[' . date('H:i:s') . '] ' . self::$str_model . ' ' . $str . "\n";
        @error_log($msg, 3, $file_path);
        unset($str);
        unset($msg);
        return;
    }
}