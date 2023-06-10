  
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">New User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

       
        
        <div class="add_user_form">
            <form id="add_new_user_form_Data" method="post">
              <div class="card">
                  <div class="card-body">
                    <div class="row"> 

                      <div class="col-lg-4 col-12">
                          <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control"  name="name" id="name" placeholder="Name" required>
                          </div>
                      </div>

                      <div class="col-lg-4 col-12">
                          <div class="form-group">
                            <label for="mobile_no">Mobile No</label>
                            <input type="text" class="form-control" pattern="[789][0-9]{9}" value="" name="mobile_no" id="mobile_no" placeholder="Mobile No" required>
                          </div>
                      </div>
                       <div class="col-lg-4 col-12">
                          <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control"  value="<?php echo @$_GET['email'];?>" name="email" id="email" placeholder="Email Address" <?php if(@$_GET['email']){ echo 'disabled'; }?> required>
                          </div>
                      </div>
                      
                      <div class="col-lg-4 col-12">
                          <div class="form-group">
                            <label for="gam">Gam</label>
                            <select class="form-control" name="gam" id="gam" required>
                              <option value="">Select Gam</option>
                              <?php if(isset($gams)){
                                foreach ($gams as $key => $gam) {
                              ?>
                                <option value="<?php echo $gam->id;?>"><?php echo $gam->name;?></option>
                              <?php }}?>
                            </select>
                          </div>
                      </div>
                      <div class="col-lg-4 col-12">
                          <div class="form-group">
                            <label for="role">roles</label>
                            <select class="form-control" name="role" id="role" required>
                              <option value="">Select Role</option>
                              <?php if(isset($roles)){
                                foreach ($roles as $key => $role) {
                              ?>
                                <option value="<?php echo $role->id;?>"><?php echo $role->name;?></option>
                              <?php }}?>
                            </select>
                          </div>
                      </div>
                      
                      <div class="col-lg-4 col-12">
                          <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" value="" name="password" id="password" placeholder="Password" required>
                          </div>
                      </div>

                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="col-lg-6 col-12">
                        <button class="btn btn-success save_sub_btn">SAVE</button>
                      </div>
                  </div>
              </div>
            </form>
        </div>
        <!-- /.row -->    

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<style>
  .add_user_form.add_user_form_active {display: block !important;}
</style>
  <script>

$(".add_user_form #add_new_user_form_Data").submit(function(e){
  e.preventDefault(); 
  $(".save_sub_btn").prop("disabled", true);
  var form = $(this);
  $.ajax({
        type: "POST",
        url: '<?php echo base_url() ?>'+'index.php/users/save_user',
        data: form.serialize(),
        dataType: "json",
        success: function(res)
        {
          if(res.code == 200){
              toastr.success(res.message);
              var redirect_url = "<?php echo base_url();?>index.php/users";
              setTimeout(function(){ window.location.href= redirect_url; },1500);
          }
          if(res.code == 400){
              toastr.warning(res.message);
              $(".save_sub_btn").prop("disabled", false);     
            }
            if(res.code == 404){
              $(".save_sub_btn").prop("disabled", false);
              toastr.error(res.message);     
            }
        }
    });
});

</script>