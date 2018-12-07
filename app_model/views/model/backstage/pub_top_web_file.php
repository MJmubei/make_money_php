<?php if(!defined('VIEW_MODEL_BACKGROUD')){define('VIEW_MODEL_BACKGROUD', '/CodeIgniter/view_model/backstage/');}?>
<title>业务后台管理系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/bootstrap.min.css"
	rel='stylesheet' type='text/css' />
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
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/barChart.css" rel='stylesheet' type='text/css' />
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/fabochart.css" rel='stylesheet' type='text/css' />
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
    $(function() {
        var defaultData = <?php echo json_encode($menu_fenlei);?>;
        
        var $searchableTree = $('#treeview-searchable').treeview({
            expandIcon: "glyphicon glyphicon-stop",
            collapseIcon: "glyphicon glyphicon-unchecked",
            nodeIcon: "glyphicon glyphicon-user",
            color: "yellow",
            backColor: "purple",
            onhoverColor: "orange",
            borderColor: "red",
            showBorder: false,
            showTags: true,
            highlightSelected: true,
            selectedColor: "yellow",
            selectedBackColor: "darkorange",
			data: defaultData,
        });
        var initSelectableTree = function() {
            return $('#treeview-selectable').treeview({
                data: defaultData,
                onNodeSelected: function(event, node) {
					alert("节点["+node.text+"]选中");
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
</script>
<!--js -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/jquery.nicescroll.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap.min.js"></script>