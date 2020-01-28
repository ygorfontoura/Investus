<?php if(isset($_POST) && !empty($_POST) ){header('Location:'.$_SERVER['REQUEST_URI']);} ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once("assets/site/meta.php");
            include_once("model/users.php");
            $data = (new Users)->getUserData($_SESSION['user_id']);
            $user_account = (new Users)->getAccount($_SESSION['user_id']);
            ?>
        <meta http-equiv="cache-control" content="no-cache">
        <title>Dashboard | <?=PROJECTNAME?></title>
    </head>
    <body>
        <div class="container-fluid dashboard h-100">
            <div class="row">
                <div class="col-md-2 dashboardBgc">
                    <div class="justify-content-center text-center min-vh-100 sticky-top" id="menudashboard"><?php include("assets/site/menudashboard.php");?></div>
                </div>
                <div class="col-md-10">
                    <div class="d-flex justify-content-end p-2 align-items-center">
                        <p class="h5 mr-3  text-dark"><?=$_SESSION['first_name']." ".$_SESSION['last_name'];?></p>
                        <div>
                            <img class="rounded-circle avatar" src="<?php 
                            echo ROOT."public/users_avatar/".$data['user_avatar'];
                            ?>" alt="user profile pic">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12 justify-content-center text-center pl-1"><?php include("assets/site/userpanel.php");?></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>