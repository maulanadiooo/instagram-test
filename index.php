<?php

require 'lib/function.php';
require 'lib/session.php';
require 'lib/is_login.php';
include 'template/header.php';
?>



<div class="container">
    <div class="row">
        <div class="col-lg-8 mb-3" id="controller">
            <div v-for="feed in feeds">
                
                <header > <img v-bind:src="'<?=$url_website?>assets/images/profile/' + feed.data.photoUser" height="40px" width="40px" class="rounded"> <a type="button" v-on:click="goToUser(feed.data.username)">{{ feed.data.username }}</a></header>
                <hr>
                <img v-bind:src="'<?=$url_website?>assets/images/feeds/' + feed.data.photo" class="card-img-top" height="400px">

                <a type="button" v-on:click="likePost(feed.data.id)" ><i class="fa fa-heart" style="color:#fc0505" v-if="feed.liked == 'ya'"></i> <i class="fa fa-heart-o" v-else></i></a> <a type="button"><i class="fa fa-comment-o" v-on:click="viewComment(feed.data)"></i></a> <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                
                <p class="text-muted" v-if="feed.totalLikes == 0">Be the first to like this post</p>
                <p v-else>{{ feed.totalLikes }} Likes</p>
                <span>
                    <b type="button" v-on:click="goToUser(feed.data.username)">{{ feed.data.username }}</b> {{ feed.data.caption }}
                </span>
                <hr>
                <span v-if="feed.lastComment != null">
                    <b>{{ feed.lastComment.username }}</b> {{ feed.lastComment.comment }}
                </span>
                <p type="button" class="text-muted" v-if="feed.totalComments > 0" v-on:click="viewComment(feed.data)">See {{ feed.totalComments }} comments</p>
                <p class="text-muted">1 Hour Ago</p>
                
                
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
                                    <div class="col-lg-4" >
                                        <b><p>{{ feed.username }} </p></b> <hr>
                                        
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
                                        <br>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" :id="feed.id" placeholder="Comments" aria-describedby="button-addon2">
                                                <button class="btn btn-outline-secondary" type="button"  v-on:click="sendComment(feed.id)">Send</button>
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- end modal -->

            
        </div> 
            
        <div class="col-lg-4 mb-3">
            <header> <a href='<?=$url_website?><?=$login['username']?>' type="button"><img src="<?=$url_website?>assets/images/profile/<?=$login['photo']?>" height="40px" width="40px"></a> <?=$login['username']?></header>
            <span class="text-muted"><?=$login['name']?></span>
            <hr>
            <div class="row">
                
                <div class="col-10" id="userToFollow">
                    <p class="text-muted">User you might want to follow</p>
                    <div v-for="user in users">
                        <header> <a :href='user.urlProfile' type="button"><img :src="user.urlPhoto" height="20px" width="20px"></a> {{user.data.username}} | <a type="button"><i class="fa fa-plus" aria-hidden="true" style="color:#05d3fc" v-on:click="followSuggestUser(user.data.id)"></i></a></header> 
                        <span class="text-muted">{{user.data.name}}</span>
                    </div>
                   
                </div>
            </div>
            
        </div>
    </div>
    
</div> 
<!-- get data feeds -->

<?php

    include "template/footer.php";
?>
<script type="text/javascript">
    var apiUrl = '<?=$url_website?>api/feeds.php';
    var likeUrl = '<?=$url_website?>api/action-likes.php';
    var baseUrl = '<?=$url_website?>';
    var commentDetail = '<?=$url_website?>api/comments.php';
    var commentModalAction = '<?=$url_website?>api/action-comment-modal.php';
    var likeCommentUrl = '<?=$url_website?>api/comment-like.php';
    var urlCheckNotFollow = '<?=$url_website?>api/check-user-nofollow.php';
    var actionFollowUrl = '<?=$url_website?>api/action-follow.php';
    

    var app = new Vue({
        el: '#controller',
        data: {
            feeds: [],
            apiUrl,
            likeUrl,
            baseUrl,
            feed: {},
            halaman: 1,
            lastPage: 1,
            comments: [],
            commentDetail,
            commentModalAction,
            likeCommentUrl,
            commentMessage: {},
            commentEditShow: {},
            idComment: {}
        },
        mounted: function(){
            this.getNextFeeds();
        },
        beforeMount: function (){
            this.getInitialFeeds();
        },
        methods: {
            getInitialFeeds() {
                axios.get(apiUrl + `?page=` + this.halaman).then((response) => {
                    this.feeds = response.data.results;
                });
            },
            getNextFeeds() {
                
                window.onscroll = () => {
                    let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
                    if (bottomOfWindow) {
                        this.halaman = this.halaman + 1;
                        axios.get(apiUrl + `?page=` + this.halaman).then(response => {
                            this.lastPage = response.data.lastPage;
                            if(this.halaman <= this.lastPage){
                                for(const i in response.data.results){
                                    this.feeds.push(response.data.results[i]);
                                }
                                
                            } else {
                                return;
                            }
                            
                        });
                    }
                }
            },
            likePost(data){
                axios.post(likeUrl, {q: data}).then(response => {
                    if(response.data == 1){
                        toastr.success('Success');
                        window.setTimeout(function(){
                            location.reload();
                            }, 1000);
                    } else {
                        toastr.error(response.data);
                    }
                    
                });
            },
            goToUser(data){
                window.location.href = baseUrl + data;
            },
            viewComment(data){
                this.feed = data;
                axios.post(commentDetail, {id: data.id}).then((response) => {
                    this.comments = response.data.results;
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
                
            }
        },
    });

    // untuk follow user yang belum di follow
    
    var app = new Vue({
        el: '#userToFollow',
        data: {
            urlCheckNotFollow,
            users:[],
            actionFollowUrl,
            alert: 0
        },
        mounted: function(){
            this.geUserNotFollowed();
        },
        methods:{
            geUserNotFollowed(){
                axios.post(urlCheckNotFollow).then(response => {
                   this.users = response.data.results;
                    
                });
            },
            followSuggestUser(data){
                axios.post(actionFollowUrl, {q: data}).then(response => {
                    if(response.data == 1){
                        toastr.success('Success follow user');
                        window.setTimeout(function(){
                            location.reload();
                            }, 1000);
                    } else {
                        toastr.error(response.data);
                    }
                    
                });
            }
        }
    });
</script>
