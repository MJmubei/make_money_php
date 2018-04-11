<?php
defined('BASEPATH') or exit('No direct script access allowed');

class c_main extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * http://example.com/index.php/welcome
     * - or -
     * http://example.com/index.php/welcome/index
     * - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * 
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        include_once APPPATH.'libraries/em_encrypt.class.php';
        $obj_model_bulid = new em_encrypt($this);
        
//         $this->load->database();
//         $query = $this->db->query("select * from information_schema.COLUMNS where table_name = 'em_project_model' and table_schema = 'epiboly_model'");
//         $result = $query->result_array();
//         echo json_encode($result);die;
        $this->load_view_file(array('str_123'=>array(1,2,3,4)),__LINE__);
    }

    public function make_str($len=1)
    {
        $arr = array(1,2,3,4,5,6,7,8,9,0,'q','w','e','r','t','y','u','i','o','p','[',']','{','}','\\',' ','\'','"','我是','哈','地方','的','【','】','&','、','，','/','。','？','！','@',
            '(',')','（','）','-','+','=','   ','*','……','￥','$','`','~','.','?');
        $count = count($arr);
        $count--;
        $str='';
        for ($l = 0;$l <$len;$l++)
        {
            $str.=$arr[rand(0, $count)];
        }
        return $str;
    }
    
    public function login()
    {
        $this->load_view_file(array('str_234'=>array(4,5,6,7)),__LINE__);
    }
}
