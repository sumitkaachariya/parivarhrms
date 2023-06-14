  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Village</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Village</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        

      <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6"><h5><b>Name</b></h5></div>
                        <div class="col-lg-6"><h5><b>Count</b></h5></div>
                    </div>
                    <hr>
                    <?php if(isset($villages)){
                        foreach ($villages as $key => $village) {
                       
                    ?>
                        <div class="row">
                            <div class="col-lg-6"><b><?php echo $village->name;?></b></div>
                            <div class="col-lg-6"><b style="color:#ED2C23;">(<?php echo $village->counting;?>)</b></div>
                        </div>
                    <?php }}else{ echo 'Not Found'; }?>
                </div>
            </div>
        </div>
      </div>
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->