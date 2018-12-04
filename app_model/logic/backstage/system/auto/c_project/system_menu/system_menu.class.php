<?php
include_once dirname(__FILE__).'/system_menu.base.php';
class system_menu extends system_menu_base
{
    
      /**
      * 添加信息
      * @param array $arr_params参数
      * @return array('ret'=>'状态码','reason'=>'原因')|string
      */
    public function add($arr_params=null)
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
     * 修改信息
     * @param array $arr_params参数
     * @return array('ret'=>'状态码','reason'=>'原因')|string
     */
    public function edit($arr_params=null)
    {
        $arr_params_set = $this->make_em_pre(isset($arr_params['set']) ? $arr_params['set'] : null);
        $arr_params_where = $this->make_em_pre(isset($arr_params['where']) ? $arr_params['where'] : null);
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
     * 删除信息
     * @param array $arr_params参数
     * @return array('ret'=>'状态码','reason'=>'原因')|string
     */
    public function delete($arr_params=null)
    {
        $arr_params_where = $this->make_em_pre(isset($arr_params['where']) ? $arr_params['where'] : null);
        $arr_params_where = $this->_check_edit_del_params($this->table_define, $arr_params_where);
        if($arr_params_where['ret'] !=0)
        {
            return $arr_params_where;
        }
        $arr_params_where = (isset($arr_params_where['data_info']['info']['out']) && is_array($arr_params_where['data_info']['info']['out']) && !empty($arr_params_where['data_info']['info']['out'])) ? $arr_params_where['data_info']['info']['out'] : null;
        return $this->make_delete_sql($arr_params_where);
    }
    
    
    /**
     * 查询信息
     * @param array $arr_params参数
     * @return array('ret'=>'状态码','reason'=>'原因')|string
     */
    public function query($arr_params=null)
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
     * 添加+修改信息（如果没有数据则添加，如果有则修改）
     * @param array $arr_params参数
     * @return array('ret'=>'状态码','reason'=>'原因')|string
     */
    public function add_edit($arr_params=null)
    {
        $arr_params_where = $this->make_em_pre(isset($arr_params['where']) ? $arr_params['where'] : null);
        $arr_params_where = $this->_check_edit_del_params($this->table_define, $arr_params_where);
        if($arr_params_where['ret'] !=0)
        {
            return $arr_params_where;
        }
        $arr_params_where = (isset($arr_params_where['data_info']['info']['out']) && is_array($arr_params_where['data_info']['info']['out']) && !empty($arr_params_where['data_info']['info']['out'])) ? $arr_params_where['data_info']['info']['out'] : null;
        if(is_array($arr_params_where) && !empty($arr_params_where))
        {
            $result_query = $this->make_query_sql($arr_params_where);
            if($result_query['ret'] !=0)
            {
                return $result_query;
            }
            if(isset($result_query['data_info']) && is_array($result_query['data_info']) && !empty($result_query['data_info']))
            {
                $result = $this->edit($arr_params);
                $result['data_info'] = $result_query['data_info'];
                return $result;
            }
        }
        return $this->add($arr_params);
    }
    
    /**
     * 添加+修改信息（如果没有数据则添加，如果有则修改，仅仅只有一条数据，如果多条数据直接报错）
     * @param array $arr_params参数
     * @return array('ret'=>'状态码','reason'=>'原因')|string
     */
    public function add_edit_one($arr_params=null)
    {
        $arr_params_where = $this->make_em_pre(isset($arr_params['where']) ? $arr_params['where'] : null);
        $arr_params_where = $this->_check_edit_del_params($this->table_define, $arr_params_where);
        if($arr_params_where['ret'] !=0)
        {
            return $arr_params_where;
        }
        $arr_params_where = (isset($arr_params_where['data_info']['info']['out']) && is_array($arr_params_where['data_info']['info']['out']) && !empty($arr_params_where['data_info']['info']['out'])) ? $arr_params_where['data_info']['info']['out'] : null;
        if(is_array($arr_params_where) && !empty($arr_params_where))
        {
            $result_query = $this->make_query_sql($arr_params_where);
            if($result_query['ret'] !=0)
            {
                return $result_query;
            }
            if(isset($result_query['data_info']) && is_array($result_query['data_info']) && !empty($result_query['data_info']))
            {
                if(count($result_query['data_info']) >1)
                {
                    return em_return::return_data(1,'查询出两条数据');
                }
                $result = $this->edit($arr_params);
                $result['data_info'] = $result_query['data_info'][0];
                return $result;
            }
        }
        return $this->add($arr_params);
    }
}