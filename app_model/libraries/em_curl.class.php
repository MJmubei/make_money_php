<?php
class em_curl
{
	public $callback = false;
	public $ch = null;
	public $curl_getinfo;
	public $curl_error;
	public $headers = null;
	public $response_header = 0; //响应头输出到返回数据中
	public $arr_params = null;

	public function __construct($params = null)
	{
		$this->ch = curl_init();
		$this->arr_params = $params;
	}

	/**
	 * 设置回调函数,在类初始化以后可以调用本方法设置回调函数
	 * @param $func_name 回调函数名
	 *
	 */
	public function set_callback($func_name)
	{
		$this->callback = $func_name;
	}

	/**
	 * czy 2014-07-05 函数说明，入参，返回值
	 */
	/**
	 * @param $method string get or post
	 * @param $url url地址字符串
	 * @param $vars post参数数组
	 * @param $header http 头参数数组
	 * @param $time_limit 设置超时,单位：秒
	 */
	public function do_request($method, $url, $vars = null, $header = null, $time_limit = 0)
	{
		if ($this->ch == null)
		{
			return false;
		}
		if ($method != 'get' && $method != 'post')
		{
			return false;
		}
		if ($url == '' || $url == null)
		{
			return false;
		}
		//关闭认证
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		//请求数据
		curl_setopt($this->ch, CURLOPT_URL, $url);
		//HTTP 请求头，没看懂这个headers哪里会来给值，是不是因为是public，不知道的地方来给值了？
		//需要全代码清查
		if ($this->headers)
		{
			curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
		}
		if (is_array($header))
		{
			
			curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
		}
		
		//连接超时的配置
		if (!empty($time_limit))
		{
			curl_setopt($this->ch, CURLOPT_TIMEOUT, $time_limit);
		}
		
		///czy 2014-07-05 POST模式
		if ($method == 'post')
		{
			curl_setopt($this->ch, CURLOPT_POST, 1);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $vars);
		}
		
		//czy 2014-07-05 输出定义，理论上这个参数外传更为方便，否则哪个人需要外传了，结果接口不支持。
		curl_setopt($this->ch, CURLOPT_HEADER, $this->response_header);
		//文件流的方式输出数据
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		
		$data = curl_exec($this->ch);
		if (false !== $data)
		{
			$this->curl_getinfo = curl_getinfo($this->ch);
		}
		else
		{
			$this->curl_error = curl_error($this->ch);
		}
		
		curl_close($this->ch);
		//czy 2014-07-05 如果调用了关闭，养成习惯，把东西弄成NULL
		$this->ch = NULL;
		
		if ($this->callback)
		{
			$callback = $this->callback;
			$this->callback = false;
			return call_user_func($callback, $data);
		}
		else
		{
			return $data;
		}
	}

	public function curl_getinfo()
	{
		return $this->curl_getinfo;
	}

	public function curl_error()
	{
		return $this->curl_error;
	}

	/**
	 * http get请求方式
	 * @param $url 请求url地址串
	 */
	public function get($url, $vars = null, $header = null, $time_limit = 0)
	{
		return $this->do_request('get', $url, $vars, $header, $time_limit);
	}

	/**
	 * http post请求方式
	 * @param $url 请求url地址串
	 * @param $vars  POST参数数组
	 */
	public function post($url, $vars, $header = null, $time_limit = 0)
	{
		return $this->do_request('post', $url, $vars, $header, $time_limit);
	}
}