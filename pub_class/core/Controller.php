<?php
/**
 * CodeIgniter
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//开启SESSION
session_start();
/**
 * Application Controller Class
 */
include_once APPPATH.'libraries/em_return.class.php';
include_once APPPATH.'libraries/em_preg.class.php';
include_once APPPATH.'libraries/em_logic.class.php';
include_once APPPATH.'libraries/em_guid.class.php';
class CI_Controller
{
    /**
     * Reference to the CI singleton
     *
     * @var	object
     */
    private static $instance;

    public $str_load_project = null;
    public $str_load_class = null;
    public $str_load_stage = null;
    public $str_load_model = null;
    public $str_load_file = null;
    public $str_load_method = null;
    public $str_load_directory = null;
    public $str_load_log_path = null;
    public $str_load_logic_path = null;
    public $flag_ajax_reurn = false;
    public $arr_params = null;
    public $arr_page_params = null;


    public $need_login = true;//项目全局登陆验证

    /**
     * Class constructor
     * CI_Controller constructor.
     * @param null $str_class
     * @param null $str_file
     * @param null $str_method
     * @param null $str_directory
     */
    public function __construct($str_class=null,$str_file=null,$str_method=null,$str_directory=null)
    {
        self::$instance =& $this;
        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach (is_loaded() as $var => $class)
        {
            $this->$var =& load_class($class);
        }
        $this->set_str_load_class($str_class);
        $this->set_str_load_file($str_file);
        $this->set_str_load_method($str_method);
        $this->set_str_load_directory($str_directory);
        $str_directory = (is_string($str_directory) && strlen($str_directory) > 0) ? trim($str_directory) : 'default_directory';
        $str_class = (is_string($str_class) && strlen($str_class) > 0) ? trim($str_class) : 'default_class';
        $str_method = (is_string($str_method) && strlen($str_method) > 0) ? trim($str_method) : 'default_method';
        $str_directory = trim(trim($str_directory,'\\'),'\/');
        $arr_directory = explode('/', $str_directory);
        $this->set_str_load_stage(isset($arr_directory[0]) ? trim(trim($arr_directory[0],'\\'),'\/') : '');
        $this->set_str_load_project(isset($arr_directory[1]) ? trim(trim($arr_directory[1],'\\'),'\/') : '');
        $this->set_str_load_model(isset($arr_directory[2]) ? trim(trim($arr_directory[2],'\\'),'\/') : '');
        $str_class = trim(trim($str_class,'\\'),'\/');
        $str_method = trim(trim($str_method,'\\'),'\/');
        $this->set_str_load_log_path($str_directory.'/'.$str_class.'/'.$str_method);
        $this->load =& load_class('Loader', 'core');
        $this->load->initialize();
        $this->_check_params();
        $this->auto_check_login();//全局登陆验证
        if(isset($this->arr_params['cms_page_num']))
        {
            $this->arr_page_params['cms_page_num'] = (int)$this->arr_params['cms_page_num'];
            $this->arr_page_params['cms_page_num'] = $this->arr_page_params['cms_page_num']>0 ? $this->arr_page_params['cms_page_num'] : 1;
            unset($this->arr_params['cms_page_num']);
        }
        if(isset($this->arr_params['cms_page_size']))
        {
            $this->arr_page_params['cms_page_size'] = (int)$this->arr_params['cms_page_size'];
            $this->arr_page_params['cms_page_size'] = $this->arr_page_params['cms_page_size']>0 ? $this->arr_page_params['cms_page_size'] : 10;
            unset($this->arr_params['cms_page_size']);
        }
        $this->set_flag_ajax_reurn((isset($this->arr_params['flag_ajax_reurn']) && $this->arr_params['flag_ajax_reurn'] == '1') ? true : false);
        em_return::set_ci_flow_desc($this->get_str_load_log_path(),"begin--{{{控制器-初始化控制器开始:文件路径:[{$this->get_str_load_file()}];界面框架:[{$this->get_str_load_stage()}];项目:[{$this->get_str_load_project()}];界面模板:[{$this->get_str_load_model()}];类名称:[{$this->get_str_load_class()}];方法:[{$this->get_str_load_method()}]}}}--begin");
        log_message('info', 'Controller Class Initialized');
    }

    public function _init_page()
    {
        if(isset($this->arr_page_params['cms_page_num']))
        {
            return ;
        }
        $this->arr_page_params['cms_page_num'] = 1;
        $this->arr_page_params['cms_page_size'] = 5;
    }

    /**
     * 参数生成   如果  post 和  get 参数key 都存在  则 以 post的值为准
     */
    public function _check_params()
    {
        $arr_get=$this->input->get();
        $arr_post = $this->input->post();
        em_return::set_ci_flow_desc($this->get_str_load_log_path(),"参数组装开始");
        if(!empty($arr_get) && is_array($arr_get))
        {
            em_return::set_ci_flow_desc($this->get_str_load_log_path(),"GET参数:[".var_export($arr_get,true)."]");
            foreach ($arr_get as $get_key=>$get_val)
            {
                $this->arr_params[$get_key] = $get_val;
            }
        }
        if(!empty($arr_post) && is_array($arr_post))
        {
            em_return::set_ci_flow_desc($this->get_str_load_log_path(),"POST参数:[".var_export($arr_post,true)."]");
            foreach ($arr_post as $post_key=>$post_val)
            {
                if(isset($this->arr_params[$post_key]))
                {
                    em_return::set_ci_flow_desc($this->get_str_load_log_path(),"参数错误:GET含有此key[{$post_key}]值为:[".var_export($this->arr_params[$post_key],true)."],POSTGET含有此key[{$post_key}]值为:[".var_export($post_val,true)."]以POST值为准",'message','notice');
                }
                $this->arr_params[$post_key] = $post_val;
            }
        }
        em_return::set_ci_flow_desc($this->get_str_load_log_path(),"参数组装结束");
        return;
    }


    /**
     * @return null //$str_load_project
     */
    public function get_str_load_project()
    {
        return $this->str_load_project;
    }

    /**
     * @param$str_load_project //field_type
     */
    public function set_str_load_project($str_load_project)
    {
        $this->str_load_project = $str_load_project;
    }

    /**
     * @return //the $str_load_logic_path
     */
    public function get_str_load_logic_path()
    {
        return $this->str_load_logic_path;
    }

    /**
     * @param $str_load_logic_path //field_type
     */
    public function set_str_load_logic_path($str_load_logic_path)
    {
        $this->str_load_logic_path = $str_load_logic_path;
    }

    /**
     * the $flag_ajax_reurn
     * @return bool
     */
    public function get_flag_ajax_reurn()
    {
        return $this->flag_ajax_reurn;
    }

    /**
     * @param boolean $flag_ajax_reurn
     */
    public function set_flag_ajax_reurn($flag_ajax_reurn=false)
    {
        $this->flag_ajax_reurn = $flag_ajax_reurn ? true : false;
    }

    /**
     * @return //the $str_model
     */
    public function get_str_load_model()
    {
        return $this->str_load_model;
    }

    /**
     * @param $str_load_model//field_type
     */
    public function set_str_load_model($str_load_model)
    {
        $this->str_load_model = $str_load_model;
    }

    /**
     * @return //the $str_load_stage
     */
    public function get_str_load_stage()
    {
        return $this->str_load_stage;
    }

    /**
     * @param $str_load_stage //field_type
     */
    public function set_str_load_stage($str_load_stage)
    {
        $this->str_load_stage = $str_load_stage;
    }

    /**
     * @return //the $str_load_log_path
     */
    public function get_str_load_log_path()
    {
        return $this->str_load_log_path;
    }

    /**
     * @param  $str_load_log_path //field_type
     */
    public function set_str_load_log_path($str_load_log_path)
    {
        $this->str_load_log_path = $str_load_log_path;
    }

    /**
     * @return //the $str_load_directory
     */
    public function get_str_load_directory()
    {
        return $this->str_load_directory;
    }

    /**
     * @param  $str_load_directory //field_type
     */
    public function set_str_load_directory($str_load_directory)
    {
        $this->str_load_directory = $str_load_directory;
    }

    /**
     * @return //the $str_load_method
     */
    public function get_str_load_method()
    {
        return $this->str_load_method;
    }

    /**
     * @param $str_load_method //field_type
     */
    public function set_str_load_method($str_load_method)
    {
        $this->str_load_method = $str_load_method;
    }

    /**
     * @return //the $str_load_file
     */
    public function get_str_load_file()
    {
        return $this->str_load_file;
    }

    /**
     * @param  $str_load_file //field_type
     */
    public function set_str_load_file($str_load_file)
    {
        $this->str_load_file = $str_load_file;
    }


    /**
     * 获取加载类
     * @return null
     */
    public function get_str_load_class()
    {
        return $this->str_load_class;
    }


    /**
     * 设置加载类
     * @param $str_load_class
     */
    public function set_str_load_class($str_load_class)
    {
        $this->str_load_class = $str_load_class;
    }

    /**
     * Get the CI singleton
     *
     * @static
     * @return object
     */
    public static function &get_instance()
    {
        return self::$instance;
    }

    /**
     * 加载返回管理端展示页面
     * @param null $data
     * @param null $file_line
     */
    public function load_view_file($data=null,$file_line=null)
    {
        $function = $this->get_str_load_method();
        $view_file_path = trim(rtrim(rtrim(defined('VIEWPATH') ? VIEWPATH : '','\/'),'\\'));
        $str_path_info = (strlen($this->get_str_load_stage()) >0) ? $this->get_str_load_stage() : '';
        $str_path_info .= (strlen($this->get_str_load_project()) >0) ? '/'.$this->get_str_load_project() : '';
        $str_path_info .= (strlen($this->get_str_load_model()) >0) ? '/'.$this->get_str_load_model() : '';
        $_str_path_info = $view_file_path.'/'.$str_path_info.'/'.$this->get_str_load_class().'/'.$this->get_str_load_method().'.php';

        if($this->get_flag_ajax_reurn())
        {
            $data = is_array($data) ? $data : array();
            em_return::set_ci_flow_desc($this->get_str_load_log_path(),"end---{{{控制器-接口控制器请求结束ajax结果返回}}}---end");
            $this->write_global_info();
            echo json_encode($data);die;
        }
        else
        {
            if(isset($data['ret']) && $data['ret'] !=0)
            {
                echo json_encode($data);die;
            }
            if(!file_exists($_str_path_info))
            {
                $str_desc = "文件行数:[{$file_line}];加载view文件:[$_str_path_info]错误,文件不存在";
                em_return::set_ci_flow_desc($this->get_str_load_log_path(),$str_desc,'message','error');
                em_return::set_ci_flow_desc($this->get_str_load_log_path(),"end---{{{控制器-接口控制器请求结束template_view界面展示错误模板}}}---end");
                $this->write_global_info();
                $this->load->view('model_error/model_error',array('arr_desc'=>em_return::_return_log_data()));
            }
            else
            {
                $data['arr_page_url']['list_url'] = VIEW_MODEL_BACKGROUD_REQUEST_URL.$str_path_info.'/'.$this->get_str_load_class().'/'.$this->get_str_load_method();
                $data['arr_params'] = $this->arr_params;
                em_return::set_ci_flow_desc($this->get_str_load_log_path(),"end---{{{控制器-接口控制器请求结束template_view界面展示正确模板}}}---end");
                $this->write_global_info();

                $data['data_menu'] = $this->system_auto_make_menu();
                //$data['data_menu'] = $this->system_auto_make_menu_arr($data['data_menu']);
                //         	    echo json_encode($data['data_menu']);die;
                $this->load->view($str_path_info.'/'.$this->get_str_load_class().'/'.$this->get_str_load_method(),$data);
            }
        }
    }

    /**
     * 加载展示前端页面
     * @param null $data
     * @param null $file_line
     * xinxin.deng 2018/12/7 11:29
     */
    public function load_view($data=null,$file_line=null)
    {
        $function = $this->get_str_load_method();
        $view_file_path = trim(rtrim(rtrim(defined('VIEWPATH') ? VIEWPATH : '','\/'),'\\'));
        $str_path_info = (strlen($this->get_str_load_stage()) >0) ? $this->get_str_load_stage() : '';
        $str_path_info .= (strlen($this->get_str_load_project()) >0) ? '/'.$this->get_str_load_project() : '';
        $str_path_info .= (strlen($this->get_str_load_model()) >0) ? '/'.$this->get_str_load_model() : '';
        $_str_path_info = $view_file_path.'/'.$str_path_info.'/'.$this->get_str_load_class().'/'.$this->get_str_load_method().'.php';

        if($this->get_flag_ajax_reurn())
        {
            $data = is_array($data) ? $data : array();
            em_return::set_ci_flow_desc($this->get_str_load_log_path(),"end---{{{控制器-接口控制器请求结束ajax结果返回}}}---end");
            $this->write_global_info();
            echo json_encode($data);die;
        }
        else
        {
            if(isset($data['ret']) && $data['ret'] !=0)
            {
                echo json_encode($data);die;
            }
            if(!file_exists($_str_path_info))
            {
                $str_desc = "文件行数:[{$file_line}];加载view文件:[$_str_path_info]错误,文件不存在";
                em_return::set_ci_flow_desc($this->get_str_load_log_path(),$str_desc,'message','error');
                em_return::set_ci_flow_desc($this->get_str_load_log_path(),"end---{{{控制器-接口控制器请求结束template_view界面展示错误模板}}}---end");
                $this->write_global_info();
                $this->load->view('model_error/model_error',array('arr_desc'=>em_return::_return_log_data()));
            }
            else
            {
                $data['arr_page_url']['list_url'] = VIEW_MODEL_BACKGROUD_REQUEST_URL.$str_path_info.'/'.$this->get_str_load_class().'/'.$this->get_str_load_method();
                $data['arr_params'] = $this->arr_params;
                em_return::set_ci_flow_desc($this->get_str_load_log_path(),"end---{{{控制器-接口控制器请求结束template_view界面展示正确模板}}}---end");
                $this->load->view($str_path_info.'/'.$this->get_str_load_class().'/'.$this->get_str_load_method(),$data);
            }
        }
    }

    public function system_auto_make_menu($level=1,$parent_id=0)
    {
        $last_data=null;
        if($level==1)
        {
            $this->arr_page_params['cms_page_num'] = 0;
            $this->arr_page_params['cms_page_size'] = 0;
        }
        $temp_level = $level+1;
        $menu_data = $this->auto_load_table('system','auto','c_project','system_menu', 'query',array('where'=>array('cms_level'=>$level,'cms_parent_id'=>$parent_id)));
        $menu_data = isset($menu_data['data_info']) ? $menu_data['data_info'] :null;
        if(!is_array($menu_data) || empty($menu_data))
        {
            return $last_data;
        }
        foreach ($menu_data as $value)
        {
            $last_data[$value['cms_id']]['data']=$value;
            $data = $this->system_auto_make_menu($temp_level,$value['cms_id']);
            if(!is_array($data) || empty($data))
            {
                continue;
            }
            $last_data[$value['cms_id']]['child_list'] = $data;
        }
        return $last_data;
    }


    public function system_auto_make_menu_arr($last_data)
    {
        $data = array_values($last_data);
        foreach ($data as $key=>$value)
        {
            if(!isset($value['child_list']) || empty($value['child_list']))
            {
                continue;
            }
            $data[$key]['child_list'] = $this->system_auto_make_menu_arr($value['child_list']);
        }
        return $data;
    }

    /**
     * 全局错误日志书写
     * @param string $str_message
     * @param string $str_model
     */
    public function write_global_info($str_project='system',$str_table='system_global_error',$str_model='l_general',$str_method='add')
    {
        $error_desc=em_return::get_ci_error_desc();
        if(empty($error_desc) || !is_array($error_desc))
        {
            return ;
        }
        $date = date("Y-m-d H:i:s");
        $arr_global_info = array(
            'cms_stage'=>$this->get_str_load_stage(),
            'cms_project'=>$this->get_str_load_project(),
            'cms_model'=>$this->get_str_load_model(),
            'cms_class'=>$this->get_str_load_class(),
            'cms_method'=>$this->get_str_load_method(),
            'cms_error_file'=>em_return::$last_file_log_path,
            'cms_deleted'=>0,
            'cms_create_time'=>$date,
            'cms_modify_time'=>$date,
        );
        $add_data = null;
        foreach ($error_desc as $key=>$val)
        {
            $arr_global_info['cms_error_type']=$key;
            $arr_global_info['cms_error_info']=var_export($val,true);
            $add_data[]=$arr_global_info;
        }
        $this->auto_load_table($str_project,$str_table,$str_model,$str_method,$add_data);
        return ;
    }

    /**
     * 自动加载表
     * @param string $str_project 项目标示
     * @param string $str_model 模块标示
     * @param string $str_child_model 子模块标示
     * @param string $str_table 表名
     * @param string $str_method logic 方法
     * @param string $params 参数
     * @param string $str_databse 数据库 如果未填写默认项目数据库
     */
    public function auto_load_table($str_project,$str_model,$str_child_model,$str_table,$str_method,$params=null,$str_databse=null)
    {
        empty($str_databse) ? $this->load->database() : $this->load->database($str_databse);
        $str_table = (strlen($str_project)< strlen($str_table) && substr($str_table,0, strlen($str_project)) != $str_project) ? $str_project.'_'.$str_table : $str_table;
        //加载base文件,不一定非要加载base文件
        $logic_base_file_path = trim(rtrim(rtrim(defined('APPPATH') ? APPPATH : '','\/'),'\\')).'/logic/'.$this->get_str_load_stage().'/'.$str_project.'/'.$str_model.'/'.$str_child_model.'/'.$str_table.'/'.$str_table.'.base.php';
        if(file_exists($logic_base_file_path))
        {
            include_once $logic_base_file_path;
        }
        //加载logic文件
        $logic_file_path = trim(rtrim(rtrim(defined('APPPATH') ? APPPATH : '','\/'),'\\')).'/logic/'.$this->get_str_load_stage().'/'.$str_project.'/'.$str_model.'/'.$str_child_model.'/'.$str_table.'/'.$str_table.'.class.php';
        if(!file_exists($logic_file_path))
        {
            em_return::set_ci_flow_desc($this->get_str_load_log_path(),"调用LOGIC类失败文件不存在[{$logic_file_path}];项目[{$this->get_str_load_project()}];表名[{$str_table}];模块[{$str_model}]",'sql','error');
            return em_return::_return_error_data();
        }

        include_once $logic_file_path;
        $obj_logic = new $str_table($this,$str_table,$params);
        if (!method_exists($obj_logic, $str_method))
        {
            em_return::set_ci_flow_desc($this->get_str_load_log_path(),"调用LOGIC类文件[{$logic_file_path}];项目[{$this->get_str_load_project()}];方法不存在[{$str_method}];表名[{$str_table}];模块[{$str_model}]",'sql','error');
            return em_return::_return_error_data();
        }
        return $obj_logic->$str_method($params);
    }

    /**
     * 自动加载表
     * @param unknown $str_table
     * @param unknown $str_model
     * @param unknown $str_method
     * @param string $params
     * @param string $str_databse
     */
    public function auto_make_model($str_table,$str_method,$params=null)
    {
        include_once APPPATH.'libraries/em_model_bulid.class.php';
        $obj_model_bulid = new em_model_bulid($this);
        if (!method_exists($obj_model_bulid, $str_method))
        {
            em_return::set_ci_flow_desc($this->get_str_load_log_path(),"调用模板创建类文件[".APPPATH."libraries/em_model_bulid.class.php];方法不存在[{$str_method}]",'message','error');
            return em_return::_return_error_data();
        }
        return $obj_model_bulid->$str_method($str_table,$params);
    }

    /**
     * 自动检查登录
     * @param unknown $str_table
     * @param unknown $str_model
     * @param unknown $str_method
     * @param string $params
     * @param string $str_databse
     */
    public function auto_check_login()
    {
        if($this->need_login)
        {
            $this->load->library('session');
            $session_telephone = $this->session->userdata('telephone');
            $session_role = $this->session->userdata('role_id');
            if (!$session_telephone || !$session_role)
            {
                $url = "../../../../backstage/order/con_manager/c_manager/login";//判断登录超时后，要跳转到的页面
                echo "<script language='javascript' type='text/javascript'>";
                echo "window.location.href='$url'";
                echo "</script>";
                exit;
            }
        }
    }

    /**
     * 生成32位随机id
     * @param string $something
     * @return bool|string
     */
    public function get_guid($something = 'rand')
    {
        $result = dechex(time());
        $result = $result . dechex($this->millisecond());

        $a = "";
        if(isset($_ENV["COMPUTERNAME"]))
            $a .= $_ENV["COMPUTERNAME"];
        if(isset($_SERVER["SERVER_ADDR"]))
            $a .= $_SERVER["SERVER_ADDR"];
        if(isset($_SERVER["REMOTE_ADDR"]))
            $a .= $_SERVER["REMOTE_ADDR"];

        $a = $a . rand(0,10000);
        $a = $a . rand(0,10000);
        $a = $a . rand(0,10000);
        $a = $a . microtime();

        $result = $result.md5($a . $something);
        return substr($result, 0, 32);
    }

    /**
     * 读取毫秒数
     * @return int
     */
    public function millisecond()
    {
        list ($usec, $sec) = explode(' ', microtime ());
        return intval(substr($usec, 2, 3));
    }

    public function auto_load_class($file_base_dir='')
    {
        $file_base_dir = trim(trim(str_replace("\\", '/', $file_base_dir),'\\'));
        if(strlen($file_base_dir) <1)
        {
            em_return::set_ci_flow_desc($this->get_str_load_log_path(),"加载文件参数为空",'message','error');
            return em_return::_return_error_data();
        }
        $base_dir = dirname(dirname(dirname(__FILE__))).'/'.$file_base_dir;
        if(!file_exists($base_dir))
        {
            em_return::set_ci_flow_desc($this->get_str_load_log_path(),"加载文件该文件不存在，路径[{$base_dir}]",'message','error');
            return em_return::_return_error_data();
        }
        include_once $base_dir;
        return em_return::_return_right_data('OK');
    }

    /**
     * 验证参数是否正确
     * @param array $arr_params_rule 参数名称   array(
            'cms_params_name' => array(
                'rule' => '验证规则',
                'func' => '回调函数',
                'in'   => '范围，多个使用“ - 或者 , ”隔开',
                'length=> '长度范围，多个使用“ - 或者 , ”隔开',
                'regex => '正则表达式',
                'reason=> '描述信息',
     * )
     * @param array $arr_params      参数属性值 array(
            'cms_params_name' => 'cms_params_value'
     * )
     */
    protected function control_params_check($arr_params_rule, $arr_params)
    {
        if(is_array($arr_params_rule)&&is_array($arr_params))
        {
            foreach ($arr_params_rule as $str_param => $arr_val)
            {
                if(empty($arr_val['reason']))
                {
                    $arr_val['reason']=$str_param." format is not ".$arr_val['rule'];
                }
                switch (strtolower($arr_val['rule']))
                {
                    case 'callback':
                        $arr_ckeck_re = $this->callback($arr_params[$str_param], $arr_val['func'], $arr_val['reason']);
                        break;
                    case 'email':
                        $arr_ckeck_re = $this->email($arr_params[$str_param], $arr_val['reason']);
                        break;
                    case 'in':
                        $arr_ckeck_re = $this->in($arr_params[$str_param], $arr_val['in'], $arr_val['reason']);
                        break;
                    case 'length':
                        $arr_ckeck_re = $this->length($arr_params[$str_param], $arr_val['length'], $arr_val['reason']);
                        break;
                    case 'notnull':
                        $arr_ckeck_re = $this->notnull($arr_params[$str_param], $arr_val['reason']);
                        break;
                    case 'number':
                        $arr_ckeck_re = $this->number($arr_params[$str_param], $arr_val['reason']);
                        break;
                    case 'regex':
                        $arr_ckeck_re = $this->regex($arr_params[$str_param], $arr_val['regex'], $arr_val['reason']);
                        break;
                    case 'url':
                        $arr_ckeck_re = $this->url($arr_params[$str_param], $arr_val['reason']);
                        break;
                    case 'mobile':
                        $arr_ckeck_re = $this->mobile($arr_params[$str_param], $arr_val['reason']);
                        break;
                    case 'array':
                        $arr_ckeck_re = $this->array_type($arr_params[$str_param], $arr_val['reason']);
                        break;
                    case 'string':
                        $arr_ckeck_re = $this->string_type($arr_params[$str_param], $arr_val['reason']);
                        break;
                    default:
                        $arr_ckeck_re = array('ret' => NF_RETURN_ERROR_CODE, 'reason' => 'type is not exist');
                    break;
                }
                if($arr_ckeck_re['ret'] != NF_RETURN_SUCCESS_CODE)
                {
                    $this->flag_ajax_reurn = true;
                    $this->load_view_file($arr_ckeck_re,__LINE__);
                    exit;
                }
            }
        }
    }

    /**
     * 使用自定义的正则表达式进行验证
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @param	string	$rules	正则表达式
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function regex($value, $rules, $msg = 'param error')
    {
        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        if (!preg_match($rules, $value))
        {
            $arr_re['ret'] = NF_RETURN_ERROR_CODE;
            $arr_re['reason'] = $msg;
        }
        return $arr_re;
    }

    /**
     * 非空验证
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function notnull($value, $msg = 'param error')
    {
        $value = trim($value);
        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        if (strlen($value) == 0)
        {
            $arr_re['ret'] = NF_RETURN_ERROR_CODE;
            $arr_re['reason'] = $msg;
        }
        return $arr_re;
    }

    /**
     * Email格式验证
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function email($value, $msg = 'param error')
    {
        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        $rules = "/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";
        if (!preg_match($rules, $value))
        {
            $arr_re['ret'] = NF_RETURN_ERROR_CODE;
            $arr_re['reason'] = $msg;
        }
        return $arr_re;
    }

    /**
     * URL格式验证
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function url($value, $msg = 'param error')
    {
        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        $rules = '/^http\:\/\/([\w-]+\.)+[\w-]+(\/[\w-.\/?%&=]*)?$/';
        if (!preg_match($rules, $value))
        {
            $arr_re['ret'] = NF_RETURN_ERROR_CODE;
            $arr_re['reason'] = $msg;
        }
        return $arr_re;
    }

    /**
     * 手机号码格式验证
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function mobile($value, $msg = 'param error')
    {

        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        $rules  = '/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/';
        if (!preg_match($rules, $value))
        {
            $arr_re['ret'] = NF_RETURN_ERROR_CODE;
            $arr_re['reason'] = $msg;
        }
        return $arr_re;
    }

    /**
     * 数组类型
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function array_type($value, $msg = 'param error')
    {
        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        if (!is_array($value))
        {
            $arr_re['ret'] = NF_RETURN_ERROR_CODE;
            $arr_re['reason'] = $msg;
        }
        return $arr_re;
    }

    /**
     * 字符串类型
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function string_type($value, $msg = 'param error')
    {
        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        if (!is_string($value))
        {
            $arr_re['ret'] = NF_RETURN_ERROR_CODE;
            $arr_re['reason'] = $msg;
        }
        return $arr_re;
    }

    /**
     * 数字格式验证
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function number($value, $msg = 'param error')
    {
        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        $rules = '/^\d+$/';
        if (!preg_match($rules, $value))
        {
            $arr_re['ret'] = NF_RETURN_ERROR_CODE;
            $arr_re['reason'] = $msg;
        }
        return $arr_re;
    }

    /**
     * 使用回调用函数进行验证
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @param	string	$rules	回调函数名称
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function callback($value, $rules, $msg = 'param error')
    {
        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        if (!call_user_func_array($rules, array($value)))
        {
            $arr_re['ret'] = NF_RETURN_ERROR_CODE;
            $arr_re['reason'] = $msg;
        }
        return $arr_re;
    }

    /**
     * 验证数据的值是否在一定的范围内
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @param	string	$rules	一个值或多个值，或一个范围
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function in($value, $rules, $msg = 'param error')
    {
        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        //多个值使用的是逗号分隔
        if (strstr($rules, ","))
        {
            if (!in_array($value, explode(",", $rules)))
            {
                $arr_re['ret'] = NF_RETURN_ERROR_CODE;
                $arr_re['reason'] = $msg;
            }
        }
        else if (strstr($rules, '-'))
        {//多个值使用的是-分隔

            list($min, $max) = explode("-", $rules);
            if (!($value >= $min && $value <= $max))
            {
                $arr_re['ret'] = NF_RETURN_ERROR_CODE;
                $arr_re['reason'] = $msg;
            }
        }
        else
        {

            if ($rules != $value)
            {
                $arr_re['ret'] = NF_RETURN_ERROR_CODE;
                $arr_re['reason'] = $msg;
            }
        }
        return $arr_re;
    }

    /**
     * 验证数据的值的长度是否在一定的范围内
     * @param	string	$value	需要验证的值
     * @param	string	$msg	验证失败的提示消息
     * @param	string	$rules	一个范围，例如 3-20(3-20之间)、3,20(3-20之间)、3(必须是3个)、3,(3个以上)
     * @return  array   array('ret' => 0/1,'reason' => '描述信息')
     */
    protected function length($value, $rules, $msg = 'param error')
    {
        $arr_re = array('ret' => NF_RETURN_SUCCESS_CODE, 'reason' => 'success');
        $fg = strstr($rules, '-') ? "-" : ",";
        $int_val_length=mb_strlen($value,'UTF-8');
        if (!strstr($rules, $fg))
        {
            if ( $int_val_length!= $rules)
            {
                $arr_re['ret'] = NF_RETURN_ERROR_CODE;
                $arr_re['reason'] = $msg;
            }
        }
        else
        {

            list($min, $max) = explode($fg, $rules);

            if (empty($max))
            {
                if ($int_val_length < $rules)
                {
                    $arr_re['ret'] = NF_RETURN_ERROR_CODE;
                    $arr_re['reason'] = $msg;
                }
            }
            else if (($int_val_length < $min) || ($int_val_length > $max))
            {
                $arr_re['ret'] = NF_RETURN_ERROR_CODE;
                $arr_re['reason'] = $msg;
            }
        }
        return $arr_re;
    }

}
