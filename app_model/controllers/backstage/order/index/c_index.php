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
     *  首页数据
     */
    public function index()
    {
        session_start();
        $data = $this->__index_menu();
        if(is_array($data) && !empty($data))
        {
            $data = $this->system_auto_make_menu_arr($data);
        }
        switch ($this->arr_params['project_id'])
        {
            case '1':
                $role = '';
                break;
            case '2':
                $role = '平台管理员';
                break;
            case '3':
                $role = '生产商';
                break;
            case '4':
                $role = '供应商';
                break;
            case '5':
                $role = '样板师';
                break;
            case '6':
                $role = '样衣师';
                break;
            default:
                $role = '超级管理员';
                break;
        }
        $retun_arr = array(
            'data_info' => $data,
            'user_id' => '17302816961',//$this->session->userdata('role_id'),
            'role' => $role,
        );
        $this->load_view_file($retun_arr,__LINE__);
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