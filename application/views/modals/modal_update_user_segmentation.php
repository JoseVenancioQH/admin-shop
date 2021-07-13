<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
  <div class="form-msg"></div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h3 style="display:block; text-align:center;">Update User Segmentation</h3>

  <form id="form-update-usersegmentation" method="POST" autocomplete="false">
 
    <div class="input-group form-group">
      <span class="input-group-addon" id="sizing-addon2">
        <i class="glyphicon glyphicon-home"></i>
      </span>
      <input type="text" class="form-control" placeholder="Name Company" value="<?=isset($dataUserSegmentation->namecompany)?$dataUserSegmentation->namecompany:null?>" autocomplete="false" name="namecompany" aria-describedby="sizing-addon2">
    </div>

    <div class="input-group form-group">
      <span class="input-group-addon" id="sizing-addon2">
        <i class="glyphicon glyphicon-user"></i>
      </span>
      <input type="text" class="form-control" value="<?=isset($dataUserSegmentation->username)?$dataUserSegmentation->username:null?>" placeholder="Name" autocomplete="false" name="username" aria-describedby="sizing-addon2">
    </div>
    
    <div class="input-group form-group">
      <span class="input-group-addon" id="sizing-addon2">
      <a herf="http://www.codecademy.com"><i class="glyphicon glyphicon-lock"></i></a>
      </span>
      <input type="password" class="form-control" value="<?=isset($dataUserSegmentation->password_)?$dataUserSegmentation->password_:null?>" placeholder="Password" autocomplete="false" name="password" aria-describedby="sizing-addon2">
      
    </div>   

    <div class="input-group form-group">
      <span class="input-group-addon" id="sizing-addon2">
        <i class="glyphicon glyphicon-envelope"></i>
      </span>
      <input type="text" class="form-control" placeholder="E-mail: ex@email.com;ex1@email.com;ex2@email.com" value="<?=isset($dataUserSegmentation->email)?$dataUserSegmentation->email:null?>" name="email" aria-describedby="sizing-addon2">
      <input type="text" class="form-control" placeholder="E-mail-CC: ex@email.com;ex1@email.com;ex2@email.com"  value="<?=isset($dataUserSegmentation->emailcc)?$dataUserSegmentation->emailcc:null?>" name="emailcc" aria-describedby="sizing-addon2">
      <input type="text" class="form-control" placeholder="E-mail-BCC: ex@email.com;ex1@email.com;ex2@email.com"  value="<?=isset($dataUserSegmentation->emailbcc)?$dataUserSegmentation->emailbcc:null?>" name="emailbcc" aria-describedby="sizing-addon2">
    </div>
    <div class="input-group form-group">
      <span class="input-group-addon" id="sizing-addon2">
        <i class="glyphicon glyphicon-globe"></i>
      </span>
      <input type="text" class="form-control" placeholder="Web Site" value="<?=isset($dataUserSegmentation->website)?$dataUserSegmentation->website:null?>" name="website" aria-describedby="sizing-addon2">
    </div>    
    <div class="input-group form-group" style="display: inline-block;">
      <span class="input-group-addon" id="sizing-addon2">
      <i class="glyphicon glyphicon-tag"></i>
      </span>
      <span class="input-group-addon">
          <input type="radio" name="active" <?=isset($dataUserSegmentation->active)&&$dataUserSegmentation->active==1?"checked='checked'":""?> value='1' id="user-enabled" class="minimal" >
      <label for="enabled">Enabled</label>
        </span>
        <span class="input-group-addon">
          <input type="radio" name="active" <?=isset($dataUserSegmentation->active)&&$dataUserSegmentation->active==0?"checked='checked'":""?> value='0' id="user-disabled" class="minimal"> 
      <label for="disabled">Disabled</label>
        </span>
      <input type="hidden" name="group_id" value="<?=isset($dataUserSegmentation->group_id)?$dataUserSegmentation->group_id:null?>" class="minimal" >
      <input type="hidden" name="user_id" value="<?=isset($dataUserSegmentation->user_id)?$dataUserSegmentation->user_id:null?>" class="minimal" >
      <input type="hidden" class="form-control" name="password_">
    </div>    
    <div class="form-group">
      <div class="col-md-12">
          <button type="submit" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Send Data</button>
      </div>
    </div>  
  </form>
</div>


<script type="text/javascript">
$(function () {
    //$(".select2").select2();

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });
   
});
</script>