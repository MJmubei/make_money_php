<script type="text/javascript">
$(function(){  
    $('#system-state-modal-1').click(function (){
    	if(check_checkbox_value().length<1)
        {
    		$('#system-state-modal-error').modal({backdrop:'false',keyboard:false});
        }
    	else
    	{
        	$('#system-state-modal-1-confirm').show();
        	$('#system-state-modal-2-confirm').hide();
    		$('#system-state-modal-ok').modal({backdrop:'false',keyboard:false});
    	}
	});

    $('#system-state-modal-2').click(function (){
    	if(check_checkbox_value().length<1)
        {
    		$('#system-state-modal-error').modal({backdrop:'false',keyboard:false});
        }
    	else
    	{
        	$('#system-state-modal-1-confirm').hide();
        	$('#system-state-modal-2-confirm').show();
    		$('#system-state-modal-ok').modal({backdrop:'false',keyboard:false});
    	}
	});
	
	$('.system-state-modal-1-right').click(function (){
        var attr_key = $(this).attr('attr-key');
        var attr_value = $(this).attr('attr-value');
		if(attr_key.length <1 || attr_value.length <1)
		{
			$('#system-state-modal-error').modal({backdrop:'false',keyboard:false});
			return;
		}
        var cms_id = attr_key+'[]='+attr_value+'&';
        $('#system-state-modal-1-confirm-right').attr('attr-value',cms_id);
	});

	$('.system-state-modal-2-right').click(function (){
        var attr_key = $(this).attr('attr-key');
        var attr_value = $(this).attr('attr-value');
		if(attr_key.length <1 || attr_value.length <1)
		{
			$('#system-state-modal-error').modal({backdrop:'false',keyboard:false});
			return;
		}
        var cms_id = attr_key+'[]='+attr_value+'&';
        $('#system-state-modal-2-confirm-right').attr('attr-value',cms_id);
	});

    
	
    function system_state_submit_data(submitData,cms_state)
    {
    	//submitData是解码后的表单数据，结果同上
    	submitData+="flag_ajax_reurn=1&cms_state="+cms_state;
    	$.ajax({
        	url:'../../../system/auto/c_project/state',
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
					$('#system-state-modal-confirm-result-confirm').show();
					$('#system-state-modal-confirm-result-cancel').hide();
                }
        		else
            	{
					$('#system-state-modal-confirm-result-confirm').hide();
					$('#system-state-modal-confirm-result-cancel').show();
                }
    	    	$('#system-state-modal-confirm-view').modal('hide');
    	    	$('#system-state-modal-confirm-result-content').html(dataObj.reason);
    	    	$('#system-state-modal-confirm-result').modal({backdrop:'false',keyboard:false});
        	},
        	complete:function(){
        	    //请求结束时
        	},
        	error:function(){
        	    //请求失败时
        	}
    	});
    }
    $('#system-state-modal-1-confirm').click(function (){
    	var cms_id = check_checkbox_value();
    	if(cms_id.length<1)
        {
    		$('#system-state-modal-error').modal({backdrop:'false',keyboard:false});
    		return;
        }
    	$('#system-state-modal-ok').modal('hide');
    	system_state_submit_data(cms_id,0);
	});
	
    $('#system-state-modal-2-confirm').click(function (){
    	var cms_id = check_checkbox_value();
    	if(cms_id.length<1)
        {
    		$('#system-state-modal-error').modal({backdrop:'false',keyboard:false});
    		return;
        }
    	$('#system-state-modal-ok').modal('hide');
    	system_state_submit_data(cms_id,1);
	});

    $('#system-state-modal-1-confirm-right').click(function (){
    	var cms_id = $(this).attr('attr-value');
    	if(cms_id.length<1)
        {
    		$('#system-state-modal-error').modal({backdrop:'false',keyboard:false});
    		return;
        }
    	system_state_submit_data(cms_id,0);
	});

    $('#system-state-modal-2-confirm-right').click(function (){
    	var cms_id = $(this).attr('attr-value');
    	if(cms_id.length<1)
        {
    		$('#system-state-modal-error').modal({backdrop:'false',keyboard:false});
    		return;
        }
    	system_state_submit_data(cms_id,1);
	});
    
});
</script>
<button class="btn purple" type="button" data-toggle="modal" id="system-state-modal-1">
   <i class="fa fa-unlock"> 启用 </i>
</button>
<button class="btn purple" type="button" data-toggle="modal" id="system-state-modal-2">
   <i class="fa fa-lock"> 禁用 </i>
</button>
<div class="modal fade" id="system-state-modal-error" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">请至少选择一条需要操作的数据</h2>
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
<div class="modal fade" id="system-state-modal-ok" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">确认要启用、禁用选择的数据？</h2>
			</div>
            <div class="modal-footer">
                <span>
                    <button id="system-state-modal-1-confirm" class="btn purple" type="button" >
                    	   <i class="fa fa-book"> 确定 </i>
                    </button>
                </span>
                <span>
                    <button id="system-state-modal-2-confirm" class="btn purple" type="button" >
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
<div class="modal fade" id="system-state-modal-1-right" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">确认要启用选择的数据？</h2>
			</div>
            <div class="modal-footer">
                <span>
                    <button id="system-state-modal-1-confirm-right" attr-value="" class="btn purple" type="button" >
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
<div class="modal fade" id="system-state-modal-2-right" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">确认要禁用选择的数据？</h2>
			</div>
            <div class="modal-footer">
                <span>
                    <button id="system-state-modal-2-confirm-right" attr-value="" class="btn purple" type="button" >
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
<div class="modal fade" id="system-state-modal-confirm-result" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title">处理结果:</h2>
			</div>
			<div class="clearfix"></div>
			<div class="modal-body" id="system-state-modal-confirm-result-content">
			
			</div>
            <div class="modal-footer">
                <span id="system-state-modal-confirm-result-confirm">
                    <button type="button" class="btn btn-primary" onclick="url_refresh();">确定</button>
                </span>
                <span id="system-state-modal-confirm-result-cancel">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
                </span>
            </div>
		</div>
	</div>
</div>