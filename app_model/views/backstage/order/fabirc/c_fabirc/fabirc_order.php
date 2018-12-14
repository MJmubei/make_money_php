<!DOCTYPE HTML>
<html>
<head>
<!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
    <?php
    //获取多余的GET参数

    ?>
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		.htmleaf-header{margin-bottom: 15px;font-family: "Segoe UI", "Lucida Grande", Helvetica, Arial, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans", "wenquanyi micro hei", "Hiragino Sans GB", "Hiragino Sans GB W3", "FontAwesome", sans-serif;}
		.htmleaf-icon{color: #fff;}
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
    <div class="inbox-mail">
        <div class="col-md-3 compose">
            <h2>面辅料分类</h2>
            <div id="treeview-selectable" class=""></div>
        </div>
    </div>
</body>
</html>