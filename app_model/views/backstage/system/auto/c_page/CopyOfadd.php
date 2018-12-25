<script type="text/javascript">
    $(document).ready(function() {
        $('#<?php echo $system_file_list_value['class'];?>-form').bootstrapValidator({
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
                cms_name: {
                    group: '.col-lg-4',
                    validators: {}
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
        
        $('#<?php echo $system_file_list_value['class'];?>-reset').click(function() {
            $('#<?php echo $system_file_list_value['class'];?>-form').data('bootstrapValidator').resetForm(true);
        });
        
    	$('#<?php echo $system_file_list_value['class'];?>-cancel').click(function() {
            $('#<?php echo $system_file_list_value['class'];?>-form').data('bootstrapValidator').resetForm(true);
        });
        
		
    	var file_md5   = '';   // 用于MD5校验文件
        var block_info = [];   // 用于跳过已有上传分片
        // 创建上传
        var uploader = WebUploader.create({
            swf: '<?php echo VIEW_MODEL_BACKGROUD; ?>webuploader-0.1.5/Uploader.swf',
            server: '<?php echo VIEW_MODEL_BASE; ?>app_model/libraries/em_upload.class.php',          // 服务端地址
            resize: false,
            chunked: true,                //开启分片上传
            chunkSize: 1024 * 1024 * 0.5,   //每一片的大小
            chunkRetry: 100,              // 如果遇到网络错误,重新上传次数
            threads: 3,                   // [默认值：3] 上传并发数。允许同时最大上传进程数。
            formData: {
            	system_func: 'init',
            },
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            pick: {
                id: '.system_file_picker',
                multiple:false, 
                label: '选择图片'
            },
        	fileNumLimit: 1,
        	duplicate :true,//让图片可重复上传
        });
		uploader.refresh();
        // 当有文件被添加进队列的时候-md5序列化
        uploader.on('fileQueued', function (file) {
            uploader.md5File(file).then(function (fileMd5) {
                file.wholeMd5 = fileMd5;
                file_md5 = fileMd5;
                // 检查是否有已经上传成功的分片文件
                $.post('<?php echo VIEW_MODEL_BASE; ?>app_model/libraries/em_upload.class.php', {md5: file_md5,system_func:'check'}, function (data) 
             	{
                    data = JSON.parse(data);
                    if(data.ret !=0)
                    {
                    	alert(data.reason);
                    }
                })
            });
        });
        // 发送前检查分块,并附加MD5数据
        uploader.on('uploadBeforeSend', function( block, data ) {
            var file = block.file;
            var deferred = WebUploader.Deferred();  
            data.md5value = file.wholeMd5;
            data.status = file.status;
            if ($.inArray(block.chunk.toString(), block_info) >= 0) {
                deferred.reject();  
                deferred.resolve();
                return deferred.promise();
            }
        });
        // 上传完成后触发
        uploader.on('uploadSuccess', function (file,response) {
            $.post('<?php echo VIEW_MODEL_BASE; ?>app_model/libraries/em_upload.class.php', { md5: file.wholeMd5, fileName: file.name,system_func:'merage' }, function (data) {
                var object = JSON.parse(data);
                if (object.ret == 0) 
                {
                	$(".system_file_picker_upload_1").hide();
                	$(".system_file_picker_stop").hide();
                	$(".system_file_picker_upload").hide();
                	sys_sweetalert('success','','图片上传成功','图片上传成功','','',false);
                }
                else
                {
                	sys_sweetalert('error','','图片上传失败','图片上传失败','','',false);
                }
            });
        });
        // 文件上传过程中创建进度条实时显示。
        uploader.on('uploadProgress', function (file, percentage) {
        	$("#percentage_a").css("width",parseInt(percentage * 100)+"%");
            $("#percentage").html(parseInt(percentage * 100) +"%");
        });
        // 上传出错处理
        uploader.on('uploadError', function (file) {
            uploader.retry();
        });

        // 暂停处理
        $(".system_file_picker_stop").click(function(e){
        	$(".system_file_picker_upload_1").hide();
        	$(".system_file_picker_stop").hide();
        	$(".system_file_picker_upload").show();
            uploader.stop(true);
        })

        // 从暂停文件继续
        $(".system_file_picker_upload").click(function(e){
        	$(".system_file_picker_upload_1").hide();
        	$(".system_file_picker_stop").show();
        	$(".system_file_picker_upload").hide();
            uploader.upload();
        })

        $(".system_file_picker_upload_1").click(function(e){
        	$(".system_file_picker_upload_1").hide();
        	$(".system_file_picker_stop").show();
        	$(".system_file_picker_upload").hide();
            uploader.upload();
        })
    });
</script>
<?php foreach ($system_file_list_value['button_data'] as $key=>$button_data_value){?>
    <button class="btn purple" type="button" data-toggle="modal" data-target="#<?php echo $system_file_list_value['class'];?>" onclick="system_auto_load('<?php echo $system_file_list_value['class'];?>','<?php echo $button_data_value['params'];?>');">
        <i class="fa <?php echo $button_data_value['icon'];?>"> <?php echo $button_data_value['name'];?></i>
    </button>
<?php }?>
<div class="modal fade" id="<?php echo $system_file_list_value['class'];?>" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content animated bounceInTop">
			<div class="modal-header">
				<button type="button" class="close second" data-dismiss="modal" aria-hidden="true">×</button>
				<h2 class="modal-title">添加数据</h2>
			</div>
			<div class="modal-body">
                <form id="<?php echo $system_file_list_value['class'];?>-form" method="post" action="" >
                	<div class="form-group">
                		<label class="col-md-2 control-label">图片</label>
                		<div class="col-md-10 system_file_ac_show">
                    		<div id="picker" class="col-md-3 system_file_picker">选择图片</div>
                    		<div class="col-md-5">
                        		<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 100%;margin-top: 12px;" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="percentage_a">
                                    <span id="percentage">0%</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class='btn green system_file_picker_upload_1' style="margin-top: 0px;"><i class="fa fa-upload"> 上传</i></button>
                                <button class='btn red system_file_picker_stop' style="margin-top: 0px;display:none;"><i class="fa fa-pause"> 暂停</i></button>
                                <button class='btn blue system_file_picker_upload' style="margin-top: 0px;display:none;"><i class="fa fa-play"> 继续</i></button>
                                
                            </div>
                        </div>
                        <div class="system_file_show">
                            <img alt="image" src="<?php echo VIEW_MODEL_BASE; ?>data_model/upload/psu.jpg" class="img-responsive center-block"/>
                        </div>
                	</div>
                </form>
			</div>
			<div class="clearfix"></div>
            <div class="modal-footer">
                <div class="form-body">
                    <span>
                		<button class="btn purple" type="button" onclick="sys_sweetalert('submit','<?php echo $system_file_list_value['class'];?>','您确定要添加这条信息吗','提交数据后系统将可能会添加此条数据，请谨慎操作！','<?php echo $system_file_list_value['ajax'];?>','',true);">
                        	   <i class="fa fa-book"> 提交 </i>
                        </button>
                    </span>
                    <span>
                        <button class="btn purple" type="button" id="<?php echo $system_file_list_value['class'];?>-reset">
                        	   <i class="fa fa-book"> 重置数据 </i>
                        </button>
                    </span>
                    <span>
                        <button class="btn purple" type="button" id="<?php echo $system_file_list_value['class'];?>-cancel" data-dismiss="modal">
                        	   <i class="fa fa-book"> 取消 </i>
                        </button>
                    </span>
        		</div>
            </div>
		</div>
	</div>
</div>