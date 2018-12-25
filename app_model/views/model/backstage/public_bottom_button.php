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