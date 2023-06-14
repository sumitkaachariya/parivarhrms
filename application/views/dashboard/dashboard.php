  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
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
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    Information about Collect Amount
                  </h3>
                </div>
                <div class="card-body">
                    
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">
                        Total Amount
                      </h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                          <?php if(isset($total_assume) && !empty($total_assume)){ 
                            foreach($total_assume as $assume){
                          ?>
                            <div class="col-md-3 col-sm-6 col-12">
                              <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fa fa-fw fa-money" >₹</i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text"><?php echo get_field('hrms_type_pay_list',array('id' =>$assume->id),'name')->name?></span>
                                  <span class="info-box-number">₹ <?php echo $assume->amount;?></span>
                                </div>
                              </div>
                            </div>
                          <?php }}else{
                            echo '<span style="text-align:center;display: block;width: 100%;">Data Not Found</span>';
                          } ?>
                    </div>    
                    </div>
                  </div>
                  <!--  -->
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">
                        Today Total Amount
                      </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                          <?php if(isset($todayResult) && !empty($todayResult)){ 
                            foreach($todayResult as $assume){
                          ?>
                            <div class="col-md-3 col-sm-6 col-12">
                              <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fa fa-fw fa-money" >₹</i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text"><?php echo get_field('hrms_type_pay_list',array('id' =>$assume->id),'name')->name?></span>
                                  <span class="info-box-number">₹ <?php echo $assume->amount;?></span>
                                </div>
                              </div>
                            </div>
                          <?php }}else{
                            echo '<span style="text-align:center;display: block;width: 100%;">Data Not Found</span>';
                          } ?>
                          </div>  
                    </div>
                  </div>

                
                </div>
                <!-- /.card -->
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    Information about Total count of types
                  </h3>
                </div>
                <div class="card-body">
                  
                <div class="">
                    <div class="card-header">
                      <h3 class="card-title">
                        Total All Count
                      </h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                          <?php if(isset($all_type_count) && !empty($all_type_count)){ 
                            foreach($all_type_count as $assume){
                          ?>
                            <div class="col-md-3 col-sm-6 col-12">
                              <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fa-solid fa-handshake"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text"><b><?php echo get_field('hrms_type_pay_list',array('id' =>$assume->id),'name')->name?></b></span>
                                  <span class="info-box-number"><?php echo $assume->counting;?></span>
                                </div>
                              </div>
                            </div>
                          <?php }}else{
                            echo '<span style="text-align:center;display: block;width: 100%;">Data Not Found</span>';
                          } ?>
                    </div>    
                    </div>
                  </div>
                  <!--  -->
                  <div class="">
                    <div class="card-header">
                      <h3 class="card-title">
                        <b>Total Today Count</b>
                      </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                          <?php if(isset($today_type_count) && !empty($today_type_count)){ 
                            foreach($today_type_count as $assume){
                          ?>
                            <div class="col-md-3 col-sm-6 col-12">
                              <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fa-solid fa-handshake"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text"><b><?php echo get_field('hrms_type_pay_list',array('id' =>$assume->id),'name')->name?></b></span>
                                  <span class="info-box-number"><?php echo $assume->counting;?></span>
                                </div>
                              </div>
                            </div>
                          <?php }}else{
                            echo '<span style="text-align:center;display: block;width: 100%;">Data Not Found</span>';
                          } ?>
                          </div>  
                    </div>
                  </div>

                
                </div>
                <!-- /.card -->
              </div>
          </div>
        </div>
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->