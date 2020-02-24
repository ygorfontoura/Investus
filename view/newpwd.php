<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("assets/site/meta.php");?>
        <title>Change Password | <?=PROJECTNAME?></title>
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
                            <?php
                                include_once("model/users.php");
                                $check = (new User)->checkRequestKey($key[1]);
                                if($check){
                            ?>
                            <form action="<?=ROOT."auth/forgot"?>" method="POST" id="newPassword">
                                <div class="form-group" id="newInputs">
                                    <input type="hidden" value="<?=$key[1]?>" name="request_key">
                                    <input class="col-lg-12 input-lg mt-2" type="password" name="pwd" placeholder="Choose a password" required minlegth="8" maxlength="1000" pattern="[A-Za-z-0-9]{8,1000}" title="Password must be 8 characters">
                                    <input class="col-lg-12 input-lg mt-2" type="password" name="rep_pwd" placeholder="Repeat password" required minlegth="8" maxlength="1000" pattern="[A-Za-z0-9]{8,1000}" title="Password must be 8 characters">
                                    <div class="mt-4">
                                        <button type="submit" name="newPwd" id="newPwd">Change</button>
                                    </div>
                                </div>
                            </form>
                            <?php } else { ?>
                                <p class="h4 font-weight-bold">Request key expired or already used.</p>
                            <?php } ?>
                            <a class="mt-5" href="<?=ROOT?>auth/login">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>