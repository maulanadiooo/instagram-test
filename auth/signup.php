<?php
require '../lib/function.php';
require '../lib/auth_session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=$url_website?>assets/images/logo/instagram.png" type="image/png" />
    <title>Instagram - Signup</title>
    <!-- cdn bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- cdn toastr -->
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-3">

            </div>
            <div class="col-6">
            <form action="action.php" method="post">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Your name">
            </div>
            <div class="mb-3">
                <label class="form-label">Birthday</label>
                <input type="date" name="birthday" class="form-control" >
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select class="form-select" name="gender">
                    <option selected>Select one..</option>
                    <option value="L">Male</option>
                    <option value="P">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label  class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="mb-3">
                <label  class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="username">
            </div>
            <div class="mb-3">
                <label  class="form-label">Phone Number</label>
                <input type="number" name="phone" class="form-control" placeholder="08123456789">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="password">
            </div>
            <button type="submit" name="signup" value="signup" class="btn btn-primary">Create Account</button>
            </form>
            <p class="text-center">Have an account <a href="<?=$url_website?>auth/signin">signin</a></p>
            </div>
            <div class="col-3">

            </div>
        </div>
    </div>
    <?php
    
if(isset($_SESSION['notif'])){
    if($_SESSION['notif']['alert'] == 'error'){
    ?>
    <script type="text/javascript">toastr.error('<?=$_SESSION['notif']['msg']?>')</script>
    <?php
    } else {
    ?>
    <script type="text/javascript">toastr.success('<?=$_SESSION['notif']['msg']?>')</script>
    <?php    
    }
unset($_SESSION['notif']);
}
?>
</body>
</html>
