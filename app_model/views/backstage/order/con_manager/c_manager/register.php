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
    <title>注册</title>
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
                    confirmPassword: {
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
                                regexp: /^1[3|5|8]{1}[0-9]{9}$/,
                                message: '请输入正确的手机号码'
                            }
                        }
                    },
                    num: {
                        message:'密码无效',
                        validators: {
                            notEmpty: {
                                message: '验证码不能为空'
                            },
                            stringLength: {
                                min: 6,
                                max: 6,
                                message: '验证码填写错误'
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
                }
            }).on('success.form.bv',function(e){
                e.preventDefault();
                var url = '../../../../../../../make_money_php/index.php/backstage/order/con_manager/c_manager/registry';
                var submitData = $('#defaultForm').serialize() + "&flag_ajax_reurn=1";
                //submitData是解码后的表单数据，结果同上
                $.post(url, submitData, function(result){
                    var dataObj=eval("("+result+")");
                    if(dataObj.ret != 0)
                    {
                        alert(dataObj.reason);
                        $('#password').val("");
                    }
                    else
                    {
                        window.location.href='login';
                    }
                });
            });
            $('#checkbox1').change(function()
            {
                if($('#checkbox1').is(':checked'))
                {
                    $('#system-button-submit-edit-ajax').prop('disabled',false);
                }
                else
                {
                    $('#system-button-submit-edit-ajax').prop('disabled',true);
                }
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
                            <span class="heading">用户注册</span>
                        </div>
                        <div class="form-group">
                            <select class="form-control-select" name="role_id">
                                <option value="" selected></option>
                                <option value="1">系统管理员</option>
                                <option value="2">供应商</option>
                                <option value="3">订购商</option>
                                <option value="4">生产商</option>
                            </select>
                            <i class="fa fa-user"></i>
                            <label class="label-select">请选择角色</label>
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="手机号">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn-gain-num">获取验证码</button>
                            <input type="text" class="form-control" id="num" name="num" placeholder="请输入验证码">
                            <i class="fa fa-mobile"></i>
                        </div>
                        <div class="form-group help">
                            <input type="password" class="form-control" id="password" name="password" placeholder="密码">
                            <i class="fa fa-lock"></i>
                        </div>
                        <div class="form-group help">
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="再次输入密码">
                            <i class="fa fa-lock"></i>
                        </div>
                        <div class="form-group">
                            <div class="main-checkbox">
                                <input type="checkbox" value="None" id="checkbox1" name="check" checked/>
                                <label for="checkbox1"></label>
                            </div>
                            <span class="zctext">我已阅读并同意遵守<a href="#" class="agree">《订购用户服务协议》</a></span>
                            <span  class="dltext">有账号？<a href="login" class="login-a">直接登陆</a></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="system-button-submit-edit-ajax" class="btn btn-default">同意协议并注册</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var times = 60;
    function roof(){
        if(times == 0){
            $('.btn-gain-num').text('发送验证码('+times+'s)');
            $('.btn-gain-num').prop('disabled',false);
            $('.btn-gain-num').text('发送验证码');
            times = 10;
            return
        }
        $('.btn-gain-num').text('发送验证码('+times+'s)');
        times--;
        setTimeout(roof,1000);
    }
    $('.btn-gain-num').on('click',function(){
        $(this).prop('disabled',true);
        roof();
    });


</script>
</body>
</html>