<?php
/**
 * Created by PhpStorm.
 * Use : 充值业务逻辑
 * User: kan.yang@starcor.com
 * Date: 18-12-22
 * Time: 下午1:06
 */

class c_recharge extends CI_Controller
{

    //项目基路径
    private $str_base_path   = '';

    /**
     * 默认构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->str_base_path = dirname(dirname(dirname(dirname(__DIR__))));
    }

    /**
     * 查询充值订单列表
     */
    public function list_recharge()
    {
        include_once $this->str_base_path . '/logic/backstage/order/buy_order/c_buy_order/logic_order_buy.class.php';
        $obj_order_buy_logic = new order_buy_logic($this);

        $this->arr_params['cms_order_type']= 5;
        $arr_recharge_list   = $obj_order_buy_logic->get_list($this->arr_params,'*',$this->arr_page_params);
        $this->load_view_file($arr_recharge_list,__LINE__);
    }

    /**
     * 充值订单详情
     */
    public function item_recharge()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_id'=> array(
                'rule'   => 'notnull',
                'reason' => '充值订单非法'
            ),
        ),$this->arr_params);

        include_once $this->str_base_path . '/logic/backstage/order/buy_order/c_buy_order/logic_order_buy.class.php';
        $obj_order_buy_logic = new order_buy_logic($this);

        $this->arr_params['cms_order_type']= 5;
        $arr_recharge_info = $obj_order_buy_logic->get_one($this->arr_params,'*');
        $this->load_view_file($arr_recharge_info,__LINE__);
    }

    /**
     * 充值
     */
    public function recharge()
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
                'length' => '5',
                'reason' => '订单类型非法'
            ),
            'cms_pay_partner_id' => array(
                'rule'   => 'notnull',
                'reason' => '商户非法'
            ),
            'cms_pay_channel_id' => array(
                'rule'   => 'notnull',
                'reason' => '支付渠道非法'
            ),
            'cms_pay_channel_mode_id' => array(
                'rule'   => 'notnull',
                'reason' => '支付渠道-支付模式非法'
            ),
        ),$this->arr_params);
        $this->flag_ajax_reurn = true;
        //校验商户是否有效
        include_once $this->str_base_path . '/logic/backstage/order/buy_order/c_partner/logic_partner.class.php';
        $obj_partner_logic = new partner_logic($this);
        $arr_partner_info  = $obj_partner_logic->get_one(array(
                'cms_id'   => $this->arr_params['cms_pay_partner_id'],
                'cms_status'  => 1),
                'cms_id'
        );
        if($arr_partner_info['ret'] != 0 || empty($arr_partner_info['data_info']))
        {
            $this->load_view_file($arr_partner_info,__LINE__);
            return false;
        }
        unset($obj_partner_logic, $arr_partner_info);
        //校验支付渠道是否有效
        include_once $this->str_base_path . '/logic/backstage/order/buy_order/c_channel/logic_channel.class.php';
        $obj_channel_logic = new channel_logic($this);
        $arr_channel_info  = $obj_channel_logic->get_one(array(
                'cms_id'   => $this->arr_params['cms_pay_channel_id'],
                'cms_status'    => 1,
                'nns_partner_id'=> $this->arr_params['cms_pay_partner_id'],
                ),
            'cms_id,cms_platform_id'
        );
        if($arr_channel_info['ret'] != 0 || empty($arr_channel_info['data_info']))
        {
            $this->load_view_file($arr_channel_info,__LINE__);
            return false;
        }
        else
        {
            $arr_channel_info = $arr_channel_info['data_info'];
        }
        unset($obj_channel_logic);
        //校验支付模式是否有效
        include_once $this->str_base_path . '/logic/backstage/order/buy_order/c_channel_mode/logic_channel_mode.class.php';
        $obj_channel_mode_logic = new channel_mode_logic($this);
        $arr_channel_mode_info  = $obj_channel_mode_logic->get_one(array(
                'cms_id'   => $this->arr_params['cms_pay_channel_mode_id'],
                'cms_status'    => 1,
                'cms_channel_id'=> $this->arr_params['cms_pay_channel_id'],
        ));
        if($arr_channel_mode_info['ret'] != 0 || empty($arr_channel_mode_info['data_info']))
        {
            $this->load_view_file($arr_channel_mode_info,__LINE__);
            return false;
        }
        else
        {
            $arr_channel_mode_info = $arr_channel_mode_info['data_info'];
        }
        unset($obj_channel_mode_logic);
        //创建充值订单
        include_once $this->str_base_path . '/logic/backstage/order/buy_order/c_buy_order/logic_order_buy.class.php';
        $obj_order_buy_logic = new order_buy_logic($this);
        $arr_order_info  = array(
            'cms_user_id'         => $this->arr_params['cms_user_id'],
            'cms_order_name'      => empty($this->arr_params['cms_order_name']) ? '充值订单' : $this->arr_params['cms_order_name'],
            'cms_order_price'     => $this->arr_params['cms_order_price'],
            'cms_order_type'      => $this->arr_params['cms_order_type'],
            'cms_order_state'     => '0',
            'cms_business_state'  => '0',
            'nns_order_parent'    => '',
            'cms_pay_order_code'  => '',
            'cms_pay_partner_id'  => $this->arr_params['cms_pay_channel_id'],
            'cms_pay_channel_id'  => $this->arr_params['cms_pay_channel_id'],
            'cms_pay_channel_mode'=> $this->arr_params['cms_pay_channel_mode_id'],
            'cms_pay_mode_type'   => $arr_channel_info['cms_platform_id'] . $arr_channel_mode_info['nns_channel_mode_flag'],
            'cms_order_desc'      => '充值订单：' . $this->arr_params['cms_user_id'] . ' 于 ' . date('Y-m-d h:i:s') . ' 充值 ' . $this->arr_params['cms_order_price'] . ' 元',
        );
        $arr_add_order = $obj_order_buy_logic->add($arr_order_info);
        if($arr_add_order['ret'] != 0)
        {
            $this->load_view_file($arr_add_order,__LINE__);
            return false;
        }
        else
        {
            $arr_add_order = $arr_add_order['data_info'];
        }
        //支付模式下单
        include_once $this->str_base_path . '/logic/backstage/order/pay/c_pay/pay.php';
        $obj_pay = new pay($this,'');
        $arr_third_response = array('ret' => 1,'reason' => '未知支付方式');
        switch($arr_channel_info['cms_platform_id'])
        {
            //微信
            case 1:
                if($arr_channel_mode_info['nns_channel_mode_flag'] == 0)
                {
                    $arr_third_response = $obj_pay->wechat_scan(array(
                        'cms_expire_time'=> $arr_channel_mode_info['cms_qr_expire_time'],
                        'cms_notify_url' => $arr_channel_mode_info['cms_notify_url']
                    ),array(
                        'cms_order_id'   => $arr_add_order['cms_uuid'],
                        'cms_order_name' => $arr_add_order['cms_order_name'],
                        'cms_order_price'=> $arr_add_order['cms_order_price'],
                        'cms_product_id' => $arr_add_order['cms_uuid'],
                    ));
                }
            break;
            //支付宝
            case 2:
                if($arr_channel_mode_info['nns_channel_mode_flag'] == 0)
                {
                    $arr_third_response = $obj_pay->alipay_scan(array(
                        'cms_expire_time'=> $arr_channel_mode_info['cms_qr_expire_time'],
                        'cms_notify_url' => $arr_channel_mode_info['cms_notify_url'],
                        'cms_public_key' => dirname($this->str_base_path) . '/' . ltrim($arr_channel_mode_info['cms_public_key'],'/'),
                        'cms_private_key'=> dirname($this->str_base_path) . '/' . ltrim($arr_channel_mode_info['cms_private_key'],'/'),
                    ),array(
                        'cms_order_id'   => $arr_add_order['cms_uuid'],
                        'cms_order_name' => $arr_add_order['cms_order_name'],
                        'cms_order_price'=> $arr_add_order['cms_order_price'],
                        'cms_product_id' => $arr_add_order['cms_uuid'],
                        'cms_order_num'  => '1',
                    ));
                }
            break;
            //未知
            default:
            break;
        }
        $this->load_view_file($arr_third_response,__DIR__);
        return true;
    }

    /**
     * 轮询订单状态
     */
    public function poll()
    {
        $this->control_params_check(array(
            'cms_order_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付订单非法'
            ),
        ),$this->arr_params);
        //异步返回
        $this->flag_ajax_reurn = true;
        //查询订单状态
        $this->load->driver('cache');
        $int_order_status = $this->cache->redis->get($this->arr_params['cms_order_id']);
        if($int_order_status == TRADE_SUCCESS)
        {//成功

            $this->load_view_file(array('ret' => TRADE_SUCCESS),__LINE__);
        }
        elseif($int_order_status == TRADE_FAIL)
        {//失败

            $this->load_view_file(array('ret' => TRADE_FAIL),__LINE__);
        }
        else
        {//默认处理中

            $this->load_view_file(array('ret' => TRADE_PROCESS),__LINE__);
        }
    }
} 