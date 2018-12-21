<?php
/**
 * Created by <stacrcor.com>.
 * Author: xinxin.deng
 * Date: 2018/12/16 15:27
 */
if(!defined('VIEW_MODEL_BACKGROUD'))
{
    define('VIEW_MODEL_BACKGROUD', '/CodeIgniter/view_model/backstage/');
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
    <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrapValidator.min.js"></script>
    <script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/md5.js"></script>
    <style type="text/css">
        .htmleaf-header{margin-bottom: 15px;font-family: "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", "FontAwesome", sans-serif;}
        .htmleaf-icon{color: #fff;}

        .profile-user-info-striped {
            border: 1px solid #dcebf7;
        }
        .profile-user-info {
            margin: 0 12px;
        }
        .profile-info-row {
            position: relative;
        }
        .profile-info-name {
            position: absolute;
            width: 20%;
            text-align: right;
            padding: 6px 10px 6px 0;
            left: 0;
            top: 0;
            bottom: 0;
            font-weight: normal;
            color: #667e99;
            background-color: transparent;
            border-top: 1px dotted #d5e4f1;
        }
        .profile-user-info-striped .profile-info-name {
            color: #336199;
            background-color: #edf3f4;
            border-top: 1px solid #f7fbff;
        }
        .profile-info-row:first-child .profile-info-name {
            border-top: 0;
        }
        .profile-info-value {
            padding: 6px 4px 6px 6px;
            margin-left: 20%;
            border-top: 1px dotted #d5e4f1;
        }
        .editable-click {
            border-bottom: 1px dashed #BBB;
            cursor: pointer;
            font-weight: normal;
        }
        .profile-picture {
            border: 1px solid #CCC;
            background-color: #FFF;
            padding: 4px;
            display: inline-block;
            max-width: 100%;
            -moz-box-sizing: border-box;
            box-shadow: 1px 1px 1px rgba(0,0,0,0.15);
        }
        .editable-click {
            border-bottom: 1px dashed #BBB;
            cursor: pointer;
            font-weight: normal;
        }
        img.editable-click {
            border: 1px dotted #BBB;
        }
        .space-4 {
            max-height: 1px;
            min-height: 1px;
            overflow: hidden;
            margin: 4px 0 3px;
        }
        .label {
            border-radius: 0;
            text-shadow: none;
            font-weight: normal;
            display: inline-block;
            background-color: #abbac3!important;
        }
        .label.arrowed:before, .label.arrowed-in:before {
            display: inline-block;
            content: "";
            position: absolute;
            top: 0;
            z-index: -1;
            border: 1px solid transparent;
            border-right-color: #abbac3;
        }
        .label.arrowed-in:before {
            left: -5px;
            border-width: 10px 5px;
            border-color: #abbac3;
            border-left-color: transparent!important;
        }
        .label.arrowed-in-right {
            position: relative;
            z-index: 1;
        }

        .width-80 {
            width: 80%!important;
        }
        .label-info{
            background-color: #3a87ad!important;
        }
        .label-info.arrowed-in-right:after {
            border-color: #3a87ad;
        }
        .label.arrowed-right:after, .label.arrowed-in-right:after {
            display: inline-block;
            content: "";
            position: absolute;
            top: 0;
            z-index: -1;
            border: 1px solid transparent;
            border-left-color: #abbac3;
        }
        .label.arrowed-in-right:after {
            border-color: #abbac3;
            border-right-color: transparent!important;
        }
        .label.arrowed-in-right:after {
            right: -5px;
            border-width: 10px 5px;
        }
        .label-xlg {
            padding: .3em .7em .4em;
            font-size: 14px;
            line-height: 1.3;
            height: 28px;
        }
        .label-xlg.arrowed-in {
            margin-left: 7px;
        }
        .label-xlg.arrowed-in:before {
            left: -7px;
            border-width: 14px 7px;
        }
        .label-xlg.arrowed-in-right:after {
            right: -7px;
            border-width: 14px 7px;
        }
        .label-info.arrowed-in:before {
            border-color: #3a87ad;
        }
        .label-info.arrowed-in-right:after {
            border-color: #3a87ad;
        }

        .label-xlg.arrowed-in-right {
            margin-right: 7px;
        }

        .hr {
            display: block;
            height: 0;
            overflow: hidden;
            font-size: 0;
            border-top: 1px solid #e3e3e3;
            margin: 12px 0;
        }
        .hr.dotted, .hr-dotted {
            border-top-style: dotted;
        }
        .row {
            margin-right: -12px;
            margin-left: -12px;
        }
        .inline {
            display: inline-block!important;
        }
        .position-relative {
            position: relative;
        }
        .white {
            color: #fff!important;
        }
        .center{
            text-align: center!important;
        }

        .nav-tabs {
            border-color: #c5d0dc;
            margin-bottom: 0;
            margin-left: 0;
            position: relative;
            top: 1px;
        }
        .nav-tabs.padding-12 {
            padding-left: 12px;
        }
        .nav-tabs.background-blue {
            padding-top: 6px;
            background-color: #eff3f8;
            border: 1px solid #c5d0dc;
        }
    </style>
    <script type="text/javascript">
        $(function(){/* 文档加载，执行一个函数*/
            $('#edit-password-form').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {/*input状态样式图片*/
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {/*验证：规则*/
                    old_password: {
                        message:'密码无效',
                        validators: {
                            notEmpty: {
                                message: '密码不能为空'
                            },
                            stringLength: {
                                min: 6,
                                max: 30,
                                message: '密码长度必须在6到30之间'
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
                    new_password: {
                        message:'密码无效',
                        validators: {
                            notEmpty: {
                                message: '密码不能为空'
                            },
                            stringLength: {
                                min: 6,
                                max: 30,
                                message: '密码长度必须在6到30之间'
                            },
                            identical: {//相同
                                field: 'password', //需要进行比较的input name值
                                message: '两次密码不一致'
                            },
                            different: {//不能和用户名相同
                                field: 'old_password',//需要进行比较的input name值
                                message: '不能和旧密码相同'
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
                                message: '密码长度必须在6到30之间'
                            },
                            identical: {//相同
                                field: 'new_password', //需要进行比较的input name值
                                message: '两次密码不一致'
                            },
                            different: {//不能和用户名相同
                                field: 'old_password',//需要进行比较的input name值
                                message: '不能和旧密码相同'
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
                var url = 'edit_password';
                var md5_old_password =  hex_md5($('#old_password').val());
                var md5_new_password =  hex_md5($('#new_password').val());
                var confirmPassword =  hex_md5($('#confirmPassword').val());
                $('#old_password').val(md5_old_password);
                $('#new_password').val(md5_new_password);
                $('#confirmPassword').val(confirmPassword);
                var submitData = $('#edit-password-form').serialize() + "&flag_ajax_reurn=1";
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
                        alert('修改密码成功');
                        location.reload();
                    }
                });
            });

            $('#edit-profile-form').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {/*input状态样式图片*/
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {/*验证：规则*/
                    email: {
                        message:'密码无效',
                        emailAddress: {
                            regexp: {
                                message: '邮箱地址不正确'
                            }
                        }
                    }
                }
            }).on('success.form.bv',function(e){
                e.preventDefault();
                var url = 'edit_profile';
                var submitData = $('#edit-profile-form').serialize() + "&flag_ajax_reurn=1";
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
                        alert('修改资料成功');
                        location.reload();
                    }
                });
            });
        });
    </script>
</head>
<body>
<div class="col-xs-12">
    <div class="tabbale">
        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">

            <li class="active">
                <a data-toggle="tab" href="#profile">基本资料</a>
            </li>

            <li>
                <a data-toggle="tab" href="#edit_profile">完善资料</a>
            </li>

            <li>
                <a data-toggle="tab" href="#edit_password">修改密码</a>
            </li>

            <li>
                <a data-toggle="tab" href="#edit_telephone">修改手机号</a>
            </li>
        </ul>
        <div class="tab-content">
            <!--基本资料-->
            <div class="user-profile row tab-pane active" id="profile">
                <div class="col-xs-12 col-sm-3 center">
                    <div>
                    <span class="profile-picture">
                        <img class="editable img-resposive editable-click" src="<?php echo VIEW_MODEL_BACKGROUD; ?>images/profile-pic.jpg">
                    </span>
                        <div class="space-4"></div>
                        <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                            <div class="inline position-relative">
                                <span class="white"><?PHP echo $user['cms_name']?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name">用户id</div>

                            <div class="profile-info-value">
                                <span class="editable" id="username"><?PHP echo $user['cms_id']?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">用户名</div>

                            <div class="profile-info-value">
                                <span class="editable" id="username"><?PHP echo $user['cms_name']?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">手机号</div>

                            <div class="profile-info-value">
                                <span class="editable" id="telephone"><?PHP echo $user['cms_telephone']?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">地址</div>

                            <div class="profile-info-value">
                                <i class="icon-map-marker light-orange bigger-110"></i>
                                <span class="editable" id="country">Netherlands</span>
                                <span class="editable" id="city">Amsterdam</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">邮箱</div>

                            <div class="profile-info-value">
                                <span class="editable" id="email">946015091@qq.com</span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">用户角色</div>

                            <div class="profile-info-value">
                                <?php switch ($user['cms_role_id']){
                                    case 1:
                                        echo '<span class="editable" id="login">订单管理员</span>';
                                        break;
                                    case 2:
                                        echo '<span class="editable" id="login">平台管理员</span>';
                                        break;
                                    case 3:
                                        echo '<span class="editable" id="login">生产商</span>';
                                        break;
                                    case 4:
                                        echo '<span class="editable" id="login">供应商</span>';
                                        break;
                                    case 5:
                                        echo '<span class="editable" id="login">样板师</span>';
                                        break;
                                    case 6:
                                        echo '<span class="editable" id="login">样衣师</span>';
                                        break;
                                } ?>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">简介</div>

                            <div class="profile-info-value">
                                <span class="editable" id="about">Editable as WYSIWYG</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--完善资料-->
            <div class="user-profile row tab-pane" id="edit_profile" >
                <div class="col-xs-12 col-sm-12">
                    <form id="edit-profile-form">
                        <div class="profile-user-info profile-user-info-striped">
                            <input hidden id="user_id" value="<?PHP echo $user['cms_id']?>">
                            <input hidden id="telephone" value="<?PHP echo $user['cms_telephone']?>">
                            <input hidden id="role_id" value="<?PHP echo $user['cms_role_id']?>">
                            <div class="profile-info-row">
                                <div class="profile-info-name">用户名</div>

                                <div class="profile-info-value">
                                    <input type="text" class="editable" id="username" name="username" value="<?PHP echo $user['cms_name']?>">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">地址</div>

                                <div class="profile-info-value">
                                    <input type="text" class="editable" id="address" name="address" value="<?PHP if (isset($user['cms_address'])){echo $user['cms_address'];}?>">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">邮箱</div>

                                <div class="profile-info-value">
                                    <input type="email" class="editable" id="email" name="email" value="<?PHP echo $user['cms_email']?>">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">成立时间</div>

                                <div class="profile-info-value">
                                    <div class="input-group date form_date" style="padding-bottom: 0!important;width: 33%" data-date="" data-date-format="yyyy-mm-dd" data-link-field="establish_date" data-link-format="yyyy-mm-dd">
                                        <input class="form-control" type="text" value="" readonly>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                    <input type="hidden" id="establish_date" value="" />
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">主营产品</div>

                                <div class="profile-info-value">
                                    <input type="text" style="width: 50%" class="editable" id="main_product" name="main_product" value="<?PHP echo $user['cms_desc']?>">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">销售渠道</div>

                                <div class="profile-info-value">
                                    <input type="text" style="width: 50%" class="editable" id="sale_channels" name="sale_channels" value="<?PHP echo $user['cms_desc']?>">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">对公银行账户数据信息</div>

                                <div class="profile-info-value">
                                    <input type="text" style="width: 100%" class="editable" id="bank_info" name="bank_info" value="" placeholder="如开户名、开户地、开户行、银行卡号">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">快递发货地址、电话、收件人</div>

                                <div class="profile-info-value">
                                    <input type="text" style="width: 100%" class="editable" id="courier_info" name="courier_info" value="">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">大件发货地址、电话、收件人</div>

                                <div class="profile-info-value">
                                    <input type="text" style="width: 100%" class="editable" id="courier_big_info" name="courier_big_info" value="">
                                </div>
                            </div>


                            <div class="profile-info-row">
                                <div class="profile-info-name">简介</div>

                                <div class="profile-info-value">
                                    <input type="text" style="width: 100%" class="editable" id="desc" name="desc" value="<?PHP echo $user['cms_desc']?>">
                                </div>
                            </div>
                        </div>
                        <div class="profile-info-row center">
                            <button class="btn btn-primary">确认修改</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--修改密码-->
            <div class="user-profile row tab-pane" id="edit_password">
                <div class="col-xs-12 col-sm-12">
                    <form id="edit-password-form">
                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name">用户id</div>

                                <div class="profile-info-value">
                                    <span class="editable"><?PHP echo $user['cms_id']?></span>
                                    <input type="text"  hidden name="user_id" id="user_id" value="<?PHP echo $user['cms_id']?>">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">手机号</div>

                                <div class="profile-info-value">
                                    <span class="editable"><?PHP echo $user['cms_telephone']?></span>
                                    <input type="tel" hidden name="telephone" id="telephone" value="<?PHP echo $user['cms_telephone']?>">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name">旧密码</div>

                                <div class="profile-info-value">
                                    <input type="password" class="editable" id="old_password" name="old_password">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">新密码</div>

                                <div class="profile-info-value">
                                    <input type="password" class="editable" id="new_password" name="new_password">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name">再次输入新密码</div>

                                <div class="profile-info-value">
                                    <input type="password" class="editable" id="confirmPassword" name="confirmPassword">
                                </div>
                            </div>
                        </div>
                        <div class="profile-info-row center">
                            <button type="submit" class="btn btn-primary">确认修改</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!--<div class="hr dotted"></div>-->
    <!--<div class="">-->
    <!--    <div class="col-xs-12 center">-->
    <!--        <div class="col-xs-12 col-sm-3">-->
    <!--            <button class="btn btn-primary" href="edit_profile">完善资料</button>-->
    <!--        </div>-->
    <!--        <div class="col-xs-12 col-sm-3">-->
    <!--            <button class="btn btn-primary">修改密码</button>-->
    <!--        </div>-->
    <!--        <div class="col-xs-12 col-sm-3">-->
    <!--            <button class="btn btn-primary">修改手机号</button>-->
    <!--        </div>-->
    <!--        <div class="col-xs-12 col-sm-3"></div>-->
    <!--    </div>-->
    <!--</div>-->
</div>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_date').datetimepicker({
        language:  'zh-CN',
        weekStart: 0, //一周从哪一天开始
        todayBtn:  1, //
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        showMeridian: 1
    });
</script>
</body>
</html>