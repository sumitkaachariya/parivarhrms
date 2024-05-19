  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Business</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Business</li>
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
        <?php if($user->role_id == 3){ ?>
            <div class="col-12 text-right">
                <a href="<?php echo site_url('business/new');?>" class="btn btn-primary mb-3">New Business</a>
            </div>
        <?php }?>
        </div>

      <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Business Information table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="subscription-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>SrNo</th>
                    <th>Business Name</th>
                    <th>Business Type</th>
                    <th>Gam Name</th>
                    <th>Address</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php if(isset($bussiness_s)){
                    foreach ($bussiness_s as $key => $bussiness) {
                  ?>    
                    <tr>
                         <td><?php echo $bussiness->id; ?></td>
                         <td><?php echo $bussiness->bussiness_name; ?></td>
                         <td><?php echo $bussiness->bussiness_type; ?></td>
                         <td><?php echo $bussiness->gam_name; ?></td>
                         <td><?php echo $bussiness->bussiness_address; ?></td>
                    </tr>
                  <?php }}?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>SrNo</th>
                    <th>Business Name</th>
                    <th>Business Type</th>
                    <th>Gam Name</th>
                    <th>Address</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->    
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
   


  </div>
  <!-- /.content-wrapper -->
