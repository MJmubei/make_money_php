<?php
/**
 * Created by PhpStorm.
 * Use : 支付渠道支付模式
 * User: kan.yang@starcor.com
 * Date: 18-12-15
 * Time: 下午4:00
 */

class logic_channel_mode_base extends em_logic
{

    //数据表名称
    public $str_base_table = 'system_channel_mode';

    //基本表定义参数用于排除非法字段，验证字段
    public $table_define = array(
        'cms_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-11',
            'desc' => '订单id',
        ),
        'cms_user_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-10',
            'desc' => '用户ID',
        ),
        'cms_channel_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-11',
            'desc' => '支付渠道ID',
        ),
        'cms_pay_mode_name' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-128',
            'desc' => '支付方式名称',
        ),
        'cms_pay_appid' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-64',
            'desc' => '支付平台：APP ID',
        ),
        'cms_pay_partner_key' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-64',
            'desc' => '支付平台：商户KEY',
        ),
        'cms_pay_partner_id' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-128',
            'desc' => '支付平台：商户ID',
        ),
        'cms_pay_partner' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '支付平台：商户名称',
        ),
        'cms_qr_expire_time' => array(
            'type' => '11',
            'isempty' => '',
            'length' => '0-11',
            'desc' => '二维码过期时间',
        ),
        'cms_sign_type' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '1',
            'desc' => '签名方式（支付宝），默认2。1：RSA1；2：RSA2（SHA256）',
        ),
        'cms_apiclient_cert' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '密钥证书路径（微信）：apiclient_cert',
        ),
        'cms_apiclient_key' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '密钥证书路径（微信）：apiclient_key',
        ),
        'cms_public_key' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '密钥证书路径-公钥（支付宝）：public_key',
        ),
        'cms_private_key' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '密钥证书路径-私钥（支付宝）：private_key',
        ),
        'cms_notify_url' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '支付异步通知地址',
        ),
        'cms_error_notify_url' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '异步错误通知地址',
        ),
        'cms_desc' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '支付方式描述',
        ),
        'cms_create_time' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '创建时间',
        ),
        'cms_modify_time' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '',
            'desc' => '修改时间',
        ),
        'cms_uuid' => array(
            'type' => 'char',
            'isempty' => '',
            'length' => '32',
            'desc' => 'GUUID，外部标识',
        ),
        'cms_status' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '1',
            'desc' => '支付方式状态，默认0：0开启；1禁止',
        ),
    );

    /**
     * 默认构造函数
     */
    public function __construct($obj_controller,$arr_params = null)
    {
        //初始化父级构造函数
        parent::__construct($obj_controller,$this->str_base_table,$arr_params);
    }

} 