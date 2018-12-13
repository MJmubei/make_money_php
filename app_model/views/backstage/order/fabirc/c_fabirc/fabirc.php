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
    <table class="table">
        <tbody>
        <?php foreach ($fabirc as $value) {?>
        <tr class="table-row">
            <td class="table-img"><input type="checkbox" /></td>
            <td class="table-text">
                <h6><?php echo $value['cms_name'];?></h6>
            </td>
            <td><?php echo ($value['cms_is_scarce'] == 1) ? '<span class="ur">奇缺</span>' : '<span class="work">普通</span>' ?></td>
            <td class="march"></td>
            <td><i class="fa fa-star-half-o icon-state-warning"></i></td>
        </tr>
        <?php }?>
        </tbody>
    </table>

    <!--*********** 初始化必须加载 ***************** （分页信息） *********** 初始化必须加载 ***************** -->
    <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_page.php';?>
    <div class="form-body">
        <div class="col-md-12 form-group button-2">
            <button class="btn blue" type="button"
                    id="btn_tablecheckbox_check">
                <i class="fa fa-check-circle-o"> 全选</i>
            </button>

            <button class="btn blue" type="button"
                    id="btn_tablecheckbox_exchange">
                <i class="fa fa-times-circle-o"> 反选</i>
            </button>

            <button class="btn blue" type="button"
                    id="btn_tablecheckbox_uncheck">
                <i class="fa fa-times-circle"> 取消</i>
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
</body>
</html>
