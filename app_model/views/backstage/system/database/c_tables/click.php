<?php if(!defined('VIEW_MODEL_BACKGROUD')){define('VIEW_MODEL_BACKGROUD', '/CodeIgniter/view_model/backstage/');}?>
<!DOCTYPE HTML>
<html>
<head>
<!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
<?php include_once dirname(dirname(dirname(dirname(__FILE__)))).'/pub_top_web_file.php';?>
</head>
<body>
	<div class="page-container">
		<!--/content-inner-->
		<div class="left-content">
			<div class="inner-content">
				<!--*********** 初始化必须加载 ***************** （顶部导航栏加载） *********** 初始化必须加载 *****************   -->
				<?php include_once dirname(dirname(dirname(dirname(__FILE__)))).'/pub_top_menu.php';?>
				<!--//outer-wp-->
				<div class="outter-wp">
					<!--/sub-heard-part-->
					<div class="sub-heard-part">
						<ol class="breadcrumb m-b-0">
							<li><a href="index.html">Home</a></li>
							<li class="active">Typography Page</li>
						</ol>
					</div>
					<div class="typo-grid">
						<div class="typo-1">
							<h3 class="head-top">Modal</h3>
							<div class="grid_3 grid_5">
								<div class="bs-example2 bs-example-padded-bottom">
									<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Launch demo modal</button>
									<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
													<h2 class="modal-title">Modal title</h2>
												</div>
												<div class="modal-body">
													<h2>Text in a modal</h2>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="button" class="btn btn-primary">Save changes</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--*********** 初始化必须加载 ***************** （最下版权加载） *********** 初始化必须加载 ***************** -->
		        <?php include_once dirname(dirname(dirname(dirname(__FILE__)))).'/pub_footer.php';?>
			</div>
		</div>
		<!--*********** 初始化必须加载 ***************** （左侧目录加载） *********** 初始化必须加载 ***************** -->
		<?php include_once dirname(dirname(dirname(dirname(__FILE__)))).'/pub_left_menu.php';?>
	</div>
	<!--*********** 初始化必须加载 ***************** （底部JS加载   必须放在下面） *********** 初始化必须加载 *****************   -->
	<?php include_once dirname(dirname(dirname(dirname(__FILE__)))).'/pub_foot_web_file.php';?>
</body>
</html>