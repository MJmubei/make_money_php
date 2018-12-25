<!DOCTYPE HTML>
<html>
<head>
<!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
</head> 
<body>
    <div class="outter-wp">
    	<div class="but_list">
    		<ol class="breadcrumb">
    			<li><a href="#">系统配置</a></li>
    			<li><a href="#">自动化管理</a></li>
    			<li class="active">目录列表</li>
    		</ol>
    	</div>
    	<div class="graph">
    		<div class="form-body">
    			<form class="form-horizontal" method="post" action="<?php echo $arr_page_url['list_url'];?>">
    				<div class="form-group">
    					<label for="disabledinput" class="col-sm-1 control-label">名称</label>
    					<div class="col-sm-2">
    						<input type="text" class="form-control1" name="TABLE_NAME" id="focusedinput" value="<?php echo isset($arr_params['TABLE_NAME']) ? $arr_params['TABLE_NAME'] : '';?>">
    					</div>
    					<label for="disabledinput" class="col-sm-1 control-label">类型</label>
    					<div class="col-sm-2">
    						<input type="text" class="form-control1" id="focusedinput" value="<?php echo isset($arr_params['TABLE_TYPE']) ? $arr_params['TABLE_TYPE'] : '';?>">
    					</div>
    					<label for="disabledinput" class="col-sm-1 control-label">引擎</label>
    					<div class="col-sm-2">
    						<input type="text" class="form-control1" id="focusedinput" value="<?php echo isset($arr_params['ENGINE']) ? $arr_params['ENGINE'] : '';?>">
    					</div>
    					<div class="col-sm-1">
    						<button class="btn btn-success" type="button" id="button_query_list">
    							<i class="fa fa-search">查询</i>
    						</button>
    					</div>
    				</div>
    			</form>
    		</div>
    		<div class="view_tables">
    			<table class="table table-hover">
    				<thead>
    					<tr>
    						<th><input type="checkbox"></th>
    						<th>项目名称</th>
    						<th>菜单名称</th>
    						<th>菜单URL地址</th>
    						<th>菜单层级</th>
    						<th>排序权重</th>
    						<th>状态</th>
    						<th>修改时间</th>
    						<th>操作</th>
    					</tr>
    				</thead>
    				<tbody>
    				    <?php  if(isset($data_info) && is_array($data_info) && !empty($data_info))
    						   {
    						       foreach ($data_info as $val)
    						       {
    				    ?>
    								<tr class='odd selected'>
    								    <td scope="row"><input type="checkbox" value="<?php echo $val['cms_id'];?>"/></td>
    									<td><?php echo isset($project_list[$val['cms_project_id']]['cms_name']) ? $project_list[$val['cms_project_id']]['cms_name'] : "<font color='red'>{$val['cms_project_id']}</font>";?></td>
    									<td><?php echo $val['cms_name'];?></td>
    									<td><?php echo $val['cms_url'];?></td>
    									<td><?php echo $val['cms_level'];?></td>
    									<td><?php echo $val['cms_order'];?></td>
    									<td><?php echo $val['cms_state'];?></td>
    									<td><?php echo $val['cms_modify_time'];?></td>
    									<td>
                                            <div class="dropdown">
    											<a href="#" title="" class="btn btn-default wh-btn" data-toggle="dropdown" aria-expanded="false"> 
    											    <i class="fa fa-cog icon_8"></i>
    											    <i class="fa fa-chevron-down icon_8"></i>
    										    </a>
    											<ul class="dropdown-menu float-right">
                                            		<!--*********** 初始化必须加载 ***************** （下拉操作信息） *********** 初始化必须加载 ***************** -->
    												<?php echo make_right_button($system_file_list, $val);?>
    											</ul>
    										</div>
    									</td>
    								</tr>
    					<?php     }
    						   }
    				     ?>
    				     
    				</tbody>
    			</table>
    		</div>
    	</div>
		<!--*********** 初始化必须加载 ***************** （分页信息） *********** 初始化必须加载 ***************** -->
        <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_page.php';?>
		<!--*********** 初始化必须加载 ***************** （底部按钮信息） *********** 初始化必须加载 ***************** -->
        <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/public_bottom_button.php';?>
    </div>
</body>
</html>