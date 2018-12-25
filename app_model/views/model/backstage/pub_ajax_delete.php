<script>
    function hideModal(){
    	$(".modal-backdrop").remove();
    	$('#system-button-submit-delete').modal('hide');
    }
	
    function showModal(header,title,post_url,back_url){
        $('#system-button-submit-delete-header-content').html(header);
        if(title.length>0)
        {
        	$('#system-button-submit-delete-title').show();
    		$('#system-button-submit-delete-title-content').html(title);
        }
        else
        {
        	$('#system-button-submit-delete-title').hide();
        }
        if(post_url.length>0)
       	{
        	$('#system-button-submit-delete-confirm').hide();
        	$('#system-button-submit-delete-ajax').show();
        	$('#system-button-submit-delete-back').hide();
        }
        else if(back_url.length>0 && back_url == 'back')
        {
        	$('#system-button-submit-delete-confirm').hide();
        	$('#system-button-submit-delete-ajax').hide();
        	$('#system-button-submit-delete-back').show();
        }
        else if(back_url.length>0 && back_url == 'keep')
        {
        	$('#system-button-submit-delete-confirm').hide();
        	$('#system-button-submit-delete-ajax').hide();
        	$('#system-button-submit-delete-back').hide();
        }
        else
        {
        	$('#system-button-submit-delete-confirm').hide();
        	$('#system-button-submit-delete-ajax').show();
        	$('#system-button-submit-delete-back').hide();
        }
    	$('#system-button-submit-delete').modal({backdrop:'false',keyboard:false});
    }
    
    $(function(){
    	$('#system-button-submit-delete-back').click(function(){
        	var back_url="../../../system/auto/c_project/index";
    		location.href = back_url;
        });
        // 给登录按钮增加事件监听
        $('#system-button-submit-delete-ajax').click(function(){
        	var data=$('#system_select_checkbox').serialize();
        	//序列化获得表单数据，结果为：user_id=12&user_name=John&user_age=20
        	var submitData=decodeURIComponent(data,true);
        	//submitData是解码后的表单数据，结果同上
        	submitData+="&flag_ajax_reurn=1";
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
            			showModal("执行成功!",dataObj.reason,'','back');
                    }
            		else
                	{
            			showModal("执行失败!",dataObj.reason,'','keep');
                    }
            	},
            	complete:function(){
            	    //请求结束时
            	},
            	error:function(){
            	    //请求失败时
            	}
        	})
        });
        $('#pre-system-button-submit-delete').click(function(){
        	showModal('确认删除数据？','','','');
        });
        $('#system-button-submit-delete-hidden1').click(function(){
        	hideModal();
        });
        $('#system-button-submit-delete-hidden2').click(function(){
        	hideModal();
        });
    });
</script>

<div class="modal fade" id="system-button-submit-delete" tabindex="-1" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button id="system-button-submit-delete-hidden1" type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 id="system-button-submit-delete-header-content" class="modal-title"></h2>
			</div>
			<div class="modal-body" id="system-button-submit-delete-title">
				<p class="modal-body" id="system-button-submit-delete-title-content"></p>
			</div>
			<div class="modal-footer">
				<button id="system-button-submit-delete-hidden2" type="button" class="btn btn-default close">取消</button>
				<button id="system-button-submit-delete-confirm" type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
				<button id="system-button-submit-delete-ajax" type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
				<button id="system-button-submit-delete-back" type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
			</div>
		</div>
	</div>
</div>