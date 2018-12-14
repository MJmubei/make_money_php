<script type="text/javascript">
$(function(){
    $('#system-delete-modal').click(function (){
    	if(check_checkbox_value().length<1)
        {
    		$('#system-delete-modal-error').modal({backdrop:'false',keyboard:false});
        }
    	else
    	{
    		$('#system-delete-modal-ok').modal({backdrop:'false',keyboard:false});
    	}
	});
	$('.system-delete-modal-right').click(function (){
        var attr_key = $(this).attr('attr-key');
        var attr_value = $(this).attr('attr-value');
		if(attr_key.length <1 || attr_value.length <1)
		{
			$('#system-delete-modal-error').modal({backdrop:'false',keyboard:false});
			return;
		}
        var cms_id = attr_key+'[]='+attr_value+'&';
        $('#system-delete-modal-confirm-right').attr('attr-value',cms_id);
        $('#system-delete-modal-ok-right').modal({backdrop:'false',keyboard:false});
	});
    function system_delete_submit_data(submitData)
    {
    	//submitData是解码后的表单数据，结果同上
    	submitData+="flag_ajax_reurn=1";
    	$.ajax({
        	url:'../../../system/auto/c_project/delete',
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
					$('#system-delete-modal-confirm-result-confirm').show();
					$('#system-delete-modal-confirm-result-cancel').hide();
                }
        		else
            	{
					$('#system-delete-modal-confirm-result-confirm').hide();
					$('#system-delete-modal-confirm-result-cancel').show();
                }
    	    	$('#system-delete-modal-confirm-view').modal('hide');
    	    	$('#system-delete-modal-confirm-result-content').html(dataObj.reason);
    	    	$('#system-delete-modal-confirm-result').modal({backdrop:'false',keyboard:false});
        	},
        	complete:function(){
        	    //请求结束时
        	},
        	error:function(){
        	    //请求失败时
        	}
    	});
    }
    $('#system-delete-modal-confirm').click(function (){
    	var cms_id = check_checkbox_value();
    	if(cms_id.length<1)
        {
    		$('#system-delete-modal-error').modal({backdrop:'false',keyboard:false});
    		return;
        }
    	$('#system-delete-modal-ok').modal('hide');
    	system_delete_submit_data(cms_id);
	});

    $('#system-delete-modal-confirm-right').click(function (){
    	var cms_id = $(this).attr('attr-value');
    	if(cms_id.length<1)
        {
    		$('#system-delete-modal-error').modal({backdrop:'false',keyboard:false});
    		return;
        }
    	$('#system-delete-modal-ok-right').modal('hide');
    	system_delete_submit_data(cms_id);
	});
});
</script>
<button class="btn purple" type="button" data-toggle="modal" id="system-delete-modal">
   <i class="fa fa-trash-o"> 删除</i>
</button>
<div class="modal fade" id="system-delete-modal-error" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">请至少选择一条需要删除的数据</h2>
			</div>
			<div class="clearfix"></div>
            <div class="modal-footer">
                <span>
                    <button class="btn purple" type="button" data-dismiss="modal">
                    	   <i class="fa fa-book"> 确定 </i>
                    </button>
                </span>
            </div>
		</div>
	</div>
</div>
<div class="modal fade" id="system-delete-modal-ok" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">确认要删除选择的数据？</h2>
			</div>
            <div class="modal-footer">
                <span>
                    <button id="system-delete-modal-confirm" class="btn purple" type="button" >
                    	   <i class="fa fa-book"> 确定 </i>
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
<div class="modal fade" id="system-delete-modal-ok-right" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">确认要删除选择的数据？</h2>
			</div>
            <div class="modal-footer">
                <span>
                    <button id="system-delete-modal-confirm-right" attr-value="" class="btn purple" type="button" >
                    	   <i class="fa fa-book"> 确定 </i>
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
<div class="modal fade" id="system-delete-modal-confirm-result" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title">处理结果:</h2>
			</div>
			<div class="clearfix"></div>
			<div class="modal-body" id="system-delete-modal-confirm-result-content">
			
			</div>
            <div class="modal-footer">
                <span id="system-delete-modal-confirm-result-confirm">
                    <button type="button" class="btn btn-primary" onclick="url_refresh();">确定</button>
                </span>
                <span id="system-delete-modal-confirm-result-cancel">
                    <button type="button" class="btn btn-primary">确定</button>
                </span>
            </div>
		</div>
	</div>
</div>