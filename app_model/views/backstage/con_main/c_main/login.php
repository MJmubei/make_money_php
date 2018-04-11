<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once dirname(dirname(dirname(__FILE__))).'/pub_web_file.php';?>
    </head>
    <body>
        <div class="ch-container">
            <div class="row">
                <div class="row">
                    <div class="col-md-12 center login-header">
                        <h2>Welcome to Charisma</h2>
                    </div>
                    <!--/span-->
                </div><!--/row-->
                <div class="row">
                    <div class="well col-md-5 center login-box">
                        <div class="alert alert-info">
                            	请输入你的账号密码...
                        </div>
                        <form class="form-horizontal" action="./index" method="post">
                            <fieldset>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                                    <input type="text" class="form-control" placeholder="账号...">
                                </div>
                                <div class="clearfix"></div><br>
            
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                                    <input type="password" class="form-control" placeholder="密码...">
                                </div>
                                <div class="clearfix"></div>
            
                                <div class="input-prepend">
                                    <label class="remember" for="remember"><input type="checkbox" id="remember"> 记住密码</label>
                                </div>
                                <div class="clearfix"></div>
            
                                <p class="center col-md-5">
                                    <button type="submit" class="btn btn-primary">登录</button>
                                </p>
                            </fieldset>
                        </form>
                    </div>
                    <!--/span-->
                </div><!--/row-->
            </div><!--/fluid-row-->
        </div><!--/.fluid-container-->
    </body>
</html>
