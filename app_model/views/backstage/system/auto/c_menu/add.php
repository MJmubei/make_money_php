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
                		<label class="col-md-3 control-label">项目</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-file-text-o"></i>
                				</span> 
                				<select name="cms_project_id" id="cms_project_id" class="form-control1">
            				        <option id="cms_project_id" name="cms_project_id" value="">---请选择项目---</option>
                				    <?php if(isset($project_list) && is_array($project_list) && !empty($project_list)){foreach ($project_list as $project_list_key=>$project_list_value){?>
                				        <option value="<?php echo $project_list_value['cms_id'];?>"><?php echo $project_list_value['cms_name'];?></option>
                				    <?php }}?>
                				</select>
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">目录标示</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-file-text-o"></i>
                				</span> <input id="cms_mark" name="cms_mark" class="form-control1 icon" type="text" value="" placeholder="">
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">目录名称</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-file-text-o"></i>
                				</span> <input id="cms_name" name="cms_name" class="form-control1 icon" type="text" value="" placeholder="">
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">目录地址</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-file-text-o"></i>
                				</span> <input id="cms_url" name="cms_url" class="form-control1 icon" type="text" value="" placeholder="">
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">目录层级</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-file-text-o"></i>
                				</span> 
                				<select name="cms_level" id="cms_level" class="form-control1">
            				        <option value="">---请选择目录层级---</option>
            				        <option value="1">1</option>
            				        <option value="2">2</option>
            				        <option value="3">3</option>
                				</select>
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">父级ID</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-file-text-o"></i>
                				</span> <input id="cms_parent_id" name="cms_parent_id" class="form-control1 icon" type="text" value="" placeholder="">
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">权重</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-level-up"></i>
                				</span> <input id="cms_order" name="cms_order" class="form-control1 icon" type="text" value="" placeholder="">
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