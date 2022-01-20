<?php

require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

include_once '../template/header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                <i class='bx bxs-user'></i> <?=$login['username']?>
                </div>
                <div class="card-body">
                    <form action = '<?=$url_website?>settings/action' class="form-horizontal" method="post" enctype="multipart/form-data" id="order-form">
                        <img src="<?=$url_website?>assets/images/profile/<?=$login['photo']?>" >
                        <br>
                        <span>Change Photo (Max 512kb, Format: jpeg,jpg, and png)</span>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="inputGroupFile01">Photo Profile</label>
                                <input type="file" class="form-control" id="inputGroupFile01" name="photoprof">
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <button type="submit" name="changephoto" value="changephoto" class="btn btn-primary waves-effect waves-light">Change Photo
                            </button>
                        </div>
                    </form>
                    <br>
                    <form action = '<?=$url_website?>settings/action' class="form-horizontal" method="post" id="order-form">
                        
                        
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label for="inputEmail" class="form-label">Name</label>
                                <input type="text" name="name" value="<?=$login['name']?>" class="form-control" >
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label for="inputEmail" class="form-label">Birthday</label>
                                <input type="date" name="birthday" value="<?=$login['birthday']?>" class="form-control" >
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                                <option value="L" <?php echo ($login['gender'] == 'L') ? 'selected' : '' ?>>Male</option>
                                <option value="P" <?php echo ($login['gender'] == 'P') ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label  class="form-label">Phone</label>
                                <input type="number"  name="phone" value="<?=$login['phone']?>" class="form-control" >
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label  class="form-label">Email</label>
                                <input type="email"  value="<?=$login['email']?>" class="form-control" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label  class="form-label">username</label>
                                <input type="text"  value="<?=$login['username']?>" class="form-control" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="form-group col-lg-6">
                                <button type="submit" name="cdetail" value="cdetail" class="btn btn-primary waves-effect waves-light">Change Detail
                                </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class='bx bxs-key' ></i> Change Password
                </div>
                <div class="card-body" >
                    <form action = '<?=$url_website?>settings/action' class="form-horizontal" method="post" >
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label for="inputEmail" class="form-label">Current Password</label>
                                <input type="password" name = 'password' class="form-control">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label for="inputEmail" class="form-label">New Password</label>
                                <input type="password" name="npassword"  class="form-control" >
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label for="inputEmail" class="form-label">Confirm New Password</label>
                                <input type="password" name="cnpassword" class="form-control" >
                            </div>
                        </div>
                        <br>
                        
                        <div class="form-group">
                            <button type="submit" name="changepass" value="changepass" class="btn btn-primary waves-effect waves-light">Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 

</body>
</html>