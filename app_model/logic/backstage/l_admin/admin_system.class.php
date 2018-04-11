<?php
class admin_system extends em_logic
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
    public function query_tables()
    {
        return $this->_make_query_sql("select * from information_schema.TABLES where table_schema = '{$this->obj_controller->db->database}'");
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