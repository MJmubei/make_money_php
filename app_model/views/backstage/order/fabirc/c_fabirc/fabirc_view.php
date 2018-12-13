<!DOCTYPE HTML>
<html>
<head>
    <!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        .htmleaf-header{margin-bottom: 15px;font-family: "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", "FontAwesome", sans-serif;}
        .htmleaf-icon{color: #fff;}
    </style>
</head>
<body>
<div class="page-container">
    <!--/content-inner-->
    <div class="left-content">
        <div class="inner-content">
            <!--*********** 初始化必须加载 ***************** （顶部导航栏加载） *********** 初始化必须加载 *****************   -->
            <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_menu.php';?>
            <div class="outter-wp">
                <div class="sub-heard-part">
                    <ol class="breadcrumb m-b-0">
                        <li><a href="../../../system/auto/c_project/index">首页</a></li>
                        <li class="active">面辅料</li>
                    </ol>
                </div>
                <h3 class="inner-tittle two">面辅料订单</h3>
                <div class="graph">
                    <iframe width=25% height=630 frameborder=0 src="./fabirc_order"></iframe>
                    <iframe width=73% height=630 frameborder=0 src="./fabirc?big_fabirc_id=<?php echo isset($_GET['big_fabirc_id']) ? $_GET['big_fabirc_id'] : '';?>"></iframe>
                </div>
            </div>
            <!--*********** 初始化必须加载 ***************** （最下版权加载） *********** 初始化必须加载 ***************** -->
            <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_footer.php';?>
        </div>
    </div>
    <!--*********** 初始化必须加载 ***************** （左侧目录加载） *********** 初始化必须加载 ***************** -->
    <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_left_menu.php';?>
</div>
</body>
</html>