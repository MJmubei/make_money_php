<!DOCTYPE HTML>
<html>
<head>
<!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
<script>
    function hideModal(){
    	$('#submit-modal').modal('hide');
    }
    function showModal(header,title){
        $('#submit-modal-header-desc').html(header);
        if(title.length>0)
        {
        	$('#submit-modal-title').show();
    		$('#submit-modal-title-desc').html(title);
        }
        else
        {
        	$('#submit-modal-title').hide();
        }
    	$('#submit-modal').modal({backdrop:'static',keyboard:false});
    }
    
    function sleep(n) 
    {
        var start = new Date().getTime();
        while(true)  if(new Date().getTime()-start > n) break;
    }
    
    $(function(){
        // 给登录按钮增加事件监听
        $('#btn-submit').click(function(){
        	var data=$('.form-horizontal').serialize();
        	//序列化获得表单数据，结果为：user_id=12&user_name=John&user_age=20
        	var submitData=decodeURIComponent(data,true);
        	//submitData是解码后的表单数据，结果同上
        	submitData+="&flag_ajax_reurn=1";
        	var back_url="../../../system/auto/c_project/index";
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
            			showModal("执行成功!结果描述:",dataObj.reason);
                    }
            		else
                	{
            			showModal("执行失败!结果描述:",dataObj.reason);
                    }
            		sleep(100);
        			window.location.href = back_url;
            	},
            	complete:function(){
            	    //请求结束时
            	},
            	error:function(){
            	    //请求失败时
            	}
        	})
        });
        $('#pre-btn-submit').click(function(){
        	showModal('确认修改数据？','');
        });
    });
</script>
</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
	<div class="left-content">
	   <div class="inner-content">
				<!--*********** 初始化必须加载 ***************** （顶部导航栏加载） *********** 初始化必须加载 *****************   -->
				<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_menu.php';?>
				<div class="outter-wp">
					<div class="but_list">
						<ol class="breadcrumb">
							<li><a href="#">Home</a></li>
							<li><a href="#">Library</a></li>
							<li class="active">Data</li>
						</ol>
					</div>
					<h3 class="inner-tittle two">项目数据修改</h3>
					<div class="set-3">
    					<div class="graph-2 general">
							<div class="grid-1">
							   <form class="form-horizontal">
							        <input name="cms_id" class="" type="hidden" value="<?php echo $data_info[0]['cms_id'];?>" >
									<div class="form-group">
										<label class="col-md-2 control-label">项目名称</label>
										<div class="col-md-8">
											<div class="input-group input-icon right">
												<span class="input-group-addon">
													<i class="fa fa-file-text-o"></i>
												</span>
												<input id="cms_name" name="cms_name" class="form-control1 icon" type="text" value="<?php echo $data_info[0]['cms_name'];?>" placeholder="">
											</div>
										</div>
										<div class="col-sm-2">
											<p class="help-block">With tooltip</p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">联系人手机号码</label>
										<div class="col-md-8">
											<div class="input-group input-icon right">
												<span class="input-group-addon">
													<i class="fa fa-phone"></i>
												</span>
												<input id="cms_mobilephone_number" name="cms_mobilephone_number" class="form-control1 icon" type="text" value="<?php echo $data_info[0]['cms_mobilephone_number'];?>" placeholder="">
											</div>
										</div>
										<div class="col-sm-2">
											<p class="help-block">With tooltip</p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">联系人座机号码</label>
										<div class="col-md-8">
											<div class="input-group input-icon right">
												<span class="input-group-addon">
													<i class="fa fa-phone"></i>
												</span>
												<input id="cms_telphone_number" name="cms_telphone_number" class="form-control1 icon" type="text" value="<?php echo $data_info[0]['cms_telphone_number'];?>" placeholder="">
											</div>
										</div>
										<div class="col-sm-2">
											<p class="help-block">With tooltip</p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">邮箱</label>
										<div class="col-md-8">
											<div class="input-group input-icon right">
												<span class="input-group-addon">
													<i class="fa fa-envelope-o"></i>
												</span>
												<input id="cms_email" name="cms_email" class="form-control1 icon" type="text" value="<?php echo $data_info[0]['cms_email'];?>" placeholder="">
											</div>
										</div>
										<div class="col-sm-2">
											<p class="help-block">With tooltip</p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">权重</label>
										<div class="col-md-8">
											<div class="input-group input-icon right">
												<span class="input-group-addon">
													<i class="fa fa-level-up"></i>
												</span>
												<input id="cms_order" name="cms_order" class="form-control1 icon" type="text" value="<?php echo $data_info[0]['cms_order'];?>" placeholder="">
											</div>
										</div>
										<div class="col-sm-2">
											<p class="help-block">With tooltip</p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">备注</label>
										<div class="col-md-8">
											<div class="input-group input-icon right">
												<span class="input-group-addon">
													<i class="fa fa-book"></i>
												</span>
												<textarea name="cms_remark" name="cms_remark" id="txtarea1" cols="50" rows="4" class="form-control"><?php echo $data_info[0]['cms_remark'];?></textarea>
											</div>
										</div>
										<div class="col-sm-2">
											<p class="help-block">With tooltip</p>
										</div>
									</div>
								</form>
								
								<div class="form-body">
    						     <div class="col-md-12 form-group button-2">
    								<button class="btn purple" id="pre-btn-submit" type="button" data-toggle="modal" >
    									<i class="fa fa-book"> 提交 </i>
    								</button>
    								<button class="btn purple" id="btn-back" type="button" data-toggle="modal" >
    									<i class="fa fa-edit"> 返回 </i>
    								</button>
    								<div class="modal fade" id="submit-modal" tabindex="-1" style="display: none;">
    									<div class="modal-dialog">
    										<div class="modal-content">
    											<div class="modal-header">
    												<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
    												<h2 id="submit-modal-header-desc" class="modal-title"></h2>
    											</div>
    											<div class="modal-body" id="submit-modal-title">
    												<p class="modal-body" id="submit-modal-title-desc"></p>
    											</div>
    											<div class="modal-footer">
													<button type="button" class="btn btn-default close" data-dismiss="modal">取消</button>
													<button id="btn-submit" type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
    											</div>
    										</div>
    									</div>
    								</div>
    							</div>
    							<div class="clearfix"></div>
    						</div>
							</div>
        					
    					</div>
    				</div>
				</div>
				<!--*********** 初始化必须加载 ***************** （最下版权加载） *********** 初始化必须加载 ***************** -->
		        <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_footer.php';?>
			</div>
		</div>			
		<!--*********** 初始化必须加载 ***************** （左侧目录加载） *********** 初始化必须加载 ***************** -->
		<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_left_menu.php';?>
</body>
</html>