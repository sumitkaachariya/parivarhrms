  
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">New Subscription</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Subscription</li>
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
                    <form method="get"> 
                        <div class="form-group">
                            <label for="mobileno">Mobile No</label>
                            <input type="text" class="form-control" value="<?php echo @$_GET['mobileno'];?>" name="mobileno" pattern="[789][0-9]{9}" id="mobileno" placeholder="Enter Mobile No" required>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary">Process</button>
                        </div>
                </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if(@$_GET['mobileno']){?>
        <div class="row">
          <div class="col-12 text-right p-3">
             <button class="btn btn-primary add_subscription_form_btn mb-1">Add Subscription Form</button>
             <?php if(isset($subscriptions)){?>
              <a href="<?php echo site_url('subscription/edit?mobileno=')?><?php echo $_GET["mobileno"];?>"class="print_btn btn btn-primary mb-1"><i class="fa fa-edit"></i> Edit <Form></Form></a>
              <a href="<?php echo site_url('subscription/printview?mobileno=')?><?php echo $_GET["mobileno"];?>"class="print_btn btn btn-primary mb-1"><i class="fa fa-print"></i> Print</a>
             <?php }  ?>
          </div>
        </div>
        <?php }?>
        
        <div class="add_subscription_form" style="display:none;">
          <?php if(!isset($subscriptions)){?>
            <form id="add_new_subscripatiob_form_Data" method="post">

              <div class="row">
                <div class="col-lg-6 col-12">
                  <div class="card">
                    <div class="card-header">Member Details</div>
                    <div class="card-body">
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control"  name="name" id="name" placeholder="Name" required>
                        </div>

                        <div class="form-group">
                          <label for="mobile_no">Mobile No</label>
                          <input type="text" class="form-control" pattern="[789][0-9]{9}" value="<?php echo @$_GET['mobileno'];?>" name="mobile_no_disbaled" id="mobile_no" placeholder="Mobile No" <?php if(@$_GET['mobileno']){ echo 'disabled'; }?> required>
                          <input type="hidden" class="form-control" pattern="[789][0-9]{9}" value="<?php echo @$_GET['mobileno'];?>" name="mobile_no" id="mobile_no" placeholder="Mobile No" <?php if(@$_GET['mobileno']){ echo 'disabled'; }?> required>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control"  name="address" id="address" placeholder="Address" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="gam">Gam</label>
                            <select class="form-control" name="gam" id="gam" required>
                              <option value="">Select Gam</option>
                              <?php if(isset($gams)){
                                foreach ($gams as $key => $gam) {
                              ?>
                                <option value="<?php echo $gam->id;?>" <?php if(@$user->gam == 'સેંદરડા'){ echo 'selected'; }?>><?php echo $gam->name;?></option>
                              <?php }}?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="total_member">Total member</label>
                            <input type="number" class="form-control"  name="total_member" id="total_member" placeholder="Total member" required>
                        </div>
    
                        <div class="form-group">
                            <label for="no_of_child_std">Number of children studying</label>
                            <input type="number" class="form-control"  id="no_of_child_std" placeholder="Number of children studying" value="0" required disabled>
                            <input type="hidden" class="form-control"  name="no_of_child_std" id="no_of_child_std_val" value="0" placeholder="Number of children studying">
                        </div>  

                        <div class="form-group">
                            <label for="submit_result">Deposited result</label>
                            <input type="number" class="form-control" value="0" id="submit_result" placeholder="Deposited result" required disabled>
                            <input type="hidden" class="form-control" value="0" name="submit_result" id="submit_result_val" placeholder="Deposited result">
                        </div>    
                        
                        <div class="form-group">
                            <label for="notebook">A given notebook</label>
                            <input type="number" class="form-control" value="0" id="notebook" placeholder="A given notebook" disabled required>
                            <input type="hidden" class="form-control"  name="notebook" id="notebook_val" placeholder="A given notebook">
                        </div>
                        
                        <?php if(isset($type_pay_list)){ 
                          foreach($type_pay_list as $key => $pay_list){

                            $label = '';
                            $formtitle = '';
                            if($key == 0){
                              $label = 'varshik_lavajam';
                              $formtitle = 'lavajam';
                            }
                            if($key == 1){
                              $label = 'danbhet';
                              $formtitle = 'Danbhet';
                            }
                            if($key == 2){
                              $label = 'notebook';
                              $formtitle = 'Notebook';
                            }
                            if($key == 3){
                              $label = 'other';
                              $formtitle = 'Other';
                            }
                        ?>
                        <div class="form-group">
                            <label for="list_<?php echo $key;?>"><?php echo  $formtitle; ?></label>
                            <input type="number" class="form-control"  name="pay_list[<?php echo  $label; ?>]" id="list_<?php echo $key;?>" placeholder="Amount">
                        </div>
                      <?php }}?>

                      

                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card">
                        <div class="card-header">Member List</div>
                        <div class="card-body">
                          <div class="total_member_of_list"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-12">
                  <div class="card">
                      <div class="card-footer text-center">
                        <button class="btn btn-success save_sub_btn">SAVE</button>
                      </div>
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
                          $formtitle = '';
                          if($key == 0){
                            $label = 'varshik_lavajam';
                            $formtitle = 'lavajam';
                          }
                          if($key == 1){
                            $label = 'danbhet';
                            $formtitle = 'Danbhet';
                          }
                          if($key == 2){
                            $label = 'notebook';
                            $formtitle = 'Notebook';
                          }
                          if($key == 3){
                            $label = 'other';
                            $formtitle = 'Other';
                          }
                      ?>
                      <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="list_<?php echo $key;?>"><?php echo $formtitle; ?></label>
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
      <?php if(isset($member_user)){ ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>Remark</b></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="form-group">
                      <textarea class="form-control" onkeyup="update_remark(this);" name="Remark_text" id="Remark_text" placeholder="Remark"><?php echo @$member_user->remark;?></textarea>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      <?php } ?>

      <!-- education list -->
      <?php if(isset($eduction_list)){?>
        <div class="row education_list_row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><b>Education Getting List - <?php echo date('Y'); ?></b></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Standard</th> 
                      <th>Percentage</th> 
                      <th>Year</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($eduction_list as $key => $eduction) { 
                      $name = get_field('hrms_member_of_user_home',array('id' =>$eduction->home_member_id),'member_name')->member_name;  
                    ?>
                    <tr class="eduction_parent_row">
                      <td>
                        <div class="form-group">
                          <input type="text" disabled value="<?php echo $name;?>"  class="form-control" required>
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <select class="form-control update_std" required>
                            <option value="">Select Standard</option>
                            <?php if(isset($educations)){
                              foreach ($educations as $key => $edu) {?>
                                  <option <?php if($eduction->std == $edu->id){ echo 'selected'; }?> value="<?php echo $edu->id;?>"><?php echo $edu->name;?></option>
                            <?php }}  ?>
                          </select>
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="number" value="<?php echo $eduction->percentage; ?>" name="percentage" class="form-control percentage" required>
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <select class="form-control update_year" required>
                            <option <?php if($eduction->year == date('Y')){ echo 'selected'; }?> value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                          </select>
                        </div>
                      </td>
                      <td>
                      <!-- update_edu_btn -->
                        <button data-member_user_id="<?php echo $eduction->member_user_id; ?>" data-home_member_id="<?php echo $eduction->home_member_id; ?>" data-id="<?php echo $eduction->id; ?>" class="btn btn-primary update_edu_btn">Update</button>
                      </td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      <?php }?>
        <?php if(isset($subscriptions)){ ?>
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Subscription <b><?php echo $member_user->name;?></b> - <b><?php echo  get_field('gam',array('id'=> $member_user->gam_id),'name')->name; ?></b></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="subscription-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Type of Pay</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                
                  <?php if(isset($subscriptions)){
                    foreach ($subscriptions as $key => $subscription) {
                  ?>
                  <tr>
                    <td><?php echo date('d-m-Y',strtotime($subscription->created_at)); ?></td>
                    <td>
                      <?php 
                        $name = get_field('hrms_type_pay_list',array('id' =>$subscription->type_pay),'name')->name;
                        if($name == 'varshik_lavajam'){
                          $formtitle = 'lavajam';
                        }
                        if($name == 'danbhet'){
                          $formtitle = 'Danbhet';
                        }
                        if($name == 'notebook'){
                          $formtitle = 'Notebook';
                        }
                        if($name == 'other'){
                          $formtitle = 'Other';
                        }
                      ?>  
                    <?php echo $formtitle; ?></td>
                    <td><?php echo '₹'.$subscription->total_amount; ?></td>
                    <td><a class="delete_subscripation" data-id="<?php echo $subscription->id; ?>" href="javascript:void(0)"><i class="fa fa-trash"></i></a></td>
                  </tr>
                  <?php 
                    } }?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Date</th>
                    <th>Type of Pay</th>
                    <th>Amount</th>
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
  .add_subscription_form.add_subscription_form_active {display: block !important;}
  @media(max-width:767px){
    .education_list_row .form-control{width: inherit;}
  }
</style>
  <script>
    $(".add_subscription_form_btn").on("click", function(){
      if($(this).hasClass('active')){
          $(this).removeClass('active');
          $(this).text('Add Subscription Form');
          $('.add_subscription_form').removeClass('add_subscription_form_active');
      }else{
          $(this).addClass('active');
          $(this).text('Hide Subscription Form');
          $('.add_subscription_form').toggleClass('add_subscription_form_active');
      }
  });

$(".add_subscription_form #add_new_subscripatiob_form_Data").submit(function(e){
  e.preventDefault(); 
  $(".save_sub_btn").prop("disabled", true);
  var mobileno = "<?php echo @$_GET['mobileno'];?>";
  var form = $(this);
  $.ajax({
        type: "POST",
        url: '<?php echo base_url() ?>'+'index.php/subscription/submit_subscription',
        data: form.serialize() + '&mobile_no=' + mobileno,
        dataType: "json",
        success: function(data)
        {
          if(data.status == 200){
              toastr.success(data.response);
              setTimeout(function(){ location.reload(); },300);
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
          url: '<?php echo base_url() ?>'+'subscription/update',
          data: form.serialize() + '&mobileno=' + mobileno,
          dataType: "json",
          success: function(data)
          {
            if(data.status == 200){
              toastr.success(data.response);
              setTimeout(function(){ location.reload(); },300);
            }
          }
      });
 }else{
  toastr.error('Please fill any Amount of Subscription');
 }
});
var total_study_count_member = 0;
$("#total_member").on("keyup", function(){
   var total = $(this).val();
   var html = '';
   total_study_count_member = 0;
   if(total > 0){
   
    $('.total_member_of_list').empty();
    for(var i=1;i<=total;i++){
      html += '<div class="row">';
        html += '<div class="col-lg-8 col-12">';
          html += '<div class="form-group">';
            html += '<label for="sabhy_name_'+i+'">Member Name '+i+'</label>';
            html += '<input type="text" data-id="save_sabhy_name_'+i+'" class="form-control" name="sabhy['+i+'][name]" id="sabhy_name_'+i+'" placeholder="Member Name" required="">';
          html += '</div>';
        html += '</div>';
        html += '<div class="col-lg-4 col-12">';
          html += '<div class="form-group">';
            html += '<label for="sabhy_age_'+i+'">Member Age '+i+'</label>';
            html += '<input type="number" data-id="save_sabhy_age_'+i+'" class="form-control" name="sabhy['+i+'][age]" id="sabhy_age_'+i+'" placeholder="Member Age" required="">';
          html += '</div>';
        html += '</div>';
        html += '<div class="col-lg-12 col-12">';
          html += '<div class="form-group">';
            html += '<label for="sabhy_std_'+i+'">Member Education '+i+'</label>';
            html += '<select required="" data-id="save_sabhy_std_'+i+'" class="form-control" name="sabhy['+i+'][std]" id="sabhy_std_'+i+'">';
            html += '<option value="">Select Education</option>';
            <?php  if(isset($educations)){
              foreach ($educations as $key => $education) {
            ?>
              html += '<option value="<?php echo $education->id; ?>"><?php echo $education->name; ?></option>';
            <?php } } ?>
            html += '</select>';
          html += '</div>';
        html += '</div>';
        html += '<div class="col-lg-12 col-12">';
          html += '<div class="custom-control custom-checkbox">';
            html += '<input onclick="check_total_study_count_member(this);" type="checkbox" value="1" data-id="save_sabhy_present_'+i+'" class="custom-control-input custom-control-input-danger custom-control-input-outline" name="sabhy['+i+'][present]" id="sabhy_present_'+i+'">';
            html += '<label class="custom-control-label" for="sabhy_present_'+i+'">Present Study Member'+i+'</label>';
          html += '</div>';
        html += '</div>';
      html += '</div><hr>';
    }
   }
   $('.total_member_of_list').html(html);
   all_counting_form(total_study_count_member);
});

$(".update_edu_btn").click(function(e){

  var id = $(this).data('id');
  var member_user_id = $(this).data('member_user_id');
  var home_member_id=  $(this).data('home_member_id');
  var std = $(this).parents('.eduction_parent_row').find('.update_std option:selected').val();
  var percentage = $(this).parents('.eduction_parent_row').find('.percentage').val();
  var year = $(this).parents('.eduction_parent_row').find('.update_year option:selected').val();
  var that = $(this);
  if(std == ''){
    toastr.warning('Please Select Standard');
    $(this).parents('.eduction_parent_row').find('.update_std').focus();
    return false;
  }
  if(percentage == ''){
    toastr.warning('Please Enter Percentage');
    $(this).parents('.eduction_parent_row').find('.percentage').focus();
    return false;
  }
  if(year == ''){
    toastr.warning('Please Select Year');
    $(this).parents('.eduction_parent_row').find('.update_year option:selected').focus();
    return false;
  }

  $(this).prop('disabled', true);
  $(this).html('<i class="fa fa-spinner fa-spin"></i>');

  $.ajax({
      url:'<?php echo base_url();?>subscription/update_edu',
      type:'post',
      dataType: "json",
      data:{member_user_id:member_user_id,home_member_id:home_member_id,std:std,percentage:percentage,year:year},
      success:function(res){
        if(res.code == 200){
          toastr.success(res.message);  
        }
        if(res.code == 400){
          toastr.warning(res.message);     
        }
        if(res.code == 404){
          toastr.error(res.message);     
        }
        $(that).prop('disabled', false);
        $(that).html('Update');
      }
    });
});

$(".delete_subscripation").on("click", function(){
  var id = $(this).data('id');
  if (confirm('Are You Sure Delete Record?')) {
      $.ajax({
        url:'<?php echo base_url();?>subscription/delete_subscrption_rec',
        type:'post',
        dataType: "json",
        data:{id:id},
        success:function(res){
          if(res.code == 200){
            toastr.success(res.message);  
          }
          if(res.code == 400){
            toastr.warning(res.message);     
          }
          if(res.code == 404){
            toastr.error(res.message);     
          }
          setTimeout(function(){ location.reload(); },300); 
        }
      });
    }
});
function check_total_study_count_member(t){
  if ($(t).is(':checked')) {
      total_study_count_member = (total_study_count_member + 1); 
  }else{
    total_study_count_member = (total_study_count_member - 1); 
  }
  all_counting_form(total_study_count_member);
}
function all_counting_form(total_study_count_member){
  $("#no_of_child_std").val(total_study_count_member);
  $("#no_of_child_std_val").val(total_study_count_member);
  $("#submit_result").val(total_study_count_member);
  $("#submit_result_val").val(total_study_count_member);

  var no_of_book_couting = (total_study_count_member * 6);
  $("#notebook").val(no_of_book_couting);
  $("#notebook_val").val(no_of_book_couting);
}
function update_remark(remark){
  var mobileno = "<?php echo @$_GET['mobileno'];?>";
  $.ajax({
      url:'<?php echo base_url();?>subscription/remark',
      type:'post',
      dataType: "json",
      data:{mobileno:mobileno,remark_text:$(remark).val()},
      success:function(res){
        if(res.code == 200){
          toastr.success(res.message);  
        }
        if(res.code == 400){
          toastr.warning(res.message);     
        }
        if(res.code == 404){
          toastr.error(res.message);     
        }
      }
    });
}



function view_print_popup(){

}
</script>