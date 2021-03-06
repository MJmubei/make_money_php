<?php
/**
 * Created by PhpStorm.
 * User: fingal
 * Date: 2018/12/25
 * Time: 14:02
 */

class order_producer_time extends order_producer_time_base
{
    /**
     * LOGIC 添加 操作
     * @return array array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     * @author pan.liang
     * @date 2016-12-30 13:51:33
     */
    public function add($arr_params)
    {
        $arr_params_insert = $this->make_em_pre(isset($arr_params['insert']) ? $arr_params['insert'] : null);
        $arr_params_insert = $this->_check_insert_params($this->table_define, $arr_params_insert);
        if($arr_params_insert['ret'] !=0)
        {
            return $arr_params_insert;
        }
        $arr_params_insert = (isset($arr_params_insert['data_info']['info']['out']) && is_array($arr_params_insert['data_info']['info']['out']) && !empty($arr_params_insert['data_info']['info']['out'])) ? $arr_params_insert['data_info']['info']['out'] : null;
        return $this->make_insert_sql($arr_params_insert);
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
     * 修改
     * @param $arr_params
     * @return array|multitype|NULL|string
     */
    public function edit($arr_params)
    {
        $arr_params_set = $this->make_em_pre(isset($arr_params['set']) ? $arr_params['set'] : array());
        $arr_params_where = $this->make_em_pre(isset($arr_params['where']) ? $arr_params['where'] : array());
        $arr_params_set = $this->_check_edit_del_params($this->table_define, $arr_params_set);
        $arr_params_where = $this->_check_edit_del_params($this->table_define, $arr_params_where);
        if($arr_params_set['ret'] !=0)
        {
            return $arr_params_set;
        }
        if($arr_params_where['ret'] !=0)
        {
            return $arr_params_where;
        }
        $arr_params_set = (isset($arr_params_set['data_info']['info']['out']) && is_array($arr_params_set['data_info']['info']['out']) && !empty($arr_params_set['data_info']['info']['out'])) ? $arr_params_set['data_info']['info']['out'] : null;
        $arr_params_where = (isset($arr_params_where['data_info']['info']['out']) && is_array($arr_params_where['data_info']['info']['out']) && !empty($arr_params_where['data_info']['info']['out'])) ? $arr_params_where['data_info']['info']['out'] : null;

        return $this->make_update_sql($arr_params_set,$arr_params_where);
    }

    /**
     * LOGIC 查询
     * @param $arr_params
     * @return array|multitype|NULL
     */
    public function query($arr_params, $str_field = '*')
    {
        $arr_params_where = $this->make_em_pre(isset($arr_params['where']) ? $arr_params['where'] : null);
        $arr_params_where = $this->_except_empty_data($arr_params_where);
        $arr_params_where = $this->_check_query_params($this->table_define, $arr_params_where);
        if($arr_params_where['ret'] !=0)
        {
            return $arr_params_where;
        }
        $arr_params_where = (isset($arr_params_where['data_info']['info']['out']) && is_array($arr_params_where['data_info']['info']['out']) && !empty($arr_params_where['data_info']['info']['out'])) ? $arr_params_where['data_info']['info']['out'] : null;
        return $this->make_query_sql($arr_params_where,$this->str_base_table,$str_field);
    }

    /**
     * LOGIC 查询唯一 操作
     * @param $arr_params
     * @return array|null array('ret'=>'状态码','reason'=>'原因','data_info'=>'数据','page_info'=>'分页信息','other_info'=>'扩展信息')
     */
    public function query_only($arr_params,$str_field = '*')
    {
        $arr_params_where = $this->make_em_pre(isset($arr_params['where']) ? $arr_params['where'] : null);
        $arr_params_where = $this->_except_empty_data($arr_params_where);
        $arr_params_where = $this->_check_query_params($this->table_define, $arr_params_where);
        if($arr_params_where['ret'] !=0)
        {
            return $arr_params_where;
        }
        $arr_params_where = (isset($arr_params_where['data_info']['info']['out']) && is_array($arr_params_where['data_info']['info']['out']) && !empty($arr_params_where['data_info']['info']['out'])) ? $arr_params_where['data_info']['info']['out'] : null;
        return $this->make_query_only_sql($arr_params_where,$this->str_base_table,$str_field);
    }
}