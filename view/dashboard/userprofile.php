<div class="row">
    <div class="col-md-12 shadow p-3 mb-5 bg-white rounded text-dark">
        <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST" enctype="multipart/form-data"> 
            <div class="form-group">
                <div class="row align-content-center justify-content-between">
                    <div class="col-md-8 userpanel p-3">
                        <p class="h4">Edit Profile</p>
                        <div class="row ">
                            <div class="col-md-2">
                                <label>First name:</label>
                            </div>
                            <div class="col-md-4">
                                <input class="col-lg-12 input-lg mt-1 mb-2" type="text" name="first_name" value="<?=$user->first_name?>" required minlength="2">
                            </div>
                            <div class="col-md-2">
                                <label>Last name:</label>
                            </div>
                            <div class="col-md-4">
                                <input class="col-lg-12 input-lg mt-1 mb-2" type="text" name="last_name" value="<?=$user->last_name?>" required minlength="2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Email:</label>
                            </div>
                            <div class="col-md-6">
                                <input class="col-lg-12 input-lg mt-1 mb-2 " type="email" name="email" value="<?=$user->email?>" required minlength="2">
                            </div>
                            <div class="col-md-2">
                                <label>Phone:</label>
                            </div>
                            <div class="col-md-2">
                                <input class="col-lg-12 input-lg mt-1 mb-2" type="text" name="phone" value="<?=$user->phone?>" required minlength="2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Address:</label>
                            </div>
                            <div class="col-md-10">
                                <input class="col-lg-12 input-lg mt-1 mb-2" type="text" name="address" value="<?=(isset($user->address)) ? $user->address : "Add your address"?>" minlength="4">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Suite:</label>
                            </div>
                            <div class="col-md-4">
                                <input class="col-lg-12 input-lg mt-1 mb-2" type="text" name="suite" value="<?=(isset($user->suite)) ? $user->suite : "Suite"?>" minlength="1">
                            </div>
                            <div class="col-md-2">
                                <label>Postal Code:</label>
                            </div>
                            <div class="col-md-4">
                                <input class="col-lg-12 input-lg mt-1 mb-2" type="text" name="postal_code" value="<?=(isset($user->postal_code)) ? $user->postal_code : "Suite"?>" minlength="4">
                            </div>
                        </div>
                        <div>
                            <button class="mb-2 mt-2" type="submit" name="update" >Save</button>
                        </div>
                    </div>
                    <div class="col-md-4 userpanel p-3">
                        <label>Current avatar:<div class="overflow-hidden"><img class="currentAvatar mt-1 mb-2" src="<?=ROOT."public/users_avatar/".$user->user_avatar?>" alt="current user avatar"></div></label>
                        <input type="file" class="mb-2" name="userAvatar">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>