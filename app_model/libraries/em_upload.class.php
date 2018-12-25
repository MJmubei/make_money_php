<?php
include_once dirname(__FILE__) . '/em_return.class.php';
include_once dirname(__FILE__) . '/em_guid.class.php';
class em_upload extends em_return
{

    public $base_data_dir = null;

    public $arr_params = null;

    public function __construct($arr_params = null)
    {
        $this->arr_params = $arr_params;
        $this->base_data_dir = dirname(dirname(dirname(__FILE__))).'/data_model/upload';
    }

    public function init()
    {
        $str_input_image_key = isset($this->arr_params['input_image_key']) ? trim($this->arr_params['input_image_key']) : '';
        if(!isset($_FILES[$str_input_image_key]) || empty($_FILES[$str_input_image_key]) || !is_array($_FILES[$str_input_image_key]))
        {
            return em_return::return_data(1,'未接收到任何可上传文件');
        }
        $base_dir = '';
        if(isset($this->arr_params['save_path']) && strlen($this->arr_params['save_path']) <1)
        {
            $this->arr_params['save_path'] = str_replace('\\', '/', $this->arr_params['save_path']);
            $this->arr_params['save_path'] = str_replace('//', '/', $this->arr_params['save_path']);
            $this->arr_params['save_path'] = trim(trim($this->arr_params['save_path'],'/'));
            if(strlen($this->arr_params['save_path'])>0)
            {
                $base_dir=$this->arr_params['save_path']."/";
            }
            $base_dir.=date("Y").'/'.date("m").'/'.date("d").'/';
        }
        else
        {
            $base_dir=date("Y").'/'.date("m").'/'.date("d").'/';
        }
        $result_make_dir = em_return::make_dir_out_project($this->base_data_dir.'/'.$base_dir);
        if($result_make_dir['ret'] !=0)
        {
            return $result_make_dir;
        }
        $arr_file_value = pathinfo($_FILES[$str_input_image_key]['name']);
        $file_name_ex = isset($arr_file_value['extension']) ? trim($arr_file_value['extension']) : '';
        if(strlen($file_name_ex) <1)
        {
            return em_return::return_data(1,'上传文件非法');
        }
        $str_guid = em_guid::em_guid_rand();
        $file_name = $this->base_data_dir.'/'.$base_dir.$str_guid.".".$file_name_ex;
        $result = @move_uploaded_file($_FILES[$str_input_image_key]["tmp_name"],$file_name);
        if(!$result)
        {
            return em_return::return_data(1,"迁移文件失败文件名称[{$_FILES[$str_input_image_key]['name']}]");
        }
        $last_data = array(
            'name'=>$_FILES[$str_input_image_key]['name'],
            'type'=>$_FILES[$str_input_image_key]['type'],
            'size'=>$_FILES[$str_input_image_key]['size'],
            'absolute_path'=>$this->base_data_dir.'/'.$base_dir.$str_guid.".".$file_name_ex,
            'base_pth'=>$base_dir.$str_guid.".".$file_name_ex,
        );
        return em_return::return_data(0,'文件上传成功',$last_data);
    }
    
    public function delete()
    {
        return em_return::return_data(0,'文件删除成功');
        $str_url = isset($this->arr_params['url']) ? trim($this->arr_params['url']) : '';
        if(file_exists($this->base_data_dir.'/'.$str_url))
        {
            @unlink($str_url);
        }
        return em_return::return_data(0,'文件删除成功');
    }

    public function check()
    {
        // 通过MD5唯一标识找到缓存文件
        $check_file_path = $this->base_data_dir . 'temp_check/' . $this->arr_params['md5'];
        // 有断点
        if (file_exists($check_file_path)) 
        {
            // 遍历成功的文件
            $block_info = scandir($check_file_path);
            // 除去无用文件
            foreach ($block_info as $key => $block) 
            {
                if ($block == '.' || $block == '..')
                {
                    unset($block_info[$key]);
                }
            }
            return em_return::return_data(0, '存在分片', array('block_info' => $block_info));
        }
        return em_return::return_data(0, '不存在分片');
    }

    public function merage()
    {
        // 找出分片文件
        $upload_dir = $this->base_data_dir . 'temp_upload/' . $this->arr_params['md5'];
        em_return::make_dir_out_project($upload_dir);
        // 获取分片文件内容
        $block_info = @scandir($upload_dir);
        // 除去无用文件
        if(is_array($block_info) && !empty($block_info))
        {
            foreach ($block_info as $key => $block)
            {
                if ($block == '.' || $block == '..')
                {
                    unset($block_info[$key]);
                }
            }
            // 数组按照正常规则排序
            natsort($block_info);
        }
        // 定义保存文件
        $save_file = $this->base_data_dir . 'upload/' . $this->arr_params['fileName'];

        em_return::make_dir_out_project($save_file);
        
        // 没有？建立
        if (! file_exists($save_file))
        {
            fopen($this->arr_params['fileName'], "w");
        }
            // 开始写入
        $out = @fopen($save_file, "wb");
        
        // 增加文件锁
        if (flock($out, LOCK_EX)) 
        {
            if(is_array($block_info) && !empty($block_info))
            {
                foreach ($block_info as $b) 
                {
                    // 读取文件
                    if (! $in = @fopen($upload_dir . '/' . $b, "rb")) 
                    {
                        break;
                    }
                    // 写入文件
                    while ($buff = fread($in, 4096)) 
                    {
                        fwrite($out, $buff);
                    }
                    @fclose($in);
                    @unlink($upload_dir . '/' . $b);
                }
                flock($out, LOCK_UN);
            }
        }
        @fclose($out);
        @rmdir($upload_dir);
        if(file_exists(dirname(__FILE__).'/'.$this->arr_params['fileName']))
        {
            @unlink(dirname(__FILE__).'/'.$this->arr_params['fileName']);
        }
        return em_return::return_data(0,'OK',$this->arr_params);
    }
}
$str_func = isset($_POST['system_func']) ? $_POST['system_func'] : 'init';
if (! in_array($str_func, array(
    'init',
    'check',
    'merage',
    'delete',
))) {
    echo json_encode(em_return::return_data(1, '未知方法'));
    die();
}
$em_upload = new em_upload($_REQUEST);
$result = $em_upload->$str_func();
echo json_encode($result);
die();