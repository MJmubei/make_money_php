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
    									<a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a> 
    									<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a> 
    									<a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
    								</div>
    							</div>
    							<div class="box-content">
    								<table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    									<thead>
    										<tr>
    										    <th><input type='checkbox'/></th>
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
    										<tr>
    										    <th><input type='checkbox'/></th>
    											<td>David R</td>
    											<td class="center">男</td>
    											<td class="center">四川成都</td>
    											<td class="center">2012/01/01</td>
    											<td class="center">5</td>
    											<td class="center">普通会员</td>
    											<td class="center">￥20</td>
    											<td class="center">￥300</td>
    											<td class="center">Member</td>
    											<td class="center"><span class="label-error label label-default">禁用</span></td>
    											<td class="center">
                                                    <div class="btn-group">
                                                    	<button  data-toggle="dropdown"><span class="hidden-sm hidden-xs"> 操作</span><span class="caret"></span></button>
                                                    	<ul class="dropdown-menu" >
                                                    		<li><a href="#"><i class="whitespace"></i> 查看详情 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 修改 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 删除 </a></li>
                                                    	</ul>
                                                    </div>
    											</td>
    										</tr>
    										<tr>
    										    <th><input type='checkbox'/></th>
    											<td>David R</td>
    											<td class="center">男</td>
    											<td class="center">四川成都</td>
    											<td class="center">2012/01/01</td>
    											<td class="center">5</td>
    											<td class="center">普通会员</td>
    											<td class="center">￥20</td>
    											<td class="center">￥300</td>
    											<td class="center">Member</td>
    											<td class="center"><span class="label-danger label label-default">异常</span></td>
    											<td class="center">
                                                    <div class="btn-group">
                                                    	<button  data-toggle="dropdown"><span class="hidden-sm hidden-xs"> 操作</span><span class="caret"></span></button>
                                                    	<ul class="dropdown-menu" >
                                                    		<li><a href="#"><i class="whitespace"></i> 查看详情 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 修改 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 删除 </a></li>
                                                    	</ul>
                                                    </div>
    											</td>
    										</tr>
    										<tr>
    										    <th><input type='checkbox'/></th>
    											<td>David R</td>
    											<td class="center">男</td>
    											<td class="center">四川成都</td>
    											<td class="center">2012/01/01</td>
    											<td class="center">5</td>
    											<td class="center">普通会员</td>
    											<td class="center">￥20</td>
    											<td class="center">￥300</td>
    											<td class="center">Member</td>
    											<td class="center"><span class="label-success label label-default">正常</span></td>
    											<td class="center">
                                                    <div class="btn-group">
                                                    	<button  data-toggle="dropdown"><span class="hidden-sm hidden-xs"> 操作</span><span class="caret"></span></button>
                                                    	<ul class="dropdown-menu" >
                                                    		<li><a href="#"><i class="whitespace"></i> 查看详情 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 修改 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 删除 </a></li>
                                                    	</ul>
                                                    </div>
    											</td>
    										</tr>
    										<tr>
    										    <th><input type='checkbox'/></th>
    											<td>David R</td>
    											<td class="center">男</td>
    											<td class="center">四川成都</td>
    											<td class="center">2012/01/01</td>
    											<td class="center">5</td>
    											<td class="center">普通会员</td>
    											<td class="center">￥20</td>
    											<td class="center">￥300</td>
    											<td class="center">Member</td>
    											<td class="center"><span class="label-success label label-default">正常</span></td>
    											<td class="center">
                                                    <div class="btn-group">
                                                    	<button  data-toggle="dropdown"><span class="hidden-sm hidden-xs"> 操作</span><span class="caret"></span></button>
                                                    	<ul class="dropdown-menu" >
                                                    		<li><a href="#"><i class="whitespace"></i> 查看详情 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 修改 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 删除 </a></li>
                                                    	</ul>
                                                    </div>
    											</td>
    										</tr>
    										<tr>
    										    <th><input type='checkbox'/></th>
    											<td>David R</td>
    											<td class="center">男</td>
    											<td class="center">四川成都</td>
    											<td class="center">2012/01/01</td>
    											<td class="center">5</td>
    											<td class="center">普通会员</td>
    											<td class="center">￥20</td>
    											<td class="center">￥300</td>
    											<td class="center">Member</td>
    											<td class="center"><span class="label-success label label-default">正常</span></td>
    											<td class="center">
                                                    <div class="btn-group">
                                                    	<button  data-toggle="dropdown"><span class="hidden-sm hidden-xs"> 操作</span><span class="caret"></span></button>
                                                    	<ul class="dropdown-menu" >
                                                    		<li><a href="#"><i class="whitespace"></i> 查看详情 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 修改 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 删除 </a></li>
                                                    	</ul>
                                                    </div>
    											</td>
    										</tr>
    										<tr>
    										    <th><input type='checkbox'/></th>
    											<td>David R</td>
    											<td class="center">男</td>
    											<td class="center">四川成都</td>
    											<td class="center">2012/01/01</td>
    											<td class="center">5</td>
    											<td class="center">普通会员</td>
    											<td class="center">￥20</td>
    											<td class="center">￥300</td>
    											<td class="center">Member</td>
    											<td class="center"><span class="label-success label label-default">正常</span></td>
    											<td class="center">
                                                    <div class="btn-group">
                                                    	<button  data-toggle="dropdown"><span class="hidden-sm hidden-xs"> 操作</span><span class="caret"></span></button>
                                                    	<ul class="dropdown-menu" >
                                                    		<li><a href="#"><i class="whitespace"></i> 查看详情 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 修改 </a></li>
                                                    		<li><a href="#"><i class="whitespace"></i> 删除 </a></li>
                                                    	</ul>
                                                    </div>
    											</td>
    										</tr>
    									</tbody>
    								</table>
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
