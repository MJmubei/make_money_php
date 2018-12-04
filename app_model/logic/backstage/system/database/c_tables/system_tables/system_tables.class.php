<?php
class system_tables extends em_logic
{
    /**
     * 添加
     * @return string
     */
    public function add()
    {
        return $this->make_insert_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }
    
    
    /**
     * 查询数据库所有表
     * @return string
     */
    public function query_tables($arr_params=null)
    {
        $arr_query = array('table_schema'=>$this->obj_controller->db->database);
        if(is_array($this->obj_controller->arr_params) && !empty($this->obj_controller->arr_params))
        {
            $arr_query = array_merge($arr_query,$this->obj_controller->arr_params);
        }
        $arr_query = $this->_except_empty_data($arr_query);
        return $this->make_query_sql($arr_query,'information_schema.TABLES');
    }
    
    
    /**
     * 查询数据库所有表
     * @return string
     */
    public function query_table_fileds()
    {
        return $this->_make_query_sql("select * from information_schema.COLUMNS where table_name = '{$this->arr_params['table_name']}' and table_schema = '{$this->obj_controller->db->database}'");
    }
}