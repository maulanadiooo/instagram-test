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
            { "data": "id" },
            { "data": "username" },
            { "data": "photo" },
            { "data": "caption" },
            { "data": "action" },
        ]  

    });
    });

    
</script>
