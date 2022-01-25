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
                        <h3 class="card-title">User</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Brithday</th>
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
                "url": "<?=$url_website?>admin/users/ajax.php?action=table_data",
                "dataType": "json",
                "type": "POST"
            },
        "columns": [
            { "data": "id", orderable: true, width:'30px', class:'text-center'},
            {render: function(index, row, data, meta){
            return `
                    <img src="<?=$url_website?>assets/images/profile/${data.photo}" width="50px" height="50px">`;
            }, orderable: false, width:'50px', class:'text-center'},
            { "data": "name", orderable: true, width:'100px', class:'text-center'},
            { "data": "username", orderable: true, width:'100px', class:'text-center' },
            { "data": "email", orderable: true, width:'100px', class:'text-center' },
            { "data": "phone", orderable: true, width:'100px', class:'text-center' },
            { "data": "gender", orderable: true, width:'100px', class:'text-center' },
            { "data": "birthday", orderable: true, width:'100px', class:'text-center' },
            {render: function(index, row, data, meta){
            return `
                    <button class="btn btn-danger btn-sm" onclick="user.deleteUser(event, ${data.id})">Delete</button>`;
            }, orderable: false, width:'100px', class:'text-center'},
        ]  

    });
    });
    var deleteUserUrl = '<?=$url_website?>api/delete-user.php';

    var user = new Vue({
        el: '#controller',
        data: {
            feed: {},
            deleteUserUrl
        },
        methods:{
            deleteUser(event, row){
                if(confirm("Are you sure ? ")){
                    axios.post(deleteUserUrl, {q: row}).then(response =>{
                        if(response.data == 1){
                            location.reload();
                        } else {
                            console.log(response.data);
                        }
                        
                    });
                }
            },
        }
    });
    
</script>
