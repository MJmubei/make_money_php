<div class="form-body">
    <div>
         <?php 
               if(isset($system_file_list) && is_array($system_file_list) && !empty($system_file_list))
               {
                   foreach ($system_file_list as $system_file_list_value)
                   {
                        include_once dirname(dirname(dirname(__FILE__))).'/backstage/'.$system_file_list_value['url'];
                   }
               }
         ?>
     </div>
     <div class="clearfix"></div>
</div>

<!-- 时间插件 -->
<link href="<?php echo VIEW_MODEL_BACKGROUD; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script src="<?php echo VIEW_MODEL_BACKGROUD; ?>js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({//年月日时分秒
        language:  'zh-CN',
        weekStart: 0, //一周从哪一天开始
        todayBtn:  1, //
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $('.form_date').datetimepicker({//年月日
        language:  'zh-CN',
        weekStart: 0, //一周从哪一天开始
        todayBtn:  1, //
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $('.form_time').datetimepicker({//时分秒
        language:  'zh-CN',
        weekStart: 0, //一周从哪一天开始
        todayBtn:  1, //
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        showMeridian: 1
    });
</script>
