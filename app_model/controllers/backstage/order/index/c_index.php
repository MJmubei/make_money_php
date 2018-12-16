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
    public function __construct($str_class = null, $str_file = null, $str_method = null, $str_directory = null)
    {
        parent::__construct($str_class, $str_file, $str_method, $str_directory);
        $this->load->library('session');
    }

    /**
     *  首页数据
     */
    public function index()
    {
        if(empty($this->session->userdata('telephone')) || empty($this->session->userdata('role_id')))
        {
            echo "<script>window.location.href='../../../order/con_manager/c_manager/login';</script>";die;
        }
        $this->arr_params['project_id'] = $this->session->userdata('role_id');
        $data = $this->__index_menu();
        if(is_array($data) && !empty($data))
        {
            $data = $this->system_auto_make_menu_arr($data);
        }

        $retun_arr = array(
            'data_info' => $data,
            'user_id' => $this->session->userdata('telephone'),
            'project_id' => $this->session->userdata('role_id'),
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