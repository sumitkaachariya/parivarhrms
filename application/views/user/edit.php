  
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
                            <input type="number" class="form-control" value="<?php echo $member_user->edu_no_of_child;?>" name="no_of_child_std" id="no_of_child_std" placeholder="Number of children studying" required>
                        </div> 

                        <div class="form-group">
                            <label for="submit_result">Deposited result</label>
                            <input type="number" class="form-control" value="<?php echo $member_user->no_of_result;?>" name="submit_result" id="submit_result" placeholder="Deposited result" required>
                        </div>   

                        <div class="form-group">
                            <label for="notebook">A given notebook</label>
                            <input type="number" class="form-control" value="<?php echo $member_user->pay_of_notebook;?>" name="notebook" id="notebook" placeholder="A given notebook" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="total_member">Total member</label>
                            <input type="number" class="form-control" min="<?php echo $member_user->no_of_home_person;?>" value="<?php echo $member_user->no_of_home_person;?>" name="total_member" id="total_member" placeholder="Total member" required>
                        </div>

                    </div>
                    <div class="card-footer">
                            <button class="btn btn-success save_sub_btn">Update</button>
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
                                    <label for="sabhy_edu_<?php echo $i;?>">Member study <?php echo $i;?></label>
                                    <input type="text" value="<?php echo $memberlist->member_edu ;?>" data-id="save_sabhy_edu_<?php echo $i;?>" class="form-control" name="sabhy[<?php echo $memberlist->id;?>][edu]" id="sabhy_edu_<?php echo $i;?>" placeholder="Member study <?php echo $i;?>" required="">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <?php $i++;} } ?>
                        <div class="total_member_of_list"></div>
                    </div>
                    <div class="card-footer"></div>
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


$("#total_member").on("keyup", function(){
   var total = $(this).val();
   var html = '';

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
            html += '<label for="sabhy_edu_'+num+'">Member study '+num+'</label>';
            html += '<input type="text" data-id="save_sabhy_edu_'+i+'" class="form-control" name="sabhy[null][edu]" id="sabhy_edu_'+num+'" placeholder="Member study '+num+'" required="">';
          html += '</div>';
        html += '</div>';
      html += '</div>';
    }
   }
   $('.total_member_of_list').html(html);
});


</script>