<!DOCTYPE HTML>
<html>
<head>
<!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		.htmleaf-header{margin-bottom: 15px;font-family: "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", "FontAwesome", sans-serif;}
		.htmleaf-icon{color: #fff;}
	</style>
</head>
</head>
<body>
	<div class="page-container">
		<!--/content-inner-->
		<div class="left-content">
			<div class="inner-content">
				<!--*********** 初始化必须加载 ***************** （顶部导航栏加载） *********** 初始化必须加载 *****************   -->
				<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_menu.php';?>
					<div class="outter-wp">
					<!--/sub-heard-part-->
					<div class="sub-heard-part">
						<ol class="breadcrumb m-b-0">
							<li><a href="index.html">Home</a></li>
							<li class="active">Inbox</li>
						</ol>
					</div>
					<!--/sub-heard-part-->
					<!--/inbox-->
					<div class="inbox-mail">
						<div class="col-md-6 compose">
							<div class="input-group input-group-in">
                                <input type="text" class="form-control" id="input-select-node" placeholder="分类查询" value="">
								<span class="input-group-btn">
									<button class="btn btn-success" type="button">
										<i class="fa fa-search"></i>
									</button>
								</span>
							</div>
                            <h2>分类</h2>
                            <div id="treeview-searchable" class=""></div>
						</div>
						
						<!-- tab content -->
						<div class="col-md-6 tab-content tab-content-in">
							<div class="grid-1">
							   
							   <form class="form-horizontal">
									<div class="form-group">
										<label class="col-md-2 control-label">GUID</label>
										<div class="col-md-8">
											<div class="input-group input-icon right">
												<span class="input-group-addon">
													<i class="fa fa-file-text-o"></i>
												</span>
												<input id="cms_id" name="cms_id" class="form-control1 icon" type="text" value="" placeholder="">
											</div>
										</div>
										<div class="col-sm-2">
											<p class="help-block">With tooltip</p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">父级ID</label>
										<div class="col-md-8">
											<div class="input-group input-icon right">
												<span class="input-group-addon">
													<i class="fa fa-file-text-o"></i>
												</span>
												<input id="cms_parent_id" name="cms_parent_id" class="form-control1 icon" type="text" value="" placeholder="">
											</div>
										</div>
										<div class="col-sm-2">
											<p class="help-block">With tooltip</p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">分类名称</label>
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
								</form>
                				<!--*********** 初始化必须加载 ***************** （最下版权加载） *********** 初始化必须加载 ***************** -->
                		        <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_ajax_add.php';?>
							</div>
						</div>
						<div class="clearfix"></div>
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