<?php
/**
 * Created by IntelliJ IDEA.
 * User: LZ
 * Date: 2018/12/12
 */
defined('BASEPATH') or exit('No direct script access allowed');
class c_fabirc extends CI_Controller
{
    public function fabirc_view()
    {
        $this->load_view_file();
    }
    public function fabirc_order()
    {
        $fabirc_type_data = array();
        //取出面辅料订单类型数据
        $fabirc_type = $this->auto_load_table('order','fabirc', 'c_fabirc', 'order_fabirc_type', 'query');
        if($fabirc_type['ret'] == 0 && !empty($fabirc_type['data_info']))
        {
            foreach ($fabirc_type['data_info'] as $type)
            {
                $fabirc_type_data[] = array(
                    'text'          => $type['cms_name'],
                    'cms_parent_id' => 0,
                    'cms_id'        => $type['cms_id'],
                );
            }
        }
        $return_arr = array(
            'fabirc_type' => $fabirc_type_data,//面辅料订单类型
            'url_params' => $this->arr_params,
        );
        //取出面辅料
        $this->load_view_file($return_arr,__LINE__);
    }

    public function fabirc()
    {
        $this->_init_page();
        $fabirc = array();
        //根据面辅料订单类型获取右侧面辅料清单
        if(isset($this->arr_params['fabirc_type_id']) && !empty($this->arr_params['fabirc_type_id']))
        {
            $fabirc = $this->auto_load_table('order','fabirc', 'c_fabirc', 'order_fabirc', 'query', array('cms_fabirc'));
        }
        else
        {
            $fabirc = $this->auto_load_table('order','fabirc', 'c_fabirc', 'order_fabirc', 'query');
        }
        $page_info = $fabirc['page_info'];
        if($fabirc['ret'] == 0 && !empty($fabirc['data_info']))
        {
            $fabirc = $fabirc['data_info'];
        }

        $return_arr = array(
            'fabirc' => $fabirc,//面辅料
            'url_params'  => $this->arr_params,
            'page_info'   => $page_info,
        );
        //取出面辅料
        $this->load_view_file($return_arr,__LINE__);
    }

    public function shopping_list()
    {
        $this->load_view_file(array('fabirc' => array()),__LINE__);
    }
}