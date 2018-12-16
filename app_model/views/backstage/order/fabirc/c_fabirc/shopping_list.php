<script type="text/javascript">
    $(document).ready(function() {
        $('#system_add_form').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                cms_mark: {
                    group: '.col-lg-4',
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            message: '输入字符长度需要在6-30之间'
                        },
                    }
                },
                captcha: {
                    validators: {
                        callback: {
                            message: 'Wrong answer',
                            callback: function(value, validator) {
                                var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                                return value == sum;
                            }
                        }
                    }
                }
            }
        });
        $('#system_add_form').on('hide.bs.modal', function () {
            $('#system_add_form').data('bootstrapValidator').resetForm(true);
        });
        $("#system_add_form").submit(function(ev){ev.preventDefault();});
        $('#system_add_reset_btn').click(function() {
            $('#system_add_form').data('bootstrapValidator').resetForm(true);
        });
        function system_add_submit_data()
        {
            var data=$('.system-add-form-horizontal').serialize();
            //序列化获得表单数据，结果为：user_id=12&user_name=John&user_age=20
            var submitData=decodeURIComponent(data,true);
            //submitData是解码后的表单数据，结果同上
            submitData+="&flag_ajax_reurn=1";
            $.ajax({
                url:'../../../system/auto/c_project/add',
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
                        $('#system-add-modal-confirm-result-confirm').show();
                        $('#system-add-modal-confirm-result-cancel').hide();
                    }
                    else
                    {
                        $('#system-add-modal-confirm-result-confirm').hide();
                        $('#system-add-modal-confirm-result-cancel').show();
                    }
                    $('#system-add-modal-confirm-view').modal('hide');
                    $('#system-add-modal-confirm-result-content').html("<p>"+dataObj.reason+"<p>");
                    $('#system-add-modal-confirm-result').modal({backdrop:'false',keyboard:false});
                },
                complete:function(){
                    //请求结束时
                },
                error:function(){
                    //请求失败时
                }
            });
        }
        $('#system-add-modal-confirm').click(function(){
            var bootstrapValidator = $("#system_add_form").data('bootstrapValidator');
            bootstrapValidator.validate();
            if(bootstrapValidator.isValid()){
                $('#system-add-modal-confirm-view').modal({backdrop:'false',keyboard:false});
            }else{
                return;
            }
        });
        $('#system-add-modal-confirm-view-cancel').click(function(){
            $('#system-add-modal-confirm-view').modal('hide');
        });
        $('#system-add-modal-confirm-result-cancel').click(function(){
            $('#system-add-modal-confirm-result').modal('hide');
        });

        $('#system-add-modal-confirm-result-confirm').click(function(){
            $('#system-add-modal-confirm-result').modal('hide');
        });
    });
</script>
<button class="btn purple" type="button" data-toggle="modal" data-target="#system-add-modal">
    <i class="fa fa-book"> 购物车</i>
</button>
<div class="modal fade" id="system-add-modal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">购物车</h2>
            </div>
            <!-- table -->
            <div class="view_tables">
                <table class="table table-hover" id="index_list">
                    <thead>
                    <tr>
                        <th>名称</th>
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
                                <td><input type="hidden" value="<?php echo $val['cms_id'];?>"/>
                                    <h5><?php echo $val['cms_name'];?></h5>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" title="" class="btn btn-default wh-btn" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-cog icon_8"></i>
                                            <i class="fa fa-chevron-down icon_8"></i>
                                        </a>
                                        <ul class="dropdown-menu float-right">
                                            <li>
                                                <a href="#" data-toggle="modal" attr-key="cms_id" attr-value="<?php echo $val['cms_id']; ?>" class="font-red" title="">
                                                    <i class="fa fa-trash-o icon_9"></i> 删除
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
            <!-- table -->
            <div class="clearfix"></div>
            <div class="modal-footer">
                <div class="form-body">
                    <span>
                		<div class="modal fade" id="system-add-modal-confirm-result" tabindex="-1" aria-hidden="true">
                			<div class="modal-dialog">
                				<div class="modal-content">
                					<div class="modal-header">
                                        <h4 class="modal-title">处理结果:</h4>
                                    </div>
                					<div class="modal-body" id="system-add-modal-confirm-result-content">

                					</div>
                                    <div class="modal-footer">
                                        <span id="system-add-modal-confirm-result-confirm">
                                            <button type="button" class="btn btn-primary" onclick="url_refresh();">确定</button>
                                        </span>
                                        <span id="system-add-modal-confirm-result-cancel">
                                            <button type="button" class="btn btn-primary">确定</button>
                                        </span>
                                    </div>
                				</div>
                			</div>
                		</div>
                    </span>
                    <span>
                        <button class="btn purple" type="button" id="system_add_reset_btn">
                        	   <i class="fa fa-book"> 重置数据 </i>
                        </button>
                    </span>
                    <span>
                        <button class="btn purple" type="button" data-dismiss="modal">
                        	   <i class="fa fa-book"> 取消 </i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>