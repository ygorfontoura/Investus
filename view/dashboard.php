<?php 
        ## space for debubing functions
        ## example
            // include_once("assets/site/meta.php");
            // include_once("model/users.php");
            // include_once("model/stocks.php");
            // $data = getCurrency(CURRENCY); $currencies = $data['rates']; $base = $data['base']; $date = $data['date'];
            // $user_account = (new Account)->getAccount($_SESSION['user_id']);
            // print_r($user_account->addFunds($_SESSION['user_id'], $_POST));
            // die();
            
?>
<?php if(isset($_POST) && !empty($_POST) ){header('Location:'.$_SERVER['REQUEST_URI']);} ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once("assets/site/meta.php");
            include_once("model/users.php");
            include_once("model/stocks.php");
            $data = getCurrency(CURRENCY); $currencies = $data['rates']; $base = $data['base']; $date = $data['date'];
            $user->getUserData($_SESSION['user_id']);
            $user_account = (new Account)->getAccount($_SESSION['user_id']);
            ?>
        <meta http-equiv="cache-control" content="no-cache">
        <title>Dashboard | <?=PROJECTNAME?></title>
    </head>
    <body>
        <div class="container-fluid dashboard h-100">
            <div class="row">
                <div class="col-lg-2 col-md-1 dashboardBgc" id="lateralMenu">
                    <div class="justify-content-center text-center min-vh-100 sticky-top" id="menudashboard"><?php include("assets/site/menudashboard.php");?></div>
                </div>
                <div class="col-lg-10 col-md-11">
                    <div class="d-flex justify-content-end p-2 align-items-center">
                        <p class="h6 mr-3 text-dark"><a class="text-dark text-decoration-none" href="<?=ROOT?>dashboard/transferlog">
                            <?php $value = ($user_account->currency != 'EUR') ?number_format($user_account->balance*$currencies[$user_account->currency], 2, ".",",") : number_format($user_account->balance, 2, ".",",");
                                echo $value." "; echo (!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency];?>
                        </a>
                        </p>
                        <p class="h5 mr-3 text-dark"><?=$_SESSION['first_name']." ".$_SESSION['last_name'];?></p>
                        <div>
                            <img class="rounded-circle avatar" src="<?php 
                            echo ROOT."public/users_avatar/".$user->user_avatar;
                            ?>" alt="user profile pic">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm justify-content-center text-center pl-1"><?php include("assets/site/userpanel.php");?></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>