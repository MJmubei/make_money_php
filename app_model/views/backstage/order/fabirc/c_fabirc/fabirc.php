<!DOCTYPE HTML>
<html>
<head>
    <!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
    <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        .htmleaf-header{margin-bottom: 15px;font-family: "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", "FontAwesome", sans-serif;}
        .htmleaf-icon{color: #fff;}
        .table-row .table-img input{cursor: pointer;}
        .icon-state-warning{cursor: pointer;}
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $("table tbody tr").click(function(){
                if($(this).attr("class"))
                {

                }
                if($(this).find("input[type='checkbox']").is(':checked') == true)
                {
                    $(this).find("input[type='checkbox']").prop('checked',false);
                }
                else
                {
                    $(this).find("input[type='checkbox']").prop('checked',true);
                }
            })
            //全选
        });
    </script>
</head>
<body>
    <table class="table" border="0">
        <tbody>
        <?php foreach ($fabirc as $value) {?>
        <tr class="table-row">
            <td class="table-text"><input class="cms_id" type="hidden" value="<?php echo $value['cms_id'];?>" /><h6><?php echo $value['cms_name'];?></h6></td>
            <td><?php echo ($value['cms_is_scarce'] == 1) ? '<span class="ur">奇缺</span>' : '<span class="work">普通</span>' ?></td>
            <td><i class="fa fa-star-half-o icon-state-warning"></i></td>
        </tr>
        <?php }?>
        </tbody>
    </table>
    <!--*********** 初始化必须加载 ***************** （分页信息） *********** 初始化必须加载 ***************** -->
    <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_page.php';?>
    <div class="form-body">
        <div class="col-md-12 form-group button-2">
            <button class="btn blue" type="button" id="btn_tablecheckbox_check">
                <i class="fa fa-check-circle-o"> 全选</i>
            </button>

            <button class="btn blue" type="button" id="btn_tablecheckbox_exchange">
                <i class="fa fa-times-circle-o"> 反选</i>
            </button>

            <button class="btn purple" type="button" id="btn_tablecheckbox_exchange">
                <i class="fa fa-book"> 加入购物车</i>
            </button>
            <button class="btn purple" type="button" id="btn_tablecheckbox_exchange">
                <i class="fa fa-book"> 支付面料</i>
            </button>

            <button class="btn blue" type="button" id="btn_tablecheckbox_exchange">
                <i class="fa fa-book"> 下一步</i>
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
</body>
</html>
