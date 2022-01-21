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
                <div id="postID(feed.data.id)"></div>
                <header > <img v-bind:src="'<?=$url_website?>assets/images/profile/' + feed.data.photoUser" height="40px" width="40px" class="rounded"> <a type="button" v-on:click="goToUser(feed.data.username)">{{ feed.data.username }}</a></header>
                <hr>
                <img v-bind:src="'<?=$url_website?>assets/images/feeds/' + feed.data.photo" class="card-img-top" height="400px">

                <a type="button" v-on:click="likePost(feed.data.id)" ><i class="fa fa-heart" style="color:#fc0505" v-if="feed.liked == 'ya'"></i> <i class="fa fa-heart-o" v-else></i></a> <i class="fa fa-comment-o"></i> <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                
                <p class="text-muted" v-if="feed.data.total_like == 0">Be the first to like this post</p>
                <p v-else>{{ feed.data.total_like }} Likes</p>
                <span>
                    <b type="button" v-on:click="goToUser(feed.data.username)">{{ feed.data.username }}</b> {{ feed.data.caption }}
                </span>
                <p type="button" class="text-muted" v-if="feed.data.total_comment > 0" v-on:click="viewComment(feed.data)">See {{ feed.data.total_comment }} comments</p>
                <p class="text-muted">1 Hour Ago</p>
                <form method="post" action="<?=$url_website?>api/action-comment.php">
                    <div class="input-group mb-3">
                        <input type="text" name="comment" class="form-control" placeholder="Comment Here" aria-describedby="button-addon2" required>
                        <input type="hidden" name="feedid" :value="feed.data.id">
                        <button class="btn btn-outline-secondary" type="submit">Send</button>
                    </div>
                </form>
                
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
                                                <b>{{ comment.username }}</b> {{ comment.comment }}<br>
                                                <p><a type="button" class="text-muted" style="font-size:10px;">Like</a> <a type="button" class="text-muted" style="font-size:10px;" >Delete</a></p>
                                            </span>
                                        </div>
                                        <hr>
                                        <br>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Tambahkan Komentar" aria-describedby="button-addon2">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Kirim</button>
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
    var commentUrl = '<?=$url_website?>api/action-comment.php';
    var commentDetail = '<?=$url_website?>api/comments.php';

    var app = new Vue({
        el: '#controller',
        data: {
            feeds: [],
            apiUrl,
            likeUrl,
            baseUrl,
            feed: {},
            halaman: 1,
            commentUrl,
            lastPage: 1,
            comments: [],
            commentDetail
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
                                this.feeds.push(response.data.results[0]);
                            } else {
                                return;
                            }
                            
                        });
                    }
                }
            },
            likePost(data){
                this.feed = data;
                const _this = this;
                axios.post(likeUrl, {q: data}).then(response => {
                    if(response.data == 1){
                        location.reload();
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
        },
    });

</script>