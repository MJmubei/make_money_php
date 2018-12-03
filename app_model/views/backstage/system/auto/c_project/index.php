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
					<h3 class="inner-tittle two">项目列表</h3>
					<div class="graph">
						<div class="form-body">
							<form class="form-horizontal" method="post" action="<?php echo $arr_page_url['list_url'];?>">
							    <input type="hidden" name="cms_page_num" id="cms_page_num" value="<?php echo isset($page_info['cms_page_num']) ? $page_info['cms_page_num'] : 1;?>">
							    <input type="hidden" name="cms_page_size" id="cms_page_size" value="<?php echo isset($page_info['cms_page_size']) ? $page_info['cms_page_size'] : 10;?>">
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
        										    <td scope="row"><input type="checkbox" value="<?php echo $val['cms_id'];?>"/></td>
        										    <?php if($val['cms_name'] == $val['cms_mark']){?>
        										    
        											<td><font color='red'><?php echo $val['cms_name'];?></font></td>
        										    <?php }else{?>
        											<td><?php echo $val['cms_name'];?></td>
        											<?php }?>
        											<td><?php echo $val['cms_mobilephone_number'];?></td>
        											<td><?php echo $val['cms_telphone_number'];?></td>
        											<td><?php echo $val['cms_remark'];?></td>
        											<td><?php echo $val['cms_order'];?></td>
        											<td><?php echo $val['cms_state'];?></td>
        											<td><?php echo $val['cms_create_time'];?></td>
        											<td><?php echo $val['cms_modify_time'];?></td>
        											<td>
                                                        <div class="dropdown">
            												<a href="#" title="" class="btn btn-default wh-btn" data-toggle="dropdown" aria-expanded="false"> 
            												    <i class="fa fa-cog icon_8"></i>
            												    <i class="fa fa-chevron-down icon_8"></i>
            											    </a>
            												<ul class="dropdown-menu float-right">
            												    <li>
            													   <a href="../../../system/auto/c_project/auto_make_project" title=""> 
            													       <i class="fa fa-book icon_9"></i> 
            												                  生成logic
            													   </a>
            													</li>
            													<li>
            													   <a href="../../../system/auto/c_project/edit?cms_id=<?php echo $val['cms_id'];?>" title=""> 
            													       <i class="fa fa-pencil-square-o icon_9"></i> 
            												                  修改
            													   </a>
            													</li>
            													<li>
            													    <a href="#" class="font-red" title="">
            													       <i class="fa fa-trash-o" icon_9=""></i> 
            													            删除
            													    </a>
            													</li>
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
						<div class="form-body">
						     <div class="col-md-12 form-group button-2">
								<button class="btn blue" type="button" id="btn_tablecheckbox_check">
									<i class="fa fa-check-circle-o"> 全选</i>
								</button>
								
								<button class="btn blue" type="button" id="btn_tablecheckbox_exchange">
									<i class="fa fa-times-circle-o"> 反选</i>
								</button>
								
								<button class="btn blue" type="button" id="btn_tablecheckbox_uncheck">
									<i class="fa fa-times-circle"> 取消</i>
								</button>
								<button class="btn purple" type="button" data-toggle="modal" data-target="#myModal">
									<i class="fa fa-book"> 添加</i>
								</button>
								<button class="btn purple" type="button" data-toggle="modal" data-target="#myModal1">
									<i class="fa fa-edit"> 生成项目 </i>
								</button>
								<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
												<h2 class="modal-title">是否确认自动生成项目清单？</h2>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal"> 取消 </button>
												<button type="button" class="btn btn-primary"> 确认 </button>
											</div>
										</div>
									</div>
								</div>
								<button class="btn red six" type="button">
									<i class="fa fa-trash-o"> 删除</i>
								</button>
							</div>
							<div class="clearfix"></div>
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