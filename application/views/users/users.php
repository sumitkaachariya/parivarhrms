  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                <a href="<?php echo site_url('users/add_user');?>" class="btn btn-primary mb-3">New Users</a>
            </div>
        </div>

      <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="subscription-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Gam</th>
                    <th>Mobile No</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                
                  <?php if(isset($users)){
                    foreach ($users as $key => $user) {
                    $total_count_subscription = get_total_count_subscription('hrms_user_plan',array('staff_id' =>$user->id,'year' => date('Y')),'*');
                  ?>
                  <tr>
                    <td><?php echo $user->name; ?><br /><span class="btn btn-warning btn-xs">Total Subscription: (<?php echo count($total_count_subscription); ?>)</span></td>
                    <td><?php echo get_field('gam',array('id' =>$user->gam_id),'name')->name; ?></td>
                    <td><?php echo $user->mobileno; ?></td>
                    <td>
                      <a href="<?php echo site_url('users/edit');?>?id=<?php echo $user->id?>"><i class="fa fa-edit"></i></a>
                      <!-- <a href="javascript:void(0)" data-id="<?php #echo $user->id; ?>" class="delete_user"><i class="fa fa-trash"></i></a> -->
                    </td>
                  </tr>
                  <?php } }?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Gam</th>
                    <th>Mobile No</th>
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
                    <div class="form-group">
                      <label for="Remark_text">Remark</label>
                      <textarea class="form-control" name="Remark_text" id="Remark_text" placeholder="Remark"></textarea>
                    </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
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
$(".delete_user").on("click", function(){
  var id = $(this).data('id');
  if (confirm('Are You Sure Delete Record?')) {
      $.ajax({
        url:'<?php echo base_url();?>users/delete_user',
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
</script>