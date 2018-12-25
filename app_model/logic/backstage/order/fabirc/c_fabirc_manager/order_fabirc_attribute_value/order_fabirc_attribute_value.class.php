<?php
/**
 * Created by IntelliJ IDEA.
 * User: LZ
 * Date: 2018/12/13
 * Time: 10:14
 */
class order_fabirc_attribute_value extends order_fabirc_attribute_value_base
{
    /**
     * LOGIC 添加 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     */
    public function add()
    {
        $insert_params = array(
            'cms_name' => $this->arr_params['cms_name'],
            'cms_value' => $this->arr_params['cms_value'],
            'cms_fabirc_attribute_id' => $this->arr_params['cms_fabirc_attribute_id'],
            'cms_create_time' => date("Y-m-d H:i:s",time()),
            'cms_modify_time' => date("Y-m-d H:i:s",time()),
        );
        return $this->make_insert_sql($this->except_useless_params($insert_params,$this->table_define));
    }

    /**
     * LOGIC 虚拟删除 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     */
    public function del()
    {
        return $this->make_delete_sql($this->except_useless_params($this->arr_params,$this->table_define));
    }

    /**
     * 修改
     * @param $arr_params
     * @return array|multitype|NULL|string
     */
    public function edit()
    {
        $arr_params_set = array(
            'cms_name' => $this->arr_params['cms_name'],
            'cms_value' => $this->arr_params['cms_value'],
            'cms_modify_time' => date('Y-m-d H:i:s',time()),
        );
        $arr_params_where = array(
            'cms_id' => $this->arr_params['cms_id'],
        );
        return $this->make_update_sql($arr_params_set,$arr_params_where);
    }

    /**
     * LOGIC 查询
     * @param $arr_params
     * @return array|multitype|NULL
     */
    public function query()
    {
        $arr_params_where = array();
        if(isset($this->arr_params['cms_fabirc_attribute_id']) && !empty($this->arr_params['cms_fabirc_attribute_id']))
        {
            $arr_params_where['cms_fabirc_attribute_id'] = $this->arr_params['cms_fabirc_attribute_id'];
        }
        if(isset($this->arr_params['cms_name']) && !empty($this->arr_params['cms_name']))
        {
            $arr_params_where['like'] = array('cms_name' => $this->arr_params['cms_name']);
        }
        if(isset($this->arr_params['cms_value']) && !empty($this->arr_params['cms_value']))
        {
            $arr_params_where['like'] = array('cms_value' => $this->arr_params['cms_value']);
        }

        return $this->make_query_sql($arr_params_where);
    }

    /**
     * LOGIC 查询唯一 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     */
    public function query_only()
    {
        return $this->make_query_only_sql($this->except_useless_params($this->arr_params, $this->table_define,true),$this->str_base_table);
    }
}