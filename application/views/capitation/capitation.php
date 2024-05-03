  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Capitation</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Capitation</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-12">
                    <div class="info-box">
                        <div class="info-box-content">
                                <h3 class="text-center"><span class="info-box-text">Total Capitation</span></h3>
                                <span class="info-box-number text-center"><?php echo @$total_capitation;?></span>
                        </div>
                    <!-- /.info-box-content -->
                    </div>
            </div>

            <div class="col-lg-12 col-12 mt-8">
                <div class="row">
                    <?php foreach($group_by_capitation as $capitation){?>
                        <div class="col-lg-3 col-12">
                            <div class="info-box shadow">
                                <span class="info-box-icon bg-warning color-red"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $capitation->name;;?></span>
                                    <span class="info-box-number"><?php echo $capitation->total_person_count;?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>   
      </div><!-- /.container-fluid -->
    </section>

  </div>
  <style>
    .info-box .color-red{background-color:#ED2C23 !important;}
    .info-box .color-red i{color:#fff;}
  </style>
  <!-- /.content-wrapper -->