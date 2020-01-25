<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("assets/site/meta.php");?>
        <?php include("model/users.php");?>
        <title>Dashboard | InvestUs</title>
    </head>
    <body>
        <div class="container-fluid dashboard">
            <nav class="d-flex justify-content-end p-2 align-items-center">
            <p class="h5 mr-3  text-white"><?=$_SESSION['fullname']?></p>
                <div>
                    <img class="rounded-circle avatar" src="<?php 
                    $data = (new Users)->getUserData($_SESSION['user_id']);
                    echo ROOT."public/users_avatar/".$data['user_avatar'];
                    ?>" alt="user profile pic">
                </div>
            </nav>
            <div class="row mt-1 p-3">
                <div class="col-lg-2 justify-content-center text-center" id="menudashboard"><?php include("assets/site/menudashboard.php"); ?></div>
                <div class="col-lg-10 justify-content-center text-center pl-1"><?php include("assets/site/userpanel.php");?></div>
            </div>
            </div>
        </div>
    </body>
</html>