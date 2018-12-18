<?php
/**
 * Created by PhpStorm.
 * Use : 支付回调基类
 * User: kan.yang@starcor.com
 * Date: 18-12-16
 * Time: 下午3:12
 */

include_once dirname(dirname(__DIR__)) . '/buy_order/c_buy_order/logic_order_buy.class.php';
include_once dirname(dirname(__DIR__)) . '/buy_order/c_channel_mode/logic_channel_mode.class.php';
abstract class c_nofity_base
{

    protected $str_log_path   = '';
    //Controller
    protected $obj_controller = null;
    //订单详情
    protected $arr_order_info = null;
    //Cache处理类
    protected $obj_cache_redis= null;
    //订单处理类
    protected $obj_order_logic= array();
    //支付模式业务类
    protected $obj_channel_mode_logic = null;

    /**
     * 默认构造函数
     */
    public function __construct($obj_controller)
    {
        $this->obj_controller  = $obj_controller;
        //初始化购买订单业务类
        $this->obj_order_logic = new order_buy_logic($this->obj_controller);
        //初始化支付模式业务类
        $this->obj_channel_mode_logic = new order_buy_logic($this->obj_controller);
        //初始化Cache
        $this->obj_controller->load->driver('cache');
        $this->obj_cache_redis = $this->obj_controller->cache->redis;
        //日志路径
        $this->str_log_path = $this->obj_controller->get_str_load_log_path();
    }

    /**
     * 回调入口函数
     */
    abstract public function notify($data);

    /**
     * 反馈信息
     */
    abstract public function back_msg($int_ret,$str_reason);

    /**
     * 支付回调业务处理核心函数
     * @param bool  $bool_pay_status  false 失败；true 成功
     * @param array $arr_params_data  array(
            'cms_buy_order_id' => '购买订购ID',
            'cms_pay_order_id' => '支付订购ID',
            'cms_reason'       => '描述信息',
     * )
     * @return bool true 成功；false 失败
     */
    protected function logic_init($bool_pay_status,$arr_params_data)
    {
        if($bool_pay_status)
        {
            $int_business_status = 1;
            $cache_order_status = TRADE_SUCCESS;
            $arr_params_data['cms_reason'] = empty($arr_params_data['cms_reason']) ? '支付成功，业务处理成功' : $arr_params_data['cms_reason'];
            //充值类订单，需要更新用户余额
            if($this->arr_order_info['cms_order_type'] == 5)
            {
                include_once dirname(dirname(dirname(__DIR__))) . '/order/manager/c_manager/order_manager/order_manager.class.php';
                $obj_order_manager = new order_manager($this->obj_controller,'order_manager');
                //查询用户余额
                $arr_user_info = $obj_order_manager->query_only(array('cms_id' => $this->arr_order_info['cms_user_id']),'cms_user_money');
                if($arr_user_info['ret'] != 0 || empty($arr_user_info['data_info']))
                {
                    em_return::set_ci_flow_desc($this->str_log_path,'支付回调:查询【' . $this->arr_order_info['cms_user_id'] . '】用户信息失败,','message','error');
                    //微信充值成功，用户余额充值失败
                    $int_business_status = 2;
                    $cache_order_status = TRADE_FAIL;
                    $arr_params_data['cms_reason'] = '支付平台支付成功，但是系统业务处理失败-未查询到任何用户信息';
                }
                else
                {
                    $arr_user_info = $arr_user_info['data_info'];
                    //重试3次
                    $int_repeat_num = 0;
                    while($int_repeat_num < 3)
                    {
                        $arr_edit_ret = $obj_order_manager->edit(array(
                            'set' => array(
                                'cms_user_money' => $arr_user_info['cms_user_money'] + $this->arr_order_info['cms_order_price'],
                            ),'where' => array(
                                'id' => $this->arr_order_info['cms_user_id'],
                            ),
                        ));
                        if($arr_edit_ret['ret'] != 0)
                        {
                            $cache_order_status = TRADE_FAIL;
                            em_return::set_ci_flow_desc($this->str_log_path,'支付回调:更新【' . $this->arr_order_info['cms_user_id'] . '】用户余额失败，,','message','error');
                        }
                        else
                        {
                            break;
                        }
                        usleep(20000); $int_repeat_num ++;
                    }
                    //充值余额失败
                    if($cache_order_status === TRADE_FAIL)
                    {
                        //微信充值成功，用户余额充值失败
                        $int_business_status = 2;
                        $arr_params_data['cms_reason'] = '支付平台支付成功，但是系统业务处理失败-更新用户余额异常';
                    }
                }
            }
            //更新订单结果
            $this->obj_order_logic->edit($this->arr_order_info['cms_uuid'],array(
                'cms_order_state' => 1,
                'cms_business_state' => $int_business_status,
                'cms_pay_order_id'   => $arr_params_data['nns_pay_order_id'],
                'cms_order_desc'     => $arr_params_data['cms_reason'],
            ));
            //更新Redis订单呢状态：成功
            $this->obj_cache_redis->save($this->arr_order_info['cms_uuid'],$cache_order_status,ORDER_STATUS_BUFF_TIME);
        }
        else
        {
            //更新订单结果
            $this->obj_order_logic->edit($this->arr_order_info['cms_uuid'],array(
                'cms_business_state' => 2,
                'cms_pay_order_id'   => $arr_params_data['nns_pay_order_id'],
                'cms_order_desc'     => '支付失败，' . $arr_params_data['cms_reason'],
            ));
            //更新Redis订单呢状态：失败
            $this->obj_cache_redis->save($this->arr_order_info['cms_uuid'],TRADE_FAIL,ORDER_STATUS_BUFF_TIME);
            em_return::set_ci_flow_desc($this->str_log_path,'支付回调:,' . $arr_params_data['cms_reason'],'message','error');
        }
        return true;
    }




}