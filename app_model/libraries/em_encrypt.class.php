<?php
/**
 * 加解密
 * @author pan.liang
 */
class em_encrypt
{
    private $securekey='';
	private $iv;
	private $MCRYPT_RIJNDAEL;
	private $MCRYPT_MODE;
	public $obj_controller = null;

	function __construct($obj_controller,$textkey=null,$MCRYPT_RIJNDAEL=MCRYPT_RIJNDAEL_128,$MCRYPT_MODE=MCRYPT_MODE_ECB)
	{
	    $this->obj_controller = $obj_controller;
		$this->securekey = (strlen($textkey) <1) ? '8888888888888888' : $textkey;
		$this->iv = mcrypt_create_iv(32,MCRYPT_DEV_URANDOM);
		$this->MCRYPT_RIJNDAEL=$MCRYPT_RIJNDAEL;
		$this->MCRYPT_MODE = $MCRYPT_MODE;
		em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"begin---{{{公共-加解密类开始;加载文件:[".__FILE__."]}}}---begin",'message','info');
	}
	
	/**
	 * UnPKCS7Padding
	 * @param unknown $str
	 */
	private function UnPKCS7Padding($str) 
	{
		$block=mcrypt_get_block_size($this->MCRYPT_RIJNDAEL,$this->MCRYPT_MODE);
		$char=substr($str,-1,1);
		$num=ord($char);
		if($num>8) {
			return $str;
		}
		$len=strlen($str);
		for($i=$len-1;$i>=$len-$num;$i--) {
			if(ord(substr($str,$i,1))!=$num) {
				return $str;
			}
		}
		$str=substr($str,0,-$num);
		return $str;
	}
	
	/**
	 * PKCS7Padding
	 * @param unknown $str
	 */
	public function PKCS7Padding($str)
	{
		$block=mcrypt_get_block_size($this->MCRYPT_RIJNDAEL,$this->MCRYPT_MODE);
		$pad=$block-(strlen($str)%$block);
		if($pad<=$block)
		{
			$char=chr($pad);
			$str.=str_repeat($char,$pad);
		}
		return $str;
	}
	
	/**
	 * 字符串转为二进制
	 * @param unknown $str
	 */
    public function StrToBin($str)
    {
        //1.列出每个字符
        $arr = preg_split('/(?<!^)(?!$)/u', $str);
        //2.unpack字符
        foreach($arr as &$v)
        {
            $temp = unpack('H*', $v);
            $v = base_convert($temp[1], 16, 2);
            unset($temp);
        }
        return join(' ',$arr);
    }
	
    /**
     * 二进制流转为字符串
     * @param unknown $str
     */
    public function BinToStr($str)
    {
        $arr = explode(' ', $str);
        foreach($arr as &$v)
        {
            $v = pack("H".strlen(base_convert($v, 2, 16)), base_convert($v, 2, 16));
        }
        return join('', $arr);
    }
    
	/**
	 * 加密
	 * @param unknown $input
	 * @return string
	 */
	public function encrypt($input)
	{
		$input = $this->PKCS7Padding($input);
		return base64_encode(mcrypt_encrypt($this->MCRYPT_RIJNDAEL, $this->securekey, $input, $this->MCRYPT_MODE, $this->iv));
	}

	/**
	 * 解密
	 * @param unknown $input
	 * @return string
	 */
	function decrypt($input)
	{
	    return trim(mcrypt_decrypt($this->MCRYPT_RIJNDAEL, $this->securekey, base64_decode($input), $this->MCRYPT_MODE, $this->iv));
	}
	
	public function __destruct()
	{
	    em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"begin---{{{公共-加解密操作类结束}}}---begin",'message','info');
	    unset($this->obj_controller);
	}
}