<?php
/**
 * Created by <stacrcor.com>.
 * Author: xinxin.deng
 * Date: 2018/11/29 11:02
 */
if(!defined('VIEW_MODEL_BACKGROUD'))
{
    define('VIEW_MODEL_BACKGROUD', '/CodeIgniter/view_model/backstage/');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/style.css" rel='stylesheet' type='text/css' />
    <!-- Graph CSS -->
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/font-awesome.css" rel="stylesheet">
    <!-- jQuery -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>
    <!-- lined-icons -->
    <link rel="stylesheet" href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/icon-font.min.css" type='text/css' />
    <!-- //lined-icons -->
    <script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/jquery-1.10.2.min.js"></script>
    <!--clock init-->
</head>
<body>
<!--/login-->

<div class="error_page">
    <!--/login-top-->

    <div class="error-top">
        <h2 class="inner-tittle page">订购系统</h2>
        <div class="login">
            <h3 class="inner-tittle t-inner">登录</h3>
            <form action="../../../../../../../make_money_php/index.php/backstage/order/con_manager/c_manager/sigin">
                <input type="text" placeholder="手机号" id="telephone" name="telephone">
                <input type="password" placeholder="密码" id="password" name="password">
                <div class="submit"><input type="submit" value="登录" ></div>
                <div class="clearfix"></div>

                <div class="new">
                    <p><label class="checkbox11"><input type="checkbox" name="checkbox"><i> </i>是否记住密码?</label></p>
                    <p class="sign">还没有账号?<a href="">注册</a></p>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>


    </div>


    <!--//login-top-->
</div>

<!--//login-->
<!--footer section start-->
<div class="footer">
    <div class="error-btn">
        <a class="read fourth" href="index.html">Return to Home</a>
    </div>
    <p>Copyright &copy; 2018.</p>
</div>
<!--footer section end-->
<!--/404-->
<!--js -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/jquery.nicescroll.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap.min.js"></script>
</body>
</html>
