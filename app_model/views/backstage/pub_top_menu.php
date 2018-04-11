<!-- topbar starts -->
<div class="navbar navbar-default" role="navigation">
    <div class="navbar-inner">
        <button type="button" class="navbar-toggle pull-left animated flip">
    		<span class="sr-only">Toggle navigation</span> 
    		<span class="icon-bar"></span> 
    		<span class="icon-bar"></span> 
    		<span class="icon-bar"></span>
    	</button>
    	<a class="navbar-brand" href="index.html"> <img alt="Charisma Logo" src="<?php echo VIEW_MODEL_BACKGROUD; ?>img/logo20.png" class="hidden-xs" /> 
            <span> STARCOR </span>
        </a>
        <!-- user dropdown starts -->
        <div class="btn-group pull-right">
        	<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        		<i class="glyphicon glyphicon-user"></i>
        		<span class="hidden-sm hidden-xs"> 管理员 </span> 
        		<span class="caret"></span>
        	</button>
        	<ul class="dropdown-menu">
        		<li><a href="#"> 个人信息 </a></li>
        		<li class="divider"></li>
        		<li><a href="login.html"> 修改密码 </a></li>
        		<li class="divider"></li>
        		<li><a href="./login"> 退出登录 </a></li>
        	</ul>
        </div>
        <!-- user dropdown ends -->
        <!-- theme selector starts -->
        <div class="btn-group pull-right theme-container animated tada">
        	<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        		<i class="glyphicon glyphicon-tint"></i>
        		<span class="hidden-sm hidden-xs"> 更换主题 / 皮肤</span> 
        		<span class="caret"></span>
        	</button>
        	<ul class="dropdown-menu" id="themes">
        		<li><a data-value="classic" href="#"><i class="whitespace"></i> 经典主题 </a></li>
        		<li class="divider"></li>
        		<li><a data-value="cerulean" href="#"><i class="whitespace"></i> 蔚蓝色 </a></li>
        		<li class="divider"></li>
        		<li><a data-value="simplex" href="#"><i class="whitespace"></i> 单调色 </a></li>
        		<li class="divider"></li>
        		<li><a data-value="slate" href="#"><i class="whitespace"></i> 石板色 </a></li>
        	</ul>
        </div>
        <!-- theme selector ends -->
		<ul class="collapse navbar-collapse nav navbar-nav top-menu">
			<li><a href="#"><i class="glyphicon glyphicon-globe"></i>Visit Site</a></li>
			<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="glyphicon glyphicon-star"></i> Dropdown <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#">Action</a></li>
					<li class="divider"></li>
					<li><a href="#">Another action</a></li>
					<li class="divider"></li>
					<li><a href="#">Something else here</a></li>
					<li class="divider"></li>
					<li><a href="#">Separated link</a></li>
					<li class="divider"></li>
					<li><a href="#">One more separated link</a></li>
				</ul>
			</li>
			<li>
				<form class="navbar-search pull-left">
					<input placeholder=" 搜索 " class="search-query form-control col-md-10" name="query" type="text">
				</form>
			</li>
		</ul>
	</div>
</div>
<!-- topbar ends -->