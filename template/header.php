<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=$url_website?>assets/images/logo/instagram.png" type="image/png" />
    <title>Instagram</title>
    <!-- cdn bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="<?=$url_website?>assets/css/style.css" rel="stylesheet">
    

    <!-- cdn toastr -->
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <!-- cdn fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
</head>
<body>
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



<div class="container ">
    <div class="row">
        <div class="col-lg-2">

        </div>
        <div class="col-lg-8 mb-3">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?=$url_website?>">YOGRAM</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
                        </form>
                        <?php
                        if(isset($_SESSION['id'])){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$url_website?><?=$login['username']?>">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a type="button" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalUpload">Upload</a>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?=$url_website?>assets/images/profile/<?=$login['photo']?>" width="10px" height="10px">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="<?=$url_website?><?=$login['username']?>">Profile</a></li>
                            <li><a class="dropdown-item" href="<?=$url_website?>accounts/edit">Setting</a></li>
                            <li><a class="dropdown-item" href="<?=$url_website?>auth/signout">Logout</a></li>
                        </ul>
                        </li>
                        <?php
                        } else {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary btn-sm text-white" href="<?=$url_website?>auth/signin">Signin</a>
                        </li>
                        <li class="nav-item">
                            <a type="button" class="nav-link " href="<?=$url_website?>auth/signup">Signup</a>
                        </li>
                        <?php
                        }
                        ?>
                        
                    </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-lg-2">
            
        </div>
    </div>
    

</div>