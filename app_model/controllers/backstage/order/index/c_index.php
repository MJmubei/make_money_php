<?php
/**
 * Created by IntelliJ IDEA.
 * User: LZ
 * Date: 2018/12/16
 * Time: 12:15
 */
defined('BASEPATH') or exit('No direct script access allowed');
class c_index extends CI_Controller
{
    /**
     * 列表页
     */
    public function index()
    {
        $data = $this->__index_menu();
        if(is_array($data) && !empty($data))
        {
            $data = $this->system_auto_make_menu_arr($data);
        }
        $this->load_view_file(em_return::return_data(0,'ok',$data),__LINE__);
    }

    private function __index_menu($level = 1,$parent_id = 0)
    {
        $last_data=null;
        if($level==1)
        {
            $this->arr_page_params['cms_page_num'] = 0;
            $this->arr_page_params['cms_page_size'] = 0;
        }
        $temp_level = $level+1;
        $menu_data = $this->auto_load_table('system','auto','c_project','system_menu', 'query',array('where'=>array('cms_level'=>$level,'cms_parent_id'=>$parent_id,'cms_project_id'=>$this->arr_params['project_id'])));
        $menu_data = isset($menu_data['data_info']) ? $menu_data['data_info'] :null;
        if(!is_array($menu_data) || empty($menu_data))
        {
            return $last_data;
        }
        foreach ($menu_data as $value)
        {
            $last_data[$value['cms_id']]['data']=$value;
            $data = $this->__index_menu($temp_level,$value['cms_id']);
            if(!is_array($data) || empty($data))
            {
                continue;
            }
            $last_data[$value['cms_id']]['child_list'] = $data;
        }
        return $last_data;
    }
}