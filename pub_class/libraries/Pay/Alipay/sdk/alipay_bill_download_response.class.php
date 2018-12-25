<?php
/**
 * 支付宝对账回调处理，包括解析支付宝对账返回结果，根据返回url获取文件等
 * @author:  kang.lu
 * @date:    2017-03-10
 */

class nl_alipay_bill_download_response extends nl_alipay_response_v2
{
    //对账相关业务状态
    protected $business_code = array(
        'ISP.INVAILID_ARGUMENTS' => '入参不合法',
        'ISP.BILL_NOT_EXIST' => '账单不存在',
        'ISP.UNKNOWN_ERROR' => '未知错误',
    );

    //支付宝对账返回结果解析
    public function parse($alipay_result)
    {
        $responseNode = str_replace(".", "_", $this->api_name) . "_response";
        $result_code = $alipay_result->$responseNode->code;
        if(!empty($result_code) && ($result_code == 10000))
        {
            //成功
            $ret_data = array(
                'bill_download_url' => $alipay_result->$responseNode->bill_download_url,
            );
            return format_return(true, $result_code, $this->get_msg_by_code($result_code), $ret_data);
        }

        $sub_code = $alipay_result->$responseNode->sub_code;
        if($result_code == self::BUSSINESS_FAILD_CODE)
        {
            //业务失败
            return format_return(false, $result_code, $this->get_buss_msg($result_code, $sub_code), array());
        }

        //通用失败
        return format_return(false, $result_code, $this->get_msg_by_subcode($result_code, $sub_code), array());
    }

    private function get_buss_msg($code, $sub_code, $prefix='')
    {
        $sub_code = strtoupper($sub_code);
        return (($code == self::BUSSINESS_FAILD_CODE)
            && (array_key_exists($sub_code, $this->business_code))) ?
            $prefix.$this->business_code[$sub_code] :
            '';
    }
}