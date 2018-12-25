<div class="sidebar-menu">
	<header class="logo">
		<a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span>
		</a> <a href="index.html"> <span id="logo">
				<h1>管理系统</h1>
		</span> <!--<img id="logo" src="" alt="Logo"/>-->
		</a>
	</header>
	<div style="border-top: 1px solid rgba(69, 74, 84, 0.7)"></div>
	<!--/down-->
	<!--//down-->
	<div class="menu">
		<ul id="menu">
			<li><a href="index.html"><i class="fa fa-tachometer"></i> <span> 首页 </span></a></li>
			<?php if(isset($data_menu) && is_array($data_menu)){foreach ($data_menu as $menu_1_val){?>
			     <?php if(isset($menu_1_val['child_list']) && is_array($menu_1_val['child_list']) && !empty($menu_1_val['child_list']) && isset($menu_1_val['child_list'][0]['child_list'][0]['data']['cms_url'])){?>
    			     <li id="menu-comunicacao"><a href="../../../<?php echo $menu_1_val['child_list'][0]['child_list'][0]['data']['cms_url'];?>"><i class="fa fa-smile-o"></i> <span> <?php echo $menu_1_val['data']['cms_name'];?> </span><span	class="fa fa-angle-double-right" style="float: right"></span></a>
    			         <ul id="menu-comunicacao-sub">
    			             <?php foreach ($menu_1_val['child_list'] as $menu_2_val){?>
			                     <?php if(isset($menu_2_val['child_list']) && is_array($menu_2_val['child_list']) && !empty($menu_2_val['child_list'])){?>
        			                 <li id="menu-mensagens" style="width: 200px"><a href="../../../<?php echo $menu_1_val['child_list'][0]['child_list'][0]['data']['cms_url'];?>"> <?php echo $menu_2_val['data']['cms_name'];?>	<i class="fa fa-angle-right" style="float: right; margin-right: -8px; margin-top: 2px;"></i></a>
        						          <ul id="menu-mensagens-sub">
        						              <?php foreach ($menu_2_val['child_list'] as $menu_3_val){?>
        						                  <li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../../<?php echo $menu_3_val['data']['cms_url'];?>"> <?php echo $menu_3_val['data']['cms_name'];?> </a></li>
        						              <?php }?>
        						          </ul>
        						     </li>
    						     <?php }?>
    			             <?php }?>
    		             </ul>
    			     </li>
			     <?php }?>
			<?php }}else{?>
    			<li id="menu-comunicacao"><a href="#"><i class="fa fa-smile-o"></i> <span> 系统配置 </span><span	class="fa fa-angle-double-right" style="float: right"></span></a>
    				<ul id="menu-comunicacao-sub">
    					<li id="menu-mensagens" style="width: 200px"><a href="project.html"> 自动化管理	<i class="fa fa-angle-right" style="float: right; margin-right: -8px; margin-top: 2px;"></i></a>
    						<ul id="menu-mensagens-sub">
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../../system/auto/c_project/index"> 项目管理 </a></li>
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../../system/auto/c_menu/index"> 目录管理 </a></li>
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../../system/auto/c_page/index"> 页面管理 </a></li>
    						</ul>
    					</li>
    					<li id="menu-mensagens" style="width: 200px"><a href="project.html"> 数据库管理	<i class="fa fa-angle-right" style="float: right; margin-right: -8px; margin-top: 2px;"></i></a>
    						<ul id="menu-mensagens-sub">
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../database/c_tables/index"> 数据库表清单 </a></li>
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../con_admin/c_logic_model/logic_list">LOGIC模板</a></li>
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../con_admin/c_web_model/web_list">WEB模板</a></li>
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../con_admin/c_controll_model/controll_list">CONTROLL模板</a></li>
    						</ul>
    					</li>
    					<li id="menu-mensagens" style="width: 200px"><a href="project.html">全局配置	<i class="fa fa-angle-right" style="float: right; margin-right: -8px; margin-top: 2px;"></i></a>
    						<ul id="menu-mensagens-sub">
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../con_general/c_general/index">全局参数配置</a></li>
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../con_general/c_general/log">日志查询</a></li>
    						</ul>
    					</li>
    					<li id="menu-mensagens" style="width: 200px"><a href="project.html">系统配置	<i class="fa fa-angle-right" style="float: right; margin-right: -8px; margin-top: 2px;"></i></a>
    						<ul id="menu-mensagens-sub">
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../con_admin/c_admin/index">管理员配置</a></li>
    							<li id="menu-mensagens-enviadas" style="width: 200px"><a href="../../con_admin/c_logic_model/logic_list">角色配置</a></li>
    						</ul>
    					</li>
    				</ul>
    			</li>
			<?php }?>
		</ul>
	</div>
</div>