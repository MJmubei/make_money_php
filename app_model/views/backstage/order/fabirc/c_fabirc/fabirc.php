<!DOCTYPE HTML>
<html>
<head>
    <!-- *********** 初始化必须加载 ***************** （顶部JS加载） *********** 初始化必须加载 ***************** -->
    <?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/model/backstage/pub_top_web_file.php';?>
    <script type="text/javascript">
        $(function(){
            function initTableCheckbox() {
                var $thr = $('#index_list thead tr');
                var $checkAll = $thr.find('input');
                $checkAll.click(function(event){
                    /*将所有行的选中状态设成全选框的选中状态*/
                    $tbr.find("input[name='checkItem']").prop('checked',$(this).prop('checked'));
                    /*并调整所有选中行的CSS样式*/
                    if ($(this).prop('checked')) {
                        $tbr.find("input[name='checkItem']").parent().parent().addClass('warning');
                    } else{
                        $tbr.find("input[name='checkItem']").parent().parent().removeClass('warning');
                    }
                    /*阻止向上冒泡，以防再次触发点击操作*/
                    event.stopPropagation();
                });
                var $tbr = $('#index_list tbody tr');
                $tbr.find("input[name='checkItem']").click(function(event){
                    /*调整选中行的CSS样式*/
                    $(this).parent().parent().toggleClass('warning');
                    /*如果已经被选中行的行数等于表格的数据行数，将全选框设为选中状态，否则设为未选中状态*/
                    $checkAll.prop('checked',$tbr.find('input:checked').length == $tbr.length ? true : false);
                    /*阻止向上冒泡，以防再次触发点击操作*/
                    event.stopPropagation();
                });
                /*点击每一行时也触发该行的选中操作*/
                $tbr.click(function(){
                    $(this).find("input[name='checkItem']").click();
                });
            }
            initTableCheckbox();
        });
        function check_checkbox_value()
        {
            var cms_id = '';
            $('#index_list tbody tr').find("input[name='checkItem']").each(function(){
                if ($(this).is(':checked') && $(this).val().length >0 && $(this).attr('attr-key').length >0)
                {
                    cms_id+=$(this).attr('attr-key')+'[]='+$(this).val()+'&';
                }
            });
            return cms_id;
        }
        function system_submit_data(submitData,url)
        {
            //submitData是解码后的表单数据，结果同上
            submitData+="flag_ajax_reurn=1";
            $.ajax({
                url:url,
                type:"POST",
                data:submitData,
                cache:false,//false是不缓存，true为缓存
                async:true,//true为异步，false为同步
                beforeSend:function(){
                },
                success:function(result){
                    var dataObj=eval("("+result+")");
                    if(dataObj.ret == 0)
                    {
                        $('#system-modal-confirm-result-confirm').show();
                        $('#system-modal-confirm-result-cancel').hide();
                    }
                    else
                    {
                        $('#system-modal-confirm-result-confirm').hide();
                        $('#system-modal-confirm-result-cancel').show();
                    }
                    $('#system-modal-confirm-result-content').html("<p>"+dataObj.reason+"</p>");
                    $('#system-modal-confirm-result').modal({backdrop:'false',keyboard:false});
                },
                complete:function(){
                    //请求结束时
                },
                error:function(){
                    //请求失败时
                }
            });
        }
    </script>
</head>
<body>
    <div>
        <div class="view_tables">
            <table class="table table-hover" id="index_list">
                <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll" name="checkAll" /></th>
                    <th>面辅料</th>
                    <th>珍稀程度</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(isset($fabirc) && is_array($fabirc) && !empty($fabirc))
                {
                    foreach ($fabirc as $val)
                    {
                        ?>
                        <tr class='odd selected'>
                            <td><input type="checkbox" name="checkItem" attr-key="cms_id" value="<?php echo $val['cms_id'];?>"/></td>
                            <td><h5><?php echo $val['cms_name'];?></h5></td>
                            <td><?php echo ($val['cms_is_scarce'] == '1') ? "<span class='ur'>奇缺</span>" : "<span class='work'>普通</span>" ?></td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" title="" class="btn btn-default wh-btn" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog icon_8"></i>
                                        <i class="fa fa-chevron-down icon_8"></i>
                                    </a>
                                    <ul class="dropdown-menu float-right">
                                        <li>
                                            <a href="#" data-toggle="modal" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
                                                <i class="fa fa-plus"></i> 加入购物车
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="modal" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
                                                <i class="fa fa-trash-o icon_9"></i> 取消购物车
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="modal" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
                                            <i class="fa fa-plus"></i> 收藏
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" data-toggle="modal" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
                                                <i class="fa fa-trash-o icon_9"></i> 取消收藏
                                            </a>
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
                    <i class="fa fa-book"> 购物车列表</i>
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
        <div class="clearfix"></div>
    </div>
</body>
</html>