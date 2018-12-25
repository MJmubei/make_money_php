<?php foreach ($system_file_list_value['button_data'] as $key=>$button_data_value){?>
    <button class="btn purple" type="button" onclick="sys_sweetalert('nopage_action_button','<?php echo $system_file_list_value['class'];?>','您确定要<?php echo $button_data_value['name'];?>这条信息吗','提交数据后系统将可能会<?php echo $button_data_value['name'];?>此条数据，请谨慎操作！','<?php echo $system_file_list_value['ajax'];?>','',true);">
        <i class="fa <?php echo $button_data_value['icon'];?>"> <?php echo $button_data_value['name'];?></i>
    </button>
<?php }?>