<?php

/**
 * Curl处理类
 */
class np_http_curl_class
{

	public $callback = false;
	public $ch=null;
	public $curl_getinfo;
	public $curl_error;
	public $headers = null;
    public $response_header = 0;

    /**
     * 默认构造函数
     */
    public function __construct()
    {
    	$this->ch = curl_init();
    }

    /**
     * file_get_contents/curl（支持IPV4/IPV6）
     */
    function file_contents_http_request($filename, $use_include_path = false, $context = null, $offset = null, $maxlen = null)
    {
        $params_count = func_num_args();
        if($params_count < 1)
        {
            return false;
        }

        $type = $this->judge_url_type_support_ipv6($filename);
        $result = false;
        if($type == 1)
        {
            switch($params_count)
            {
                case 1:
                    $result = file_get_contents($filename);
                    break;
                case 2:
                    $result = file_get_contents($filename, $use_include_path);
                    break;
                case 3:
                    $result = file_get_contents($filename, $use_include_path, $context);
                    break;
                case 4:
                    $result = file_get_contents($filename, $use_include_path, $context, $offset);
                    break;
                case 5:
                    $result = file_get_contents($filename, $use_include_path, $context, $offset, $maxlen);
                    break;
            }
        }
        else
        {
            switch($params_count)
            {
                case 1:
                case 2:
                    $result = $this->get($filename);
                    break;
                case 3:
                case 4:
                case 5:
                    if(!is_null($context))
                    {
                        $options = $this->parse_stream_data_support_ipv6($context);
                        if(is_array($options) && count($options) > 0)
                        {
                            if($options['method'] == 'get')
                            {
                                $result = $this->get($filename, $options['header'], $options['timeout']);
                            }
                            else if($options['method'] == 'post')
                            {
                                $result = $this->post($filename, $options['content'], $options['header'], $options['timeout']);
                            }
                        }
                    }
                    else
                    {
                        $result = $this->get($filename);
                    }
                    break;
            }
        }
        return $result;
    }


    /**
     * GET请求方式（支持IPV4）
     * @param string $url          请求地址
     * @param array  $header       HTTP头信息
     * @param bool   $close_curl   是否关闭curl链接
     * @param int    $int_timeout  超时时间，默认30s
     * @return bool|mixed
     */
	public function get($url, $header = null,$int_timeout = 30,$close_curl = true)
    {
		return $this->do_request('get', $url, null, $header, $int_timeout, $close_curl);
	}

    /**
     * POST请求方式（支持IPV4）
     * @param string $url          请求地址
     * @param string $vars         POST体
     * @param array  $header       HTTP头信息
     * @param bool   $close_curl   是否关闭curl链接
     * @param int    $int_timeout  超时时间，默认30s
     * @return bool|mixed
     */
	public function post($url, $vars,$header = null,$int_timeout = 30,$close_curl = true)
    {
		return $this->do_request('post', $url, $vars ,$header,$int_timeout,$close_curl);
	}

    /**
     * 回调函数（没什么用）
     */
    public function set_callback($func_name)
    {
        $this->callback = $func_name;
    }

    /**
     * HTTP请求信息
     */
    public function curl_get_info()
    {
        return $this->curl_getinfo;
    }

    /**
     * HTTP错误信息
     */
    public function curl_error()
    {
        return $this->curl_error;
    }

	/**
	 * 手动关闭连接
	 */
	public function close_curl()
	{
		if($this->ch)
		{
			curl_close ( $this->ch );
			$this->ch = NULL;
		}
	}

    /**
     * 释放资源
     */
    public function __destruct()
	{
		if($this->ch)
		{
			curl_close ( $this->ch );
			$this->ch = NULL;
		}
	}

    /**
     * REQUEST请求
     * @param string $method       HTTP类型。get | post
     * @param string $url          请求地址
     * @param string $vars         POST体
     * @param array  $header       HTTP头信息
     * @param bool   $close_curl   是否关闭curl链接
     * @param int    $int_timeout  超时时间，默认30s
     * @return bool|mixed
     */
    private function do_request($method, $url, $vars,$header,$int_timeout,$close_curl)
    {
        if( $this->ch==null )
        {
            return false;
        }
        if($method != 'get' && $method != 'post')
        {
            return false;
        }
        if( $url=='' || $url ==null )
        {
            return false;
        }

        //关闭认证
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        //请求数据
        curl_setopt ( $this->ch, CURLOPT_URL, $url );
        if($this->headers)
        {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        }
        if (is_array($header))
        {

            curl_setopt (  $this->ch, CURLOPT_HTTPHEADER,$header);
        }

        //连接超时的配置
        if(!empty($int_timeout))
        {
            curl_setopt($this->ch, CURLOPT_TIMEOUT,$int_timeout);
        }

        if ($method == 'post')
        {
            curl_setopt ( $this->ch, CURLOPT_POST, 1 );
            curl_setopt ( $this->ch, CURLOPT_POSTFIELDS, $vars );
        }
        curl_setopt ( $this->ch, CURLOPT_HEADER, $this->response_header );
        //文件流的方式输出数据
        curl_setopt ( $this->ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $this->ch, CURLOPT_FOLLOWLOCATION, 1 );

        $data = curl_exec ( $this->ch );
        if(false !== $data)
        {
            $this->curl_getinfo = curl_getinfo($this->ch);
        }
        else
        {
            $this->curl_error = curl_error($this->ch);
        }

        if($close_curl === true)
        {
            curl_close ( $this->ch );
            $this->ch = NULL;
        }

        if ($this->callback)
        {
            $callback = $this->callback;
            $this->callback = false;
            return call_user_func ( $callback, $data );
        }
        else
        {
            return $data;
        }
    }

    /**
     * 判断传入的文件类型
     */
    private function judge_url_type_support_ipv6($filename)
    {
        if(strpos($filename, "http://") === false && strpos($filename, "https://") === false)
        {
            return 1;
        }
        return 3;
    }

    /**
     * 解析file_get_contents第三个参数,stream
     * 将资源类型的stream还原为基础类型变量
     */
    private function parse_stream_data_support_ipv6($stream)
    {
        if(!is_resource($stream))
        {
            return false;
        }
        $params = stream_context_get_params($stream);
        if(!isset($params['options']))
        {
            return false;
        }
        $params = $params['options'];
        $options = array();
        foreach($params as $type => $value)
        {
            if(strtolower($type) == 'http')
            {
                if(is_array($value))
                {
                    //获取请求方式,get还是post
                    if(isset($value['method']))
                    {
                        $options['method'] = strtolower($value['method']);
                    }
                    if(isset($value['METHOD']))
                    {
                        $options['method'] = strtolower($value['METHOD']);
                    }
                    $options['method'] = isset($options['method']) ? $options['method'] : 'get';

                    //获取超时时间设置
                    $options['timeout'] = isset($value['timeout']) ? intval($value['timeout']) : 5;

                    //获取请求的内容参数
                    if(isset($value['content']))
                    {
                        $options['content'] = $value['content'];
                    }
                    else
                    {
                        $options['content'] = null;
                    }

                    //获取请求头
                    if(isset($value['header']))
                    {
                        if(is_array($value['header']))
                        {
                            $options['header'] = $value['header'];
                        }
                        else
                        {
                            $headers = explode("\r\n", $value['header']);
                            foreach($headers as $map => $header)
                            {
                                if(strlen($header) == 0)
                                {
                                    unset($headers[$map]);
                                    continue;
                                }
                                $headers[$map] = trim($header);
                            }
                            unset($header);
                            $options['header'] = $headers;
                        }
                    }
                    else
                    {
                        $options['header'] = array();
                    }
                }
            }
        }
        return $options;
    }


}
