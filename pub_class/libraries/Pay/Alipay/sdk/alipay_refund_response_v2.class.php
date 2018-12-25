<?php
/**
 * 处理支付宝退款返回
 *
 * @useage:
 * [useage]
 *
 * @author:  tom.chen <ziwei.chen@starcor.cn>
 * @date:    2017-02-15 18:45:48
 */
class nl_alipay_refund_response_v2 extends nl_alipay_response_v2
{
    //退款相关业务状态
    protected  $bussiness_code   = array(
        'ACQ.SYSTEM_ERROR'                => '系统错误',
        'ACQ.INVALID_PARAMETER'           => '参数无效',
        'ACQ.SELLER_BALANCE_NOT_ENOUGH'   => '卖家余额不足',
        'ACQ.REFUND_AMT_NOT_EQUAL_TOTAL'  => '退款金额超限',
        'ACQ.REASON_TRADE_BEEN_FREEZEN'   => '请求退款的交易被冻结',
        'ACQ.TRADE_NOT_EXIST'             => '交易不存在',
        'ACQ.TRADE_HAS_FINISHED'          => '交易已完结',
        'ACQ.TRADE_STATUS_ERROR'          => '交易状态非法',
        'ACQ.DISCORDANT_REPEAT_REQUEST'   => '不一致的请求',
        'ACQ.REASON_TRADE_REFUND_FEE_ERR' => '退款金额无效',
        'ACQ.TRADE_NOT_ALLOW_REFUND'      => '当前交易不允许退款',
    );

    protected  $default_response = array(
        'code'     => 10000,
        'msg'      => '',
        'data'     => array(),
    );

    protected  $default_response_data = array(
        'out_trade_no'         => '',
        'fund_channel'         => '',
        'refund_pay_timestamp' => '',
        'refund_amount'        => 0,
        'refund_fee'           => 0,
        'refund_real_amount'   => 0,
        'trade_no'             => '',
    );

    public  function error($code, $msg=null)
    {
        $response         = self::$default_response;
        $response['code'] = $code;
        $response['msg']  = $msg;
        return array(false, $response);
    }

    public function parse($response)
    {
        $request_name = str_replace(".", "_", $this->api_name)."_response";
        // $response = json_decode($response, true);
        if (!is_object($response) || !isset($request_name, $response))
        {
            $response         = self::$default_response;
            $response['code'] = self::FAILD_PARSE_RESPONSE;
            $response['msg']  = '解析返回数据出错。';
            return array(false, $response);
        }

        $request_response = $response->$request_name;
        $return_response  = self::$default_response;
        $return_state     = false;

        switch (intval($request_response->code)) {
            case self::BUSSINESS_SUCCESS_CODE:
                $return_response['code']      = self::BUSSINESS_SUCCESS_CODE;
                $return_response['msg']       = $request_response->msg;
                $data                         = self::$default_response_data;
                $data['out_trade_no']         = $request_response->out_trade_no;
                $data['fund_channel']         = $request_response->refund_detail_item_list[0]['fund_channel'];
                $data['refund_pay_timestamp'] = $request_response->gmt_refund_pay;
                $data['refund_amount']        = $request_response->refund_detail_item_list[0]['amount'];
                $data['refund_fee']           = $request_response->refund_fee;
                $data['refund_real_amount']   = $request_response->refund_detail_item_list;
                $data['trade_no']             = $request_response->trade_no;
                $return_response['data']      = $data;
                $return_state                 = true;
                break;
            case self::BUSSINESS_FAILD_CODE:
                $return_response['code'] = self::BUSSINESS_SUCCESS_CODE;
                $return_response['msg']  = '业务处理失败:'.self::get_msg_by_bussiness_code(
                                                strtoupper($request_response->sub_code)
                                            );
                break;
            default:
                $return_response['code'] = $request_response->code;
                $return_response['msg']  = nl_alipay_public_code::get_msg_by_code(
                                            $request_response->code, $request_response->sub_code
                                        );
                break;
        }

        return array($return_state, $return_response);
    }

    protected function get_msg_by_bussiness_code($code)
    {
        return array_key_exists($code, self::$bussiness_code) ? self::$bussiness_code[$code] : '未知业务错误';
    }
}
