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
				<li class="active">页面列表</li>
			</ol>
		</div>
		<div class="graph">
		    <div class="form-body">
    			<form class="form-horizontal" method="post" action="<?php echo $arr_page_url['list_url'];?>">
    				<div class="form-group">
    					<label for="disabledinput" class="col-sm-1 control-label">名称</label>
    					<div class="col-sm-2">
    						<input type="text" class="form-control1" name="cms_name" id="cms_name" value="<?php echo isset($arr_params['cms_name']) ? $arr_params['cms_name'] : '';?>">
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
    			<table class="table table-hover" id="index_list">
    				<thead>
    					<tr>
    					    <th><input type="checkbox" id="checkAll" name="checkAll" /></th>
    						<th>项目名称</th>
    						<th>联系人手机号码</th>
    						<th>联系人座机号码</th>
    						<th>备注</th>
    						<th>排序权重</th>
    						<th>状态</th>
    						<th>创建时间</th>
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
    								    <td><input type="checkbox" name="checkItem" attr-key="cms_id" value="<?php echo $val['cms_id'];?>"/></td>
    								    <?php if($val['cms_name'] == $val['cms_mark']){?>
    									<td><font color='red'><?php echo $val['cms_name'];?></font></td>
    								    <?php }else{?>
    									<td><?php echo $val['cms_name'];?></td>
    									<?php }?>
    									<td><?php echo $val['cms_mobilephone_number'];?></td>
    									<td><?php echo $val['cms_telphone_number'];?></td>
    									<td><?php echo $val['cms_remark'];?></td>
    									<td><?php echo $val['cms_order'];?></td>
    									<td>
    									<?php echo $val['cms_state'] != '0' ? "<font color='red'>禁用</font>" : "<font color='green'>启用</font>";?>
    									</td>
    									<td><?php echo $val['cms_create_time'];?></td>
    									<td><?php echo $val['cms_modify_time'];$val['cms_image_v']='2018/12/25/5c2105c117a0e1ce987c488e60a0576f.png';?></td>
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
    		<!--*********** 初始化必须加载 ***************** （分页信息） *********** 初始化必须加载 ***************** -->
            <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_page.php';?>
    		<!--*********** 初始化必须加载 ***************** （底部按钮信息） *********** 初始化必须加载 ***************** -->
            <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/public_bottom_button.php';?>
	   </div>
	</div>
</body>
</html>