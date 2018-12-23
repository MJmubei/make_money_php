<?php
include_once dirname(__FILE__) . '/em_return.class.php';

class em_upload extends em_return
{

    public $base_data_dir = null;

    public $arr_params = null;

    public function __construct($arr_params = null)
    {
        $this->arr_params = $arr_params;
        $this->base_data_dir = dirname(dirname(__FILE__)) . '/data_model/';
    }

    public function init()
    {
        // 建立临时目录存放文件-以MD5为唯一标识
        $temp_upload_dir = $this->base_data_dir . 'temp_upload/' . $this->arr_params['md5value'];
        em_return::make_dir_out_project($temp_upload_dir);
            // 移入缓存文件保存
        $result = move_uploaded_file($_FILES["file"]["tmp_name"], $temp_upload_dir . '/' . $this->arr_params["chunk"]);
        return $result ? em_return::return_data(0,'文件迁移OK') : em_return::return_data(1,'文件迁移失败');
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
$str_func = isset($_POST['system_func']) ? $_POST['system_func'] : '';
if (! in_array($str_func, array(
    'init',
    'check',
    'merage'
))) {
    echo json_encode(em_return::return_data(1, '未知方法'));
    die();
}
$em_upload = new em_upload($_REQUEST);
$result = $em_upload->$str_func();
echo json_encode($result);
die();