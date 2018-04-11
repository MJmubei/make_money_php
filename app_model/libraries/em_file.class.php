<?php
/**
 * 文件处理类
 * @author pan.liang
 */
class em_file
{
	public $obj_controller = null;
    public $absolute_project_dir = null;
    public $base_project_dir = null;
    public $base_project_file_path = null;
    public $ex_file_name = 'xml';
	
    public function __construct($obj_controller,$ex_file_name='xml')
    {
        $this->obj_controller = $obj_controller;
        $this->absolute_project_dir = dirname(dirname(dirname(__FILE__)));
        $this->ex_file_name = $ex_file_name;
        em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"begin---{{{公共-文件处理类开始;加载文件:[".__FILE__."]}}}---begin",'message','info');
    }
	/**
	 * 生产文件
	 * @param string $xml 文件内容
	 * @return boolean
	 * @author liangpan
	 * @date 2016-08-24
	 */
	public function make_file($file_content,$file_dir,$str_file_name)
	{
	    $str_file_name = (substr($str_file_name, 0,3) == 'em_') ? substr($str_file_name, 3) : $str_file_name;
	    $file_dir = trim(trim(trim($file_dir,'\\'),'\/'));
		if(strlen($file_content) < 1)
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:内容为空不在创建文件,内容[{$file_content}]",'message','error');
			return em_return::_return_error_data();
		}
		if(strlen($str_file_name) < 1)
		{
		    em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:文件名称为空不创建文件[{$str_file_name}]",'message','error');
		    return em_return::_return_error_data();
		}
		if(strlen($file_dir) < 1)
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:file_dir参数为空[{$file_dir}]",'message','error');
			return em_return::_return_error_data();
		}
		$this->base_project_file_path = $this->absolute_project_dir.'/'.$file_dir.'/';
		if(!is_dir($this->base_project_file_path) && !$this->make_dir($this->base_project_file_path))
		{
		    return em_return::_return_error_data();
		}
		$this->base_project_file_path .=$str_file_name;
		
		return $this->write_file($file_content,$this->base_project_file_path) ? em_return::_return_right_data('ok',array('file_path'=>$this->base_project_file_path,'base_path'=>$file_dir.'/'.$str_file_name)) : em_return::_return_error_data();
	}
	
	/**
	 * 创建文件路径
	 * @param string $xml 文件内容
	 * @return boolean
	 * @author liangpan
	 * @date 2016-08-24
	 */
	private function make_dir($base_file_dir)
	{
		if (is_dir($base_file_dir))
		{
			return true;
		}
		$result=mkdir($base_file_dir, 0777, true);
		if(!$result)
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:文件路径失败[{$base_file_dir}]",'message','error');
		    return false;
		}
		return true;
	}
	
	/**
	 * 写入文件内容
	 * @param string $xml 文件内容
	 * @return boolean
	 * @author liangpan
	 * @date 2016-08-24
	 */
	private function write_file($file_content,$base_file)
	{
		if(strlen($file_content) < 1)
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:文件内容为空不写入[{$file_content}]",'message','error');
			return false;
		}
		$result = file_put_contents($base_file, $file_content, LOCK_EX);
		if($result === false)
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:写入文件失败，文件为：".$base_file,'message','error');
			return false;
		}
		return true;
	}
	
	/**
	 * 获取文件
	 * @param unknown $base_file_dir
	 * @param number $dir_child
	 * @return unknown|string|boolean
	 */
	public function get_files($base_file_dir,$dir_child=0)
	{
		$dir_child+=1;
		if(!is_dir($base_file_dir))
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:文件夹不存在".$base_file_dir,'message','error');
			return false;
		}
		$arr_base_file_dir = scandir($base_file_dir);
		if((!is_array($arr_base_file_dir) || empty($arr_base_file_dir)) && $dir_child > 1 )
		{
			$this->delete_dir($base_file_dir);
			return true;
		}
		$arr_base_file_dir = array_diff($arr_base_file_dir, array('.','..'));
		if((!is_array($arr_base_file_dir) || empty($arr_base_file_dir)) && $dir_child > 1 )
		{
			$this->delete_dir($base_file_dir);
			return true;
		}
		ksort($arr_base_file_dir);
		$arr_temp_base_file_dir_1 = $arr_temp_base_file_dir = array();
		foreach ($arr_base_file_dir as $afile)
		{
			if (is_dir($base_file_dir . '/' . $afile))
			{
				$temp_data = $this->get_files($base_file_dir . '/' . $afile,$dir_child);
				if(is_bool($temp_data))
				{
					continue;
				}
				return $temp_data;
			}
			$pathinfo_file = pathinfo($afile);
			if(isset($pathinfo_file['extension']) && $pathinfo_file['extension']==$this->ex_file_name && isset($pathinfo_file['filename']) && strlen($pathinfo_file['filename']) > 0)
			{
				$arr_temp_base_file_dir[] = $base_file_dir.'/'.$afile;
				$arr_temp_base_file_dir_1[]=$this->get_file_date($base_file_dir.'/'.$afile);
			}
		}
		if($dir_child > 1 && empty($arr_temp_base_file_dir))
		{
			$this->delete_dir($base_file_dir);
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:查无文件，文件路径为：".$base_file_dir,'message','error');
			return false;
		}
		if(empty($arr_temp_base_file_dir))
		{
			return array();
		}
		array_multisort($arr_temp_base_file_dir,$arr_temp_base_file_dir_1);
		return $arr_temp_base_file_dir;
	}
	
	/**
	 * 获取文件的创建时间
	 * @param unknown $file_path
	 * @return number
	 */
	private function get_file_date($file_path)
	{
		$date_time=filemtime($file_path);
		return ($date_time === false) ? 0 : $date_time;
	}
	
	/**
	 * 删除文件夹
	 * @param unknown $file_dir
	 * @return boolean
	 */
	private function delete_dir($file_dir)
	{
		if(!is_dir($file_dir))
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:删除文件夹失败，没有文件路径[{$file_dir}]",'message','error');
			return false;
		}
		$files = scandir($file_dir);
		if(!is_array($files) || empty($files))
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:删除文件夹失败，文件夹下文件列表为空:".var_export($files,true),'message','error');
			return false;
		}
		$files = array_diff($files, array('.','..')); 
	    foreach ($files as $file) 
	    { 
	      	if(is_dir($file_dir . '/' . $file))
	      	{
	      		if(!$this->delete_dir($file_dir . '/' . $file))
	      		{
	      			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:删除文件失败，文件:".$file_dir . '/' . $file,'message','error');
			        return false;
	      		}
	      	}
	      	else
	      	{
	      		em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:删除文件夹失败，居然还有文件，有问题，文件路径为：".$file_dir.'/'.$file,'message','error');
			    if(!$this->delete_file($file_dir . '/' . $file))
	      		{
	      			return false;
	      		}
	    	}
	    }
	    if(!rmdir($file_dir))
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:删除文件夹失败，文件路径为：".$file_dir,'message','error');
			return false;
		}
		return true;
	}
	
	/**
	 * 删除文件
	 * @param unknown $file_dir
	 * @return boolean
	 */
	private function delete_file($file_path)
	{
		if(!file_exists($file_path))
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:删除文件失败,文件不存在，文件路径为[{$file_path}]",'message','error');
			return false;
		}
		$result = unlink($file_path);
		if(!$result)
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:文删除文件失败,文件路径为[{$file_path}]",'message','error');
			return false;
		}
		return true;
	}
	
	/**
	 * 获取文件内容
	 * @param unknown $file_dir
	 * @return boolean
	 */
	private function get_file_data($file_path)
	{
		if(!file_exists($file_path))
		{
		    em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:文件内容读取失败,文件不存在，文件路径为[{$file_path}]",'message','error');
			return false;
		}
		$result=file_get_contents($file_path);
		if($result === false)
		{
			em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"行号:[".__LINE__."]:文件内容读取失败，文件路径为[{$file_path}]",'message','error');
			return false;
		}
		return $result;
	}
	
	/**
	 * 
	 */
	public function __destruct()
	{
	    em_return::set_ci_flow_desc($this->obj_controller->get_str_load_log_path(),"end---{{{公共-文件处理类结束}}}---end",'message','info');
	    unset($this->obj_controller);
	}
}