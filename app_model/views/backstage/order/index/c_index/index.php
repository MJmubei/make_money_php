<?php
    if(!defined('VIEW_MODEL_BACKGROUD')){
        define('VIEW_MODEL_BACKGROUD', '/CodeIgniter/view_model/backstage/');
    }
    if(empty($user_id) || empty($project_id))
    {
        echo "<script>window.location.href='../../../order/con_manager/c_manager/login';</script>";die;
    }
    switch ($project_id)
    {
        case '1':
            $role = '';
            break;
        case '2':
            $role = '平台管理员';
            break;
        case '3':
            $role = '生产商';
            break;
        case '4':
            $role = '供应商';
            break;
        case '5':
            $role = '样板师';
            break;
        case '6':
            $role = '样衣师';
            break;
        default:
            $role = '超级管理员';
            break;
    }
    ?>
<title>服装系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript">
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }
</script>
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/css/bootstrap.min14ed.css" rel="stylesheet">
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/css/font-awesome.min93e3.css" rel="stylesheet">
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/css/animate.min.css" rel="stylesheet">
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/css/style.min862f.css" rel="stylesheet">
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".select_cl").click(function () {
            var location_url = $(this).find("input[type='hidden']").val();
            $(".J_iframe").attr("src",location_url);
        })
    })
</script>
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow: hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close">
            <i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <!--							<span><img alt="image" class="img-circle" src="img/profile_small.jpg" /></span>-->
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
									<span class="block m-t-xs"><strong class="font-bold"><?php echo $user_id;?></strong></span>
									<?php if(!empty($role)){?><span class="text-muted text-xs block"><?php echo $role;?><b class="caret"></b></span><?php }?>
							    </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
<!--                            <li><a class="J_menuItem" href="form_avatar.html">修改头像</a></li>-->
<!--                            <li><a class="J_menuItem" href="profile.html">个人资料</a></li>-->
<!--                            <li><a class="J_menuItem" href="contacts.html">联系我们</a></li>-->
<!--                            <li><a class="J_menuItem" href="mailbox.html">信箱</a></li>-->
<!--                            <li class="divider"></li>-->
                            <li><a href="../../con_manager/c_manager/logout">安全退出</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">H+</div>
                </li>
                <?php if(isset($data_info) && is_array($data_info)){
                    foreach ($data_info as $menu_1_val){
                        ?>
                <li>
                    <a class="select_cl">
                        <?php if(!empty($menu_1_val['data']['cms_url'])){?>
                            <input type="hidden" value="../../../<?php echo $menu_1_val['data']['cms_url'];?>" />
                        <?php }?>
                        <i class="fa fa-flask"></i>
                        <span class="nav-label"><?php echo $menu_1_val['data']['cms_name'];?></span>
                        <span class="fa arrow"></span>
                    </a>
                    <?php if(isset($menu_1_val['child_list']) && is_array($menu_1_val['child_list']) && !empty($menu_1_val['child_list'])){?>
                        <ul class="nav nav-second-level">
                            <?php foreach ($menu_1_val['child_list'] as $menu_2_val){?>
                                <li>
                                    <a class="J_menuItem select_cl">
                                        <?php if(!empty($menu_2_val['data']['cms_url'])){?>
                                            <input type="hidden" value="../../../<?php echo $menu_2_val['data']['cms_url'];?>" />
                                        <?php }?>
                                        <i class="fa fa-flask"></i>
                                        <span class="nav-label"><?php echo $menu_2_val['data']['cms_name'];?></span>
                                        <span class="fa arrow"></span>
                                    </a>
                                </li>
                            <?php }?>
                        </ul>
                    <?php }}}?>
                    </li>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
<!--        <div class="row border-bottom">-->
<!--            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">-->
<!--                <div class="navbar-header">-->
<!--                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary "-->
<!--                       href="#"><i class="fa fa-bars"></i> </a>-->
<!--                    <form role="search" class="navbar-form-custom" method="post"-->
<!--                          action="http://www.zi-han.net/theme/hplus/search_results.html">-->
<!--                        <div class="form-group">-->
<!--                        </div>-->
<!--                    </form>-->
<!--                </div>-->
<!--                <ul class="nav navbar-top-links navbar-right">-->
<!--                    <li class="dropdown"><a class="dropdown-toggle count-info"-->
<!--                                            data-toggle="dropdown" href="#"> <i class="fa fa-envelope"></i>-->
<!--                            <span class="label label-warning">16</span>-->
<!--                        </a>-->
<!--                        <ul class="dropdown-menu dropdown-messages">-->
<!--                            <li class="m-t-xs">-->
<!--                                <div class="dropdown-messages-box">-->
<!--                                    <a href="profile.html" class="pull-left"> <img alt="image"-->
<!--                                                                                   class="img-circle" src="img/a7.jpg">-->
<!--                                    </a>-->
<!--                                    <div class="media-body">-->
<!--                                        <small class="pull-right">46小时前</small> <strong>小四</strong>-->
<!--                                        这个在日本投降书上签字的军官，建国后一定是个不小的干部吧？ <br> <small-->
<!--                                            class="text-muted">3天前 2014.11.8</small>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li>-->
<!--                                <div class="dropdown-messages-box">-->
<!--                                    <a href="profile.html" class="pull-left"> <img alt="image"-->
<!--                                                                                   class="img-circle" src="img/a4.jpg">-->
<!--                                    </a>-->
<!--                                    <div class="media-body ">-->
<!--                                        <small class="pull-right text-navy">25小时前</small> <strong>国民岳父</strong>-->
<!--                                        如何看待“男子不满自己爱犬被称为狗，刺伤路人”？——这人比犬还凶 <br> <small-->
<!--                                            class="text-muted">昨天</small>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li>-->
<!--                                <div class="text-center link-block">-->
<!--                                    <a class="J_menuItem" href="mailbox.html"> <i-->
<!--                                            class="fa fa-envelope"></i> <strong> 查看所有消息</strong>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                        </ul></li>-->
<!--                    <li class="dropdown"><a class="dropdown-toggle count-info"-->
<!--                                            data-toggle="dropdown" href="#"> <i class="fa fa-bell"></i> <span-->
<!--                                class="label label-primary">8</span>-->
<!--                        </a>-->
<!--                        <ul class="dropdown-menu dropdown-alerts">-->
<!--                            <li><a href="mailbox.html">-->
<!--                                    <div>-->
<!--                                        <i class="fa fa-envelope fa-fw"></i> 您有16条未读消息 <span-->
<!--                                            class="pull-right text-muted small">4分钟前</span>-->
<!--                                    </div>-->
<!--                                </a></li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li><a href="profile.html">-->
<!--                                    <div>-->
<!--                                        <i class="fa fa-qq fa-fw"></i> 3条新回复 <span-->
<!--                                            class="pull-right text-muted small">12分钟钱</span>-->
<!--                                    </div>-->
<!--                                </a></li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li>-->
<!--                                <div class="text-center link-block">-->
<!--                                    <a class="J_menuItem" href="notifications.html"> <strong>查看所有-->
<!--                                        </strong> <i class="fa fa-angle-right"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                        </ul></li>-->
<!--                    <li class="dropdown hidden-xs"><a-->
<!--                            class="right-sidebar-toggle" aria-expanded="false"> <i-->
<!--                                class="fa fa-tasks"></i> 主题-->
<!--                        </a></li>-->
<!--                </ul>-->
<!--            </nav>-->
<!--        </div>-->
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft">
                <i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab"
                       data-id="index_v1.html">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight">
                <i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">
                    关闭操作<span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a></li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a></li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a></li>
                </ul>
            </div>
            <a href="../../con_manager/c_manager/logout" class="roll-nav roll-right J_tabExit"><i
                    class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%"
                    src="../../../system/auto/c_project/index" frameborder="0"
                    data-id="../../../system/auto/c_project/index" seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right">
                Copyright &copy; 2018.Company name All rights reserved.More Templates
                <a href="../../../order/index/c_index/index?project_id=<?php echo $project_id;?>" target="_blank" title="任性工作室">任性工作室</a>
                - Collect from <a href="../../../order/index/c_index/index?project_id=<?php echo $project_id;?>" title="任性工作室"
                                  target="_blank">任性工作室</a>
            </div>
        </div>
    </div>
    <!--右侧部分结束-->
    <!--右侧边栏开始-->
    <div id="right-sidebar">
        <div class="sidebar-container">
            <ul class="nav nav-tabs navs-2">
                <li class="active"><a data-toggle="tab" href="#tab-1"> 通知 </a></li>
                <li class=""><a data-toggle="tab" href="#tab-2"> 项目进度 </a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane">
                    <div class="sidebar-title">
                        <h3>
                            <i class="fa fa-comments-o"></i> 最新通知
                        </h3>
                        <small><i class="fa fa-tim"></i> 您当前有10条未读信息</small>
                    </div>
                    <div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="pull-left text-center">
                                    <div class="m-t-xs">
                                        <i class="fa fa-star text-warning"></i> <i
                                            class="fa fa-star text-warning"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    据天津日报报道：瑞海公司董事长于学伟，副董事长董社轩等10人在13日上午已被控制。 <br> <small
                                        class="text-muted">今天 4:21</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="pull-left text-center">
                                </div>
                                <div class="media-body">
                                    HCY48之音乐大魔王会员专属皮肤已上线，快来一键换装拥有他，宣告你对华晨宇的爱吧！ <br> <small
                                        class="text-muted">昨天 2:45</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">

                    <div class="sidebar-title">
                        <h3>
                            <i class="fa fa-cube"></i> 最新任务
                        </h3>
                        <small><i class="fa fa-tim"></i> 您当前有14个任务，10个已完成</small>
                    </div>

                    <ul class="sidebar-list">
                        <li><a href="#">
                                <div class="small pull-right m-t-xs">9小时以后</div>
                                <h4>市场调研</h4> 按要求接收教材；

                                <div class="small">已完成： 22%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 22%;"
                                         class="progress-bar progress-bar-warning"></div>
                                </div>
                                <div class="small text-muted m-t-xs">项目截止： 4:00 -
                                    2015.10.01</div>
                            </a></li>
                        <li><a href="#">
                                <div class="small pull-right m-t-xs">9小时以后</div>
                                <h4>建设阶段</h4> 编写目的编写本项目进度报告的目的在于更好的控制软件开发的时间,对团队成员的
                                开发进度作出一个合理的比对

                                <div class="small">已完成： 48%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar"></div>
                                </div>
                            </a></li>
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/js/bootstrap.min.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/js/plugins/layer/layer.min.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/js/hplus.min.js"></script>
<script type="text/javascript" src="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/js/contabs.min.js"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>hplus/js/plugins/pace/pace.min.js"></script>
</body>
</html>