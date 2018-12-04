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
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/style.css"
	rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/font-awesome.css"
	rel="stylesheet">
<!-- jQuery -->
<!-- lined-icons -->
<link rel="stylesheet"
	href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/icon-font.min.css"
	type='text/css' />
<!-- /js -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/jquery-1.10.2.min.js"></script>
<!--clock init-->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/css3clock.js"></script>
<!--Easy Pie Chart-->
<!--skycons-icons-->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/skycons.js"></script>
<!--//skycons-icons-->
<script>
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
</script>

<script type="text/javascript">
	 $('.main-search').hide();
	$('button').click(function (){
		$('.main-search').show();
		$('.main-search text').focus();
	}
	);
	$('.close').click(function(){
		$('.main-search').hide();
	});
</script>
<!--js -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/jquery.nicescroll.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap.min.js"></script>