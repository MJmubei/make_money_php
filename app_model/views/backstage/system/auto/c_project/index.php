<!DOCTYPE HTML>
<html>
<head>
<!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
<script type="text/javascript">
    $(function(){  
        function initTableCheckbox() {  
            var $thr = $('#index_list thead tr');  
            var $checkAll = $thr.find('input');  
            $checkAll.click(function(event){  
                /*将所有行的选中状态设成全选框的选中状态*/  
                $tbr.find("input[name='checkItem']").prop('checked',$(this).prop('checked'));  
                /*并调整所有选中行的CSS样式*/  
                if ($(this).prop('checked')) {  
                    $tbr.find("input[name='checkItem']").parent().parent().addClass('warning');  
                } else{  
                    $tbr.find("input[name='checkItem']").parent().parent().removeClass('warning');  
                }  
                /*阻止向上冒泡，以防再次触发点击操作*/  
                event.stopPropagation();  
            });
            var $tbr = $('#index_list tbody tr');  
            $tbr.find("input[name='checkItem']").click(function(event){  
                /*调整选中行的CSS样式*/  
                $(this).parent().parent().toggleClass('warning');  
                /*如果已经被选中行的行数等于表格的数据行数，将全选框设为选中状态，否则设为未选中状态*/  
                $checkAll.prop('checked',$tbr.find('input:checked').length == $tbr.length ? true : false);  
                /*阻止向上冒泡，以防再次触发点击操作*/  
                event.stopPropagation();  
            });  
            /*点击每一行时也触发该行的选中操作*/  
            $tbr.click(function(){  
                $(this).find("input[name='checkItem']").click();  
            });  
        }
        initTableCheckbox();
    });
    function check_checkbox_value()
    {
        var cms_id = ''; 
        $('#index_list tbody tr').find("input[name='checkItem']").each(function(){
        	if ($(this).is(':checked') && $(this).val().length >0 && $(this).attr('attr-key').length >0) 
            {
        		cms_id+=$(this).attr('attr-key')+'[]='+$(this).val()+'&';
    		} 
    	});
    	return cms_id;
    }
    function system_submit_data(submitData,url)
    {
    	//submitData是解码后的表单数据，结果同上
    	submitData+="flag_ajax_reurn=1";
    	$.ajax({
        	url:url,
    		type:"POST",
        	data:submitData,
        	cache:false,//false是不缓存，true为缓存
        	async:true,//true为异步，false为同步
        	beforeSend:function(){
        	},
        	success:function(result){
        		var dataObj=eval("("+result+")");
        		if(dataObj.ret == 0)
            	{
    				$('#system-modal-confirm-result-confirm').show();
    				$('#system-modal-confirm-result-cancel').hide();
                }
        		else
            	{
    				$('#system-modal-confirm-result-confirm').hide();
    				$('#system-modal-confirm-result-cancel').show();
                }
    	    	$('#system-modal-confirm-result-content').html("<p>"+dataObj.reason+"</p>");
    	    	$('#system-modal-confirm-result').modal({backdrop:'false',keyboard:false});
        	},
        	complete:function(){
        	    //请求结束时
        	},
        	error:function(){
        	    //请求失败时
        	}
    	});
    }
</script>
</head> 
<body>
		<div class="outter-wp">
			<div class="but_list">
				<ol class="breadcrumb">
					<li><a href="#">系统配置</a></li>
					<li><a href="#">自动化管理</a></li>
					<li class="active">项目列表</li>
				</ol>
			</div>
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
									<td>
									<?php echo $val['cms_state'] != '0' ? "<font color='red'>禁用</font>" : "<font color='green'>启用</font>";?>
									</td>
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
												   <a href="#" data-toggle="modal" data-target="#system-edit-modal-right" class="system-edit-modal-right" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
												       <i class="fa fa-pencil-square-o icon_9"></i>修改
												   </a>
												</li>
												<li>
												<?php if($val['cms_state'] != '0'){?>
    											     <a href="#" data-toggle="modal" data-target="#system-state-modal-1-right" class="system-state-modal-1-right" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>"  class="font-red" title="">
												           <i class="fa fa-unlock icon_9"></i>启用
													 </a>
												 <?php }else {?>
													 <a href="#" data-toggle="modal" data-target="#system-state-modal-2-right" class="system-state-modal-2-right" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>"  class="font-red" title="">
												           <i class="fa fa-lock icon_9"></i>禁用
													 </a>
												 <?php }?>
												</li>
												<li>
												   <a href="#" data-toggle="modal" data-target="#system-order-modal-top" class="system-order-modal-top" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
												       <i class="fa fa-chevron-up icon_9"></i>置顶
												   </a>
												</li>
												<li>
												   <a href="#" data-toggle="modal" data-target="#system-order-modal-up" class="system-order-modal-up" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
												       <i class="fa fa-arrow-up icon_9"></i>上移
												   </a>
												</li>
												<li>
												   <a href="#" data-toggle="modal" data-target="#system-order-modal-down" class="system-order-modal-down" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
												       <i class="fa fa-arrow-down icon_9"></i>下移
												   </a>
												</li>
												
												<li>
												   <a href="#" data-toggle="modal" data-target="#system-order-modal-bottom" class="system-order-modal-bottom" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
												       <i class="fa fa-chevron-down icon_9"></i>置底
												   </a>
												</li>
												<li>
												   <a href="#" data-toggle="modal" data-target="#system-delete-modal-right" class="system-delete-modal-right" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>"  class="font-red" title="">
												       <i class="fa fa-trash-o icon_9""></i>删除
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
			<?php include_once dirname(__FILE__).'/state.php';?>
			<?php //include_once dirname(__FILE__).'/order.php';?>
			<?php include_once dirname(__FILE__).'/delete.php';?>
			<?php include_once dirname(__FILE__).'/auto_make_project.php';?>
			<div class="modal fade" id="system-modal-confirm-result" data-target="#system-modal-confirm-result" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" >
            		<div class="modal-content">
            			<div class="modal-header">
            				<h2 class="modal-title">处理结果:</h2>
            			</div>
            			<div class="clearfix"></div>
            			<div class="modal-body" id="system-modal-confirm-result-content">
            			
            			</div>
                        <div class="modal-footer">
                            <span id="system-modal-confirm-result-confirm">
                                <button type="button" class="btn btn-primary" onclick="url_refresh();">确定</button>
                            </span>
                            <span id="system-modal-confirm-result-cancel">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
                            </span>
                        </div>
            		</div>
            	</div>
            </div>
		</div>
		<div class="clearfix"></div>
		</div>
	</div>
</body>
</html>