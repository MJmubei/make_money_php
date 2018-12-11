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
										<input type="text" class="form-control1" name="cms_name" id="focusedinput" value="<?php echo isset($arr_params['cms_name']) ? $arr_params['cms_name'] : '';?>">
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
            													   <a href="#" data-toggle="modal" data-target="#system-edit-modal" class="system-edit-modal-right" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
            													       <i class="fa fa-pencil-square-o icon_9"></i> 
            												                  修改
            													   </a>
            													</li>
            													<li>
            													   <a href="#" data-toggle="modal" data-target="#system-delete-modal-right" class="system-delete-modal-right" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>"  class="font-red" title="">
            													       <i class="fa fa-trash-o icon_9""></i> 
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
								<?php include_once dirname(__FILE__).'/add.php';?>
								<?php include_once dirname(__FILE__).'/edit.php';?>
								<?php include_once dirname(__FILE__).'/delete.php';?>
								<?php include_once dirname(__FILE__).'/auto_make_project.php';?>
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