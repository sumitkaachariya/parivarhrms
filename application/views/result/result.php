<?php 
    $edu_id = $this->input->get('edu_id');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Result</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Result</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <?php if($user->role_id != 3){ ?>
        <div class="card card-info filter_card">
          <div class="card-body">
            <form class="row">
                <div class="col-12">
                  <label>Filter</label>
                </div>
                <div class="col-lg-4 col-md-4 col-10">
                    <div class="form-group">
                      <?php if(isset($hrms_eduction_list)){?>
                        <select class="form-control" name="edu_id">
                          <option <?php if($edu_id == 'all'){ echo 'selected'; }?> value="all">All</option>
                          <?php foreach ($hrms_eduction_list as $key => $edu) { ?>
                            <option <?php if($edu_id == $edu->id){ echo 'selected'; }?> value="<?php echo $edu->id;?>"><?php echo $edu->name;?></option>
                          <?php }?>
                        </select>
                      <?php } ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-2">
                  <input type="submit" value="Filter" class="btn btn-primary">
                </div>
                <div class="col-lg-5 col-md-3 col-12 text-right">
                  <a href="<?php echo site_url('result/allresult');?>?std=all" class="btn btn-primary">All Result</a>
                </div>
            </form>
          </div>
        </div>
      <?php }?>

        <div class="row">
        	<div class="col-md-12 col-12">
            <div class="row">
              <?php if(isset($final_result)){
                foreach ($final_result as $key => $result) {
                if($edu_id == $key){
              ?>  
                <div class="col-lg-6 col-12">
                  <div class="card card-info result_card">
                    <div class="card-header">
                    <label class="std_label">standard <span><?php echo get_field('hrms_eduction_list',array('id' => $key),'name')->name; ?></span></label>
                    </div>
                    <div class="card-body">
                        <div class="row result_table_title">
                          <div class="col-1 text-center"><label class="result_title">RANK<label></div>
                          <div class="col-5"><label class="result_title">NAME<label></div>
                          <div class="col-3 text-center"><label class="result_title">PERCENTAGE<label></div>
                          <div class="col-3 text-center"><label class="result_title">GAM NAME<label></div>
                        </div>
                        <?php foreach($result as $res){
                        ?>
                          <div class="row">
                            <div class="col-1 text-center"><span class="rank"><?php echo $res->RN; ?><span></div>
                            <div class="col-5"><?php echo $res->member_name; ?></div>
                            <div class="col-3 text-center"><span class="percentage_rank"><?php echo $res->percentage !=  '' ? $res->percentage : '0'; ?> %</span></div>
                            <div class="col-3 text-center"><?php echo $res->gname; ?></div>
                          </div>
                        <?php } ?>
                    </div>
                  </div>
                </div> 
              <?php }elseif($edu_id == 'all'){?>
                <div class="col-lg-6 col-12">
                  <div class="card card-info result_card">
                    <div class="card-header">
                    <label class="std_label">standard <span><?php echo get_field('hrms_eduction_list',array('id' => $key),'name')->name; ?></span></label>
                    </div>
                    <div class="card-body">
                        <div class="row result_table_title">
                          <div class="col-1 text-center"><label class="result_title">RANK<label></div>
                          <div class="col-5"><label class="result_title">NAME<label></div>
                          <div class="col-3 text-center"><label class="result_title">PERCENTAGE<label></div>
                          <div class="col-3 text-center"><label class="result_title">GAM NAME<label></div>
                        </div>
                        <?php foreach($result as $res){
                        ?>
                          <div class="row">
                            <div class="col-1 text-center"><span class="rank"><?php echo $res->RN; ?><span></div>
                            <div class="col-5"><?php echo $res->member_name; ?></div>
                            <div class="col-3 text-center"><span class="percentage_rank"><?php echo $res->percentage !=  '' ? $res->percentage : '0'; ?> %</span></div>
                            <div class="col-3 text-center"><?php echo $res->gname; ?></div>
                          </div>
                        <?php } ?>
                    </div>
                  </div>
                </div>      
              <?php }}}?>
            </div>     		
        	</div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->