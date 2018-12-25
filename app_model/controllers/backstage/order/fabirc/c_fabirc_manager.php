<?php
/**
 * Created by IntelliJ IDEA.
 * User: LZ
 * Date: 2018/12/17
 * Time: 19:23
 */
defined('BASEPATH') or exit('No direct script access allowed');
class c_fabirc_manager extends CI_Controller
{
    /**
     * 面辅料管理界面
     */
    public function fabirc_manager_list()
    {
        $this->_init_page();
        $fabirc = $this->auto_load_table('order','fabirc', 'c_fabirc', 'order_fabirc', 'query',$this->arr_params);
        $page_info = $fabirc['page_info'];
        if($fabirc['ret'] == 0 && !empty($fabirc['data_info']))
        {
            $fabirc = $fabirc['data_info'];
        }
        else
        {
            $fabirc = array();
        }
        //底部选择框
        $system_file_list = array(
            array(
                'url'=>'order/fabirc/c_fabirc_manager/add.php',
                'class'=>'order-fabirc-c_fabirc_manager-add',
                'ajax'=>'order/fabirc/c_fabirc_manager/add',
                'function'=>'add',
                'button_data'=>array(
                    array(
                        'name'=>'添加',
                        'icon'=>'fa-plus',
                        'params'=>'',
                        'where'=>'',
                    ),
                ),
            ),
            array(
                'url'=>'order/fabirc/c_fabirc_manager/add.php',
                'class'=>'system-auto-c_project-edit',
                'ajax'=>'system/auto/c_project/add',
                'function'=>'edit',
                'button_data'=>array(
                    array(
                        'name'=>'修改',
                        'icon'=>'fa-pencil-square-o',
                        'params'=>'',
                        'where'=>'',
                    ),
                ),
            ),
            array(
                'url'=>'system/auto/c_project/delete.php',
                'class'=>'system-auto-c_project-delete',
                'ajax'=>'system/auto/c_project/delete',
                'function'=>'delete',
                'button_data'=>array(
                    array(
                        'name'=>'删除',
                        'icon'=>'fa-trash-o',
                        'params'=>'',
                        'where'=>'',
                    ),
                ),
            ),
        );
        $return_arr = array(
            'data_info' => $fabirc,//面辅料
            'system_file_list' => $system_file_list,
            'page_info'   => $page_info,
            'arr_params' => $this->arr_params,
        );
        //取出面辅料
        $this->load_view_file($return_arr,__LINE__);
    }
    /**
     * 面辅料属性列表
     */
    public function fabirc_attribute_list()
    {
        $this->_init_page();
        $fabirc_attribute = $this->auto_load_table('order','fabirc', 'c_fabirc_manager', 'order_fabirc_attribute', 'query');
        $page_info = $fabirc_attribute['page_info'];
        $attribute_list = array();
        if($fabirc_attribute['ret'] == 0 && !empty($fabirc_attribute['data_info']))
        {
            $attribute_list = $fabirc_attribute['data_info'];
        }
        //底部选择框
        $system_file_list = array(
            array(
                'url'=>'order/fabirc/c_fabirc_manager/attribute_add.php',
                'class'=>'order-fabirc-c_fabirc_manager-attribute_add',
                'ajax'=>'order/fabirc/c_fabirc_manager/attribute_add',
                'function'=>'add',
                'button_data'=>array(
                    array(
                        'name'=>'添加',
                        'icon'=>'fa-plus',
                        'params'=>'',
                        'where'=>'',
                    ),
                ),
            ),
            array(
                'url'=>'order/fabirc/c_fabirc_manager/attribute_edit.php',
                'class'=>'order-fabirc-c_fabirc_manager-attribute_edit',
                'ajax'=>'order/fabirc/c_fabirc_manager/attribute_edit',
                'function'=>'edit',
                'button_data'=>array(
                    array(
                        'name'=>'修改',
                        'icon'=>'fa-pencil-square-o',
                        'params'=>'',
                        'where'=>'',
                    ),
                ),
            ),
            array(
                'url'=>'order/fabirc/c_fabirc_manager/attribute_delete.php',
                'class'=>'order-fabirc-c_fabirc_manager-attribute_delete',
                'ajax'=>'order/fabirc/c_fabirc_manager/attribute_delete',
                'function'=>'delete',
                'button_data'=>array(
                    array(
                        'name'=>'删除',
                        'icon'=>'fa-trash-o',
                        'params'=>'',
                        'where'=>'',
                    ),
                ),
            ),
        );
        $return_arr = array(
            'data_info' => $attribute_list,//面辅料属性列表
            'system_file_list' => $system_file_list,
            'page_info'   => $page_info,
        );
        $this->load_view_file($return_arr,__LINE__);
    }

    /**
     * 面辅料属性添加，json返回
     */
    public function attribute_add()
    {
        $fabirc_attribute = $this->auto_load_table('order','fabirc', 'c_fabirc_manager', 'order_fabirc_attribute', 'add', $this->arr_params);
        $return_arr = array('ret' => 0, 'reason' => '操作成功');
        if($fabirc_attribute['ret'] != 0)
        {
            $return_arr = array('ret' => 1, 'reason' => '操作失败');
        }
        $this->load_view_file($return_arr);
    }

    /**
     * 面辅料属性删除，json返回
     */
    public function attribute_delete()
    {
        $fabirc_attribute = $this->auto_load_table('order','fabirc', 'c_fabirc_manager', 'order_fabirc_attribute', 'del', $this->arr_params);
        $return_arr = array('ret' => 0, 'reason' => '操作成功');
        if($fabirc_attribute['ret'] != 0)
        {
            $return_arr = array('ret' => 1, 'reason' => '操作失败');
        }

        $this->load_view_file($return_arr);
    }
    /**
     * 面辅料属性修改,json返回
     */
    public function attribute_edit()
    {
        $fabirc_attribute = $this->auto_load_table('order','fabirc', 'c_fabirc_manager', 'order_fabirc_attribute', 'edit', $this->arr_params);
        $return_arr = array('ret' => 0, 'reason' => '操作成功');
        if($fabirc_attribute['ret'] != 0)
        {
            $return_arr = array('ret' => 1, 'reason' => '操作失败');
        }

        $this->load_view_file($return_arr);
    }
}