<?php
/**
 * Created by PhpStorm.
 * Use : 商户、支付渠道、支付方式业务逻辑
 * User: kan.yang@starcor.com
 * Date: 18-12-22
 * Time: 下午1:07
 */

class c_channel extends CI_Controller
{

    //项目基路径
    private $str_base_path    = '';
    //商户
    private $obj_partner_logic= null;
    //支付渠道
    private $obj_channel_logic= null;
    //支付方式
    private $obj_channel_mode_logic = null;

    /**
     * 默认构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->str_base_path = dirname(dirname(dirname(dirname(__DIR__))));
        $this->_init();
    }

/*==================================================== 商户管理 开始 ===================================================*/

    /**
     * 查询商户列表
     */
    public function list_partner()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_user_id'=> array(
                'rule'   => 'notnull',
                'reason' => '用户非法'
            ),
        ),$this->arr_params);

        $arr_partner_list = $this->obj_partner_logic->get_list($this->arr_params,'*');
        $this->load_view_file($arr_partner_list,__LINE__);
    }

    /**
     * 查询商户详情
     */
    public function item_partner()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_id'=> array(
                'rule'   => 'notnull',
                'reason' => '商户非法'
            ),
        ),$this->arr_params);

        $arr_partner_list = $this->obj_partner_logic->get_one($this->arr_params,'*');
        $this->load_view_file($arr_partner_list,__LINE__);
    }

    /**
     * 添加商户
     */
    public function add_partner()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_name'=> array(
                'rule'   => 'notnull',
                'reason' => '商户名称非法'
            ),
            'cms_user_id'=> array(
                'rule'   => 'notnull',
                'reason' => '用户非法'
            ),
        ),$this->arr_params);

        $arr_partner_add = $this->obj_partner_logic->add($this->arr_params);
        $this->load_view_file($arr_partner_add,__LINE__);
    }

    /**
     * 更新商户
     */
    public function edit_partner()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_id'=> array(
                'rule'   => 'notnull',
                'reason' => '商户非法'
            ),
            'cms_name'=> array(
                'rule'   => 'notnull',
                'reason' => '商户名称非法'
            ),
            'cms_user_id'=> array(
                'rule'   => 'notnull',
                'reason' => '用户非法'
            ),
        ),$this->arr_params);

        $arr_partner_edit = $this->obj_partner_logic->edit($this->arr_params['cms_id'],$this->arr_params);
        $this->load_view_file($arr_partner_edit,__LINE__);
    }

    /**
     * 删除商户
     */
    public function del_partner()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_id'=> array(
                'rule'   => 'notnull',
                'reason' => '商户非法'
            ),
        ),$this->arr_params);
        //校验商户是否绑定了支付渠道
        $arr_channel_count = $this->obj_channel_logic->get_one(array('nns_partner_id' => $this->arr_params['cms_id']),'count(1) total');
        if($arr_channel_count['ret'] != 0 || !empty($arr_channel_count['data_info']['total']))
        {
            $arr_partner_del = array('ret' => 1,'reason' => '错误:删除商户，请优先删除绑定的支付渠道');
        }
        else
        {
            $arr_partner_del = $this->obj_partner_logic->del($this->arr_params['cms_id']);
        }
        $this->load_view_file($arr_partner_del,__LINE__);
    }

/*==================================================== 商户管理 结束 ===================================================*/


/*==================================================== 支付渠道管理 开始 ================================================*/

    /**
     * 查询支付渠道列表
     */
    public function list_channel()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_user_id'=> array(
                'rule'   => 'notnull',
                'reason' => '用户非法'
            ),
            'nns_partner_id'=> array(
                'rule'   => 'notnull',
                'reason' => '商户非法'
            ),
        ),$this->arr_params);

        $arr_channel_list = $this->obj_channel_logic->get_list($this->arr_params,'*');
        $this->load_view_file($arr_channel_list,__LINE__);
    }

    /**
     * 查询支付渠道详情
     */
    public function item_channel()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付渠道非法'
            ),
        ),$this->arr_params);

        $arr_channel_info = $this->obj_channel_logic->get_one($this->arr_params,'*');
        $this->load_view_file($arr_channel_info,__LINE__);
    }

    /**
     * 添加支付渠道
     */
    public function add_channel()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_user_id'=> array(
                'rule'   => 'notnull',
                'reason' => '用户非法'
            ),
            'cms_name'=> array(
                'rule'   => 'notnull',
                'reason' => '支付渠道名称非法'
            ),
            'cms_platform_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付平台非法'
            ),
            'nns_partner_id'=> array(
                'rule'   => 'notnull',
                'reason' => '商户非法'
            ),
        ),$this->arr_params);

        $arr_channel_add = $this->obj_channel_logic->add($this->arr_params);
        $this->load_view_file($arr_channel_add,__LINE__);
    }

    /**
     * 更新支付渠道
     */
    public function edit_channel()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付渠道非法'
            ),
            'cms_user_id'=> array(
                'rule'   => 'notnull',
                'reason' => '用户非法'
            ),
            'cms_name'=> array(
                'rule'   => 'notnull',
                'reason' => '支付渠道名称非法'
            ),
            'cms_platform_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付平台非法'
            ),
            'nns_partner_id'=> array(
                'rule'   => 'notnull',
                'reason' => '商户非法'
            ),
        ),$this->arr_params);

        $arr_channel_edit = $this->obj_channel_logic->edit($this->arr_params['cms_id'],$this->arr_params);
        $this->load_view_file($arr_channel_edit,__LINE__);
    }

    /**
     * 删除支付渠道
     */
    public function del_channel()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付渠道非法'
            ),
        ),$this->arr_params);
        //校验商户是否绑定了支付渠道
        $arr_channel_mode_count = $this->obj_channel_mode_logic->del(array('cms_channel_id' => $this->arr_params['cms_id']),'count(1) total');
        if($arr_channel_mode_count['ret'] != 0 || !empty($arr_channel_mode_count['data_info']['total']))
        {
            $arr_mode_del = array('ret' => 1,'reason' => '错误:删除支付渠道，请优先删除绑定的支付方式');
        }
        else
        {
            $arr_mode_del = $this->obj_channel_logic->del($this->arr_params['cms_id']);
        }

        $this->load_view_file($arr_mode_del,__LINE__);
    }

/*==================================================== 支付渠道管理 结束 ================================================*/




/*==================================================== 支付方式管理 开始 ================================================*/

    /**
     * 查询支付方式列表
     */
    public function list_channel_mode()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_user_id'=> array(
                'rule'   => 'notnull',
                'reason' => '用户非法'
            ),
            'cms_channel_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付渠道非法'
            ),
        ),$this->arr_params);

        $arr_mode_list = $this->obj_channel_mode_logic->get_list($this->arr_params,'*');
        $this->load_view_file($arr_mode_list,__LINE__);
    }

    /**
     * 查询支付方式详情
     */
    public function item_channel_mode()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付方式非法'
            ),
        ),$this->arr_params);

        $arr_mode_info = $this->obj_channel_mode_logic->get_one($this->arr_params,'*');
        $this->load_view_file($arr_mode_info,__LINE__);
    }

    /**
     * 添加支付方式
     */
    public function add_channel_mode()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_user_id'=> array(
                'rule'   => 'notnull',
                'reason' => '用户非法'
            ),
            'cms_channel_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付渠道非法'
            ),
            'cms_pay_appid'=> array(
                'rule'   => 'notnull',
                'reason' => '支付平台：APP ID'
            ),
            'cms_pay_partner_key'=> array(
                'rule'   => 'notnull',
                'reason' => '支付平台：商户KEY'
            ),
            'cms_pay_partner_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付平台：商户ID'
            ),
            'cms_notify_url'=> array(
                'rule'   => 'notnull',
                'reason' => '支付异步通知地址非法'
            ),
        ),$this->arr_params);

        $arr_mode_add = $this->obj_channel_mode_logic->add($this->arr_params);
        $this->load_view_file($arr_mode_add,__LINE__);
    }

    /**
     * 更新支付方式
     */
    public function edit_channel_mode()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付方式非法'
            ),
            'cms_user_id'=> array(
                'rule'   => 'notnull',
                'reason' => '用户非法'
            ),
            'cms_channel_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付渠道非法'
            ),
            'cms_pay_appid'=> array(
                'rule'   => 'notnull',
                'reason' => '支付平台：APP ID'
            ),
            'cms_pay_partner_key'=> array(
                'rule'   => 'notnull',
                'reason' => '支付平台：商户KEY'
            ),
            'cms_pay_partner_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付平台：商户ID'
            ),
            'cms_notify_url'=> array(
                'rule'   => 'notnull',
                'reason' => '支付异步通知地址非法'
            ),
        ),$this->arr_params);

        $arr_mode_edit = $this->obj_channel_mode_logic->edit($this->arr_params['cms_id'],$this->arr_params);
        $this->load_view_file($arr_mode_edit,__LINE__);
    }

    /**
     * 删除支付方式
     */
    public function del_channel_mode()
    {
        //参数验证
        $this->control_params_check(array(
            'cms_id'=> array(
                'rule'   => 'notnull',
                'reason' => '支付方式非法'
            ),
        ),$this->arr_params);

        $arr_mode_del = $this->obj_channel_mode_logic->del($this->arr_params['cms_id']);
        $this->load_view_file($arr_mode_del,__LINE__);
    }

/*==================================================== 支付方式管理 结束 ================================================*/

    /**
     * 初始化函数
     */
    private function _init()
    {
        include_once $this->str_base_path . '/logic/backstage/order/buy_order/c_partner/logic_partner.class.php';
        include_once $this->str_base_path . '/logic/backstage/order/buy_order/c_channel/logic_channel.class.php';
        include_once $this->str_base_path . '/logic/backstage/order/buy_order/c_channel_mode/logic_channel_mode.class.php';

        $this->obj_partner_logic = new partner_logic($this);
        $this->obj_channel_logic = new channel_logic($this);
        $this->obj_channel_mode_logic = new channel_mode_logic($this);
    }

} 