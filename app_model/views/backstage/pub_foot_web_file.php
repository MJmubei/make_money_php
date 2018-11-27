<?php if(!defined('VIEW_MODEL_BACKGROUD')){define('VIEW_MODEL_BACKGROUD', '/CodeIgniter/view_model/backstage/');}?>
<script>
	var toggle = true;
	$(".sidebar-icon").click(function() 
	{                
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
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tablecheckbox').click(function(){
            var bool = ($(".view_tables table > thead > tr > th > input[type=checkbox]").attr("checked")) ? true : false;
            alert(bool);
        	selectAllCheckBox(bool);
        });
        $('#btn_tablecheckbox_check').click(function(){
        	selectAllCheckBox(true);
        });
        $('#btn_tablecheckbox_uncheck').click(function(){
        	selectAllCheckBox(false);
        });
        $('#btn_tablecheckbox_exchange').click(function(){
        	unselectAllCheckBox();
        });
        $('#button_query_list').click(function(){
            $(".form-horizontal").submit();  
        });
    });
    function cancel_choice_check_box()
    {
    	$("input[name='tablecheckboxvalue']:checkbox").each(function(){
    		if ($(this).is(":checked")) 
    		{ 
    			$(this).attr("checked",false);
        	}
    	});
    }
    function selectAllCheckBox(bool)
    {
    	var len=$(".view_tables table > tbody > tr").length;
    	for (var i=0;i<len;i++){
    		$obj=$(".view_tables table > tbody > tr:eq("+i+")").find("input[type=checkbox]");
    		if(bool)
        	{
            	if(!$obj.attr("checked"))
                {
            		$obj.attr("checked",true);
                }
            }
    		else
        	{
    			if($obj.attr("checked"))
                {
    				$obj.removeAttr("checked");
                }
            }
    	}
    }
    function unselectAllCheckBox()
    {
    	var len=$(".view_tables table > tbody > tr").length;
    	for (var i=0;i<len;i++){
    		$obj=$(".view_tables table > tbody > tr:eq("+i+")").find("input[type=checkbox]");
        	if($obj.attr("checked") === undefined || !$obj.attr("checked"))
            {
        		$obj.attr("checked",true);
            }
        	else
            {
        		$obj.attr("checked",false);
            }
    	}
    }

    function getselectAllCheckBox(attr)
    {
        var datastr='';
        var len=$(".view_tables table > tbody > tr").length;
    	for (var i=0;i<len;i++){
    		$obj=$(".view_tables table > tbody > tr:eq("+i+")").find("input[type=checkbox]");
    		if ($obj.is(":checked")){
				if (attr.length <1){
					datastr+=$obj.attr("value")+",";
				}else{
					datastr+=$obj.attr(attr)+",";
				}
    		}
    	}
    	if(datastr.length>1)
    	{
    		datastr = datastr.substr(0,datastr.length-1);
    	}
    	return datastr;
    }
</script>
<!--js -->
<link rel="stylesheet" href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/vroom.css">
<script type="text/javascript" src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/vroom.js"></script>
<script type="text/javascript" src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/TweenLite.min.js"></script>
<script type="text/javascript" src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/CSSPlugin.min.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/jquery.nicescroll.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap.min.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/public.js"></script>