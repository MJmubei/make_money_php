<?php
/**
 * Created by PhpStorm.
 * Use : 购买订单基础类
 * User: kan.yang@starcor.com
 * Date: 18-12-13
 * Time: 下午7:36
 */

class logic_order_buy_base extends em_logic
{

    //数据表名称
    public $str_base_table = 'system_buy_order';

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
        'cms_order_name' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-128',
            'desc' => '订单名称',
        ),
        'cms_order_price' => array(
            'type' => 'decimal',
            'isempty' => '',
            'length' => '',
            'desc' => '订单金额',
        ),
        'cms_order_type' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '1',
            'desc' => '订单类型。0批量订单；1面料小样；2样板订单；3样衣订单；4稀缺面料定金订单',
        ),
        'cms_order_state' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '1',
            'desc' => '订单状态。0未支付；1已支付；2已取消；3已过期；4退款中；5已退订；6订单异常',
        ),
        'cms_business_state' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '1',
            'desc' => '业务状态。0未完成；1完成',
        ),
        'cms_pay_order_id' => array(
            'type' => 'VARCHAR',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '支付订单号',
        ),
        'cms_pay_partner_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-11',
            'desc' => '支付商户',
        ),
        'cms_pay_channel_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-4',
            'desc' => '支付渠道。1微信支付；2支付宝支付',
        ),
        'cms_pay_mode_id' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '0-4',
            'desc' => '支付方式。10微信二维码；20支付宝二维码',
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
        'cms_refund_time' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '',
            'desc' => '退订时间',
        ),
        'cms_refund_money' => array(
            'type' => 'decimal',
            'isempty' => '',
            'length' => '',
            'desc' => '退订金额',
        ),
        'cms_refund_state' => array(
            'type' => 'int',
            'isempty' => '',
            'length' => '1',
            'desc' => '退订状态。0部分退款；1全额退款',
        ),
        'cms_uuid' => array(
            'type' => 'char',
            'isempty' => '',
            'length' => '32',
            'desc' => 'GUUID，外部标识',
        ),
        'nns_order_data' => array(
            'type' => 'text',
            'isempty' => '',
            'length' => '',
            'desc' => '订单数据，以JSON格式存储',
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