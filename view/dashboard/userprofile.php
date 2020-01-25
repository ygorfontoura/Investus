<?php $data = (new Users)->getUserData($_SESSION['user_id']); ?>
<div class="row pt-0">
    <div class="col-md-12">
        <form action="">
            <div class="form-group d-flex flex-column align-items-center">
                <div class="row">
                    <div class="col-md-8 userpanel">
                        <p class="h4">Edit Profile</p>
                        <label>Full name:</label>
                        <input class="col-lg-10 input-lg mt-1 mb-2" type="text" name="fullname" value="<?=$data['fullname']?>" required minlength="2">
                        <label>Email:</label>
                        <input class="col-lg-10 input-lg mt-1 mb-2 " type="email" name="email" value="<?=$data['email']?>" required minlength="2">
                        <label>Phone:</label>
                        <input class="col-lg-10 input-lg mt-1 mb-2" type="email" name="email" value="<?=$data['phone']?>" required minlength="2">
                        <label>Address:</label>
                        <input class="col-lg-10 input-lg mt-1 mb-2" type="email" name="email" value="<?=(isset($data['address'])) ? $data['address'] : "Add your address"?>" required minlength="8">
                        <div>
                            <button type="button" name="update">Save</button>
                        </div>
                    </div>
                    <div class="col-md-4 userpanel">
                        <label>Current avatar:<div><img class="currentAvatar mt-1 mb-2" src="<?=ROOT."public/users_avatar/".$data['user_avatar']?>" alt="current user avatar"></div></label>
                        <input type="file" class="mb-2">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>