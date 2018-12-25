<?php
/**
 * Created by PhpStorm.
 * Use : 支付回调
 * User: kan.yang@starcor.com
 * Date: 18-12-22
 * Time: 上午12:30
 */

class alipay_pay_notify_callback
{
	private $log_module = __CLASS__;
	private $pay_dc = null;
	private $aaa_dc = null;
	private $log_dc = null;
	public $alipay_config;

	public function __construct($alipay_config){
		// 获取数据库连接对象
		$this->aaa_dc = k13_common::get_aaa_dc();
		$this->pay_dc = k13_common::get_pay_dc();
		$this->log_dc = k13_common::get_log_dc();
		$this->alipay_config = $alipay_config;
	}

	/**
	 *
	 * 回调处理函数
	 *
	 */
	public function NotifyProcess()
	{
		// 日志记录
		nl_log_v2_init_manager($this->log_module);
		nl_log_v2_info($this->log_module, "支付宝异步通知开始，请求数据为：" . var_export($_POST, true));
		nl_log_v2_info($this->log_module, "当前支付宝配置为：" . var_export($this->alipay_config, true));

		// 计算得出通知验证结果
		$alipay = new nl_alipay_interface($this->alipay_config);
		$verify_result = $alipay->verify_notify($_POST);

		// 判断订单真实性
		if (!$verify_result) {
			nl_log_v2_error($this->log_module, "请求数据异常:" . var_export($_POST, true));
			return false;
		}

		// db日志初始化
		$log_arr = k13_common::$log_arr;
		$log_arr['interface_name'] = $this->log_module;
		$log_arr['request_data'] = !empty($_POST) ? var_export($_POST, true) : '无';

		if($_POST['trade_status'] == 'TRADE_SUCCESS')
		{
			nl_log_v2_info($this->log_module, "订单支付成功，逻辑处理开始:" . var_export($_POST, true));

			// 添加DB日志
			$log_arr['status'] = 0;
			$log_arr['desc'] = '通知返回的是SUCCESS';
			k13_common::add_pay_log($this->log_dc, $log_arr);

			// 处理支付回调入账授权
			$pay_notify = new pay_notify();
			$pay_notify->log_dc = $this->log_dc;
			$pay_notify->pay_dc = $this->pay_dc;
			$pay_notify->aaa_dc = $this->aaa_dc;
			$pay_notify->type = 'alipay';
			$pay_notify->log_module = $this->log_module;

			$result = $pay_notify->notify_process($_POST);

			if ($result == true)
			{
				echo 'SUCCESS';
			}
			else
			{
				nl_log_v2_info($this->log_module, '支付宝支付交易失败，订单号：' . $_POST['out_trade_no']);
			}
			nl_log_v2_info($this->log_module,'回调成功,支付宝支付回调流程结束');
		}
		else if ($_POST['trade_status'] == 'WAIT_BUYER_PAY')
		{
			$redis = $this->aaa_dc->aaa_redis(NL_REDIS_WRITE);
			$result = $redis->setex($_POST['out_trade_no'], ORDER_STATUS_BUFF_TIME, TRADE_PROCESS);
			nl_log_v2_info(__FUNCTION__, '支付宝交易中，订单号：' . $_POST['out_trade_no'] . '设置订单状态结果为：' . var_export($result, true));
			return false;
		}
		else
		{
			// 更新订单状态
			$redis = $this->aaa_dc->aaa_redis(NL_REDIS_WRITE);
			$result = $redis->setex($_POST['out_trade_no'], ORDER_STATUS_BUFF_TIME, TRADE_FAIL);
			nl_log_v2_info(__FUNCTION__, '支付宝交易失败，订单号：' . $_POST['out_trade_no'] . '设置订单状态结果为：' . var_export($result, true));

			// 添加DB日志
			$log_arr['status'] = 1;
			$log_arr['desc'] = '通知返回的是FAIL';
			k13_common::add_pay_log($this->log_dc, $log_arr);
			nl_log_v2_error($this->log_module, "异步通知错误信息:" . var_export($_POST, true));
			return false;
		}
	}

}