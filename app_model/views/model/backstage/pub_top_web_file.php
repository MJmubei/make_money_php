<?php if(!defined('VIEW_MODEL_BACKGROUD')){define('VIEW_MODEL_BACKGROUD', '/CodeIgniter/view_model/backstage/');}?>
<title>业务后台管理系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/font-awesome.css" rel="stylesheet">
<!-- jQuery -->
<!-- lined-icons -->
<link rel="stylesheet" href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/icon-font.min.css" type='text/css' />
<!-- /js -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/jquery-1.10.2.min.js"></script>
<!--clock init-->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/css3clock.js"></script>
<!--Easy Pie Chart-->
<!--skycons-icons-->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/skycons.js"></script>
<!--//skycons-icons-->

<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/jquery-2.1.0.min.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap-treeview.js"></script>

<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/amcharts.js"></script>	
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/serial.js"></script>	
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/light.js"></script>	
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/radar.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/md5.js"></script>
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/fabochart.css" rel='stylesheet' type='text/css' />
<!-- Sweet Alert -->
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/js/plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
    var toggle = true;
    $(".sidebar-icon").click(function() {                
        if (toggle)
        {
            $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
            $("#menu span").css({"position":"absolute"});
        }
        else
        {
        	$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
        	setTimeout(function() {
          		$("#menu span").css({"position":"relative"});
        	}, 400);
        }		
    	toggle = !toggle;
    });


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
    
    /**
    *  Base64 encode / decode
    */
    function Base64() {
     
        // private property
        _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
     
        // public method for encoding
        this.encode = function (input) {
            var output = "";
            var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
            var i = 0;
            input = _utf8_encode(input);
            while (i < input.length) {
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);
                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;
                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }
                output = output +
                _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
                _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
            }
            return output;
        }
     
        // public method for decoding
        this.decode = function (input) {
            var output = "";
            var chr1, chr2, chr3;
            var enc1, enc2, enc3, enc4;
            var i = 0;
            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
            while (i < input.length) {
                enc1 = _keyStr.indexOf(input.charAt(i++));
                enc2 = _keyStr.indexOf(input.charAt(i++));
                enc3 = _keyStr.indexOf(input.charAt(i++));
                enc4 = _keyStr.indexOf(input.charAt(i++));
                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;
                output = output + String.fromCharCode(chr1);
                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }
            }
            output = _utf8_decode(output);
            return output;
        }
     
        // private method for UTF-8 encoding
        _utf8_encode = function (string) {
            string = string.replace(/\r\n/g,"\n");
            var utftext = "";
            for (var n = 0; n < string.length; n++) {
                var c = string.charCodeAt(n);
                if (c < 128) {
                    utftext += String.fromCharCode(c);
                } else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                } else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
     
            }
            return utftext;
        }
     
        // private method for UTF-8 decoding
        _utf8_decode = function (utftext) {
            var string = "";
            var i = 0;
            var c = c1 = c2 = 0;
            while ( i < utftext.length ) {
                c = utftext.charCodeAt(i);
                if (c < 128) {
                    string += String.fromCharCode(c);
                    i++;
                } else if((c > 191) && (c < 224)) {
                    c2 = utftext.charCodeAt(i+1);
                    string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                    i += 2;
                } else {
                    c2 = utftext.charCodeAt(i+1);
                    c3 = utftext.charCodeAt(i+2);
                    string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                    i += 3;
                }
            }
            return string;
        }
    }

    
    $(document).ready(function() {
        var defaultData = <?php echo (isset($menu_fenlei)&&is_array($menu_fenlei)) ? json_encode($menu_fenlei) : json_encode(array());?>;
        var $searchableTree = $('#treeview-searchable').treeview({ 
    		showBorder: true, //是否在节点周围显示边框
    		showCheckbox: false, //是否在节点上显示复选框
    		showIcon: true, //是否显示节点图标
    		highlightSelected: true,
    		levels: 1,
    		multiSelect: false, //是否可以同时选择多个节点
    		showTags: true,
			data: defaultData,
        });
        var initSelectableTree = function() {
            return $('#treeview-selectable').treeview({
                data: defaultData,
                onNodeSelected: function(event, node) {
// 					alert("节点["+node.text+"]选中");
                	var inputobj = $(".form-horizontal :input");
                    for(var k=0;k<inputobj.length;k++){
                        var typeofstr = inputobj[k].name;
                        typeofstr = typeofstr.toString();
                        inputobj[k].value = node[typeofstr];
                    }
                },
                onNodeUnselected: function (event, node) {
                    //取消
                    
                }
            });
        };
        var $selectableTree = initSelectableTree();
        var findSelectableNodes = function() {
			return $selectableTree.treeview('search', [ $('#input-select-node').val(), { ignoreCase: true, exactMatch: false } ]);
        };
        
        var selectableNodes = findSelectableNodes();        
        $('#input-select-node').on('keyup', function (e) {
            selectableNodes = findSelectableNodes();
            $('.select-node').prop('disabled', !(selectableNodes.length >= 1));
        });
	});    
    $('.main-search').hide();
	$('button').click(function (){
		$('.main-search').show();
		$('.main-search text').focus();
	});
	$('.close').click(function(){
		$('.main-search').hide();
    });

	
	//ajax 提交数据
	//submitData 需要提交参数 ：user_id=12&user_name=John&user_age=20
	//url  请求的地址 ../../../system/auto/c_project/add
	//need_refresh  true 界面需要刷新  | false 界面不刷新
    function system_submit_data(str_class,submitData,url,need_refresh)
    {
        var show_log=true;
    	//submitData是解码后的表单数据，结果同上
    	submitData+="&flag_ajax_reurn=1";
		var temp_data = $('#'+str_class+'-form').serialize();
		if(temp_data !== undefined && temp_data !== null){
			submitData+='&'+temp_data;
		}
        //alert(submitData);
    	$.ajax({
        	url:url,
			type:"POST",
        	data:submitData,
        	cache:false,//false是不缓存，true为缓存
        	async:true,//true为异步，false为同步
        	beforeSend:function(){
            	
        	},
        	success:function(result){
        		var result =  eval("("+result+")");
        		if(result.ret == 0)
				{
					var log_text = show_log ? result.reason : "数据操作完毕，恭喜！";
					sys_sweetalert("success",str_class,"操作成功！",log_text,'','',need_refresh);
				}
				else
				{
					var log_text = show_log ? result.reason : "数据操作失败，请联系管理员，抱歉！";
					sys_sweetalert("error",str_class,"操作失败！",log_text,'','',false);
				}
        	},
        	complete:function(){
        	    //请求结束时
        	},
        	error:function(){
        	    //请求失败时
        	    var log_text = show_log ? "请求接口地址失败，地址["+url+"]" : "数据操作失败，请联系管理员，抱歉！";
				sys_sweetalert("error",str_class,"请求接口地址失败！",log_text,'','','',false);
        	}
    	});
    }
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

    //系统弹窗
    //action_type 提醒？还是提交数据
	//title 弹窗标题
	//text  弹窗内容
	//url 是否需要ajax请求  如果不需要为空值
	//submitData  url不为空的时候 请求的参数
	//str_id_class  获取#ID 或者 class  .xxxx 内容数据
	//need_refresh 是否需要刷新界面
    function sys_sweetalert(action_type,str_class,title,text,url,submitData,need_refresh)
    {
       	switch(action_type)
       	{
       		case "warning":
       		case "error":
       		case "success":
       			title = title.length <1 ? "您需要选择操作的数据" : title;
       			text = text.length <1 ? "再次操作后数据可能无法恢复，请谨慎！" : text;
       			if(need_refresh)
           		{
           			swal(
           					{
           						title:title,
           						text:text,
           						type:action_type,
           					},
           					function(){
               					if(action_type == 'success')
               					{
               						url_refresh();
                   				}
            				}
           				)
               	}
       			else
           		{
       				swal(
           					{
           						title:title,
           						text:text,
           						type:action_type,
           					}
           				)
           		}
       			break;
       		case "submit":
           		if(url.length<1)
                {
           			sys_sweetalert("error",str_class,"AJAX数据请求URL为空",'','','',false);
           			break;
                }
                url='../../../'+url;
           		var bootstrapValidator = $('#'+str_class+'-form').data('bootstrapValidator');
                bootstrapValidator.validate();
                if(!bootstrapValidator.isValid()){
					break;
                }
       			title = title.length <1 ? "您确定要提交这条信息吗" : title;
       			text = text.length <1 ? "提交数据后系统将可能会添加、修改、删除数据，请谨慎操作！" : text;
       			swal(
       					{
       						title:title,
       						text:text,
       						type:"warning",
       						showCancelButton:true,
        					confirmButtonColor:"#DD6B55",
       						confirmButtonText:"确定",
       						cancelButtonText:"取消",
       						closeOnConfirm:false,
       						closeOnCancel:false
   						},
   						function(isConfirm){
   							if(isConfirm){
   								system_submit_data(str_class,submitData,url,need_refresh);
       	 					}else{
           	 					sys_sweetalert("warning",str_class,"您取消了操作","取消了操作系统数据不会产生任何改变，请谨慎操作！",'','',false);
       						}
       					}
       				)
       			break;
       		case 'nopage_action_button':
       		case 'nopage_action_right':
       		case 'nopage_action_button_nocheck':
       			if(url.length<1)
                {
           			sys_sweetalert("error",str_class,"AJAX数据请求URL为空",'AJAX数据请求URL为空！','','','',false);
           			break;
                }
                url='../../../'+url;
                var checkbox_value='';
                if(action_type == 'nopage_action_button')
                {
                	checkbox_value = check_checkbox_value();
                	if(checkbox_value.length<1)
                    {
                		sys_sweetalert("error",str_class,"请至少选择一条数据",'请至少选择一条数据！','','','',false);
               			break;
                    }
                    submitData+="&"+checkbox_value;
                }
                title = title.length <1 ? "您确定要提交这条信息吗" : title;
       			text = text.length <1 ? "提交数据后系统将可能会添加、修改、删除数据，请谨慎操作！" : text;
       			swal(
       					{
       						title:title,
       						text:text,
       						type:"warning",
       						showCancelButton:true,
        					confirmButtonColor:"#DD6B55",
       						confirmButtonText:"确定",
       						cancelButtonText:"取消",
       						closeOnConfirm:false,
       						closeOnCancel:false
   						},
   						function(isConfirm){
   							if(isConfirm){
   								system_submit_data(str_class,submitData,url,need_refresh);
       	 					}else{
           	 					sys_sweetalert("warning",str_class,"您取消了操作","取消了操作系统数据不会产生任何改变，请谨慎操作！",'','',false);
       						}
       					}
       				)
           		break;
       		default :
       			sys_sweetalert("error",str_class,"未找到任何弹窗方法",'未找到任何弹窗方法,开发的锅~~~~','','',false);
   				break;
        }
    }
    
    function system_auto_load(str_class,paramas)
    {
		if(paramas.length >0){
			var b = new Base64();
			paramas = b.decode(paramas);
    		paramas =  eval("("+paramas+")");
        	$('#'+str_class+'-form').find("input").each(function(){
        		var i_type = $(this).attr('type');
            	var i_name = $(this).attr('name');
            	if(i_type.length>0 && i_name.length>0)
                {
                    var temp_data = paramas[i_name];
                    if(temp_data !== undefined && temp_data !== null)
                    {
                        if(i_type == 'text' || i_type=='password')
                        {
                            $(this).val(temp_data);
                        }
                        else if(i_type == 'checkbox')
                        {
    
                        }
                        else if(i_type == 'radio' && temp_data == $(this).val())
                        {
                        	$(this).attr("checked", true);
                        }
                        else
                        {
                        	$(this).val('');
                        }
                    }
                	else
                    {
                        $(this).val('');
                    }
                }
            	else
                {
                    $(this).val('');
                }
        	});
        	$('#'+str_class+'-form').find("textarea").each(function(){
        		var i_name = $(this).attr('name');
            	if(i_name.length>0)
                {
                    var temp_data = paramas[i_name];
                    if(temp_data !== undefined && temp_data !== null)
                    {
                    	$(this).html(temp_data);
                    }
                }
            	else
                {
                    $(this).html('');
                }
        	});
		}
		
    	$('#'+str_class+'-reset').click(function() {
            $('#'+str_class+'-form').data('bootstrapValidator').resetForm(true);
        });
        
    	$('#'+str_class+'-cancel').click(function() {
            $('#'+str_class+'-form').data('bootstrapValidator').resetForm(true);
        });
    }
</script>
<!--js -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/jquery.nicescroll.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo VIEW_MODEL_BACKGROUD; ?>bootstrap-tree-view-demo/js/bootstrap-treeview.min.js"></script>
<link rel="stylesheet" href="<?php echo VIEW_MODEL_BACKGROUD; ?>bootstrapvalidator-master/dist/css/bootstrapValidator.css" />
<script type="text/javascript" src="<?php echo VIEW_MODEL_BACKGROUD; ?>bootstrapvalidator-master/dist/js/bootstrapValidator.js"></script>
<?php 
    function make_right_button($system_file_list,$val)
    {
        $str = '';
        if(isset($system_file_list) && is_array($system_file_list) && !empty($system_file_list))
        {
            foreach ($system_file_list as $system_file_list_key=>$system_file_list_value)
            {
                $arr_button_temp = null;
                if(!isset($system_file_list_value['button_data']) || !is_array($system_file_list_value['button_data']) || empty($system_file_list_value['button_data']))
                {
                    continue;
                }
                if(!isset($system_file_list_value['function']) || !in_array($system_file_list_value['function'], array('edit','state','delete')))
                {
                    continue;
                }
                if($system_file_list_value['function'] == 'edit')
                {
                    foreach ($system_file_list_value['button_data'] as $button_data_key=>$button_data_value)
                    {
                        if(!isset($val) || empty($val))
                        {
                            continue;
                        }
                        $arr_button_temp[] = array(
                            'a'=>'<a href="#" data-toggle="modal" data-target="#'.$system_file_list_value['class'].'" '.
                            ' onclick="system_auto_load('."'".$system_file_list_value['class']."','".base64_encode(json_encode($val))."'".');">',
                            'name'=>$button_data_value['name'],
                            'icon'=>$button_data_value['icon'],
                        ); 
                    }
                }
                else if($system_file_list_value['function'] == 'state')
                {
                    foreach ($system_file_list_value['button_data'] as $button_data_key=>$button_data_value)
                    {
                        $flag = true;
                        if(isset($button_data_value['where']) && is_array($button_data_value['where']) && !empty($button_data_value['where']))
                        {
                            foreach ($button_data_value['where'] as $button_data_where_key=>$button_data_where_value)
                            {
                                if(!isset($val[$button_data_where_key]) || $val[$button_data_where_key] == $button_data_where_value)
                                {
                                    $flag = false;
                                    break;
                                }
                            }
                        }
                        if(!$flag)
                        {
                            continue;
                        }
                        if(!isset($val['cms_state']) || $val['cms_state'] != '0')
                        {
                            $arr_button_temp[] = array(
                                'a'=>'<a href="#" onclick="sys_sweetalert('."'".'nopage_action_right'."','".$system_file_list_value['class']."','您确定要启用这条信息吗','".
                                    '提交数据后系统将可能会启用此条数据，请谨慎操作！'."','".$system_file_list_value['ajax']."','cms_id[]=".$val['cms_id'].'&cms_state=0'."'".',true);">',
                                'name'=>$button_data_value['name'],
                                'icon'=>$button_data_value['icon'],
                            );
                        }
                        else
                        {
                            $arr_button_temp[] = array(
                                'a'=>'<a href="#" onclick="sys_sweetalert('."'".'nopage_action_right'."','".$system_file_list_value['class']."','您确定要禁用这条信息吗','".
                                    '提交数据后系统将可能会禁用此条数据，请谨慎操作！'."','".$system_file_list_value['ajax']."','cms_id[]=".$val['cms_id'].'&cms_state=1'."'".',true);">',
                                'name'=>$button_data_value['name'],
                                'icon'=>$button_data_value['icon'],
                            );
                        }
                    }
                }
                else if($system_file_list_value['function'] == 'delete')
                {
                    foreach ($system_file_list_value['button_data'] as $button_data_key=>$button_data_value)
                    {
                        $arr_button_temp[] = array(
                                'a'=>'<a href="#" onclick="sys_sweetalert('."'".'nopage_action_right'."','".$system_file_list_value['class']."','您确定要删除这条信息吗','".
                                    '提交数据后系统将可能会删除此条数据，请谨慎操作！'."','".$system_file_list_value['ajax']."','cms_id[]=".$val['cms_id']."'".',true);">',
                            'name'=>$button_data_value['name'],
                            'icon'=>$button_data_value['icon'],
                        );
                    }
                }
                if(empty($arr_button_temp) || !is_array($arr_button_temp))
                {
                    continue;
                }
                foreach ($arr_button_temp as $arr_button_temp_value)
                {
                    $str_button_temp_value_icon = isset($arr_button_temp_value['icon']) ? $arr_button_temp_value['icon'] : '';
                    $str_button_temp_value_name = (isset($arr_button_temp_value['name']) && strlen($arr_button_temp_value['name']) >0) ? $arr_button_temp_value['name'] : '<font color="red">未知按钮</font>';
                    $str.= '<li>';
                    $str.=      $arr_button_temp_value['a'];
                    $str.=          '<i class="fa '. $str_button_temp_value_icon .' icon_9"></i>'.$str_button_temp_value_name;
                    $str.=      '</a>';
                    $str.= '</li>';
                }
//                 echo $str;die;
            }
        }
        return $str;
    }
?>