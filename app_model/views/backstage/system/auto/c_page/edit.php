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
                        min: 1,
                        max: 30,
                        message: '输入字符长度需要在6-30之间'
                    },
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

    $('#<?php echo $system_file_list_value['class'];?>-reset').click(function() {
        $('#<?php echo $system_file_list_value['class'];?>-form').data('bootstrapValidator').resetForm(true);
    });
    
	$('#<?php echo $system_file_list_value['class'];?>-cancel').click(function() {
        $('#<?php echo $system_file_list_value['class'];?>-form').data('bootstrapValidator').resetForm(true);
    });
});
function init_<?php echo $system_file_list_value['class'];?>(str_class,paramas)
{
	var oFileInput = new FileInput();
    oFileInput.Init('edit',"image_data_edit_1",'image_data_edit_value_1',paramas);
};
</script>
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
                        <label class="col-md-3 control-label">单文件上传</label>
                        <div class="col-md-9">
                           <input type="file" id="image_data_edit_1" name="image_data" accept="image/*">
                        </div>
                        <div id="image_data_edit_value_1" post_name="cms_image_v" >
                            <input type="text" name="cms_image_v" value="2018/12/25/5c2105c117a0e1ce987c488e60a0576f.png">
                        </div>
                    </div>
                </form>
			</div>
			<div class="clearfix"></div>
            <div class="modal-footer">
                <div class="form-body">
                    <span>
                		<button class="btn purple" type="button" onclick="sys_sweetalert('submit','<?php echo $system_file_list_value['class'];?>','您确定要修改这条信息吗','提交数据后系统将可能会修改此条数据，请谨慎操作！','<?php echo $system_file_list_value['ajax'];?>','',true);">
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