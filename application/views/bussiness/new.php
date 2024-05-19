  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">New Business</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Business</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row justify-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <form method="post" id="business_form"> 
                        <div class="form-group">
                            <label for="mobileno">Name:</label>
                            <input type="text" class="form-control"  name="name" id="name" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group">
                            <label for="mobileno">Mobile No:</label>
                            <input type="text" class="form-control"  name="mobileno" id="mobileno" placeholder="Enter Mobile No" required>
                        </div>
                        <div class="form-group">
                          <label for="gam_id">Gam:</label>
                          <select class="form-control" id="gam_id" name="gam_id" required>
                            <option value="">Select Gam</option>
                            <?php if(isset($gams)){
                              foreach ($gams as $key => $gam) {?>
                                  <option  value="<?php echo $gam->id;?>"><?php echo $gam->name;?></option>
                            <?php }}  ?>
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="business_name">Business Name:</label>
                            <input type="text" class="form-control"  name="businessname" id="business_name" placeholder="Enter Business Name" required>
                        </div>
                        <div class="form-group">
                            <label for="business_type">Business Type:</label>
                            <input type="text" class="form-control"  name="businesstype" id="business_type" placeholder="Enter Business Type" required>
                        </div>
                        <div class="form-group">
                            <label for="business_address">Business Address:</label>
                            <textarea class="form-control"  name="businessaddress" id="business_address" placeholder="Enter Business address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="business_mobile_no">Business Mobile No:</label>
                            <input type="text" class="form-control"  name="businessmobileno" id="business_mobile_no" placeholder="Enter Business Mobile No" required>
                        </div>
                        <div class="form-group">
                            <label for="business_visiting_card">Business visiting card:</label>
                            <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="businessvisitingcard" id="business_visiting_card">
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary save_bus_btn">Save Business</button>
                        </div>
                </form>
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
    $("#business_form").submit(function(e){
        e.preventDefault(); 
        $(".save_bus_btn").prop("disabled", true);
        // var form = $(this);
        // var formData = new FormData($('#business_form')[0]);
        var data = new FormData(this);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>'+'index.php/business/save',
            data: data,
            processData: false,
            contentType: false,
            success: function(data)
            {
                data = JSON.parse(data);
                if(data.status == 200){
                    $(".save_bus_btn").prop("disabled", false);
                    toastr.success(data.response);
                    setTimeout(function(){ 
                        window.location.href = "<?php echo site_url('business')?>";
                     },300);
                }else{
                    toastr.error(data.response);
                }
            }
        });
    });
  </script>
