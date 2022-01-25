<?php
require '../lib/function.php';
require '../lib/admin-session.php';
require 'template/header.php';
require 'lib/popular.php';


// processing chart

$label_line = ['Likes', 'Comments'];
$dataLine = [];

foreach($label_line as $key => $value){
        $dataLine[$key]['label'] = $label_line[$key];
        $dataLine[$key]['backgroundColor'] = $key == 0 ? 'rgba(60,141,188,0.9)' : 'rgba(210, 214, 222, 1) ';
        $dataLine[$key]['borderColor'] = $key == 0 ? 'rgba(60,141,188,0.9)' : 'rgba(210, 214, 222, 1) ';
        $data_month = [];

        foreach(range(1,12) as $month) {
                if($key == 0 ){
                  $dataMonth = mysqli_query($db, "SELECT count(*) as total FROM likes WHERE month(created_at) = '$month' ");
                  $data = mysqli_fetch_assoc($dataMonth);
                  $data_month[] = $data['total'];
                } else {
                  $dataMonth = mysqli_query($db, "SELECT count(*) as total FROM comments WHERE month(created_at) = '$month' ");
                  $data = mysqli_fetch_assoc($dataMonth);
                  $data_month[] = $data['total']; 
                }
                
        }
        $dataLine[$key]['data'] = $data_month;
}


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
          <!-- Info boxes -->
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total Post</span>
                  <span class="info-box-number"><?=$totalPost?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-comments"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total Comment</span>
                  <span class="info-box-number">
                  <?=$totalComments?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total Likes</span>
                  <span class="info-box-number"><?=$totalLikes?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total User</span>
                  <span class="info-box-number"><?=$totalUsers?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- popular user -->
          <div class="row">
            <!-- user yang paling banyak follwoers -->
            <div class="col-6">
              <div class="card " > 
                <div class="card-header">
                  <h3 class="card-title">User with most followers</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <ul class="users-list clearfix">
                    <div class="row p-5" >
                    
                      <div class="col-lg-3 col-sm-6">
                        <img src="<?=$url_website?>assets/images/profile/<?=$getuserInfo['photo']?>" width="128px" height="128px">
                          <a class="users-list-name" href="<?=$url_website.$getuserInfo['username']?>"><?=$getuserInfo['username']?></a>
                          <p>Total Followers: <?=$followersTotal?></p>
                      </div>
                    </div>
                    
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <!-- post yang paling banyak like -->
            <div class="col-6">
              <div class="card " > 
                <div class="card-header">
                  <h3 class="card-title">Post with most likes</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <ul class="users-list clearfix">
                    <div class="row p-5" >
                    
                      <div class="col-lg-3 col-sm-6">
                        <img src="<?=$url_website?>assets/images/feeds/<?=$dataMostLike['photo']?>" width="128px" height="128px">
                          <a class="users-list-name" href="<?=$url_website.$dataMostLike['username']?>"><?=$dataMostLike['username']?></a>
                          <p>Total Likes: <?=$dataMostLike['total']?></p>
                      </div>
                    </div>
                    
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
              </div>
            </div>

            <!--/.card -->
          </div>
          <!-- popular user -->
          
          <!-- chart -->
          <div class="row">
            <div class="col-md-12">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Total Commments and Likes Chart Each Month</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
           <!-- chart -->

          <!-- 10 new post -->
          <div class="row">
            <div class="col-12">
              <div class="card " > 
                <div class="card-header">
                  <h3 class="card-title">10 New Posts</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <ul class="users-list clearfix">
                    <div class="row p-5" >
                      <?php
                        while($dataFeed = mysqli_fetch_assoc($feeds)){
                      ?>
                      <div class="col-lg-3 col-sm-6">
                        <img src="<?=$url_website?>assets/images/feeds/<?=$dataFeed['photo']?>" width="128px" height="128px">
                          <a class="users-list-name" href="<?=$url_website.$dataFeed['username']?>"><?=$dataFeed['username']?></a>
                      </div>
                        
                      <?php
                      }
                      ?>
                    </div>
                    
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                  <a href="<?=$url_website?>admin/posts/">View All Posts</a>
                </div>
                <!-- /.card-footer -->
              </div>
            </div>
            
            <!--/.card -->
          </div>
        </div> <!-- Container Fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php

include 'template/footer.php';

?>
<script>
  
  
  $(function () {
    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: <?=json_encode($dataLine)?>
    }
    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }
  //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })
  });
  
</script>
