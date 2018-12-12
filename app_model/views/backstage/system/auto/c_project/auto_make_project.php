<script type="text/javascript">
$(function(){
    $('#system-auto-make-project-modal').click(function (){
		$('#system-auto-make-project-modal-ok').modal({backdrop:'false',keyboard:false});
	});
    function system_auto_make_project_submit_data()
    {
    	var submitData="flag_ajax_reurn=1";
    	$.ajax({
        	url:'../../../system/auto/c_project/auto_make_project',
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
					$('#system-auto-make-project-modal-confirm-result-confirm').show();
					$('#system-auto-make-project-modal-confirm-result-cancel').hide();
                }
        		else
            	{
					$('#system-auto-make-project-modal-confirm-result-confirm').hide();
					$('#system-auto-make-project-modal-confirm-result-cancel').show();
                }
    	    	$('#system-auto-make-project-modal-confirm-view').modal('hide');
    	    	$('#system-auto-make-project-modal-confirm-result-content').html(dataObj.reason);
    	    	$('#system-auto-make-project-modal-confirm-result').modal({backdrop:'false',keyboard:false});
        	},
        	complete:function(){
        	    //请求结束时
        	},
        	error:function(){
        	    //请求失败时
        	}
    	});
    }
    $('#system-auto-make-project-modal-confirm').click(function (){
    	$('#system-auto-make-project-modal-ok').modal('hide');
    	system_auto_make_project_submit_data();
	});
});
</script>
<button class="btn purple" type="button" data-toggle="modal" id="system-auto-make-project-modal">
   <i class="fa fa-book"> 自动生成项目列表 </i>
</button>
<div class="modal fade" id="system-auto-make-project-modal-ok" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">确认要自动生成项目列表选择的数据？</h2>
			</div>
            <div class="modal-footer">
                <span>
                    <button id="system-auto-make-project-modal-confirm" class="btn purple" type="button" >
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
<div class="modal fade" id="system-auto-make-project-modal-confirm-result" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title">处理结果:</h2>
			</div>
			<div class="clearfix"></div>
			<div class="modal-body" id="system-auto-make-project-modal-confirm-result-content">
			
			</div>
            <div class="modal-footer">
                <span id="system-auto-make-project-modal-confirm-result-confirm">
                    <button type="button" class="btn btn-primary" onclick="url_refresh();">确定</button>
                </span>
                <span id="system-auto-make-project-modal-confirm-result-cancel">
                    <button type="button" class="btn btn-primary">确定</button>
                </span>
            </div>
		</div>
	</div>
</div>