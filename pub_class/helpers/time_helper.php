<?php
/**
  *
  * Use：时间处理类
  * Author：kan.yang@starcor.cn
  * DateTime：18-12-15 下午3:30
  * Description：
  *
  *=====================================================================================================================
*/

/**
 * 读取毫秒，整数
 */
function system_millisecond()
{
    list ( $usec, $sec ) = explode ( ' ', microtime () );
    return intval( substr ( $usec, 2, 3 ) );
}

/**
 * 读取毫秒，以秒为单位的整数
 */
function system_millisecond_f()
{
    return microtime(TRUE);
}

/**
 * 代码测时
 */
function system_runtime( $is_end )
{
    static $t = 0.0;
    if( $is_end )
    {
        return system_millisecond_f() - $t;
    }
    else
    {
        $t = system_millisecond_f();
        return 0.0;
    }
}

/**
 * 从ISO时间转到GMT时间
 */
function system_time_from_iso($iso_time)
{
    if( empty( $iso_time) )
        return -1;

    if( strlen( $iso_time ) < 15 )
        return -1;

    $time_year = substr( $iso_time, 0, 4 );
    $time_mon = substr( $iso_time, 4, 2 );
    $time_day = substr( $iso_time, 6, 2 );
    $time_hour = substr( $iso_time, 9, 2 );
    $time_min = substr( $iso_time, 11, 2 );
    $time_sec = substr( $iso_time, 13, 2 );

    //直接是认为这是ＧＭＴ时间，转的，理论上，这个需要检查最后的参数，确定时区，再进行操作.
    return gmmktime(   $time_hour, $time_min, $time_sec ,$time_mon, $time_day, $time_year );
}

/**
 * 生成时间随机数字GUID
 */
function system_millitime_rand($num = 16)
{
    if (empty($num) || $num<16)
    {
        $num=16;
    }
    $millisecond=round(system_millisecond_f()*1000);
    $random_max='999';
    for ($i=0;$i<$num-16;$i++){
        $random_max .='9';
    }
    $random=rand(0,(int)$random_max);

    $random=sprintf("%0".($num-13)."d", $random);

    return  $millisecond.$random;
}