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
                cms_mark: {
                    group: '.col-lg-4',
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            message: '输入字符长度需要在6-30之间'
                        },
                    }
                },
                cms_name: {
                    group: '.col-lg-4',
                    validators: {}
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
                <h2 class="modal-title">修改数据</h2>
            </div>
            <div class="modal-body">
                <form id="<?php echo $system_file_list_value['class'];?>-form" method="post" action="" >
                    <div class="form-group">
                        <label class="col-md-2 control-label">属性名称</label>
                        <div class="col-md-10">
                            <div class="input-group input-icon right">
                                <span class="input-group-addon"> <i class="fa fa-file-text-o"></i></span>
                                <input id="cms_name" name="cms_name" class="form-control1 icon" type="text" value="" placeholder="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <div class="form-body">
                    <span>
                		<button class="btn purple" type="button" onclick="sys_sweetalert('submit','<?php echo $system_file_list_value['class'];?>','您确定要添加这条信息吗','提交数据后系统将可能会添加此条数据，请谨慎操作！','<?php echo $system_file_list_value['ajax'];?>','',true);">
                        	   <i class="fa fa-book"> 提交 </i>
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