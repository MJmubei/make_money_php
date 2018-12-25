<?php
/**
 * Created by PhpStorm.
 * User: fingal
 * Date: 2018/12/23
 * Time: 14:43
 */

class order_client_order extends order_client_order_base
{
    /**
     * LOGIC 查询
     * @param $arr_params
     * @return array|multitype|NULL
     */
    public function query($arr_params)
    {
        $arr_params_where = $this->make_em_pre(isset($arr_params['where']) ? $arr_params['where'] : null);
        $arr_params_where = $this->_except_empty_data($arr_params_where);
        $arr_params_where = $this->_check_query_params($this->table_define, $arr_params_where);
        if($arr_params_where['ret'] !=0)
        {
            return $arr_params_where;
        }
        $arr_params_where = (isset($arr_params_where['data_info']['info']['out']) && is_array($arr_params_where['data_info']['info']['out']) && !empty($arr_params_where['data_info']['info']['out'])) ? $arr_params_where['data_info']['info']['out'] : null;
        return $this->make_query_sql($arr_params_where);
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