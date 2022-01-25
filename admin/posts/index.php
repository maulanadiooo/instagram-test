<?php
require '../../lib/function.php';
require '../../lib/admin-session.php';
include '../template/header.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div id="controller">
                <div class="row">
                    <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">Posts Feed</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Photo</th>
                                    <th>Caption</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>

                <!-- modal start -->
                <div class="modal fade" id="postModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                                
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <center><img v-bind:src="'<?=$url_website?>assets/images/feeds/' + feed.photo" width="300px" height="300px"></center>
                                        </div>
                                        
                                        
                                        <span>
                                            <b>Full Caption: </b><br> 
                                            {{ feed.caption }}
                                        </span>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- end modal -->

            </div>
        </div> <!-- Container Fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php
include '../template/footer.php';

?>

<script>
   $(function(){
 
    $('.table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                "url": "<?=$url_website?>admin/posts/ajax.php?action=table_data",
                "dataType": "json",
                "type": "POST"
            },
        "columns": [
            { "data": "id", orderable: true, width:'30px', class:'text-center' },
            { "data": "username", orderable: true, width:'100px', class:'text-center' },
            {render: function(index, row, data, meta){
            return `
                    <img src="<?=$url_website?>assets/images/feeds/${data.photo}" width="100px" height="100px">`;
            }, orderable: false, width:'100px', class:'text-center'},
            { "data": "caption", orderable: true, width:'300px', class:'text-left' },
            {render: function(index, row, data, meta){
            return `
                    
                    <button class="btn btn-info btn-sm" onclick="app.viewPost(event, ${data.id})">View</button>
                    <a type="button" href="<?=$url_website?>admin/posts/comment-detail.php?q=${data.id}" class="btn btn-warning btn-sm" >All Comment</a>
                    <button class="btn btn-danger btn-sm" onclick="app.deletePost(event, ${data.id})">Delete</button>`;
            }, orderable: false, width:'200px', class:'text-center'},
        ]  

    });
    });
    var postDetail = '<?=$url_website?>api/feeds-admin.php';
    var deleteUrl = '<?=$url_website?>api/delete-posts.php';

    var app = new Vue({
        el: '#controller',
        data: {
            feed: {},
            postDetail,
            deleteUrl
        },
        methods:{
            viewPost(event, row){
                axios.get(postDetail + '?q=' + row).then((response) => {
                    this.feed = response.data.results[0];
                });
                $('#postModal').modal('show');
            },
            deletePost(event, row){
                if(confirm("Are you sure ? ")){
                    axios.post(deleteUrl, {q: row}).then(response =>{
                        if(response.data == 1){
                            location.reload();
                        } else {
                            toastr.error(response.data);
                        }
                        
                    });
                }
            },
        }
    });
    
</script>
