<?php
/**
 * CodeIgniter
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 */
include_once APPPATH.'libraries/em_return.class.php';
include_once APPPATH.'libraries/em_preg.class.php';
include_once APPPATH.'libraries/em_logic.class.php';
class CI_Controller 
{
	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;
	
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

    /**
     * Class constructor
     * @return	void
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
        $this->set_str_load_model(isset($arr_directory[1]) ? trim(trim($arr_directory[1],'\\'),'\/') : '');
        $str_class = trim(trim($str_class,'\\'),'\/');
        $str_method = trim(trim($str_method,'\\'),'\/');
        $this->set_str_load_log_path($str_directory.'/'.$str_class.'/'.$str_method);
        $this->load =& load_class('Loader', 'core');
        $this->load->initialize();
        $this->_check_params();
        $this->set_flag_ajax_reurn((isset($this->arr_params['flag_ajax_reurn']) && $this->arr_params['flag_ajax_reurn'] == '1') ? true : false);
        em_return::set_ci_flow_desc($this->get_str_load_log_path(),"begin--{{{控制器-初始化控制器开始:文件路径:[{$this->get_str_load_file()}];界面框架:[{$this->get_str_load_stage()}];界面模板:[{$this->get_str_load_model()}];类名称:[{$this->get_str_load_class()}];方法:[{$this->get_str_load_method()}]}}}--begin");
        log_message('info', 'Controller Class Initialized');
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
     * @return the $str_load_logic_path
     */
    public function get_str_load_logic_path()
    {
        return $this->str_load_logic_path;
    }
    
    /**
     * @param field_type $str_load_logic_path
     */
    public function set_str_load_logic_path($str_load_logic_path)
    {
        $this->str_load_logic_path = $str_load_logic_path;
    }
    /**
     * @return the $flag_ajax_reurn
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
     * @return the $str_model
     */
    public function get_str_load_model()
    {
        return $this->str_load_model;
    }
    
    /**
     * @param field_type $str_model
     */
    public function set_str_load_model($str_load_model)
    {
        $this->str_load_model = $str_load_model;
    }
    
    /**
     * @return the $str_load_stage
     */
    public function get_str_load_stage()
    {
        return $this->str_load_stage;
    }
    
    /**
     * @param field_type $str_load_stage
     */
    public function set_str_load_stage($str_load_stage)
    {
        $this->str_load_stage = $str_load_stage;
    }
    
    /**
     * @return the $str_load_log_path
     */
    public function get_str_load_log_path()
    {
        return $this->str_load_log_path;
    }
    
    /**
     * @param field_type $str_load_log_path
     */
    public function set_str_load_log_path($str_load_log_path)
    {
        $this->str_load_log_path = $str_load_log_path;
    }
    
	/**
     * @return the $str_load_directory
     */
    public function get_str_load_directory()
    {
        return $this->str_load_directory;
    }

    /**
     * @param field_type $str_load_directory
     */
    public function set_str_load_directory($str_load_directory)
    {
        $this->str_load_directory = $str_load_directory;
    }

    /**
     * @return the $str_load_method
     */
    public function get_str_load_method()
    {
        return $this->str_load_method;
    }

    /**
     * @param field_type $str_load_method
     */
    public function set_str_load_method($str_load_method)
    {
        $this->str_load_method = $str_load_method;
    }

    /**
     * @return the $str_load_file
     */
    public function get_str_load_file()
    {
        return $this->str_load_file;
    }

    /**
     * @param field_type $str_load_file
     */
    public function set_str_load_file($str_load_file)
    {
        $this->str_load_file = $str_load_file;
    }

    /**
     * @return the $obj_class
     */
    public function get_str_load_class()
    {
        return $this->str_load_class;
    }

    /**
     * @param field_type $obj_class
     */
    public function set_str_load_class($str_load_class)
    {
        $this->str_load_class = $str_load_class;
    }

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}
	
	/**
	 * @param unknown $obj_class
	 * @param unknown $function
	 * @param string $file_line
	 */
	public function load_view_file($data=null,$file_line=null)
	{
	    $function = $this->get_str_load_method();
	    $view_file_path = trim(rtrim(rtrim(defined('VIEWPATH') ? VIEWPATH : '','\/'),'\\'));
	    $str_path_info = (strlen($this->get_str_load_stage()) >0) ? $this->get_str_load_stage() : '';
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
        	    em_return::set_ci_flow_desc($this->get_str_load_log_path(),"end---{{{控制器-接口控制器请求结束template_view界面展示正确模板}}}---end");
        	    $this->write_global_info();
        	    $this->load->view($str_path_info.'/'.$this->get_str_load_class().'/'.$this->get_str_load_method(),$data);
    	    }
	    }
	}
	
	/**
	 * 全局错误日志书写
	 * @param string $str_message
	 * @param string $str_model
	 */
	public function write_global_info($str_table='em_global_error',$str_model='l_general',$str_method='add')
	{
	    $error_desc=em_return::get_ci_error_desc();
	    if(empty($error_desc) || !is_array($error_desc))
	    {
	        return ;
	    }
	    $date = date("Y-m-d H:i:s");
	    $arr_global_info = array(
	        'em_stage'=>$this->get_str_load_stage(),
	        'em_model'=>$this->get_str_load_model(),
	        'em_class'=>$this->get_str_load_class(),
	        'em_method'=>$this->get_str_load_method(),
	        'em_error_file'=>em_return::$last_file_log_path,
	        'em_deleted'=>0,
	        'em_create_time'=>$date,
	        'em_modify_time'=>$date,
	    );
	    $add_data = null;
	    foreach ($error_desc as $key=>$val)
	    {
	        $arr_global_info['em_error_type']=$key;
	        $arr_global_info['em_error_info']=var_export($val,true);
	        $add_data[]=$arr_global_info;
	    }
	    $this->auto_load_table($str_table,$str_model,$str_method,$add_data);
	    return ;
	}
	
	/**
	 * 自动加载表
	 * @param unknown $str_table
	 * @param unknown $str_model
	 * @param unknown $str_method
	 * @param string $params
	 * @param string $str_databse
	 */
	public function auto_load_table($str_table,$str_model,$str_method,$params=null,$str_databse=null)
	{
	    empty($str_databse) ? $this->load->database() : $this->load->database($str_databse);
	    $str_table = (strpos($str_table, 'em_') === FALSE) ? $str_table : substr($str_table, 3);
	    $str_table_em = 'em_'.$str_table;
	    $logic_file_path = trim(rtrim(rtrim(defined('APPPATH') ? APPPATH : '','\/'),'\\')).'/logic/'.$this->get_str_load_stage().'/'.$str_model.'/'.$str_table.'.class.php';
	    if(!file_exists($logic_file_path))
	    {
	        em_return::set_ci_flow_desc($this->get_str_load_log_path(),"调用LOGIC类失败文件不存在[{$logic_file_path}];表名[{$str_table_em}];模块[{$str_model}]",'sql','error');
	        return em_return::_return_error_data();
	    }
	    include_once $logic_file_path;
	    $obj_logic = new $str_table($this,$str_table,$params);
	    if (!method_exists($obj_logic, $str_method))
	    {
	        em_return::set_ci_flow_desc($this->get_str_load_log_path(),"调用LOGIC类文件[{$logic_file_path}];方法不存在[{$str_method}];表名[{$str_table_em}];模块[{$str_model}]",'sql','error');
	        return em_return::_return_error_data();
	    }
	    return $obj_logic->$str_method();
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
	public function auto_check_login($str_table,$str_method,$params=null)
	{
	    
	}
}
