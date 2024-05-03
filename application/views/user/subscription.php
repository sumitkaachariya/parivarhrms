  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Subscription</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Subscription</li>
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
            <div class="col-12 text-right">
                <a href="<?php echo site_url('subscription/new');?>" class="btn btn-primary mb-3">New Subscription</a>
            </div>
        </div>

      <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Subscription and Donation Information table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="subscription-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>SrNo</th>
                    <th>Name</th>
                    <th>Gam</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                
                  <?php if(isset($subscriptions)){
                    foreach ($subscriptions as $key => $subscription) {
                  ?>
                  <tr>
                    <td><?php echo $subscription->id; ?></td>
                    <td><?php echo $subscription->name; ?><br/><?php if($subscription->is_subscriptions == 0){?><span class="btn btn-warning btn-xs">Pending</span><?php } ?></td>
                    <td><?php echo get_field('gam',array('id' => $subscription->gam_id),'name')->name;?></td>
                    <td><?php echo date('d-m-Y',strtotime($subscription->created_at)); ?></td>
                    <td>
                      <a href="<?php echo site_url('subscription/edit');?>?mobileno=<?php echo $subscription->mobileno?>"><i class="fa fa-edit"></i></a>
                      <a href="<?php echo site_url('subscription/new');?>?mobileno=<?php echo $subscription->mobileno?>"><i class="fa fa-eye"></i></a>
                      <a href="#" data-remark="<?php echo $subscription->remark;?>" data-mobileno="<?php echo $subscription->mobileno; ?>" data-toggle="modal" data-target="#modal-default"><i class="fa fa-comment remark"></i></a>
                    </td>
                  </tr>
                  <?php } }?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>SrNo</th>
                    <th>Name</th>
                    <th>Gam</th>
                    <th>Date</th>
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
        <!-- /.row -->    
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Remark</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="remark-body">
                    <input type="hidden" name="remark_mobile_no" id="remark_mobile_no">
                    <div class="form-group">
                      <label for="Remark_text">Remark</label>
                      <textarea class="form-control" name="Remark_text" id="Remark_text" placeholder="Remark"></textarea>
                    </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary save_remark"><span>Save changes</span></button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


  </div>
  <!-- /.content-wrapper -->

<script>
  $(".remark").on("click", function(){
    var mobileno =  $(this).parent('a').data('mobileno');
    var remark =  $(this).parent('a').data('remark');
    $('#remark_mobile_no').val(mobileno);
    $('#Remark_text').val(remark);
  });
  $(".save_remark").on("click", function(){
    var mobileno = $('#remark_mobile_no').val();
    var remark_text = $('#Remark_text').val();
    $(this).find('span').html('<i class="fa fa-spinner fa-spin"></i>');
    $.ajax({
      url:'<?php echo base_url();?>subscription/remark',
      type:'post',
      dataType: "json",
      data:{mobileno:mobileno,remark_text:remark_text},
      success:function(res){
        if(res.code == 200){
          $('.save_remark').find('span').html('Save changes');
          toastr.success(res.message);  
            setTimeout( function(){
              window.location.reload();
            }, 1000);
        }
        if(res.code == 400){
          toastr.warning(res.message);     
        }
        if(res.code == 404){
          toastr.error(res.message);     
        }
      }
    })
  });
</script>