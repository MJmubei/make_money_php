<?php
/**
 * Created by <stacrcor.com>.
 * Author: xinxin.deng
 * Date: 2018/12/25 13:58
 */
?>
<!DOCTYPE HTML>
<html>
<head>
<!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
</head>
<body>
<div class="outter-wp">
    <div class="but_list">
        <ol class="breadcrumb">
            <li class="active">用户列表</li>
        </ol>
    </div>
    <div class="graph">
        <div class="form-body">
            <form class="form-horizontal" method="post" action="<?php echo $arr_page_url['list_url'];?>">
                <div class="form-group">
                    <label for="disabledinput" class="col-sm-1 control-label">用户名称</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control1" name="name" id="focusedinput" value="<?php echo isset($arr_params['cms_name']) ? $arr_params['cms_name'] : '';?>">
                    </div>
                    <label for="disabledinput" class="col-sm-1 control-label">电话号码</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control1" name="telephone" id="focusedinput" value="<?php echo isset($arr_params['cms_telephone']) ? $arr_params['cms_telephone'] : '';?>">
                    </div>
                    <label for="disabledinput" class="col-sm-1 control-label">注册日期</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control1" name="create_time" id="focusedinput" value="<?php echo isset($arr_params['cms_create_time']) ? $arr_params['cms_create_time'] : '';?>">
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
                    <th>用户名称</th>
                    <th>手机号码</th>
                    <th>角色</th>
                    <th>性别</th>
                    <th>公司名称</th>
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
                            <td><?php echo $val['cms_name'];?></td>
                            <td><?php echo $val['cms_telephone'];?></td>
                            <td><?php switch ($val['cms_role_id']){
                                    case 1:
                                        echo '订单管理员';
                                        break;
                                    case 2:
                                        echo '平台管理员';
                                        break;
                                    case 3:
                                        echo '生产商';
                                        break;
                                    case 4:
                                        echo '供应商';
                                        break;
                                    case 5:
                                        echo '样板师';
                                        break;
                                    case 6:
                                        echo '样衣师';
                                        break;
                                } ?></td>
                            <td><?php switch ($val['cms_sex']){
                                    case 1:
                                        echo '未知';
                                        break;
                                    case 2:
                                        echo '男';
                                        break;
                                    case 3:
                                        echo '女';
                                        break;
                                    default:
                                        echo '未知';
                                        break;
                                } ?></td>
                            <td><?php echo $val['cms_company_name'];?></td>
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
                                        <!--*********** 初始化必须加载 ***************** （下拉操作信息） *********** 初始化必须加载 ***************** -->
                                        <?php echo make_right_button($system_file_list, $val);?>
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
        <!--*********** 初始化必须加载 ***************** （底部按钮信息） *********** 初始化必须加载 ***************** -->
        <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/public_bottom_button.php';?>
    </div>
</body>
</html>