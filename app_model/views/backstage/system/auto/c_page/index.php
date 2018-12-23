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
				<li><a href="#">系统配置</a></li>
				<li><a href="#">自动化管理</a></li>
				<li class="active">项目列表</li>
			</ol>
		</div>
		<div class="graph">
    		<div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-heading">上传文件</div>
                  <div class="panel-body">
                        <div id="picker">选择文件</div>
                  </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">日志</div>
                    <div class="panel-body">
                        <div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="percentage_a">
                                    <span id="percentage">0%</span>
                                </div>
                            </div>
                        </div>
                        <div id="log" style="max-height: 600px;overflow: auto;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">按钮组</div>
                    <div class="panel-body">
                        <div id="ctlBtn" class="btn-group">
                            <input class="btn btn-primary" type="button" value="上传按钮">
                        </div>
                        <div class="btn-group">
                            <input class="btn btn-danger" type="button" value="暂停" id="stop">
                        </div>
                        <div class="btn-group">
                            <input class="btn btn-success" type="button" value="继续" id="start">
                        </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    var file_md5   = '';   // 用于MD5校验文件
    var block_info = [];   // 用于跳过已有上传分片

    // 创建上传
    var uploader = WebUploader.create({
        swf: '<?php echo VIEW_MODEL_BACKGROUD; ?>webuploader-0.1.5/Uploader.swf',
        server: 'index.php',          // 服务端地址
        pick: '#picker',              // 指定选择文件的按钮容器
        resize: false,
        chunked: true,                //开启分片上传
        chunkSize: 1024 * 1024 * 0.5,   //每一片的大小
        chunkRetry: 100,              // 如果遇到网络错误,重新上传次数
        threads: 3,                   // [默认值：3] 上传并发数。允许同时最大上传进程数。
    });

    // 上传提交
    $("#ctlBtn").click(function () {
        log('准备上传...');
        uploader.upload();
    });

    // 当有文件被添加进队列的时候-md5序列化
    uploader.on('fileQueued', function (file) {

        log("正在计算MD5值...");
        uploader.md5File(file)

        .then(function (fileMd5) {
            file.wholeMd5 = fileMd5;
            file_md5 = fileMd5;
            log("MD5计算完成。");

            // 检查是否有已经上传成功的分片文件
            $.post('check.php', {md5: file_md5}, function (data) {
                data = JSON.parse(data);

                // 如果有对应的分片，推入数组
                if (data.block_info) {
                    for (var i in data.block_info) {
                        block_info.push(data.block_info[i]);
                    }
                    log("有断点...");
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
            log("已有分片.正在跳过分片"+block.chunk.toString());
            deferred.reject();  
            deferred.resolve();
            return deferred.promise();
        }
    });

    // 上传完成后触发
    uploader.on('uploadSuccess', function (file,response) {
        log("上传分片完成。");
        log("正在整理分片...");
        $.post('merge.php', { md5: file.wholeMd5, fileName: file.name }, function (data) {
            var object = JSON.parse(data);
            if (object.code) {
                log("上传成功");
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
    $("#stop").click(function(e){
        log("暂停上传...");
        uploader.stop(true);
    })

    // 从暂停文件继续
    $("#start").click(function(e){
        log("恢复上传...");
        uploader.upload();
    })

    function log(html) {
        $("#log").append("<div>"+html+"</div>");
    }

</script>
	   </div>
	</div>
</body>
</html>