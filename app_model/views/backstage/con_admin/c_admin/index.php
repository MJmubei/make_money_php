<!DOCTYPE html>
<html lang="en">
<head>
        <?php include_once dirname(dirname(dirname(__FILE__))).'/pub_web_file.php';?>
    </head>
<body>
        <?php include_once dirname(dirname(dirname(__FILE__))).'/pub_top_menu.php';?>
        <div class="ch-container">
		<div class="row">
                <?php include_once dirname(dirname(dirname(__FILE__))).'/pub_left_menu.php';?>
                <div id="content" class="col-lg-10 col-sm-10">
				<div>
					<ul class="breadcrumb">
						<li><a href="#">Home</a></li>
						<li><a href="#">Tables</a></li>
					</ul>
				</div>
				<div class="row">
					<div class="box col-md-12">
						<div class="box-inner">
							<div class="box-header well" data-original-title="">
								<h2>
									<i class="glyphicon glyphicon-user"></i> Datatable + Responsive
								</h2>
								<div class="box-icon">
									<!--     									<a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>  -->
									<!--     									<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>  -->
									<!--     									<a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a> -->
								</div>
							</div>

							<div class="box-content">
                                <div class="row">
									
									<div class="col-md-3">
										<div class="dataTables_filter" id="DataTables_Table_1_filter">
											<label>Search: <input type="text"
												aria-controls="DataTables_Table_1"></label>
										</div>
									</div>
									<div class="col-md-3">
										<div class="dataTables_filter" id="DataTables_Table_1_filter">
											<label>Search: <input type="text"
												aria-controls="DataTables_Table_1"></label>
										</div>
									</div>
									<div class="col-md-3">
										<div class="dataTables_filter" id="DataTables_Table_1_filter">
											<label>Search: <input type="text"
												aria-controls="DataTables_Table_1"></label>
										</div>
									</div>
									<div class="col-md-3">
										<div class="dataTables_filter" id="DataTables_Table_1_filter">
											<label>Search: <input type="text"
												aria-controls="DataTables_Table_1"></label>
										</div>
									</div>
								</div>
								<table
									class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th><input type='checkbox' /></th>
											<th>用户名</th>
											<th>性别</th>
											<th>家庭地址</th>
											<th>注册日期</th>
											<th>信用等级</th>
											<th>会员信息</th>
											<th>本月消费</th>
											<th>额度</th>
											<th>角色</th>
											<th>状态</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
    									   <?php for($i=0;$i<10;$i++){?>
    										<tr>
											<th><input type='checkbox' /></th>
											<td>David R</td>
											<td class="center">男</td>
											<td class="center">四川成都</td>
											<td class="center">2012/01/01</td>
											<td class="center">5</td>
											<td class="center">普通会员</td>
											<td class="center">￥20</td>
											<td class="center">￥300</td>
											<td class="center">Member</td>
											<td class="center"><span
												class="label-error label label-default">禁用</span></td>
											<td class="center">
												<div class="btn-group">
													<button data-toggle="dropdown">
														<span class="hidden-sm hidden-xs"> 操作</span><span
															class="caret"></span>
													</button>
													<ul class="dropdown-menu">
														<li><a href="#"><i class="whitespace"></i> 查看详情 </a></li>
														<li><a href="#"><i class="whitespace"></i> 修改 </a></li>
														<li><a href="#"><i class="whitespace"></i> 删除 </a></li>
													</ul>
												</div>
											</td>
										</tr>
    										<?php }?>
    									</tbody>
								</table>
								<div class="row">
									
									
									<div class="col-md-6">
										<div id="DataTables_Table_1_length" class="dataTables_length">
											<label><select size="1" name="DataTables_Table_1_length"
												aria-controls="DataTables_Table_1"><option value="10"
														selected="selected">10</option>
													<option value="25">25</option>
													<option value="50">50</option>
													<option value="100">100</option></select> records per page</label>
										</div>
									</div>
									<div class="col-md-6">
										<ul class="pagination pagination-centered">
									<li><a href="#">Prev</a></li>
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li><a href="#">Next</a></li>

								</ul>
									</div>
								</div>
								

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
            <?php include_once dirname(dirname(dirname(__FILE__))).'/pub_foot_menu.php';?>
        </div>
</body>
</html>
