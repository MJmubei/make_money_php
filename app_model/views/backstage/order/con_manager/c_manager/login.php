<?php
/**
 * Created by <stacrcor.com>.
 * Author: xinxin.deng
 * Date: 2018/12/7 17:16
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
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/font-awesome.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/login.css" rel='stylesheet' type='text/css' />
    <!-- jQuery -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>
    <!-- lined-icons -->
    <link rel="stylesheet" href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/icon-font.min.css" type='text/css' />
    <!-- //lined-icons -->
    <script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrapValidator.min.js"></script>
    <script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/md5.js"></script>
    <!-- Sweet Alert -->
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <script src="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(function(){/* 文档加载，执行一个函数*/
            $('#defaultForm').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {/*input状态样式图片*/
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {/*验证：规则*/
                        password: {
                            message:'密码无效',
                            validators: {
                                notEmpty: {
                                    message: '密码不能为空'
                                },
                                stringLength: {
                                    min: 6,
                                    max: 30,
                                    message: '用户名长度必须在6到30之间'
                                },
                                identical: {//相同
                                    field: 'password', //需要进行比较的input name值
                                    message: '两次密码不一致'
                                },
                                different: {//不能和用户名相同
                                    field: 'username',//需要进行比较的input name值
                                    message: '不能和用户名相同'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z0-9_\.]+$/,
                                    message: '用户名只能由字母、数字、点和下划线组成'
                                }
                            }
                        },
                        telephone: {
                            message: 'The phone is not valid',
                            validators: {
                                notEmpty: {
                                    message: '手机号码不能为空'
                                },
                                regexp: {
                                    min: 11,
                                    max: 11,
                                    regexp: /^1\d{10}$/,
                                    message: '请输入正确的手机号码'
                                }
                            }
                        }
                    }
            }).on('success.form.bv',function(e){
                e.preventDefault();
                var url = 'sigin';
                var md5_password =  hex_md5($('#password').val());
                $('#password').val(md5_password);
                var submitData = $('#defaultForm').serialize() + "&flag_ajax_reurn=1";
                //submitData是解码后的表单数据，结果同上
                $.post(url, submitData, function(result){
                    var dataObj=eval("("+result+")");
                    if(dataObj.ret != 0)
                    {
                        swal(
                            {
                                title:'登录失败',
                                text:dataObj.reason,
                                type:"error",
                                showCancelButton:false,
                                confirmButtonText:"确定",
                                closeOnConfirm:false
                            },
                        );
                        $('#password').val("");
                    }
                    else
                    {
                        swal(
                            {
                                title:'登录成功',
                                text:'',
                                type:"success",
                                showCancelButton:false,
                                showConfirmButton:false,
                                closeOnConfirm:false,
                                timer:1500
                            },function(){
                                window.location.href='../../../../backstage/order/index/c_index/index';
                            }
                        );
                    }
                });
            });
        });

    </script>
</head>
<body>
<div class="htmleaf-container">
    <header class="htmleaf-header">
        <h1>欢迎使用<span></span></h1>
    </header>
    <div class="demo form-bg" style="padding: 20px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <form class="form-horizontal" id="defaultForm">
                        <div class="heading-div">
                            <span class="heading">用户登录</span>
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="手机号">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="form-group help">
                            <input type="password" class="form-control" id="password" name="password" placeholder="密码">
                            <i class="fa fa-lock"></i>
                        </div>
                        <div class="form-group">
                            <span class="zctext">忘记密码？<a href="re_password" class="agree">找回密码</a></span>
                            <span  class="dltext">没账号？<a href="register" class="login-a">点击注册</a></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="system-button-submit-edit-ajax" class="btn btn-default">登录</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
