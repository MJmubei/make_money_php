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
						<div class="col-md-3 compose">
							<div class="input-group input-group-in">
                                <input type="text" class="form-control" id="input-select-node" placeholder="分类查询" value="">
								<span class="input-group-btn">
									<button class="btn btn-success" type="button">
										<i class="fa fa-search"></i>
									</button>
								</span>
							</div>
                            <h2>分类</h2>
                            <div id="treeview-selectable" class=""></div>
						</div>
						<!-- tab content -->
						<div class="col-md-9 tab-content tab-content-in">
							<div class="tab-pane active text-style" id="tab1">
								<div class="inbox-right">

									<div class="mailbox-content">
										<div class="mail-toolbar clearfix">
											<div class="float-left">
												<div class="input-group input-group-in">
													<input type="text" name="search" class="form-control2 input-search" placeholder="分类列表查询"> 
													<span class="input-group-btn">
														<button class="btn btn-success" type="button">
															<i class="fa fa-search"></i>
														</button>
													</span>
												</div>

											</div>

										</div>
										<table class="table">
											<tbody>
												<tr class="table-row">
													<td class="table-img"><img src="images/in.jpg" alt="" /></td>
													<td class="table-text">
														<h6>Lorem ipsum</h6>
														<p>Nullam quis risus eget urna mollis ornare vel eu leo</p>
													</td>
													<td><span class="fam">Family</span></td>
													<td class="march">in 5 days</td>

													<td><i class="fa fa-star-half-o icon-state-warning"></i></td>
												</tr>
												<tr class="table-row">
													<td class="table-img"><img src="images/in1.jpg" alt="" /></td>
													<td class="table-text">
														<h6>Lorem ipsum</h6>
														<p>Nullam quis risus eget urna mollis ornare vel eu leo</p>
													</td>
													<td><span class="mar">Market</span></td>
													<td class="march">in 5 days</td>

													<td><i class="fa fa-star-half-o icon-state-warning"></i></td>
												</tr>
												<tr class="table-row">
													<td class="table-img"><img src="images/in2.jpg" alt="" /></td>
													<td class="table-text">
														<h6>Lorem ipsum</h6>
														<p>Nullam quis risus eget urna mollis ornare vel eu leo</p>
													</td>
													<td><span class="work">work</span></td>
													<td class="march">in 5 days</td>

													<td><i class="fa fa-star-half-o icon-state-warning"></i></td>
												</tr>
												<tr class="table-row">
													<td class="table-img"><img src="images/in3.jpg" alt="" /></td>
													<td class="table-text">
														<h6>Lorem ipsum</h6>
														<p>Nullam quis risus eget urna mollis ornare vel eu leo</p>
													</td>
													<td><span class="fam">Family</span></td>
													<td class="march">in 4 days</td>

													<td><i class="fa fa-star-half-o icon-state-warning"></i></td>
												</tr>
												<tr class="table-row">
													<td class="table-img"><img src="images/in4.jpg" alt="" /></td>
													<td class="table-text">
														<h6>Lorem ipsum</h6>
														<p>Nullam quis risus eget urna mollis ornare vel eu leo</p>
													</td>
													<td><span class="ur">urgent</span></td>
													<td class="march">in 4 days</td>

													<td><i class="fa fa-star-half-o icon-state-warning"></i></td>
												</tr>
											</tbody>
										</table>

										<!--*********** 初始化必须加载 ***************** （分页信息） *********** 初始化必须加载 ***************** -->
                		                <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_page.php';?>
                		                <div class="form-body">
											<div class="col-md-12 form-group button-2">
												<button class="btn blue" type="button"
													id="btn_tablecheckbox_check">
													<i class="fa fa-check-circle-o"> 全选</i>
												</button>

												<button class="btn blue" type="button"
													id="btn_tablecheckbox_exchange">
													<i class="fa fa-times-circle-o"> 反选</i>
												</button>

												<button class="btn blue" type="button"
													id="btn_tablecheckbox_uncheck">
													<i class="fa fa-times-circle"> 取消</i>
												</button>
												<button class="btn purple" type="button" data-toggle="modal"
													data-target="#myModal">
													<a href="../../../system/auto/c_project/add" title=""> <i
														class="fa fa-book"> 添加</i>
													</a>
												</button>
												<div class="modal fade" id="myModal1" tabindex="-1"
													role="dialog" aria-labelledby="myModalLabel"
													aria-hidden="true" style="display: none;">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close second"
																	data-dismiss="modal" aria-hidden="true">×</button>
																<h2 class="modal-title">是否确认自动生成项目清单？</h2>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default"
																	data-dismiss="modal">取消</button>
																<button type="button" class="btn btn-primary">确认</button>
															</div>
														</div>
													</div>
												</div>
												<button class="btn red six" type="button"
													id="pre-system-button-submit-add">
													<i class="fa fa-trash-o"> 删除</i>
												</button>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
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