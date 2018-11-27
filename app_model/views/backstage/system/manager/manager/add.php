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
				<div class="outter-wp">
					<!--/sub-heard-part-->
					<div class="sub-heard-part">
						<ol class="breadcrumb m-b-0">
							<li><a href="index.html">Home</a></li>
							<li class="active">Forms Validation</li>
						</ol>
					</div>
					<!--/sub-heard-part-->
					<!--/forms-->
					<div class="forms-main">
						<h2 class="inner-tittle">管理员添加</h2>
						<div class="graph-form">
							<div class="validation-form">
								<!---->
								<form>
									<div class="form-group1">
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">管理员名称</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="cms_name">
										</div>
										
									    <div class="clearfix"></div><hr/>
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">后台账号</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<input type="email" class="form-control" id="inputEmail3" placeholder="Current Website Url" name="cms_login_account">
										</div>
										<div class="clearfix"></div><hr/>
										
										
										<div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">密码</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<input type="password" class="form-control" id="inputEmail3" placeholder="Create a password" name="cms_login_pass">
										</div>
										
										<div class="clearfix"></div><hr/>
										
										<div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">密码确认</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<input type="password" class="form-control" id="inputEmail3" placeholder="Create a password" name="cms_login_pass_conform">
										</div>
										
										<div class="clearfix"></div><hr/>
										
										
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">Language</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<select>
    											<option value="">English</option>
    											<option value="">Japanese</option>
    											<option value="">Russian</option>
    											<option value="">Arabic</option>
    											<option value="">Spanish</option>
										    </select>
										</div>
										
										<div class="clearfix"></div><hr/>
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">Your Comment</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<textarea placeholder="Your Comment..." required="">Your Comment.....</textarea>
										</div>
										
										<div class="clearfix"></div><hr/>
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">Phone Number</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<input type="text" class="form-control" id="inputEmail3" placeholder="Phone Number" >
										</div>
										
										<div class="clearfix"></div><hr/>
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">Mobile Number</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<input type="text" class="form-control" id="inputEmail3" placeholder="Mobile Number" >
										</div>
										
										<div class="clearfix"></div><hr/>
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">Create a password</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<input type="password" class="form-control" id="inputEmail3" placeholder="Create a password" >
										</div>
										
										<div class="clearfix"></div><hr/>
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">Repeated password</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<input type="password" class="form-control" id="inputEmail3" placeholder="Repeated password" >
										</div>
										
										<div class="clearfix"></div><hr/>
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">Date</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<input type="date" class="form-control1 ng-invalid ng-invalid-required" ng-model="model.date" required="" >
										</div>
										
										<div class="clearfix"></div><hr/>
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">Multiple
														Select</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<select multiple="" class="form-control1">
    											<option>Option 1</option>
    											<option>Option 2</option>
    											<option>Option 3</option>
    											<option>Option 4</option>
    											<option>Option 5</option>
    										</select>
										</div>
										
										<div class="clearfix"></div><hr/>
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">Checkbox</label>
										</div>
										<div class="col-sm-7 form-group2 group-mail">
											<div class="checkbox-inline1">
												<label><input type="checkbox"> Unchecked</label>
											</div>
											<div class="checkbox-inline1">
												<label><input type="checkbox" checked="">
													Checked</label>
											</div>
											<div class="checkbox-inline1">
												<label><input type="checkbox" disabled="">
													Disabled Unchecked</label>
											</div>
											<div class="checkbox-inline1">
												<label><input type="checkbox" disabled="" checked=""> Disabled Checked</label>
											</div>
										</div>
										
										<div class="clearfix"></div><hr/>
									    <div class="col-sm-2">
										    <label for="inputEmail3" class="col-sm-2 control-label">Checkbox</label>
										</div>
										<div class="col-sm-9 form-group2 group-mail">
											<div class="col-sm-8">
												<div class="checkbox-inline">
													<label><input type="checkbox"> Unchecked</label>
												</div>
												<div class="checkbox-inline">
													<label><input type="checkbox" checked="">
														Checked</label>
												</div>
												<div class="checkbox-inline">
													<label><input type="checkbox" disabled="">
														Disabled Unchecked</label>
												</div>
												<div class="checkbox-inline">
													<label><input type="checkbox" disabled="" checked=""> Disabled Checked</label>
												</div>
											</div>
										</div>
										<div class="clearfix"></div><hr/>
									    <div class="col-sm-1">
										    <button type="submit" class="btn btn-default">提交</button>
										</div>
										<div class="col-sm-1">
										    <button type="submit" class="btn btn-default">重置</button>
										</div>
										<div class="col-sm-1">
										    <button type="submit" class="btn btn-default">返回</button>
										</div>
									</div>
									<div class="clearfix"></div>
								</form>
							</div>
							
						</div>
					</div>
					<!--//forms-->
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