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
        							<div class="control-group">
                                        <label class="control-label" for="selectError">Modern Select</label>
                    
                                        <div class="controls">
                                            <select id="selectError" data-rel="chosen" style="display: none;">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                                <option>Option 4</option>
                                                <option>Option 5</option>
                                            </select>
                                                <div class="chosen-container chosen-container-single" style="width: 78px;" title="" id="selectError_chosen">
                                                <a class="chosen-single" tabindex="-1"><span>Option 1</span><div><b></b></div></a><div class="chosen-drop">
                                                <div class="chosen-search"><input type="text" autocomplete="off"></div><ul class="chosen-results"></ul></div></div>
                                        </div>
                                    </div>
    							    <div class="col-md-12">
    							         <label class="col-md-3">Search: <input type="text" aria-controls="DataTables_Table_0"></label>
							             <label class="col-md-3">Search: <input type="text" aria-controls="DataTables_Table_0"></label>
							             <label class="col-md-3">Search: <input type="text" aria-controls="DataTables_Table_0"></label>
							             <label class="col-md-3">Search: <input type="text" aria-controls="DataTables_Table_0"></label>
    							         <label class="col-md-3">Search: <input type="text" aria-controls="DataTables_Table_0"></label>
    							         <label class="col-md-3">Search: <input type="text" aria-controls="DataTables_Table_0"></label>
							             <label class="col-md-3">Search: <input type="text" aria-controls="DataTables_Table_0"></label>
							             <label class="col-md-3">Search: <input type="text" aria-controls="DataTables_Table_0"></label>
							             <label class="col-md-3">Search: <input type="text" aria-controls="DataTables_Table_0"></label>
    							         <label class="col-md-3">Search: <input type="text" aria-controls="DataTables_Table_0"></label>
    							    </div>
    								<table class="table table-striped table-bordered bootstrap-datatable responsive">
    									<thead>
    										<tr>
    										    <th><input type='checkbox'/></th>
    											<th>名称</th>
    											<th>类型</th>
    											<th>引擎</th>
    											<th>行数</th>
    											<th>剩余空间</th>
    											<th>字段编码</th>
    											<th>数据长度</th>
    											<th>平均长度</th>
    											<th>描述</th>
    											<th>创建时间</th>
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
                										    <th><input type='checkbox' value="<?php echo $val['TABLE_NAME'];?>"/></th>
                											<td class="center"><?php echo $val['TABLE_NAME'];?></td>
                											<td class="center"><?php echo $val['TABLE_TYPE'];?></td>
                											<td class="center"><?php echo $val['ENGINE'];?></td>
                											<td class="center"><?php echo $val['TABLE_ROWS'];?></td>
                											<td class="center"><?php echo $val['DATA_FREE'];?></td>
                											<td class="center"><?php echo $val['TABLE_COLLATION'];?></td>
                											<td class="center"><?php echo $val['DATA_LENGTH'];?></td>
                											<td class="center"><?php echo $val['AVG_ROW_LENGTH'];?></td>
                											<td class="center"><?php echo $val['TABLE_COMMENT'];?></td>
                											<td class="center"><?php echo $val['CREATE_TIME'];?></td>
                											<td class="center">
                                                                <div class="btn-group">
                                                                	<button  data-toggle="dropdown"><span class="hidden-sm hidden-xs"> 操作</span><span class="caret"></span></button>
                                                                	<ul class="dropdown-menu" >
                                                                		<li><a href="../../con_admin/c_logic_model/make_logic_model?table_name=<?php echo $val['TABLE_NAME'];?>"><i class="whitespace"></i> 生成logic </a></li>
                                                                		<li><a href="#" class="btn-setting"><i class="whitespace"></i> 修改 </a></li>
                                                                		<li><a href="#"><i class="whitespace"></i> 删除 </a></li>
                                                                	</ul>
                                                                </div>
                											</td>
                										</tr>
    										<?php     }
            									   }
            							     ?>
    									</tbody>
    									
    								</table>
    								<div>
    								    <a class="btn btn-default" href="#"><i class="glyphicon glyphicon-ok-sign"></i> 全选 </a>
        								<a class="btn btn-default" href="#"><i class="glyphicon glyphicon-ban-circle"></i> 反选 </a>
                                        <a class="btn btn-default" href="#"><i class="glyphicon glyphicon-remove-sign"></i> 取消 </a>
                                        <a class="btn btn-success" href="#"><i class="glyphicon glyphicon-plus-sign"></i> 添加 </a>
                                        <a class="btn btn-info" href="#"><i class="glyphicon glyphicon-plus-sign"></i> 修改 </a>
                                        <a class="btn btn-danger" href="#"><i class="glyphicon glyphicon-trash"></i> 删除 </a>
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
