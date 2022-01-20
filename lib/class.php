<?php

class Auth {
    
    public function signin($username, $password){
        global $db;
        // check email
        $checkmail = mysqli_query($db, "SELECT * FROM users WHERE username = '$username' ");
        $data_user = mysqli_fetch_assoc($checkmail);
        if(!empty($username) && !empty($password)){
            if(mysqli_num_rows($checkmail) == 1){ //checking email
                if(password_verify($password, $data_user['password'])){ // verify password
                    if($data_user['verified'] == 0){
                        $result = 'Verif your email first';
                    } else {
                        $_SESSION["loggedin"] = true;
                        $_SESSION['id'] = $data_user['id'];
                        $result = true;
                    }
                } else {
                    $result = 'Wrong Username Or Password';
                }
            } else {
                $result = 'Wrong Username Or Password';
            }
        } else {
            $result = 'Input Empty';
        }
        return $result;
    }

    public function signup($email, $password, $phone, $username, $dob, $name, $gender){
        global $db;
        global $url_website;
        // check email
        $checkmail = mysqli_query($db, "SELECT * FROM users WHERE email = '$email' ");
        // check username
        $checkusername = mysqli_query($db, "SELECT * FROM users WHERE username = '$username' ");
        // check phone
        $checkuphone = mysqli_query($db, "SELECT * FROM users WHERE phone = '$phone' ");

        $token = bin2hex(random_bytes(50));
        if(!empty($name) && !empty($username) && !empty($dob) && !empty($password) && !empty($gender) && !empty($phone) ){
            if(strlen($name) > 50 ){ //max name 50 character
                $result = 'Max 50 Characters Name';
            }
            elseif(strlen($username) > 15 ){ //max username 15 character
                $result = 'Max 15 Characters username';
            }
            elseif(strlen($phone) > 15 ){ //max phone 15 character
                $result = 'Max 15 Character Phone';
            } 
            elseif(mysqli_num_rows($checkmail) == 1){ //checking email, already regis or not
                $result = 'Email already exist, please use login form';
            } 
            elseif(mysqli_num_rows($checkusername) == 1){ //checking username, already regis or not
                $result = 'username already exist';
            } 
            elseif(mysqli_num_rows($checkuphone) == 1){ //checking phone, already regis or not
                $result = 'Phone number already exist';
            }
            else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $insert = mysqli_query ($db, "INSERT INTO users (name, username, password, gender, phone, email, birthday, photo, user_token, verified) VALUES ('$name', '$username', '$password_hash', '$gender', '$phone', '$email', '$dob', 'instagram.png', '$token', '0')");
                if($insert == true){
                    // send mail confirmation
                    $message = 'Hallo '.$name.' <br>
    Click this link to active your account : '.$url_website.'confirm/'.$token;
                    $send_email = send_email($email, 'Your Account Confirmation', $message);
                    if($send_email == true){ // if mail sent, go to login page
                        $result = true;
                    } else {
                        $result = 'Error Send Email';
                    }
                } else {
                    $result = 'Error SQL';
                }
            }
        } else {
            $result = 'Input Empty';
        }
        return $result;
    }

    public function forgot($email){
        global $db;
        global $url_website;

        // check email
        $checkmail = mysqli_query($db, "SELECT * FROM users WHERE email = '$email' AND verified = 1");
        $data_user = mysqli_fetch_assoc($checkmail);
        if(mysqli_num_rows($checkmail) == 0){ //checking email, already regis or not
            $result = 'This email not in our database or not verified yet';
        } else {
            // send mail
            $token = bin2hex(random_bytes(50));
            $update_user = mysqli_query($db, "UPDATE users SET user_token = '$token' WHERE id = '".$data_user['id']."' ");
            if($update_user){
                $message = 'Hallo '.$data_user['name'].' <br>
Click this link to reset your password : '.$url_website.'reset-password/'.$token;
                $send_email = send_email($email, 'Reset Password', $message);
                if($send_email){
                    $result = true;
                } else {
                    $result = 'Error Send Email';
                }
            } else {
                $result = 'SQL Error';
            }
            
        }
        return $result;
    }

    public function reset($password, $cpassword, $token){
        global $db;
        $sql = mysqli_query($db, "SELECT * FROM users WHERE user_token = '$token' AND verified = 1 ");
        $data_user = mysqli_fetch_assoc($sql);
        if(mysqli_num_rows($sql) == 0){
            $result = 'Your access not allowed!';
        } elseif($password !== $cpassword){
            $result = 'Confirmation password is not same!';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $update = mysqli_query($db, "UPDATE users SET password = '$password_hash', user_token = null WHERE id = '".$data_user['id']."' ");
            if($update){
                $result = true;
            } else {
                $result = 'SQL Error';
            }
        }
        return $result;

    }
}

class Profile {

    public function cpassword($password, $npassword, $cnpassword){
        global $db;
        // check password
        $checkUser = mysqli_query($db, "SELECT * FROM users WHERE id = '".$_SESSION['id']."' ");
        $dataUser = mysqli_fetch_assoc($checkUser);
        if(password_verify($password, $dataUser['password'])){
            if($npassword !== $cnpassword){
                $result = 'Confirmation password not match';
            } else {
                $password_hash = password_hash($npassword, PASSWORD_DEFAULT);
                $update = mysqli_query($db, "UPDATE users SET password = '$password_hash' WHERE id = '".$_SESSION['id']."' ");
                if($update){
                    $result = true;
                } else {
                    $result = "SQL Error";
                }
            }
        } else {
            $result = 'Your current password is wrong';
        }
        return $result;
    }

    public function cphoto($photo){
        
        
        global $db;
        $file_name = strtr( $photo['name'], " ", "-" );
        $x = explode('.', $file_name);
        $ekstensiFile = strtolower(end($x));
        $sizeFile	= $photo['size'];
        $tmpFile = $photo['tmp_name'];
        if($photo['name'] == ''){
            $result = 'Choose your photo first';
        }elseif($ekstensiFile !== 'png' && $ekstensiFile !== 'jpg' && $ekstensiFile !== 'jpeg'){
            $result = 'File type '.$ekstensiFile.' not allowed to upload';
        } elseif($sizeFile > 524288 ){
            $result = 'Max file size 512Kb';
        } else {
            // menentukan folder photo
            $tempdir = "../assets/images/profile/"; 
            // target path photo setelah upload dann mengubah nama foto
            $fileEditName = bin2hex(random_bytes(25)).$_SESSION['id'];
            $nameWithEkstensi = $fileEditName.".".$ekstensiFile;
            $tragetPath = $tempdir.$nameWithEkstensi;
            // proses upload
            $upload = move_uploaded_file($tmpFile, $tragetPath);
            if($upload){
                // resize
                $PhotoUpload = $tragetPath;
                $nameWithEkstensi = $nameWithEkstensi;
                if($ekstensiFile == 'png'){
                    $oriPhoto    = imagecreatefrompng ($PhotoUpload);
                } else{
                    $oriPhoto    = imagecreatefromjpeg ($PhotoUpload);
                }
                
                $widthOri     = imageSX($oriPhoto);
                $heightOri     = imageSY($oriPhoto);
                $widthNew     = 100;
                $heightNew     = 100;

                $img = imagecreatetruecolor($widthNew, $heightNew);
                imagecopyresampled($img, $oriPhoto, 0, 0, 0, 0, $widthNew, $heightNew, $widthOri, $heightOri);
                if($ekstensiFile == 'png'){
                    imagepng($img, $PhotoUpload);
                } else {
                    imagejpeg($img, $PhotoUpload);
                }
                
                imagedestroy($oriPhoto);
                imagedestroy($img);
    
    

                // check photo profile saat ini
                $checkCurrentPhoto = mysqli_query($db, "SELECT photo FROM users WHERE id = '".$_SESSION['id']."' ");
                $photoUser = mysqli_fetch_assoc($checkCurrentPhoto);
                // remove current photo
                if($photoUser['photo'] !== 'instagram.png'){
                    unlink($tempdir.$photoUser['photo']);
                }
                
                
                // update database user photo
                $update = mysqli_query($db, "UPDATE users SET photo = '$nameWithEkstensi' WHERE id = '".$_SESSION['id']."' ");
                if($update){
                    $result = true;
                } else {
                    $result = "SQL Error";
                }

            } else {
                $result = 'Upload Error';
            }
        }
        return $result;
    }

    public function cdetail($name, $birthday, $gender, $phone){
        global $db;
        if(!empty($name) && !empty($birthday) && !empty($gender) && !empty($phone) ){
            $checkPhone = mysqli_query($db, "SELECT phone FROM users WHERE phone = '$phone' AND id != '".$_SESSION['id']."' ");
            if(mysqli_num_rows($checkPhone) == 1){
                $result = 'This phone number already exist';
            } else {
                $update = mysqli_query($db, "UPDATE users SET name = '$name', birthday = '$birthday', gender = '$gender', phone ='$phone' WHERE id = '".$_SESSION['id']."' ");
                if($update){
                    $result = true;
                } else {
                    $result = 'SQL Error';
                }
            }
        } else {
            $result = 'Dont leave the input empty';
        }
        return $result;
    }

}