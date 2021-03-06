<?php
/**
 * LOGIC表order_manager 操作类
 * Created by <stacrcor.com>.
 * Author: xinxin.deng
 * Date: 2018/11/29 14:45
 */
include_once dirname(__FILE__).'/order_manager.base.php';
class order_manager extends order_manager_base
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
     * @param $arr_params
     * @author pan.liang
     * @date 2016-12-30 13:51:33
     */
    public function rel_del($arr_params)
    {
        $arr_params_where = $this->make_em_pre(isset($arr_params['where']) ? $arr_params['where'] : null);
        $arr_params_where = $this->_check_query_params($this->table_define, $arr_params_where);
        if($arr_params_where['ret'] !=0)
        {
            return $arr_params_where;
        }
        $arr_params_where = (isset($arr_params_where['data_info']['info']['out']) && is_array($arr_params_where['data_info']['info']['out']) && !empty($arr_params_where['data_info']['info']['out'])) ? $arr_params_where['data_info']['info']['out'] : null;
        return $this->make_delete_sql($arr_params_where);
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
        $arr_params_set = $this->_check_query_params($this->table_define, $arr_params_set);
        $arr_params_where = $this->_check_query_params($this->table_define, $arr_params_where);
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

        /***************上层封装模糊查询，范围查询等 start*******************/
        $wh = array ();
        $where = null;
        if (!empty($arr_params_where['cms_name']) && isset($arr_params_where['cms_name']))
        {
            $wh[] = "cms_name like '%" . $arr_params_where['cms_name'] . "%'";
        }
        if (!empty($arr_params_where['cms_create_time']) && isset($arr_params_where['cms_create_time']))
        {
            $wh[] = "cms_create_time >= '" . $arr_params_where['cms_create_time'] . "'";
        }
        if (!empty($arr_params_where['cms_modify_time']) && isset($arr_params_where['cms_modify_time']))
        {
            $wh[] = "cms_modify_time >= '" . $arr_params_where['cms_modify_time'] . "'";
        }
        unset($arr_params_where['cms_name']);
        unset($arr_params_where['cms_create_time']);
        unset($arr_params_where['cms_modify_time']);

        if (is_array($arr_params_where))
        {
            foreach ($arr_params_where as $k => $v)
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
        else if(is_string($arr_params_where) && strlen($arr_params_where) >0)
        {
            $where = $arr_params_where;
        }
        /*************上层封装模糊查询，范围查询等 end******************/
        return $this->make_query_sql($where,$this->str_base_table,$str_field);
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