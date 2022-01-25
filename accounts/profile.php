<?php

require '../lib/function.php';
if(isset($_SESSION['id'])){
    // req session jika terdeteksi session di browser
    require '../lib/session.php';
    require '../lib/is_login.php';
} else {
    // memberikan login id 0 jika di akses tanpa login
    $login['id'] = 0;
}

// check user from url request
$username = $db->real_escape_string(trim(htmlspecialchars($_GET['user'])));
$checkUser = mysqli_query($db, "SELECT * FROM users WHERE username = '$username' ");
$data_user = mysqli_fetch_assoc($checkUser);

// chek user posted
$checkFeed = mysqli_query($db, "SELECT * FROM feeds WHERE user_id = '".$data_user['id']."' ");
$totalFeed = mysqli_num_rows($checkFeed);

// check followers dan following
$checkFollowsbyUserId = mysqli_query($db, "SELECT * FROM follows WHERE user_id = '".$data_user['id']."'");
$checkFollowsbyUserFollow = mysqli_query($db, "SELECT * FROM follows WHERE user_follow = '".$data_user['id']."'");

if(mysqli_num_rows($checkFollowsbyUserId) > 0){

    $following = mysqli_query($db, "SELECT * FROM follows WHERE status IN (1,4) AND user_id = '".$data_user['id']."' ");
    
    $followers = mysqli_query($db, "SELECT * FROM follows WHERE user_id = '".$data_user['id']."' AND status IN (3,4)");
    
    
} else {

    $followers = false;
    $following = false;
}

if(mysqli_num_rows($checkFollowsbyUserFollow) > 0){

    $following1 = mysqli_query($db, "SELECT *  FROM follows WHERE status IN (3,4) AND user_follow = '".$data_user['id']."' ");
    
    $followers1 = mysqli_query($db, "SELECT * FROM follows WHERE user_follow = '".$data_user['id']."' AND status IN (1,4)");
    
    
} else {
    $followers1 = false;
    $following1 = false;
}
if($following && $following1){
    $totalFollowing = mysqli_num_rows($following) + mysqli_num_rows($following1);
} elseif($following){
    $totalFollowing = mysqli_num_rows($following);
} elseif($following1){
    $totalFollowing = mysqli_num_rows($following1);
}else {
    $totalFollowing = 0;
}
if($followers && $followers1){
    $totalFollowers = mysqli_num_rows($followers) + mysqli_num_rows($followers1);
} elseif($followers){
    $totalFollowers = mysqli_num_rows($followers);
} elseif($followers1){
    $totalFollowers = mysqli_num_rows($followers1);
} else {
    $totalFollowers = 0;
}



include_once '../template/header.php';
if(mysqli_num_rows($checkUser) == 0){
    // jika username terdaftar tidak ditemukan melalui URL
    echo "<center><b><h1>Sorry, This page is not available </h1></b> <br>
    <span class='text-muted'>Maybe the page is broken, go back to <a href='$url_website'>homepage</a></span></center>";
} else {
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-3">

        </div>
        <div class="col-lg-6">
            <div class="row" id="followId">
                <div class="col-lg-4">
                    <img src="<?=$url_website?>assets/images/profile/<?=$data_user['photo']?>" width="100px" height="100px">
                </div>
                <div class="col-lg-8">
                    <h5>
                    <?=$data_user['username']?>
                    <?php
                    if($login['id'] === $data_user['id']){
                    ?>
                        <a type="button" class="btn btn-secondary" href="<?=$url_website?>accounts/edit">Edit profile</a>
                    <?php
                    } else {
                        if($login['id'] !== 0){
                        // jika ada yang login, maka tampilkan button sesuai dengan status follow, unfollow atau follback
                        ?>
                        <a type="button" class="btn btn-primary btn-sm" v-on:click="follow(<?=$data_user['id']?>)">{{ statusFollow }}</a>
                        <?php
                        } else {
                        // jika tidak ada yang login maka tombol follow secara default dan mengarah ke halaman login
                        ?>
                            <a type="button" href="<?=$url_website?>auth/signin" class="btn btn-primary btn-sm">Follow</a>
                        <?php    
                        }
                    ?>

                        
                    <?php
                    }
                    ?>
                    
                    </h5> 
                    <p><b><?=$totalFeed?></b> Posts | <a type="button"><b><?=$totalFollowers?></b> Followers</a> | <a type="button"><b><?=$totalFollowing?></b> Following</a></p>
                    <p><?=$data_user['name']?></p>
                </div>
                <hr>
            </div>
            <div class="row" id="controller">
                <div class="col-4 mb-2"  v-for="feed in feeds" v-if="haveResultStatus" v-on:click="viewData(feed)">
                    <a type="button" ><img v-bind:src="'<?=$url_website?>assets/images/feeds/' + feed.photo" width="150px" height="150px"></a>
                </div>
                <div v-if="resultStatusNull">
                <h4 class="text-center text-muted" >This user don't have post yet</h4>
                </div>
                

                <!-- modal start -->
                <div class="modal fade" id="modalPost">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        
                                
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <img v-bind:src="'<?=$url_website?>assets/images/feeds/' + feed.photo" width="300px" height="300px">
                                            
                                        </div>
                                        <div class="col-lg-4">
                                            <b><p>{{ feed.username }} </p></b>
                                            
                                            
                                            <span>
                                                <b>{{ feed.username }}</b> {{ feed.caption }}
                                            </span>
                                            <p class="text-muted">1 jam yang lalu</p>
                                            <div class="scrollModal">
                                            <span v-for="comment in comments">
                                                <b>{{ comment.data.username }}</b> {{ comment.data.comment }}<br>
                                            <p>
                                                <!-- button like -->
                                                <a type="button" class="text-muted" style="font-size:10px;" v-on:click="likeComment(comment.data.id)" v-if="comment.commentLiked == 'ya'"><i class="fa fa-thumbs-up" aria-hidden="true" style="color:#fc0505"></i></a> 
                                                <a type="button" class="text-muted" style="font-size:10px;" v-on:click="likeComment(comment.data.id)" v-else><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a> 
                                                <!-- button delete -->
                                                <a type="button" class="text-muted" style="font-size:10px;" v-on:click="deleteComment(comment.data.id)" v-if="comment.data.user_id == <?=$login['id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                                                <a type="button" class="text-muted" style="font-size:10px;" v-on:click="deleteComment(comment.data.id)" v-else-if="comment.userFeedPoster == <?=$login['id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                <!-- edit button -->
                                                <a type="button" class="text-muted" style="font-size:10px;" v-on:click="showComment(comment.data.id)" v-if="comment.data.user_id == <?=$login['id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                <!-- modal edit -->
                                                <div class="modal fade" id="editComment">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="form-group">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control" :id="commentEditShow" :value="commentMessage" aria-describedby="button-addon2">
                                                                    <button class="btn btn-outline-secondary"  v-on:click="sendEditComment(idComment)">Send</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </p>

                                            
                                            </span>
                                            </div>
                                            <hr>
                                            <p>
                                                <a type="button" v-on:click="likePost(feed.id)" ><i class="fa fa-heart" style="color:#fc0505" v-if="liked == 'ya'"></i> <i class="fa fa-heart-o" v-else></i></a>
                                            </p>
                                            <br>
                                                <div class="input-group mb-3">
                                                <input type="text" class="form-control" :id="feed.id" placeholder="Comments" aria-describedby="button-addon2">
                                                <button class="btn btn-outline-secondary" type="button"  v-on:click="sendComment(feed.id)">Send</button>
                                                </div>
                                            <div v-if="feed.user_id == <?=$login['id']?>">
                                            <a type="button" class="btn btn-default bg-danger" v-on:click="deleteData(feed.id)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- end modal -->
            </div>
        </div>
        <div class="col-lg-3">
            
        </div>
    </div>
    
</div>

<?php

    include "../template/footer.php";
?>

<script type="text/javascript">
    var apiUrl = '<?=$url_website?>api/posts.php?q=<?=$data_user['id']?>';
    var deleteUrl = '<?=$url_website?>api/delete-posts.php';
    var actionPostUrl = '<?=$url_website?>api/action-posts.php';
    var commentDetail = '<?=$url_website?>api/comments.php';
    var likeCommentUrl = '<?=$url_website?>api/comment-like.php';
    var commentModalAction = '<?=$url_website?>api/action-comment-modal.php';
    var likeUrl = '<?=$url_website?>api/action-likes.php';

    var app = new Vue({
        el: '#controller',
        data: {
            feeds: [],
            apiUrl,
            deleteUrl,
            actionPostUrl,
            feed: {},
            likes: [],
            halaman: 1,
            haveResultStatus: false,
            resultStatusNull: true,
            deleteStatus: false,
            comments: [],
            commentDetail,
            likeCommentUrl,
            commentMessage: {},
            commentEditShow: {},
            idComment: {},
            commentModalAction,
            liked: 'no',
            likeUrl
        },
        mounted: function(){
            this.getNextFeeds();
        },
        beforeMount: function (){
            this.getInitialFeeds();
        },
        methods: {
            getInitialFeeds() {
                axios.get(apiUrl + `&page=` + this.halaman).then((response) => {
                    this.feeds = response.data.results;
                    if(response.data.lastPage > 0 ){
                        this.haveResultStatus = true;
                        this.resultStatusNull = false;
                    }
                });
            },
            getNextFeeds() {
                
                window.onscroll = () => {
                    let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
                    if (bottomOfWindow) {
                        this.halaman = this.halaman + 1;
                        axios.get(apiUrl + `&page=` + this.halaman).then(response => {
                            this.feeds.push(response.data.results[0]);
                        });
                    }
                }
            },
            viewData(data){
                this.feed = data;
                axios.post(commentDetail, {id: data.id}).then((response) => {
                    this.comments = response.data.results;
                    this.liked = response.data.likedBySession;
                });
                $('#modalPost').modal('show');
            },
            sendComment(data){
                var commentModal = $('#'+data).val();
                axios.post(commentModalAction, {id: data, comment: commentModal}).then((response) => {
                    if(response.data == true){
                        toastr.success('Comment posted');
                        this.commentModal = $('#'+data).val('');
                        $('#modalPost').modal('hide');
                    } else {
                        toastr.error(response.data);
                    }
                });
               
                
            },
            deleteData(id){
                this.deleteUrl = deleteUrl + `?q=` + id;
                if(confirm("Are you sure ? ")){
                    axios.get(this.deleteUrl).then(response =>{
                        if(response.data == 1){
                            location.reload();
                        } else {
                            toastr.error(response.data);
                        }
                        
                    });
                }
            },
            likeComment(data){
                axios.post(likeCommentUrl, {action: 'likeComment',q: data}).then(response => {
                    if(response.data == 'commentLiked'){
                        toastr.success('Comment Liked');
                        $('#modalPost').modal('hide');
                    } else if(response.data == 'commentUnliked'){
                        toastr.success('Comment Unliked');
                        $('#modalPost').modal('hide');
                    }else {
                        toastr.error(response.data);
                    }
                    
                });
               
                
            },
            deleteComment(data){
                axios.post(likeCommentUrl, {action:'deleteComment' ,q: data}).then(response => {
                    if(response.data = 1){
                        toastr.success('Comment Deleted');
                        $('#modalPost').modal('hide');
                    } else {
                        toastr.error(response.data);
                    }
                    
                });
            }, 
            showComment(data){
                axios.post(likeCommentUrl, {action:'editComment' ,q: data}).then(response => {
                   this.commentMessage = response.data;
                   this.commentEditShow = 'edit'+data;
                   this.idComment = data;
                    
                });
                $('#editComment').modal('show');
            },
            sendEditComment(data){
                var idCommentForEdit = $('#edit'+data).val();
                axios.post(likeCommentUrl, {action:'updateComment' ,q: data, commentUpdate: idCommentForEdit}).then(response => {
                   if(response.data == 1){
                        toastr.success('Comment edited');
                        $('#editComment').modal('hide');
                        $('#modalPost').modal('hide');
                   } else {
                       toastr.error(response.data);
                   }
                    
                });
                
            },
            likePost(data){
                axios.post(likeUrl, {q: data}).then(response => {
                    if(response.data == 1){
                        toastr.success('Success');
                        $('#modalPost').modal('hide');
                    } else {
                        toastr.error(response.data);
                    }
                    
                });
            },
        },
    });

</script>

<script type="text/javascript">
    var actionFollowUrl = '<?=$url_website?>api/action-follow.php';
    var followStatus = '<?=$url_website?>api/follows.php';

    var apps = new Vue({
        el: '#followId',
        data: {
            actionFollowUrl,
            followStatus,
            statusFollow: [],
        },
        mounted: function(){
            this.getFollow();
        },
        methods: {
            getFollow(){
                axios.get(followStatus + '?user=<?=$data_user['id']?>' ).then((response) => {
                    this.statusFollow = response.data.results;
                });
            },
            follow(data){
                axios.post(actionFollowUrl, {q: data}).then(response => {
                    if(response.data == 1){
                        location.reload();
                    } else {
                        toastr.error(response.data);
                    }
                    
                });
            },
        },
    });

</script>

<?php
}
?>