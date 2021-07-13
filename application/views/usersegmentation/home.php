<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-12">
        <button class="form-control btn btn-primary" data-toggle="modal" data-target="#usersegmentation"><i class="glyphicon glyphicon-plus-sign"></i> Add User</button>
    </div>
    <!--<div class="col-md-3">
        <a href="<?php echo base_url('Kota/export'); ?>" class="form-control btn btn-default"><i class="glyphicon glyphicon glyphicon-floppy-save"></i> Export Data Excel</a>
    </div>
    <div class="col-md-3">
        <button class="form-control btn btn-default" data-toggle="modal" data-target="#import-kota"><i class="glyphicon glyphicon glyphicon-floppy-open"></i> Import Data Excel</button>
    </div>-->
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>User Id</th>
          <th>Name Company</th>
          <th>User Name</th>
          <th>Email</th>          
          <th>Web Site</th>
          <th>Status</th>
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-usersegmentation">
      
      </tbody>
    </table>
  </div>
</div>

<?php echo $modal_user_segmentation; ?>

<div id="temsegmentation-modal">
  
</div>

