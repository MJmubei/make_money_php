<?php
    $int_page_show_num =5;
    $int_page_show_num = ($int_page_show_num%5) == '1' ? $int_page_show_num+1 : $int_page_show_num;
    $arr_page_index = array(
        '5',
        '10',
        '25',
        '50',
        '100',
        '200',
    );
    $int_page_size = (!isset($page_info['cms_page_size']) || !in_array($page_info['cms_page_size'], $arr_page_index)) ? $arr_page_index[0] : $page_info['cms_page_size'];
    $int_page_num = (!isset($page_info['cms_page_num']) || (int)$page_info['cms_page_num'] <1) ? 1 : (int)$page_info['cms_page_num'];
    $int_data_count = (!isset($page_info['cms_data_count']) || (int)$page_info['cms_data_count'] <1) ? 0 : (int)$page_info['cms_data_count'];
    $int_page_count = ceil($int_data_count/$int_page_size);
    $int_page_count = $int_page_count <1 ? 1 : $int_page_count;
    $arr_left = $arr_right = array();
    for ($i=1;$i<=$int_page_show_num;$i++)
    {
        $int_left = $int_page_num-$i;
        $int_right = $int_page_num+$i;
        if($int_left >=1)
        {
            $arr_left[] = $int_left;
        }
        if($int_right <=$int_page_count)
        {
            $arr_right[] = $int_right;
        }
    }
    $arr_pages = array($int_page_num);
    for ($j=0;$j<$int_page_show_num;$j++)
    {
        if(count($arr_left)>0)
        {
            array_unshift($arr_pages, array_pop($arr_left));
        }
        if(count($arr_right)>0)
        {
            array_push($arr_pages, array_shift($arr_right));
        }
        if(count($arr_pages) >=$int_page_show_num)
        {
            break;
        }
    }
    
?>
<div class="form-body">
	<form>
		<div class="col-md-5 page_1">
			<ul class="pagination pagination-lg">
				<li class="disabled">分页条数:</li>
			</ul>
			<select name="cms_page_size" id="location_cms_page_size">
			    <?php foreach ($arr_page_index as $page_index){?>
			        <option value="<?php echo $page_index;?>" <?php if($int_page_size == $page_index){ echo "selected";}?>><?php echo $page_index;?></option> 
			    <?php }?>
			</select>
			<ul class="pagination pagination-lg">
				<li class="disabled">记录条数:<?php echo $int_data_count;?>;当前第<?php echo $int_page_num;?>页;共计<?php echo $int_page_count;?>页</li>
			</ul>
		</div>
		<div class="col-md-5 page_1">
			<ul class="pagination pagination-lg">
		        <li <?php if($int_page_num<=1){echo 'class="disabled"';}?>>
		             <a href="javascript:url_location(1,<?php echo $int_page_size;?>);" aria-label="Previous"><span aria-hidden="true">«</span></a>
	             </li>
			    <li <?php if($int_page_num<=1){echo 'class="disabled"';}?>>
			         <a href="javascript:url_location(1,<?php echo $int_page_size;?>);"><i class="fa fa-angle-left"></i></a>
		        </li>
		        <?php foreach ($arr_pages as $page_value){?>
		             <li class="<?php if($page_value == $int_page_num){ echo 'active';}else{ echo "";}?>">
		                  <a href="javascript:url_location(<?php echo $page_value;?>,<?php echo $int_page_size;?>);"><?php echo $page_value;?></a>
	                 </li>
		        <?php }?>
				<li <?php if($int_page_num>=$int_page_count){echo 'class="disabled"';}?>>
		             <a href="javascript:url_location(<?php echo $int_page_count;?>,<?php echo $int_page_size;?>);"><i class="fa fa-angle-right"></i></a>
	            </li>
				<li <?php if($int_page_num>=$int_page_count){echo 'class="disabled"';}?>>
		             <a href="javascript:url_location(<?php echo $int_page_count;?>,<?php echo $int_page_size;?>);" aria-label="Previous"><span aria-hidden="true">»</span></a>
	            </li>
			</ul>
		</div>
		<div class="clearfix"></div>
	</form>
</div>
<script type="text/javascript">
	$("#location_cms_page_size").change(function(){
	  	var value = $(this).children('option:selected').val();
	  	$("#cms_page_size").val(value);
		$("#cms_page_num").val(1);
		$(".form-horizontal").submit();
	});
	function url_location(cms_page_num,cms_page_size)
	{
		$("#cms_page_size").val(cms_page_size);
		$("#cms_page_num").val(cms_page_num);
		$(".form-horizontal").submit();
	}
	function url_refresh()
	{
		$(".form-horizontal").submit();
	}
</script>