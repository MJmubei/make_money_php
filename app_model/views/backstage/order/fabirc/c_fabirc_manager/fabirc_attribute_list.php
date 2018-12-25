<!DOCTYPE HTML>
<html>
<head>
    <!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
    <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/model/backstage/pub_top_web_file.php';?>
</head>
<body>
<div class="outter-wp">
    <div class="but_list">
        <ol class="breadcrumb">
            <li><a href="#">产品管理</a></li>
            <li class="active">面辅料属性管理</li>
        </ol>
    </div>
    <div class="graph">
        <div class="form-body">
            <form class="form-horizontal_search" method="post" action="<?php echo $arr_page_url['list_url'];?>">
                <div class="form-group">
                    <label for="disabledinput" class="col-sm-1 control-label">名称</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control1" name="cms_name" id="focusedinput" value="<?php echo isset($arr_params['cms_name']) ? $arr_params['cms_name'] : '';?>">
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-success" type="button" id="button_query_list_search">
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
                    <th>属性</th>
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
                            <td><?php echo $val['cms_name'];?></td>
                            <td><?php echo $val['cms_create_time'];?></td>
                            <td><?php echo $val['cms_modify_time'];?></td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" title="" class="btn btn-default wh-btn" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog icon_8"></i>
                                        <i class="fa fa-chevron-down icon_8"></i>
                                    </a>
                                    <ul class="dropdown-menu float-right">
                                        <!--*********** 初始化必须加载 ***************** （下拉操作信息） *********** 初始化必须加载 ***************** -->
                                        <?php echo make_right_button($system_file_list, $val);?>
                                        <li>
                                            <a href="./fabirc_attribute_value_list?cms_fabirc_attribute_id=<?php echo $val['cms_id'];?>"><i class="fa fa-pencil-square-o icon_9"></i>属性值列表</a>
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
        <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/model/backstage/pub_page.php';?>
        <!--*********** 初始化必须加载 ***************** （底部按钮信息） *********** 初始化必须加载 ***************** -->
        <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/model/backstage/public_bottom_button.php';?>
    </div>
</body>
</html>