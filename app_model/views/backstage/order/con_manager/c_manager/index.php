<?php
/**
 * Created by <stacrcor.com>.
 * Author: xinxin.deng
 * Date: 2018/12/16 15:27
 */
if(!defined('VIEW_MODEL_BACKGROUD'))
{
    define('VIEW_MODEL_BACKGROUD', '/CodeIgniter/view_model/backstage/');
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
    <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
    <link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        .htmleaf-header{margin-bottom: 15px;font-family: "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", "FontAwesome", sans-serif;}
        .htmleaf-icon{color: #fff;}

        .profile-user-info-striped {
            border: 1px solid #dcebf7;
        }
        .profile-user-info {
            margin: 0 12px;
        }
        .profile-info-row {
            position: relative;
        }
        .profile-info-name {
            position: absolute;
            width: 110px;
            text-align: right;
            padding: 6px 10px 6px 0;
            left: 0;
            top: 0;
            bottom: 0;
            font-weight: normal;
            color: #667e99;
            background-color: transparent;
            border-top: 1px dotted #d5e4f1;
        }
        .profile-user-info-striped .profile-info-name {
            color: #336199;
            background-color: #edf3f4;
            border-top: 1px solid #f7fbff;
        }
        .profile-info-row:first-child .profile-info-name {
            border-top: 0;
        }
        .profile-info-value {
            padding: 6px 4px 6px 6px;
            margin-left: 120px;
            border-top: 1px dotted #d5e4f1;
        }
        .editable-click {
            border-bottom: 1px dashed #BBB;
            cursor: pointer;
            font-weight: normal;
        }
        .profile-picture {
            border: 1px solid #CCC;
            background-color: #FFF;
            padding: 4px;
            display: inline-block;
            max-width: 100%;
            -moz-box-sizing: border-box;
            box-shadow: 1px 1px 1px rgba(0,0,0,0.15);
        }
        .editable-click {
            border-bottom: 1px dashed #BBB;
            cursor: pointer;
            font-weight: normal;
        }
        img.editable-click {
            border: 1px dotted #BBB;
        }
        .space-4 {
            max-height: 1px;
            min-height: 1px;
            overflow: hidden;
            margin: 4px 0 3px;
        }
        .label {
            border-radius: 0;
            text-shadow: none;
            font-weight: normal;
            display: inline-block;
            background-color: #abbac3!important;
        }
        .label.arrowed:before, .label.arrowed-in:before {
            display: inline-block;
            content: "";
            position: absolute;
            top: 0;
            z-index: -1;
            border: 1px solid transparent;
            border-right-color: #abbac3;
        }
        .width-80 {
            width: 80%!important;
        }
        .label-info{
            background-color: #3a87ad!important;
        }
        .label-xlg {
            padding: .3em .7em .4em;
            font-size: 14px;
            line-height: 1.3;
            height: 28px;
        }
        .label-xlg.arrowed-in {
            margin-left: 7px;
        }
        .label.arrowed-in:before {
            left: -5px;
            border-width: 10px 5px;
        }
        .label-info.arrowed-in:before {
            border-color: #3a87ad;
        }
        .label.arrowed-in:before {
            border-color: #abbac3;
            border-left-color: transparent!important;
        }
        .label-xlg.arrowed-in-right {
            margin-right: 7px;
        }
        .label.arrowed-in-right {
            position: relative;
            z-index: 1;
        }
        .hr {
            display: block;
            height: 0;
            overflow: hidden;
            font-size: 0;
            border-top: 1px solid #e3e3e3;
            margin: 12px 0;
        }
        .hr.dotted, .hr-dotted {
            border-top-style: dotted;
        }
        .row {
            margin-right: -12px;
            margin-left: -12px;
        }
        .inline {
            display: inline-block!important;
        }
        .position-relative {
            position: relative;
        }
        .white {
            color: #fff!important;
        }
    </style>
    <script type="text/javascript">
        $(function() {
            var defaultData = <?php echo (isset($fabirc_type)&&is_array($fabirc_type)) ? json_encode($fabirc_type) : json_encode(array());?>;
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
                        //展示右侧面辅料

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
    </script>
</head>
<body>
<div class="col-xs-12">
    <div>
        <div class="user-profile row">
            <div class="col-xs-12 col-sm-3 center">
                <div>
                    <span class="profile-picture">
                        <img class="editable img-resposive editable-click" src="<?php echo VIEW_MODEL_BACKGROUD; ?>images/profile-pic.jpg">
                    </span>
                    <div class="space-4"></div>
                    <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                        <div class="inline position-relative">
                            <span class="white"><?PHP echo $user['cms_name']?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-9">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-row">
                        <div class="profile-info-name">用户id</div>

                        <div class="profile-info-value">
                            <span class="editable" id="username"><?PHP echo $user['cms_id']?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name">用户名</div>

                        <div class="profile-info-value">
                            <span class="editable" id="username"><?PHP echo $user['cms_name']?></span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name">手机号</div>

                        <div class="profile-info-value">
                            <span class="editable" id="telephone"><?PHP echo $user['cms_telephone']?></span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name">地址</div>

                        <div class="profile-info-value">
                            <i class="icon-map-marker light-orange bigger-110"></i>
                            <span class="editable" id="country">Netherlands</span>
                            <span class="editable" id="city">Amsterdam</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name">邮箱</div>

                        <div class="profile-info-value">
                            <span class="editable" id="email">946015091@qq.com</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name">用户角色</div>

                        <div class="profile-info-value">
                            <span class="editable" id="login">3 hours ago</span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name">简介</div>

                        <div class="profile-info-value">
                            <span class="editable" id="about">Editable as WYSIWYG</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hr dotted"></div>
    <div class="">
        <div class="col-xs-12">

        </div>
    </div>
</div>

</body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        $('#treeview-selectable ul li').eq(0).css('color','#ffffff');
        $('#treeview-selectable ul li').eq(0).css('background-color','#428bca');
    })
</script>