<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("assets/site/meta.php");?>
        <title>Join | <?=PROJECTNAME?></title>
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
                        <p class="font-weight-bold text-right fixed=top"><a class="text-dark text-decoration-none" href="<?=ROOT?>">X</a></p>
                            <p class="font-weight-bold">Join</p>
                            <p>Already an investor? <a href="<?=ROOT?>auth/login">Log In.</a></p>
                            <?php if(isset($success) && !$success) echo $success;?>
                            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                                <div class="form-group" id="loginInputs">
                                    <input class="col-lg-12 input-lg mt-5" type="text" name="first_name" placeholder="First name" required minlength="2">
                                    <input class="col-lg-12 input-lg mt-2" type="text" name="last_name" placeholder="Last name" required minlength="2">
                                    <input class="col-lg-12 input-lg mt-2" type="email" name="email" placeholder="Add an email" required>
                                    <input class="col-lg-12 input-lg mt-2" type="password" name="pwd" placeholder="Choose a password" required minlegth="8" maxlength="1000" pattern="[A-Za-z-0-9]{8}" title="Password must be 8 characters">
                                    <input class="col-lg-12 input-lg mt-2" type="password" name="rep_pwd" placeholder="Repeat password" required minlegth="8" maxlength="1000" pattern="[A-Za-z0-9]{8}" title="Password must be 8 characters">
                                    <input class="col-lg-12 input-lg mt-2" type="text" name="phone" placeholder="Your phone" required>
                                    <div class="mt-4">
                                        <button type="submit" name="login">JOIN</button>
                                    </div>
                            </form>
                            </div>
                            <div class="mt-3">
                                <p>By clicking Join, I confirm that I have read and agree to the InvestUs <a href="#">Terms of Service</a> , <a href="#">Privacy Policy</a>, and to receive emails and updates.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>