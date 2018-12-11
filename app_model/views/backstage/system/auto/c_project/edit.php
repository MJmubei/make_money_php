<script type="text/javascript">
$(document).ready(function() {
	<?php
	   $temp_data_info_edit = (isset($data_info)&&is_array($data_info) && !empty($data_info)) ? $data_info : null;
	   $data_info_edit = null;
	   if(is_array($temp_data_info_edit))
	   {
	       foreach ($temp_data_info_edit as $value)
	       {
	           $data_info_edit[$value['cms_id']]=$value;
	       }
	   }
	?>
    var JQ_data_info_edit = <?php echo (is_array($data_info_edit)) ? json_encode($data_info_edit) : json_encode(array());?>;
    $('#system_edit_form').bootstrapValidator({
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
    $('#system_edit_form').on('hide.bs.modal', function () {
   	 	$('#system_edit_form').data('bootstrapValidator').resetForm(true);
	});
    $("#system_edit_form").submit(function(ev){ev.preventDefault();});
    $('#system_edit_reset_btn').click(function() {
        $('#system_edit_form').data('bootstrapValidator').resetForm(true);
    });
    function system_edit_submit_data()
    {
    	var data=$('.system-edit-form-horizontal').serialize();
    	//序列化获得表单数据，结果为：user_id=12&user_name=John&user_age=20
    	var submitData=decodeURIComponent(data,true);
    	//submitData是解码后的表单数据，结果同上
    	submitData+="&flag_ajax_reurn=1";
    	$.ajax({
        	url:'../../../system/auto/c_project/edit',
			type:"POST",
        	data:submitData,
        	cache:false,//false是不缓存，true为缓存
        	async:true,//true为异步，false为同步
        	beforeSend:function(){
            	
        	},
        	success:function(result){
        		var dataObj=eval("("+result+")");
        		if(dataObj.ret == 0)
            	{
					$('#system-edit-modal-confirm-result-confirm').show();
					$('#system-edit-modal-confirm-result-cancel').hide();
                }
        		else
            	{
					$('#system-edit-modal-confirm-result-confirm').hide();
					$('#system-edit-modal-confirm-result-cancel').show();
                }
    	    	$('#system-edit-modal-confirm-view').modal('hide');
    	    	$('#system-edit-modal-confirm-result-content').html("<p>"+dataObj.reason+"<p>");
    	    	$('#system-edit-modal-confirm-result').modal({backdrop:'false',keyboard:false});
        	},
        	complete:function(){
        	    //请求结束时
        	},
        	error:function(){
        	    //请求失败时
        	}
    	});
    }
    $('#system-edit-modal-confirm').click(function(){
    	var bootstrapValidator = $("#system_edit_form").data('bootstrapValidator');
        bootstrapValidator.validate();
        if(bootstrapValidator.isValid()){
        	$('#system-edit-modal-confirm-view').modal({backdrop:'false',keyboard:false});
        }else{
            return;
        }
    });
    $('#system-edit-modal-confirm-view-cancel').click(function(){
    	$('#system-edit-modal-confirm-view').modal('hide');
    });
    $('#system-edit-modal-confirm-view-confirm').click(function(){
    	system_edit_submit_data();
    });
    $('#system-edit-modal-confirm-result-cancel').click(function(){
    	$('#system-edit-modal-confirm-result').modal('hide');
    });

    $('#system-edit-modal-confirm-result-confirm').click(function(){
    	$('#system-edit-modal-confirm-result').modal('hide');
    });

    $('.system-edit-modal-right').click(function (){
    	var attr_key = $(this).attr('attr-key');
        var attr_value = $(this).attr('attr-value');
		if(attr_key.length <1 || attr_value.length <1)
		{
			$('#system-delete-modal-error').modal({backdrop:'false',keyboard:false});
			return;
		}
		var JQ_data_info_edit_line = JQ_data_info_edit[attr_value];
		$('#system_edit_form').find("input").each(function(){
        	var i_type = $(this).attr('type');
        	var i_name = $(this).attr('name');
        	if(i_type.length>0 && i_name.length>0)
            {
                var temp_data = JQ_data_info_edit_line[i_name];
                if(i_type == 'text' || i_type=='password')
                {
                    $(this).val(temp_data);
                }
                else if(i_type == 'checkbox')
                {

                }
                else if(i_type == 'radio' && temp_data == $(this).val())
                {
                	$(this).attr("checked", true);
                }
                else
                {
                	$(this).val('');
                }
            }
        	else
            {
                $(this).val('');
            }
    	});
		$('#system_edit_form').find("textarea").each(function(){
        	var i_name = $(this).attr('name');
        	if(i_name.length>0)
            {
                var temp_data = JQ_data_info_edit_line[i_name];
                $(this).html(temp_data);
            }
        	else
            {
                $(this).html('');
            }
    	});
	});
});
</script>
<!-- <button class="btn purple" type="button" data-toggle="modal" data-target="#system-edit-modal"> -->
<!-- 	   <i class="fa fa-book"> 修改</i> -->
<!-- </button> -->
<div class="modal fade" id="system-edit-modal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">修改数据</h2>
			</div>
			<div class="modal-body">
                <form id="system_edit_form" method="post" class="system-edit-form-horizontal" action="">
                    <div class="form-group" style="display: none;">
                		<label class="col-md-3 control-label">项目ID</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-file-text-o"></i>
                				</span> <input id="cms_id" name="cms_id" class="form-control1 icon" type="text" value="" placeholder="">
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">项目标示</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-file-text-o"></i>
                				</span> <input id="cms_mark" name="cms_mark" class="form-control1 icon" type="text" value="" placeholder="">
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">项目名称</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-file-text-o"></i>
                				</span> <input id="cms_name" name="cms_name" class="form-control1 icon" type="text" value="" placeholder="">
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">联系人手机号码</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-phone"></i>
                				</span> <input id="cms_mobilephone_number" name="cms_mobilephone_number" class="form-control1 icon" type="text" value="" placeholder="">
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">联系人座机号码</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-phone"></i>
                				</span> <input id="cms_telphone_number" name="cms_telphone_number" class="form-control1 icon" type="text" value="" placeholder="">
                			</div>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-md-3 control-label">邮箱</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-envelope-o"></i>
                				</span> <input id="cms_email" name="cms_email" class="form-control1 icon" type="text" value="" placeholder="">
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
                	<div class="form-group">
                		<label class="col-md-3 control-label">备注</label>
                		<div class="col-md-9">
                			<div class="input-group input-icon right">
                				<span class="input-group-addon"> <i class="fa fa-book"></i>
                				</span>
                				<textarea name="cms_remark" id="cms_remark" cols="50" rows="4" class="form-control"></textarea>
                			</div>
                		</div>
                	</div>
                </form>
			</div>
			<div class="clearfix"></div>
            <div class="modal-footer">
                <div class="form-body">
                    <span>
                		<button id="system-edit-modal-confirm" class="btn purple" type="button" >
                        	   <i class="fa fa-book"> 提交 </i>
                        </button>
                		<div class="modal fade" id="system-edit-modal-confirm-view" tabindex="-1" aria-hidden="true">
                			<div class="modal-dialog">
                				<div class="modal-content">
                					<div class="modal-header">
                                        <h4 class="modal-title">确认修改数据？</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <span>
                                            <button type="button" class="btn btn-primary" id="system-edit-modal-confirm-view-confirm">确定</button>
                                        </span>
                                        <span>
                                            <button type="button" class="btn btn-primary" id="system-edit-modal-confirm-view-cancel">取消</button>
                                        </span>
                                    </div>
                				</div>
                			</div>
                		</div>
                		<div class="modal fade" id="system-edit-modal-confirm-result" tabindex="-1" aria-hidden="true">
                			<div class="modal-dialog">
                				<div class="modal-content">
                					<div class="modal-header">
                                        <h4 class="modal-title">处理结果:</h4>
                                    </div>
                					<div class="modal-body" id="system-edit-modal-confirm-result-content">
                					
                					</div>
                                    <div class="modal-footer">
                                        <span id="system-edit-modal-confirm-result-confirm">
                                            <button type="button" class="btn btn-primary" onclick="url_refresh();">确定</button>
                                        </span>
                                        <span id="system-edit-modal-confirm-result-cancel">
                                            <button type="button" class="btn btn-primary">确定</button>
                                        </span>
                                    </div>
                				</div>
                			</div>
                		</div>
                    </span>
                    <span>
                        <button class="btn purple" type="button" id="system_edit_reset_btn">
                        	   <i class="fa fa-book"> 重置数据 </i>
                        </button>
                    </span>
                    <span>
                        <button class="btn purple" type="button" data-dismiss="modal">
                        	   <i class="fa fa-book"> 取消 </i>
                        </button>
                    </span>
        		</div>
            </div>
		</div>
	</div>
</div>