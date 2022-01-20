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
    <title>Instagram - Signin</title>
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
            <form action="action.php" method="post">
            <div class="mb-3">
                <label  class="form-label">Email</label>
                <input type="email" name="email" class="form-control" >
            </div>
            <button type="submit" name="forgot" value="forgot" class="btn btn-primary">Signin</button>
            </form>
            <p class="text-center">Remember your password ? <a href="<?=$url_website?>auth/signin">signin</a></p>
            </div>
            <div class="col-3">

            </div>
        </div>
    </div>
<!-- // alert notifikasi     -->
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
