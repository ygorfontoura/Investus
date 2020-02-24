<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("assets/site/meta.php");?>
        <title>Forgot Password | <?=PROJECTNAME?></title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row loginBackground justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="row loginDiv">
                        <div class="col-lg-6 loginAreaBgc p-5">
                            <p class="h1 font-weight-bold text-white">Join the largest stock community in the world</p>
                            <p class="mt-5 text-white">Whether you want to buy or sell stock, become a better investor, or stay tuned – you can do it all here.</p>
                        </div>
                        <div class="col-lg-6 loginArea p-5">
                            <p class="font-weight-bold text-right fixed=top"><a class="text-dark text-decoration-none h3" href="<?=ROOT?>">&times;</a></p>
                            <p class="font-weight-bold">Reset your password</p>
                            <p>Enter your email and we’ll send a link to reset your password.</p>
                            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST" id="forgotForm">
                                <div class="form-group" id="forgotInputs">
                                    <input class="col-lg-12 input-lg mt-5" type="email" name="email" placeholder="Email">
                                    <div class="mt-4">
                                        <button type="submit" name="forgot" id="sendEmail">SEND EMAIL</button>
                                    </div>
                                </div>
                            </form>
                            <p>If your email is associated with InvestUs, a link will be send within few mins.
                            <br> Please check spam folder.
                            </p>
                            <a class="mt-5" href="<?=ROOT?>auth/login">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>