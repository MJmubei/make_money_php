<?php
/*
 * GUID生成
 */
class em_System
{

    static function currentTimeMillis()
    {
        list ($usec, $sec) = explode(" ", microtime());
        return $sec . substr($usec, 2, 3);
    }
}

class em_NetAddress
{

    var $Name = 'localhost';

    var $IP = '127.0.0.1';

    static function getLocalHost() // static
    {
        $address = new em_NetAddress();
        $address->Name = isset($_ENV["COMPUTERNAME"]) ? $_ENV["COMPUTERNAME"] : '';
        $address->IP = $_SERVER["SERVER_ADDR"];
        return $address;
    }

    function toString()
    {
        return strtolower($this->Name . '/' . $this->IP);
    }
}
// 三段
// 一段是微秒 一段是地址 一段是随机数
class em_guid
{
    static function em_guid_rand( $something = "rand" )
    {
    	$result = dechex(  time() );
    	$result = $result.dechex( self::em_millisecond() );
    
    	$a = "";
    	if( isset( $_ENV ["COMPUTERNAME"] ) )
    		$a .= $_ENV ["COMPUTERNAME"];
    	if( isset( $_SERVER ["SERVER_ADDR"] ) )
    		$a .= $_SERVER ["SERVER_ADDR"];
    	if( isset( $_SERVER ["REMOTE_ADDR"] ) )
    		$a .= $_SERVER ["REMOTE_ADDR"];
    
    	//echo $a;
    
    	$a = $a.rand(0,10000);
    	$a = $a.rand(0,10000);
    	$a = $a.rand(0,10000);
        $a = $a.microtime ();
    
    
    	$result = $result.md5( $a.$something );
    	return substr( $result, 0, 32 );
    }
    
    static function em_millisecond()
    {
        list ( $usec, $sec ) = explode ( ' ', microtime () );
        return intval( substr ( $usec, 2, 3 ) );
    }
}