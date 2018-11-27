<?php
/**
 * 开发文件搭建类
 * @author pan.liang
 */
class em_model_bulid
{
	public $str_model_line="\r\n";
    public $obj_controller = null;
    public $str_date = null;
    public $str_model_content = '';
    public $arr_logic_action = array(
                'add'=>'添加',
                'del'=>'虚拟删除',
                'rel_del'=>'真实删除',
                'edit'=>'修改',
                'query'=>'查询',
                'query_only'=>'查询唯一',
            );
    
    public function __construct($obj_controller)
    {
        $this->obj_controller = $obj_controller;
        $this->str_date = date("Y-m-d H:i:s");
        $this->str_model_content='';
        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"begin---{{{公共-开发文件搭建类开始;加载文件:[".__FILE__."]}}}---begin",'message','info');
    }
    
	/**
	 * 生产文件
	 * @param string $xml 文件内容
	 * @return boolean
	 * @author liangpan
	 * @date 2016-08-24
	 */
	public function bulid_logic_file($table_name,$array_table_data)
	{
	    $table_name = trim($table_name);
	    $table_name = (substr($table_name, 0,3) == 'em_') ? substr($table_name, 3) : $table_name;
	    if(empty($table_name))
	    {
	        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:表为空不允许创建[{$table_name}]",'message','error');
	        return em_return::_return_error_data();
	    }
	    if(!is_array($array_table_data) || empty($array_table_data))
	    {
	        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:表结构数据为空[".var_export($array_table_data,true)."]",'message','error');
	        return em_return::_return_error_data();
	    }
	    $this->str_model_content.="<?php{$this->str_model_line}";
	    $this->str_model_content.="/**{$this->str_model_line}";
	    $this->str_model_content.=" * LOGIC表{$table_name} 操作类{$this->str_model_line}";
	    $this->str_model_content.=" * @author pan.liang{$this->str_model_line}";
	    $this->str_model_content.=" * @date {$this->str_date}{$this->str_model_line}";
	    $this->str_model_content.=" */{$this->str_model_line}";
	    $this->str_model_content.="class {$table_name} extends em_logic{$this->str_model_line}";
	    $this->str_model_content.="{{$this->str_model_line}";
	    
        $this->str_model_content.="    /**{$this->str_model_line}";
	    $this->str_model_content.="     * 基本表定义参数用于排除非法字段，验证字段{$this->str_model_line}";
	    $this->str_model_content.="     * @var params $"."table_define{$this->str_model_line}";
	    $this->str_model_content.="     * @date {$this->str_date}{$this->str_model_line}";
	    $this->str_model_content.="     */{$this->str_model_line}";
	    $this->str_model_content.="     public $"."table_define = array({$this->str_model_line}";
	    foreach ($array_table_data as $val)
	    {
	        $val['CHARACTER_MAXIMUM_LENGTH'] = (strlen($val['CHARACTER_OCTET_LENGTH']) <1 || $val['EXTRA'] == 'auto_increment') ? '' : $val['CHARACTER_MAXIMUM_LENGTH'];
	        $this->str_model_content.="        '{$val['COLUMN_NAME']}' => array( {$this->str_model_line}";
	        $this->str_model_content.="            'type' => '{$val['DATA_TYPE']}',{$this->str_model_line}";
	        $str_isempty = strtolower(substr($val['IS_NULLABLE'], 0,1));
	        $this->str_model_content.="            'isempty' => '{$str_isempty}',{$this->str_model_line}";
	        $this->str_model_content.="            'length' => '{$val['CHARACTER_MAXIMUM_LENGTH']}',{$this->str_model_line}";
	        $this->str_model_content.="            'desc' => '{$val['COLUMN_COMMENT']}',{$this->str_model_line}";
	        $this->str_model_content.="        ),{$this->str_model_line}";
	    }
	    $this->str_model_content.="     );{$this->str_model_line}";
	    
	    $this->str_model_content.="{$this->str_model_line}";
	    if(is_array($this->arr_logic_action) && !empty($this->arr_logic_action))
	    {
    	    foreach ($this->arr_logic_action as $key=>$val)
    	    {
    	        $this->str_model_content.="    /**{$this->str_model_line}";
    	        $this->str_model_content.="     * LOGIC {$val} 操作{$this->str_model_line}";
    	        $this->str_model_content.="     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息'){$this->str_model_line}";
    	        $this->str_model_content.="     * @author pan.liang{$this->str_model_line}";
    	        $this->str_model_content.="     * @date {$this->str_date}{$this->str_model_line}";
    	        $this->str_model_content.="     */{$this->str_model_line}";
    	        $this->str_model_content.="    public function {$key}("."){$this->str_model_line}";
    	        $this->str_model_content.="    {{$this->str_model_line}";
    	        $key = ($key == 'add') ? 'insert' : $key;
    	        $this->str_model_content.="        return $"."this->make_{$key}_sql($"."this->except_useless_params($"."this->arr_params, $"."this->table_define,true),__LINE__);{$this->str_model_line}";
    	        $this->str_model_content.="    }{$this->str_model_line}";
    	        $this->str_model_content.="{$this->str_model_line}";
    	    }
	    }
	    $this->str_model_content.="}";
	    return em_return::_return_right_data('ok',$this->str_model_content);
	}
	
	/**
	 *
	 */
	public function __destruct()
	{
        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"end---{{{公共-开发文件搭建类结束}}}---end",'message','info');
        unset($this->obj_controller);
	}
}