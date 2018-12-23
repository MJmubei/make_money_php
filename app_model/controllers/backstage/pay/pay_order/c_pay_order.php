<?php
/**
 * Created by PhpStorm.
 * Use : 订单、支付业务逻辑
 * User: kan.yang@starcor.com
 * Date: 18-12-22
 * Time: 下午12:14
 */

//引入文件
include_once dirname(dirname(dirname(dirname(__DIR__)))) . '/logic/backstage/order/buy_order/c_buy_order/logic_order_buy.class.php';
class c_pay_order extends CI_Controller
{

    //购买订单业务类
    private $obj_order_buy_logic = null;

    /**
     * 默认构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->obj_order_buy_logic = new order_buy_logic($this);
    }

    /**
     * 创建订单
     */
    public function c_order()
    {

    }

    /**
     * 支付订单
     * @return array(
            'ret' => 0 //成功
                     1 //余额不足
                     2 //失败
            'reason'   => '描述信息',
            'data_info'=> array(),
     * )
     */
    public function c_pay()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_user_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付方用户非法'
            ),
            'cms_order_price' => array(
                'rule'   => 'number',
                'reason' => '订单金额非法'
            ),
            'cms_order_type' => array(
                'rule'   => 'in',
                'length' => '0,1,2,3,4,5',
                'reason' => '订单类型非法'
            ),
            'cms_pay_order_code' => array(
                'rule'   => 'notnull',
                'reason' => '购买订单非法'
            )
        ),$this->arr_params);
        //订单处理
        $str_order_uuid = $this->arr_params['cms_order_id'];
        if(empty($this->arr_params['cms_order_id']))
        {//创建订单

            $arr_order_add = $this->obj_order_buy_logic->add(array(
                'cms_user_id'         => $this->arr_params['cms_user_id'],
                'cms_order_name'      => empty($this->arr_params['cms_order_name']) ? $this->obj_order_buy_logic->arr_order_type[$this->arr_params['cms_order_type']] : $this->arr_params['cms_order_name'],
                'cms_order_price'     => $this->arr_params['cms_order_price'],
                'cms_order_type'      => $this->arr_params['cms_order_type'],
                'cms_order_state'     => '0',
                'cms_business_state'  => '0',
                'nns_order_parent'    => $this->arr_params['nns_order_parent'],
                'cms_pay_order_code'  => $this->arr_params['cms_pay_order_code'],
                'cms_pay_partner_id'  => '',
                'cms_pay_channel_id'  => '',
                'cms_pay_channel_mode'=> '',
                'cms_pay_mode_type'   => '0',
            ));
            //创建订单失败
            if($arr_order_add['ret'] != 0)
            {
                $arr_order_add = array('ret' => 2,'reason' => '错误:创建支付订单失败');
                $this->load_view_file($arr_order_add,__LINE__);
                return false;
            }
            //订单ID
            $this->arr_params['cms_order_id'] = $str_order_uuid = $arr_order_add['data_info']['cms_uuid'];
        }
        else
        {//校验订单

            $arr_order_info = $this->obj_order_buy_logic->get_one(array('cms_uuid' => $str_order_uuid),'cms_id');
            if($arr_order_info['ret'] != 0 || empty($arr_order_info['cms_id']))
            {
                $arr_order_add = array('ret' => 2,'reason' => '错误:校验订单 ' . $str_order_uuid . ' 不存在');
                $this->load_view_file($arr_order_add,__LINE__);
                return false;
            }
        }
        //账户余额
        $float_user_money = $_SESSION[$this->arr_params['cms_user_id']]['cms_user_money'];
        //验证用账户余额是否充足
        if($float_user_money < $this->arr_params['cms_order_price'])
        {//不足

            $arr_order_add = array('ret' => 1,'reason' => '警告:用户余额不足，请充值','data_info' => $this->arr_params);
        }
        else
        {//充足

            //更新账户余额
            include_once dirname(dirname(dirname(dirname(__DIR__)))) . '/logic/backstage/order/manager/c_manager/order_manager/order_manager.class.php';
            $obj_order_manager = new order_manager($this,'order_manager');
            $obj_order_manager->edit(array(
                'set' => array(
                    'cms_user_money' => $float_user_money - $this->arr_params['cms_order_price'],
                ),'where' => array(
                    'id' => $this->arr_params['cms_user_id'],
                ),
            ));
            //更新订单状态
            $this->obj_order_buy_logic->edit(array('cms_uuid' => $str_order_uuid),array(
                'cms_order_state'     => '1',
                'cms_business_state'  => '1',
            ));
            //更新SESSION中账户余额
            $_SESSION[$this->arr_params['cms_user_id']]['cms_user_money'] = $float_user_money - $this->arr_params['cms_order_price'];
            //返回参数
            $arr_order_add = array('ret' => 0,'reason' => '支付成功');
        }
        $this->load_view_file($arr_order_add,__LINE__);
        return true;
    }




} 