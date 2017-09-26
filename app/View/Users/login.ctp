<?php echo $this->Form->create('User',array('class'=>'form center-block')); ?>
<?php echo $this->Form->input('appSalt',array('type'=>'hidden','id'=>'appSalt','label'=>false,'value' =>$appSalt,'div'=>false));?>
<div class="control-group normal_text"> 
    <h3>PMIS LOGIN</h3>
</div>
<div class="control-group">
    <div class="controls">
        <div class="main_input_box">
            <span class="add-on bg_lg"><i class="icon-user"> </i></span>
            <?php echo $this->Form->input('username',array('div'=>false,'label'=>false,'required','placeholder'=>'Enter Username','type'=>'text', 'id'=>'username', 'autocomplete'=>'off'));?>
        </div>
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <div class="main_input_box">
            <span class="add-on bg_ly"><i class="icon-lock"></i></span>
            <?php echo $this->Form->input('password',array('type'=>'password','required','placeholder'=>'Enter Password', 'autocomplete'=>'off','div'=>false,'label'=>false,'id'=>'UserPassword'));?>
        </div>
    </div>
</div>

<div class="form-actions">
    <span class="pull-right">
        <?php echo $this->Form->button('Login',array('type'=>'submit','class'=>"btn btn-success",'onclick'=>"javascript:return beforeLogin();",'div'=>false,'label'=>false,'formnovalidate'=>true))?>
    </span>
    <span class="pull-left">
        <?php  echo $this->Html->link(
    'Forgot Passsword?',
    '/users/forgotpassword'
    
);?>
    </span>
</div>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
function beforeLogin(){
    if($('#username').val() == ''){
        $('#username').addClass('error-field');
        $('#UserPassword').removeClass('error-field');
        return false;
    }else if($('#UserPassword').val() == ''){
        $('#UserPassword').addClass('error-field');
        $('#username').removeClass('error-field');
        return false;
    }else{
        $('#username').removeClass('error-field');
        $('#UserPassword').removeClass('error-field');
        var enteredPwd = $("#UserPassword").val();
        var md5Pwd     = MD5(enteredPwd);
        var getSaltVal = $("#appSalt").val();
        var saltedPwd  = MD5(md5Pwd+getSaltVal);
        $("#UserPassword").val('');
        $("#appSalt").val(saltedPwd);
        return true;
    }
}
</script>