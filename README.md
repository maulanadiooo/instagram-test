# instagram-test

Ini hanya project test mengikut seleksi di PT Cipta Solusi Datarind

# Day 3 complete

Task (DONE)
- Post user tampil 10 di halaman utama (pada file api/posts.php) dan saat scrolling reload 10 lagi, ada di file index.php

- image sudah diresize ketika upload (proses upload ada di 'settings/action.php' mulai line 57)

- Delete post bisa, pergi ke halaman profile, klik foto yang ingin di hapus dan klik button trash dikanan bawah (proses delete ada di 'api/delete-posts.php)

Penilian Khusus (DONE)
- Bisa drag and Drop saat upload foto, upload otomatis redirect ke halaman dimana user saat upload (modal upload ada di file 'template/footer.php' )

# day 4 (DONE)

TASK(DONE)
- Fungsi comment dan like button telah berfungsi (fungsi ini ada pada file api/action-comments.php dan api/action-likes.php)

- Fungsi follow, unfollow dan follback sudah berfungsi (buka profile user untuk melakukan follow terhadap user tersebut, fungsi ini ada pada file api/action-follows.php) dan menghitung jumlah followers dan following

PENILIAN KHUSUS (DONE)

- Poster bisa edit comment (Done) -> yang bisa edit comment yang posting comment saja

- Poster bisa delete comment (Done) -> yang bisa delete comment yang posting comment/dan yang punya postingan

- Semua user bisa like dan unlike masing-masing post (DONE) fungsi ini ada pada file  api/action-likes.php -> harus follow yang punya post terlebih dahulu

- List 10 user yang belum di follow (Done) -> terdapat pada halaman awal disebelah kanan. Logika file ada pada folder api -> check-user-nofollow.php

- Follow random user (Done) -> dengan menekan icon + untuk follow suggest user

- Hanya bisa like dan comment post dari user yang difollow (done) fungsi ini ada pada file api/action-comments.php dan api/action-likes.php

- Unfollow user (DONE) fungsi ini ada pada file api/action-follows.php 

- (Bonus point) Like comment dari user lain (Done) -> hanya bisa like comment dari user yang telah di follow

# Day 5 (DONE)
======
Task (DONE)
- Control panel backend untuk edit delete user, post, dan comment -> access url 

untuk access menu admin:

localhost/admin/auth/signin

username: admin@admin.com

pass: 123456

Penilaian Khusus (DONE)
- Control panel diproteksi oleh username & password (hardcode dulu) (DONE)
- View dan delete post dari list (DONE) -> pada file admin/posts/index.php
- View dan delete comment dari list untuk masing-masing post (DONE) -> file ada di admin/posts/comment-detail.php -> diakses dengan cara klik 'all comment' pada masing-masing list posts pada url http://localhost/admin/posts/ 
- View dan delete user account dari list (DONE) -> ada pada file admin/users/index.php 
- (Bonus point) Make a dashboard showing post, comment statistic, popular user (DONE) -> chart bulanan total likes dan comments yang terjadi ada pada file admin/home.php
