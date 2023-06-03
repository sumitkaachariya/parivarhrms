  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

    <form method="post" id="update_details_form">
       <div class="row">
            <div class="col-lg-6">
                <div class="card">
                <div class="card-header">Details</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control"  name="name" id="name" placeholder="Name" value="<?php echo $member_user->name;?>"  required>
                        </div>

                        <div class="form-group">
                            <label for="mobile_no">Mobile No</label>
                            <input type="text" class="form-control" pattern="[789][0-9]{9}" value="<?php echo $member_user->mobileno;?>" name="mobile_no" id="mobile_no" placeholder="Mobile No" <?php if($_GET['mobileno']){ echo ''; }?> required disabled>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control"  name="address" id="address" placeholder="Address" required><?php echo $member_user->address;?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="gam">Gam</label>
                            <select class="form-control" name="gam" id="gam" required>
                              <option value="">Select Gam</option>
                              <?php if(isset($gams)){
                                foreach ($gams as $key => $gam) {
                              ?>
                                <option value="<?php echo $gam->id;?>" <?php if($member_user->gam_id == $gam->id){ echo 'selected'; }?>><?php echo $gam->name;?></option>
                              <?php }}?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="no_of_child_std">Number of children studying</label>
                            <input type="number" class="form-control" value="<?php echo $member_user->edu_no_of_child;?>"  id="no_of_child_std" placeholder="Number of children studying" disabled required>
                            <input type="hidden" class="form-control"  name="no_of_child_std" id="no_of_child_std_val"  value="<?php echo $member_user->edu_no_of_child;?>" placeholder="Number of children studying">
                        </div> 

                        <div class="form-group">
                            <label for="submit_result">Deposited result</label>
                            <input type="number" class="form-control" value="<?php echo $member_user->no_of_result;?>"  id="submit_result" placeholder="Deposited result" disabled required>
                            <input type="hidden" class="form-control" value="<?php echo $member_user->no_of_result;?>" name="submit_result" id="submit_result_val" placeholder="Deposited result">
                        </div>   

                        <div class="form-group">
                            <label for="notebook">A given notebook</label>
                            <input type="number" class="form-control" value="<?php echo $member_user->pay_of_notebook;?>" id="notebook" placeholder="A given notebook" disabled required>
                            <input type="hidden" class="form-control" value="<?php echo $member_user->pay_of_notebook;?>" name="notebook" id="notebook_val" placeholder="A given notebook">
                        </div>
                        
                        <div class="form-group">
                            <label for="total_member">Total member</label>
                            <input type="number" class="form-control" min="<?php echo $member_user->no_of_home_person;?>" value="<?php echo $member_user->no_of_home_person;?>" name="total_member" id="total_member" placeholder="Total member" required>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">Member List</div>
                    <div class="card-body">
                    <?php if(isset($member_list)){ 
                        $i = 1;
                        foreach ($member_list as $key => $memberlist) {
                    ?>  
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <div class="form-group">
                                    <label for="sabhy_name_<?php echo $i;?>">Member Name <?php echo $i;?></label>
                                    <input type="text" value="<?php echo $memberlist->member_name ;?>" data-id="save_sabhy_name_<?php echo $i;?>" class="form-control" name="sabhy[<?php echo $memberlist->id;?>][name]" id="sabhy_name_<?php echo $i;?>" placeholder="Member Name <?php echo $i;?>" required="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="sabhy_age_<?php echo $i;?>">Member Age <?php echo $i;?></label>
                                    <input type="text" value="<?php echo $memberlist->member_age ;?>" data-id="save_sabhy_age_<?php echo $i;?>" class="form-control" name="sabhy[<?php echo $memberlist->id;?>][age]" id="sabhy_age_<?php echo $i;?>" placeholder="Member age <?php echo $i;?>" required="">
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                              <select data-id="save_sabhy_std_<?php echo $i;?>" class="form-control" name="sabhy[<?php echo $memberlist->id;?>][std]" id="sabhy_std_<?php echo $i;?>">
                                <option value="">Select Standard</option>
                                <?php if(isset($educations)){
                                  foreach ($educations as $key => $edu) {?>
                                      <option <?php if($memberlist->member_edu == $edu->id){ echo 'selected'; }?> value="<?php echo $edu->id;?>"><?php echo $edu->name;?></option>
                                <?php }}  ?>
                            </select>
                            </div>
                            <div class="col-lg-12 col-12 mt-3">
                             <div class="custom-control custom-checkbox">
                                <input <?php if($memberlist->present_member == 1){ echo 'checked'; } ?> onclick="check_total_study_count_member(this);" type="checkbox" value="1" data-id="save_sabhy_present_<?php echo $i;?>" class="custom-control-input custom-control-input-danger custom-control-input-outline" name="sabhy[<?php echo $memberlist->id;?>][present]" id="sabhy_present_<?php echo $i;?>">
                                <label class="custom-control-label" for="sabhy_present_<?php echo $i;?>">Present Study Member <?php echo $i;?></label>
                              </div>
                            </div>
                        </div>
                        <hr>
                        <?php $i++;} } ?>
                        <div class="total_member_of_list"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-12">
              <div class="card">
                  <div class="card-footer text-center">
                      <button class="btn btn-success save_sub_btn">Update</button>
                  </div>
              </div>
            </div>
       </div> 
    </form>
 
        <!-- /.row -->    

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<style>
  .add_subscription_form.add_subscription_form_active {display: block !important;}
</style>
<script>


$("#update_details_form").submit(function(e){
  e.preventDefault(); 
  var data = $("#update_details_form    ").serializeArray();
  var valid = false;
  $(data).each(function(key,value){

      if(value.value != ''){
        valid = true;
      }
  });
  $(".save_sub_btn").prop("disabled", true);

  if(valid == true){
   var mobileno = "<?php echo @$_GET['mobileno'];?>";
    var form = $(this);
    $.ajax({
          type: "POST",
          url: '<?php echo base_url() ?>'+'subscription/update_details_subscription',
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
  $("#update_details_form .custom-control-input:checked").each(function(){
    total_study_count_member = (total_study_count_member + 1);
  }); 
   var record_of_total = "<?php echo count($member_list); ?>";
   record_of_total = parseInt(record_of_total);
   var counting_is_start = (total - record_of_total);
   if(counting_is_start > 0){
    $('.total_member_of_list').empty();
    for(var i=1;i<=counting_is_start;i++){
    var num = (record_of_total + i);
      html += '<div class="row">';
        html += '<div class="col-lg-8 col-12">';
          html += '<div class="form-group">';
            html += '<label for="sabhy_name_'+num+'">Member Name '+num+'</label>';
            html += '<input type="text" data-id="save_sabhy_name_'+i+'" class="form-control" name="sabhy[null][name]" id="sabhy_name_'+num+'" placeholder="Member Name '+num+'" required="">';
          html += '</div>';
        html += '</div>';
        html += '<div class="col-lg-4 col-12">';
          html += '<div class="form-group">';
            html += '<label for="sabhy_age_'+num+'">Member Age '+num+'</label>';
            html += '<input type="text" data-id="save_sabhy_age_'+i+'" class="form-control" name="sabhy[null][age]" id="sabhy_age_'+num+'" placeholder="Member Age '+num+'" required="">';
          html += '</div>';
        html += '</div>';
        html += '<div class="col-lg-12 col-12">';
          html += '<div class="form-group">';
            html += '<label for="sabhy_std_'+num+'">Member Standard '+num+'</label>';
            html += '<select data-id="save_sabhy_std_'+i+'" class="form-control" name="sabhy[null][std]" id="sabhy_std_'+num+'">';
            html += '<option value="">Select Standard</option>';
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
            html += '<input onclick="check_total_study_count_member(this);" type="checkbox" value="1" data-id="save_sabhy_present_'+num+'" class="custom-control-input custom-control-input-danger custom-control-input-outline" name="sabhy[null][present]" id="sabhy_present_'+num+'">';
            html += '<label class="custom-control-label" for="sabhy_present_'+num+'">Present Study Member '+num+'</label>';
          html += '</div>';
        html += '</div>';
      html += '</div><hr>';
    }
   }
   $('.total_member_of_list').html(html);
   all_counting_form(total_study_count_member);
});
$("#update_details_form .custom-control-input:checked").each(function(){
    total_study_count_member = (total_study_count_member + 1);
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
</script>