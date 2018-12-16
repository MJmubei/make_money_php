<?php
/**
 * Created by PhpStorm.
 * Use : 微信公众号基础类
 * User: kan.yang@starcor.com
 * Date: 18-12-15
 * Time: 下午4:40
 */

class logic_wechat_accounts_base extends em_logic
{

    //数据表名称
    public $str_base_table = 'system_wechat_accounts';

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
        'cms_account_id' => array(
            'type' => 'char',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '微信公众号ID',
        ),
        'cms_account_name' => array(
            'type' => 'char',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '微信公众号名称',
        ),
        'cms_add_auto_reply' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-512',
            'desc' => '添加自动回复内容。如：用户关注此微信公众号时，将收到的一条回复内容',
        ),
        'cms_search_auto_reply' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-512',
            'desc' => '搜索自动回复,是一个json字符串{type:’消息类型’,content:’内容’},type表示消息类型text，news，voice如果是text则为text内容，如果是多媒体则为消息id',
        ),
        'cms_auto_reply' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-512',
            'desc' => '消息自动回复内容',
        ),
        'cms_token' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '公众号Token',
        ),
        'cms_app_id' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '微信公众号APP ID',
        ),
        'cms_app_secret' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-32',
            'desc' => '微信公众号APP密钥',
        ),
        'cms_access_token' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => '微信公众号APP访问Token',
        ),
        'cms_start_m_server_begin_keyword' => array(
            'type' => 'char',
            'isempty' => '',
            'length' => '0-8',
            'desc' => '触发搜索配起始关键词',
        ),
        'cms_search_more_img' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-128',
            'desc' => '‘更多’的标签图片地址',
        ),
        'cms_ad_img' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-128',
            'desc' => '广告图片',
        ),
        'cms_start_search_vod_begin_keyword' => array(
            'type' => 'char',
            'isempty' => '',
            'length' => '0-8',
            'desc' => '触发多客服开头关键词',
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
        'cms_access_token_create_time' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => '访问Token码生成时间',
        ),
        'cms_jsapi_ticket' => array(
            'type' => 'varchar',
            'isempty' => '',
            'length' => '0-256',
            'desc' => 'JsApi Ticket',
        ),
        'cms_jsapi_ticket_create_time' => array(
            'type' => 'datetime',
            'isempty' => '',
            'length' => '',
            'desc' => 'JsApi Ticket生成时间',
        ),
        'cms_status' => array(
            'type' => 'tinyint',
            'isempty' => '',
            'length' => '1',
            'desc' => '微信公众号状态，默认0：0开启；1禁止',
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