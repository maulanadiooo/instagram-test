<?php
require '../../lib/function.php';
require '../../lib/admin-session.php';


if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $idPost = $db->real_escape_string(trim(htmlspecialchars($_GET['q'])));
    $checkIdPost = mysqli_query($db, "SELECT * FROM feeds WHERE id = '$idPost' ");
    if(mysqli_num_rows($checkIdPost) == 0){
        exit(header("Location: ".$url_website."admin/posts/"));
    }
include '../template/header.php';
?>
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
                        <h3 class="card-title">All comment for spesific post</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Comment</th>
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
                "url": "<?=$url_website?>admin/posts/ajax.php?action=commentData&q=<?=$idPost?>",
                "dataType": "json",
                "type": "POST"
            },
        "columns": [
            { "data": "id" },
            { "data": "username" },
            { "data": "comment" },
            {render: function(index, row, data, meta){
            return `
                    <button class="btn btn-danger btn-sm" onclick="app.deleteComment(event, ${data.id})">Delete</button>`;
            }, orderable: false, width:'200px', class:'text-center'},
        ]  

    });
    });
    
    var likeCommentUrl = '<?=$url_website?>api/comment-like.php';
    var app = new Vue({
        el: '#controller',
        data: {
            feed: {},
            likeCommentUrl
        },
        methods:{
            deleteComment(event, row){
                if(confirm("Are you sure ? ")){
                    axios.post(likeCommentUrl, {action: 'adminDeleteComment', q: row}).then(response =>{
                        if(response.data == 1){
                            location.reload();
                        } else {
                            console.log(response);
                        }
                        
                    });
                }
            },
        }
    });
</script>

<?php
} else {
    exit;
}

?>