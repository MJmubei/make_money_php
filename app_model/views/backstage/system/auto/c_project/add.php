<script type="text/javascript">
$(document).ready(function() {
    $('#system_add_form').bootstrapValidator({
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
    $('#system_add_form').on('hide.bs.modal', function () {
   	 	$('#system_add_form').data('bootstrapValidator').resetForm(true);
	});
    $("#system_add_form").submit(function(ev){ev.preventDefault();});
    $('#system_add_reset_btn').click(function() {
        $('#system_add_form').data('bootstrapValidator').resetForm(true);
    });
    function system_add_submit_data()
    {
    	var data=$('.system-add-form-horizontal').serialize();
    	//序列化获得表单数据，结果为：user_id=12&user_name=John&user_age=20
    	var submitData=decodeURIComponent(data,true);
    	//submitData是解码后的表单数据，结果同上
    	submitData+="&flag_ajax_reurn=1";
    	$.ajax({
        	url:'../../../system/auto/c_project/add',
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
					$('#system-add-modal-confirm-result-confirm').show();
					$('#system-add-modal-confirm-result-cancel').hide();
                }
        		else
            	{
					$('#system-add-modal-confirm-result-confirm').hide();
					$('#system-add-modal-confirm-result-cancel').show();
                }
    	    	$('#system-add-modal-confirm-view').modal('hide');
    	    	$('#system-add-modal-confirm-result-content').html("<p>"+dataObj.reason+"<p>");
    	    	$('#system-add-modal-confirm-result').modal({backdrop:'false',keyboard:false});
        	},
        	complete:function(){
        	    //请求结束时
        	},
        	error:function(){
        	    //请求失败时
        	}
    	});
    }
    $('#system-add-modal-confirm').click(function(){
    	var bootstrapValidator = $("#system_add_form").data('bootstrapValidator');
        bootstrapValidator.validate();
        if(bootstrapValidator.isValid()){
        	$('#system-add-modal-confirm-view').modal({backdrop:'false',keyboard:false});
        }else{
            return;
        }
    });
    $('#system-add-modal-confirm-view-cancel').click(function(){
    	$('#system-add-modal-confirm-view').modal('hide');
    });
    $('#system-add-modal-confirm-view-confirm').click(function(){
    	system_add_submit_data();
    });
    $('#system-add-modal-confirm-result-cancel').click(function(){
    	$('#system-add-modal-confirm-result').modal('hide');
    });

    $('#system-add-modal-confirm-result-confirm').click(function(){
    	$('#system-add-modal-confirm-result').modal('hide');
    });
});
</script>
<button class="btn purple" type="button" data-toggle="modal" data-target="#system-add-modal">
	   <i class="fa fa-book"> 添加</i>
</button>
<div class="modal fade" id="system-add-modal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">添加数据</h2>
			</div>
			<div class="modal-body">
                <form id="system_add_form" method="post" class="system-add-form-horizontal" action="">
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
                				<textarea name="cms_remark" name="cms_remark" id="txtarea1" cols="50" rows="4" class="form-control"></textarea>
                			</div>
                		</div>
                	</div>
                </form>
			</div>
			<div class="clearfix"></div>
            <div class="modal-footer">
                <div class="form-body">
                    <span>
                		<button id="system-add-modal-confirm" class="btn purple" type="button" >
                        	   <i class="fa fa-book"> 提交 </i>
                        </button>
                		<div class="modal fade" id="system-add-modal-confirm-view" tabindex="-1" aria-hidden="true">
                			<div class="modal-dialog">
                				<div class="modal-content">
                					<div class="modal-header">
                                        <h4 class="modal-title">确认添加数据？</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <span>
                                            <button type="button" class="btn btn-primary" id="system-add-modal-confirm-view-confirm">确定</button>
                                        </span>
                                        <span>
                                            <button type="button" class="btn btn-primary" id="system-add-modal-confirm-view-cancel">取消</button>
                                        </span>
                                    </div>
                				</div>
                			</div>
                		</div>
                		<div class="modal fade" id="system-add-modal-confirm-result" tabindex="-1" aria-hidden="true">
                			<div class="modal-dialog">
                				<div class="modal-content">
                					<div class="modal-header">
                                        <h4 class="modal-title">处理结果:</h4>
                                    </div>
                					<div class="modal-body" id="system-add-modal-confirm-result-content">
                					
                					</div>
                                    <div class="modal-footer">
                                        <span id="system-add-modal-confirm-result-confirm">
                                            <button type="button" class="btn btn-primary" onclick="url_refresh();">确定</button>
                                        </span>
                                        <span id="system-add-modal-confirm-result-cancel">
                                            <button type="button" class="btn btn-primary">确定</button>
                                        </span>
                                    </div>
                				</div>
                			</div>
                		</div>
                    </span>
                    <span>
                        <button class="btn purple" type="button" id="system_add_reset_btn">
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