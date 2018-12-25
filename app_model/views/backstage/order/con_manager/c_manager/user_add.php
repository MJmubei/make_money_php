<script type="text/javascript">
    $(document).ready(function() {
        $('#<?php echo $system_file_list_value['class'];?>-form').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                username: {
                    group: '.col-lg-4',
                    validators: {
                        notEmpty: {
                            message: '名称不能为空'
                        },
                        stringLength: {
                            min: 1,
                            max: 30,
                            message: '输入字符长度需要在1-30之间'
                        }
                    }
                },
                password: {
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
                            field: 'password', //需要进行比较的input name值
                            message: '两次密码不一致'
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
                },
                captcha: {
                    validators: {
                        callback: {
                            message: 'Wrong answer',
                            callback: function(value, validator) {
                                var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                                return value == sum;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
<?php foreach ($system_file_list_value['button_data'] as $key=>$button_data_value){?>
    <button class="btn purple" type="button" data-toggle="modal" data-target="#<?php echo $system_file_list_value['class'];?>" onclick="system_auto_load('<?php echo $system_file_list_value['class'];?>','<?php echo $button_data_value['params'];?>');">
        <i class="fa <?php echo $button_data_value['icon'];?>"> <?php echo $button_data_value['name'];?></i>
    </button>
<?php }?>
<div class="modal fade" id="<?php echo $system_file_list_value['class'];?>" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content animated bounceInTop">
            <div class="modal-header">
                <button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">添加数据</h2>
            </div>
            <div class="modal-body">
                <form id="<?php echo $system_file_list_value['class'];?>-form" method="post" action="" >
                    <div class="form-group" style="display:none;">
                        <input name="aa" type="text" value="" >
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">名称</label>
                        <div class="col-md-10">
                            <div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-file-text-o"></i>
                				</span> <input id="username" name="username" class="form-control1 icon" type="text" value="" placeholder="名称">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">手机号</label>
                        <div class="col-md-10">
                            <div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-phone"></i>
                				</span> <input id="telephone" name="telephone" class="form-control1 icon" type="text" value="" placeholder="手机号">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">密码</label>
                        <div class="col-md-10">
                            <div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-lock"></i>
                				</span> <input id="password" name="password" class="form-control1 icon" type="password" placeholder="密码">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">确认密码</label>
                        <div class="col-md-10">
                            <div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-lock"></i>
                				</span> <input id="confirmPassword" name="confirmPassword" class="form-control1 icon" type="password" placeholder="请再次输入密码">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">性别</label>
                        <div class="col-md-10">
                            <div class="input-group input-icon right">
                                <input id="sex" name="sex" type="radio" value="1" checked/>未知
                                <input id="sex" name="sex" type="radio" value="2"/>男
                                <input id="sex" name="sex" type="radio" value="3"/>女
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">状态</label>
                        <div class="col-md-10">
                            <div class="input-group input-icon right">
                                <input id="state" name="state" type="radio" value="0" checked/>启用
                                <input id="state" name="state" type="radio" value="1"/>禁用
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">备注</label>
                        <div class="col-md-10">
                            <div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-book"></i>
                				</span>
                                <textarea name="desc" name="desc" id="desc" cols="50" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <div class="form-body">
                    <span>
                        <script type="text/javascript">
                            function md5_password()
                            {
                                var md5_password =  hex_md5($('#password').val());
                                $('#password').val(md5_password);
                                var md5_confirmPassword =  hex_md5($('#confirmPassword').val());
                                $('#confirmPassword').val(md5_confirmPassword);
                                sys_sweetalert('submit','<?php echo $system_file_list_value['class'];?>','您确定要添加这条信息吗','提交数据后系统将可能会添加此条数据，请谨慎操作！','<?php echo $system_file_list_value['ajax'];?>','',true);
                            }
                        </script>
                		<button class="btn purple" type="button" onclick="md5_password()">
                        	   <i class="fa fa-book"> 提交 </i>
                        </button>
                    </span>
                    <span>
                        <button class="btn purple" type="button" id="<?php echo $system_file_list_value['class'];?>-reset">
                        	   <i class="fa fa-book"> 重置数据 </i>
                        </button>
                    </span>
                    <span>
                        <button class="btn purple" type="button" id="<?php echo $system_file_list_value['class'];?>-cancel" data-dismiss="modal">
                        	   <i class="fa fa-book"> 取消 </i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>