<?php
/*
 * 支付宝结果处理父类，包括通用错误码，返回结果解析等
 */
include_once "alipay_core.function.php";//返回结果统一封装

abstract class nl_alipay_response_v2
{
    protected $api_name = '';

    const BUSSINESS_SUCCESS_CODE       = 10000;
    const FAILD_GENRATE_BIZ_CONTENT    = 30001;
    const FAILD_VALIDATE_CLIENT_PARAMS = 30002;
    const FAILD_PARSE_RESPONSE         = 30003;
    const BUSSINESS_FAILD_CODE         = 40004;

    //支付宝公共状态码
    protected static $public_codes = array(
        10000 => '接口调用成功',
        20000 => '服务不可用',
        20001 => '授权权限不足',
        40001 => '缺少必选参数',
        40002 => '非法的参数',
        40003 => '签名错误',
        40004 => '业务处理失败',
        40006 => '权限不足',
    );

    protected static $public_subcodes = array(
        20000 => array(
            'isp.unknow-error' => '服务暂不可用（业务系统不可用）',
            'aop.unknow-error' => '服务暂不可用（网关自身的未知错误）',
        ),
        20001 => array(
            'aop.invalid-auth-token'            => '无效的访问令牌',
            'aop.auth-token-time-out'           => '访问令牌已过期',
            'aop.invalid-app-auth-token'        => '无效的应用授权令牌',
            'aop.invalid-app-auth-token-no-api' => '商户未授权当前接口',
            'aop.app-auth-token-time-out'       => '应用授权令牌已过期',
            'aop.no-product-reg-by-partner'     => '商户未签约任何产品',
        ),
        40001 => array(
            'isv.missing-method'         => '缺少方法名参数',
            'isv.missing-signature'      => '缺少签名参数',
            'isv.missing-signature-type' => '缺少签名类型参数',
            'isv.missing-signature-key'  => '缺少签名配置',
            'isv.missing-app-id'         => '缺少appId参数',
            'isv.missing-timestamp'      => '缺少时间戳参数',
            'isv.missing-version'        => '缺少版本参数',
            'isv.decryption-error-missing-encrypt-type' => '解密出错, 未指定加密算法',
        ),
        40002 => array(
            'isv.invalid-parameter'        => '参数无效',
            'isv.upload-fail'              => '文件上传失败',
            'isv.invalid-file-extension'   => '文件扩展名无效',
            'isv.invalid-file-size'        => '文件大小无效',
            'isv.invalid-method'           => '不存在的方法名',
            'isv.invalid-format'           => '无效的数据格式',
            'isv.invalid-signature-type'   => '无效的签名类型',
            'isv.invalid-signature'        => '无效签名',
            'isv.invalid-encrypt-type'     => '无效的加密类型',
            'isv.invalid-encrypt'          => '解密异常',
            'isv.invalid-app-id'           => '无效的appId参数',
            'isv.invalid-timestamp'        => '非法的时间戳参数',
            'isv.invalid-charset'          => '字符集错误',
            'isv.invalid-digest'           => '摘要错误',
            'isv.decryption-error-unknown' => '解密出错, 未知异常',
            'isv.missing-signature-config' => '验签出错, 未配置对应签名算法的公钥或者证书',
            'isv.not-support-app-auth'     => '本接口不支持第三方代理调用',
            'isv.decryption-error-not-valid-encrypt-type' => '解密出错, 不支持的加密算法',
            'isv.decryption-error-not-valid-encrypt-key'  => '解密出错, 未配置加密密钥或加密密钥格式错误',
        ),
        40006 => array(
            'isv.insufficient-isv-permissions'  => 'ISV权限不足',
            'isv.insufficient-user-permissions' => '用户权限不足',
        ),
    );

    //抽象函数，子类必须重写，每个子类实现对应的返回结果解析，并封装结果输出
    abstract public function parse($alipay_result);

    //用请求对象的api_name设置响应的api_name
    public function set_api_name($api_name)
    {
        $this->api_name = $api_name;
    }

    public function get_msg_by_code($code, $subcode=null)
    {
        return array_key_exists($code, self::$public_codes) ?
            sprintf("%s%s", self::$public_codes[$code],
                self::get_msg_by_subcode($code, $subcode, ':')):
            '';
    }

    public function get_msg_by_subcode($code, $subcode, $prefix='')
    {
        return (!empty($code)
            && array_key_exists($code, self::$public_subcodes)
            && !empty($subcode)
            && array_key_exists($subcode, self::$public_subcodes[$code])) ?
            $prefix.self::$public_subcodes[$code][$subcode] :
            '';
    }
}