<?php
class global_params extends em_logic
{
    public $table_define = array(
        'em_id'=>array(
            'type'=>'int',
            'isempty'=>'n',
            'length'=>'',
        ),
        'em_global_name'=>array(
            'type'=>'varchar',
            'isempty'=>'y',
            'length'=>'128',
        ),
        'em_global_model'=>array(
            'type'=>'varchar',
            'isempty'=>'y',
            'length'=>'32',
        ),
        'em_project_model'=>array(
            'type'=>'varchar',
            'isempty'=>'y',
            'length'=>'64',
        ),
        'em_config'=>array(
            'type'=>'text',
            'isempty'=>'y',
            'length'=>'',
        ),
        'em_create_time'=>array(
            'type'=>'datetime',
            'isempty'=>'n',
            'length'=>'',
        ),
        'em_modify_time'=>array(
            'type'=>'datetime',
            'isempty'=>'n',
            'length'=>'',
        ),
    );
    
    /**
     * 添加
     * @return string
     */
    public function add()
    {
        return $this->make_insert_sql($this->except_useless_params($this->arr_params, $this->table_define,true),__LINE__);
    }
}