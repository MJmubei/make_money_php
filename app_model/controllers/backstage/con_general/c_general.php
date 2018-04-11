<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 项目全局配置公共模块
 * @author pan.liang
 *
 */
class c_general extends CI_Controller
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
        $this->load_view_file(null,__LINE__);
    }

    public function login()
    {
        $this->load_view_file(null,__LINE__);
    }
    
    public function log()
    {
        $this->load_view_file(null,__LINE__);
    }
}
