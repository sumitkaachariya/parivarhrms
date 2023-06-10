  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit User</li>
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
          <?php if(isset($user_Data)){?>
            <form id="update_user_form_Data" method="post">
              <div class="card">
                  <div class="card-body">
                    <div class="row"> 
                    
                     <input type="hidden" name="id" value="<?php echo @$_GET['id'];?>">
                      <div class="col-lg-4 col-12">
                          <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" value="<?php echo $user_Data->name;?>"  name="name" id="name" placeholder="Name" required>
                          </div>
                      </div>

                      <div class="col-lg-4 col-12">
                          <div class="form-group">
                            <label for="mobile_no">Mobile No</label>
                            <input type="text" class="form-control" value="<?php echo $user_Data->mobileno;?>" pattern="[789][0-9]{9}" value="" name="mobile_no" id="mobile_no" placeholder="Mobile No" required>
                          </div>
                      </div>
                       <div class="col-lg-4 col-12">
                          <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control"  value="<?php echo $user_Data->email;?>" name="email" id="email" placeholder="Email Address" <?php if(@$_GET['email']){ echo 'disabled'; }?> required>
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
                                <option value="<?php echo $gam->id;?>" <?php if($user_Data->gam_id == $gam->id){ echo 'selected'; }?>><?php echo $gam->name;?></option>
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
                                <option value="<?php echo $role->id;?>" <?php if($user_Data->role_id == $role->id){ echo 'selected'; }?>><?php echo $role->name;?></option>
                              <?php }}?>
                            </select>
                          </div>
                      </div>
                      
                      <div class="col-lg-4 col-12">
                          <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" value="" name="password" id="password" placeholder="Password">
                          </div>
                      </div>

                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="col-lg-6 col-12">
                        <button class="btn btn-success update_sub_btn">Update</button>
                      </div>
                  </div>
              </div>
            </form>
          <?php }else{ ?>
            <form id="updated_data" method="post">
              <div class="card">
                  <div class="card-body">
                    <div class="row"> 

                      <?php if(isset($type_pay_list)){ 
                        foreach($type_pay_list as $key => $pay_list){

                          $label = '';
                          if($key == 0){
                            $label = 'varshik_lavajam';
                          }
                          if($key == 1){
                            $label = 'danbhet';
                          }
                          if($key == 2){
                            $label = 'notebook';
                          }
                          if($key == 3){
                            $label = 'any';
                          }
                      ?>
                      <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="list_<?php echo $key;?>"><?php echo  $pay_list->name; ?></label>
                            <input type="text" class="form-control"  name="pay_list[<?php echo  $pay_list->name; ?>]" id="list_<?php echo $key;?>" placeholder="Amount">
                          </div>
                        </div>
                      <?php }}?>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="col-lg-6 col-12">
                        <button class="btn btn-success save_sub_btn">SAVE</button>
                      </div>
                  </div>
              </div>
            </form> 
            
          <?php } ?>
        </div>

        <?php if(isset($subscriptions)){ ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Subscription <b><?php echo $user->name;?></b> - <b><?php echo $user->gam;?></b></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="subscription-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr No</th>
                    <th>Date</th>
                    <th>Type of Pay</th>
                    <th>Amoount</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                
                  <?php if(isset($subscriptions)){
                    $i=1;
                    foreach ($subscriptions as $key => $subscription) {
                  ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo date('d-m-Y',strtotime($subscription->created_at)); ?></td>
                    <td><?php echo get_field('type_pay_list',array('id' =>$subscription->type_pay),'name')->name; ?></td>
                    <td><?php echo '૱'.$subscription->total_amount; ?></td>
                    <td><span><i class="fa fa-print"></i></span></td>
                  </tr>
                  <?php 
                       $i++;
                    } }?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr No</th>
                    <th>Date</th>
                    <th>Type of Pay</th>
                    <th>Amoount</th>
                    <th>Action</th>
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
        <?php } ?>
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
    $(".add_user_form_btn").on("click", function(){
      if($(this).hasClass('active')){
          $(this).removeClass('active');
          $(this).text('Add User Form');
          $('.add_user_form').removeClass('add_user_form_active');
      }else{
          $(this).addClass('active');
          $(this).text('Hide User Form');
          $('.add_user_form').toggleClass('add_user_form_active');
      }
  });

$(".add_user_form #update_user_form_Data").submit(function(e){
  e.preventDefault(); 
  $(".update_sub_btn").prop("disabled", true);
  var form = $(this);
  $.ajax({
        type: "POST",
        url: '<?php echo base_url() ?>'+'users/update_user',
        data: form.serialize(),
        dataType: "json",
        success: function(res)
        {
          if(res.code == 200){
              toastr.success(res.message);
              var redirect_url = "<?php echo base_url();?>users";
              setTimeout(function(){ window.location.href= redirect_url; },1500);
          }
          if(res.code == 400){
              toastr.warning(res.message);
              $(".update_sub_btn").prop("disabled", false);     
            }
            if(res.code == 404){
              $(".update_sub_btn").prop("disabled", false);
              toastr.error(res.message);     
            }
        }
    });
});


$(".add_subscription_form #updated_data").submit(function(e){
  e.preventDefault(); 
  var data = $("#updated_data").serializeArray();
  var valid = false;
  $(data).each(function(key,value){

      if(value.value != ''){
        valid = true;
      }
  });
 if(valid == true){
   var mobileno = "<?php echo @$_GET['mobileno'];?>";
    var form = $(this);
    $.ajax({
          type: "POST",
          url: '<?php echo base_url() ?>'+'index.php/member/update_subscription',
          data: form.serialize() + '&mobileno=' + mobileno,
          dataType: "json",
          success: function(data)
          {
            if(data.status == 200){
              toastr.success(data.response);
              setTimeout(function(){ location.reload(); },300);
            }
            if(res.code == 400){
              toastr.warning(res.message);     
            }
            if(res.code == 404){
              toastr.error(res.message);     
            }
          }
      });
 }else{
  toastr.error('Please fill any Amount of Subscription');
 }
});

$("#total_member").on("keyup", function(){
   var total = $(this).val();
   var html = '';

   if(total > 0){
    html +='<div class="card">';
    html += '<div class="card-body">';
    $('.total_member_of_list').empty();
    for(var i=1;i<=total;i++){
    
      html += '<div class="row">';
        html += '<div class="col-8">';
          html += '<div class="form-group">';
            html += '<label for="sabhy_name">સભ્ય નામ</label>';
            html += '<input  onkeyup="language_tra(this);" type="text" data-id="save_sabhy_name_'+i+'" class="form-control" name="sabhy['+i+'][name]" id="sabhy_name" placeholder="સભ્ય નામ" required="">';
          html += '</div>';
        html += '</div>';
        html += '<div class="col-4">';
          html += '<div class="form-group">';
            html += '<label for="sabhy_edu">સભ્યનો અભ્યાસ</label>';
            html += '<input onkeyup="language_tra(this);" type="text" data-id="save_sabhy_edu_'+i+'" class="form-control" name="sabhy['+i+'][edu]" id="sabhy_edu" placeholder="સભ્યનો અભ્યાસ" required="">';
          html += '</div>';
        html += '</div>';
      html += '</div>';
    }
    html += '</div>';
    html += '</div>';
   }
   $('.total_member_of_list').html(html);
});

function view_print_popup(){

}
</script>