<script>
    function hideModal(){
    	$(".modal-backdrop").remove();
    	$('#system-button-submit-edit').modal('hide');
    }
	
    function showModal(header,title,post_url,back_url){
        $('#system-button-submit-edit-header-content').html(header);
        if(title.length>0)
        {
        	$('#system-button-submit-edit-title').show();
    		$('#system-button-submit-edit-title-content').html(title);
        }
        else
        {
        	$('#system-button-submit-edit-title').hide();
        }
        if(post_url.length>0)
       	{
        	$('#system-button-submit-edit-confirm').hide();
        	$('#system-button-submit-edit-ajax').show();
        	$('#system-button-submit-edit-back').hide();
        }
        else if(back_url.length>0 && back_url == 'back')
        {
        	$('#system-button-submit-edit-confirm').hide();
        	$('#system-button-submit-edit-ajax').hide();
        	$('#system-button-submit-edit-back').show();
        }
        else if(back_url.length>0 && back_url == 'keep')
        {
        	$('#system-button-submit-edit-confirm').hide();
        	$('#system-button-submit-edit-ajax').hide();
        	$('#system-button-submit-edit-back').hide();
        }
        else
        {
        	$('#system-button-submit-edit-confirm').hide();
        	$('#system-button-submit-edit-ajax').show();
        	$('#system-button-submit-edit-back').hide();
        }
    	$('#system-button-submit-edit').modal({backdrop:'false',keyboard:false});
    }
    
    $(function(){
    	$('#system-button-submit-edit-back').click(function(){
        	var back_url="../../../system/auto/c_project/index";
    		location.href = back_url;
        });
        // 给登录按钮增加事件监听
        $('#system-button-submit-edit-ajax').click(function(){
        	var data=$('.form-horizontal').serialize();
        	//序列化获得表单数据，结果为：user_id=12&user_name=John&user_age=20
        	var submitData=decodeURIComponent(data,true);
        	//submitData是解码后的表单数据，结果同上
        	submitData+="&flag_ajax_reurn=1";
        	$.ajax({
            	url:'../../../system/auto/c_project/do_edit',
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
        $('#pre-system-button-submit-edit').click(function(){
        	showModal('确认修改数据？','','','');
        });
        $('#system-button-submit-edit-hidden1').click(function(){
        	hideModal();
        });
        $('#system-button-submit-edit-hidden2').click(function(){
        	hideModal();
        });
    });
</script>
<div class="form-body">
	<div class="col-md-12 form-group button-2">
		<button class="btn purple" id="pre-system-button-submit-edit" type="button" data-toggle="modal">
			<i class="fa fa-book"> 提交 </i>
		</button>
		<button class="btn purple" id="pre-system-button-back" type="button" data-toggle="modal">
			<i class="fa fa-edit"> 返回 </i>
		</button>
		<div class="modal fade" id="system-button-submit-edit" tabindex="-1"
			style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button id="system-button-submit-edit-hidden1" type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
						<h2 id="system-button-submit-edit-header-content" class="modal-title"></h2>
					</div>
					<div class="modal-body" id="system-button-submit-edit-title">
						<p class="modal-body" id="system-button-submit-edit-title-content"></p>
					</div>
					<div class="modal-footer">
						<button id="system-button-submit-edit-hidden2" type="button" class="btn btn-default close">取消</button>
						<button id="system-button-submit-edit-confirm" type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
						<button id="system-button-submit-edit-ajax" type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
						<button id="system-button-submit-edit-back" type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>