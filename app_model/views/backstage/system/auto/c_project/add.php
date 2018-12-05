<!DOCTYPE HTML>
<html>
<head>
<!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
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
									<div class="form-group">
										<label class="col-md-2 control-label">项目标示</label>
										<div class="col-md-8">
											<div class="input-group input-icon right">
												<span class="input-group-addon">
													<i class="fa fa-file-text-o"></i>
												</span>
												<input id="cms_mark" name="cms_mark" class="form-control1 icon" type="text" value="" placeholder="">
											</div>
										</div>
										<div class="col-sm-2">
											<p class="help-block">With tooltip</p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">项目名称</label>
										<div class="col-md-8">
											<div class="input-group input-icon right">
												<span class="input-group-addon">
													<i class="fa fa-file-text-o"></i>
												</span>
												<input id="cms_name" name="cms_name" class="form-control1 icon" type="text" value="" placeholder="">
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
												<input id="cms_mobilephone_number" name="cms_mobilephone_number" class="form-control1 icon" type="text" value="" placeholder="">
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
												<input id="cms_telphone_number" name="cms_telphone_number" class="form-control1 icon" type="text" value="" placeholder="">
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
												<input id="cms_email" name="cms_email" class="form-control1 icon" type="text" value="" placeholder="">
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
												<input id="cms_order" name="cms_order" class="form-control1 icon" type="text" value="" placeholder="">
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
												<textarea name="cms_remark" name="cms_remark" id="txtarea1" cols="50" rows="4" class="form-control"></textarea>
											</div>
										</div>
										<div class="col-sm-2">
											<p class="help-block">With tooltip</p>
										</div>
									</div>
								</form>
                				<!--*********** 初始化必须加载 ***************** （最下版权加载） *********** 初始化必须加载 ***************** -->
                		        <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_ajax_add.php';?>
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