<?php

require 'lib/function.php';



echo 
"Hello World <br>
Today : ".
format_date(date("Y-m-d")).", ".date("H:i:s"). " WIB";

include 'template/header.php'
?>



<div class="container">
    <div class="row">
        <div class="col-lg-8 mb-3">
            <div>
                <header> <img src="assets/images/feed/instagram.png" height="10px" width="10px"> maulanadioo</header>
                <hr>
                <img src="assets/images/feed/instagram.png" class="card-img-top" width="80%" height="400px">
                <i class="fa fa-heart" style="color:#fc0505"></i> <i class="fa fa-comment-o"></i> <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                <p>1 Suka</p>
                <span>
                    <b>maulanadioo</b> ini postingan kedua saya
                </span>
                <p class="text-muted">Lihat 1 komentar</p>
                    <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Tambahkan Komentar" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Kirim</button>
                </div>
            </div>
            <div>
            <hr>
                <header> <img src="assets/images/feed/instagram.png" height="10px" width="10px"> maulanadioo</header>
                <hr>
                <img src="assets/images/feed/instagram.png" class="card-img-top" width="80%" height="400px">
                <i class="fa fa-heart-o" ></i> <i class="fa fa-comment-o"></i> <i class="fa fa-paper-plane-o" aria-hidden="true"></i>

                <p>Jadilah yang pertama menyukai ini</p>
                <span>
                    <b>maulanadioo</b> ini postingan pertama saya
                </span>
                <p class="text-muted">Lihat semua komentar</p>
                <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Tambahkan Komentar" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Kirim</button>
                </div>
            </div>
        </div> 
            
        <div class="col-lg-4 mb-3">
            <header> <img src="assets/images/feed/instagram.png" height="10px" width="10px"> maulanadioo</header>
            <span class="text-muted">Dio Maulana</span>
            <hr>
            
        </div>
    </div>
    
</div> 

</body>
</html>