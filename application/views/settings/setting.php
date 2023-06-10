  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Settings</li>
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
            <div class="col-12">
                
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Google Sheet Settings</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="google_sheet_setting">
                          <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="GOOGLE_CLIENT_ID" placeholder="GOOGLE CLIENT ID">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="GOOGLE_CLIENT_SECRET" placeholder="GOOGLE CLIENT SECRET">
                                  </div>                                  
                                </div>
                                <div class="col-12">
                                  <button class="btn btn-primary add_goggle_sheet_token">ADD</button>
                                </div>
                          </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- /.row -->    
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

<script>
  $(".add_goggle_sheet_token").on("click", function(){
    if($("#GOOGLE_CLIENT_ID").val() == ''){
      $("#GOOGLE_CLIENT_ID").focus();
      toastr.error("Please Enter Google Client ID");
      return false;
    }
    if($("#GOOGLE_CLIENT_SECRET").val() == ''){
      $("#GOOGLE_CLIENT_SECRET").focus();
      toastr.error("Please Enter Google Client Secret");
      return false;
    }
    $.ajax({
      url:'<?php echo base_url();?>settings/google_sheet_token',
      type:'post',
      dataType: "json",
      data: {"_CLIENT_ID": $("#GOOGLE_CLIENT_ID").val(),"_CLIENT_SECRET" : $("#GOOGLE_CLIENT_SECRET").val()},
      success:function(res){
        console.log(res);
        // if(res.code == 400){
        //   toastr.warning(res.message);     
        // }
      }
    })
  });
</script>