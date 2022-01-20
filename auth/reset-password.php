<?php
require '../lib/function.php';
require '../lib/auth_session.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(!$_GET['token']){
        header("location: ".$url_website."auth/signin");
    } else {
        $token = $db->real_escape_string(trim(htmlspecialchars($_GET["token"])));
        $sql = mysqli_query($db, "SELECT * FROM users WHERE user_token = '$token' AND verified = 1 ");
        if(mysqli_num_rows($sql) == 1){
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=$url_website?>assets/images/logo/instagram.png" type="image/png" />
    <title>Instagram - Reset Password</title>
    <!-- cdn bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- cdn toastr -->
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <!-- cdn fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-3">

            </div>
            <div class="col-6">
            <form action="<?=$url_website?>auth/action.php" method="post">
            <div class="mb-3">
                <label  class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" >
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Confirm New Password</label>
                <input type="password" name="cpassword" class="form-control">
            </div>
            <input type="hidden" name="token" value="<?=$token?>">
            <button type="submit" name="reset" value="reset" class="btn btn-primary">Reset Password</button>
            </form>
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

<?php
        } else {
            die('you going to the wrong address');
        }
        
    }
}
?>