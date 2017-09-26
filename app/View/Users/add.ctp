<style>
.row-fluid [class*="span"]
{
  margin-left: 0px !important;
}
</style>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                    <h5>Add New User</h5>
                    <div style="float:right;padding-top: 3px;">
                        <?php echo $this->Html->link('Users List',array('action'=>'index'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $this->Form->create('User',array('class'=>'form-horizontal'));?>
                    <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                    <?php echo $this->Form->input('is_enable', array('type'=>'hidden','value'=>1))?>
                    <?php echo $this->Form->input('is_trash', array('type'=>'hidden','value'=>0))?>
                    <div class="row" style="padding-bottom: 14px;">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">First Name<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('first_name',array('div'=>false,'label'=>false,'class'=>'span11 alpha','type'=>'text','placeholder'=>'Enter First Name','required'));?>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Last Name<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('last_name',array('div'=>false,'label'=>false,'class'=>'span11 alpha','type'=>'text','placeholder'=>'Enter First Name','required'));?>
                                </div>
                            </div>
                        </div> 
                        <div class="clearfix"></div>                       
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Mail Id<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('mail_id',array('div'=>false,'label'=>false,'class'=>'span11','type'=>'email','required','placeholder'=>'Enter Mail Id',));?>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">User Name<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('username',array('div'=>false,'label'=>false,'class'=>'span11','type'=>'text','placeholder'=>'Enter User Name','required'));?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Password<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('password',array('div'=>false,'label'=>false,'class'=>'span11','type'=>'password','placeholder'=>'Enter Password','required'));?>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">User Type<?php echo $req; ?></label>
                                <div class="controls">
                                    <?php echo $this->Form->input('usertype_id',array('div'=>false,'label'=>false,'class'=>'span11','options'=>$usertypeList,'empty'=>'-- Select User Type --', 'required'));?>
                                </div>
                            </div>
                        </div> 
                        <div class="clearfix"></div>                       
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Designation<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('designation_id',array('div'=>false,'label'=>false,'class'=>'span11','options'=>$designationList,'empty'=>'-- Select Designation --','required'));?>
                                </div>
                            </div>
                        </div> 
                          
                       
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Region :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('state_id',array('id'=>'state_id', 'div'=>false,'label'=>false,'class'=>'span11','options'=>$stateList,'empty'=>'-- Select Region --', 'onchange'=>'javascript:getDistrict();'));?>
                                </div>
                            </div>
                        </div> 
                         <div class="clearfix"></div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">District :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('district_id',array('id'=>'district_id', 'div'=>false,'label'=>false,'class'=>'span11','options'=>$districtList,'empty'=>'-- Select District --',));?>
                                </div>
                            </div>
                        </div>   
                         
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Department :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('department_id',array('div'=>false,'label'=>false,'class'=>'span11','options'=>$departmentList,'empty'=>'-- Select Department --',));?>
                                </div>
                            </div>
                        </div>    
                        <div class="clearfix"></div>     
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Mobile No.:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('mobile_no',array('div'=>false,'label'=>false,'class'=>'span11 mobile','type'=>'text','placeholder'=>'Enter Mobile No.','required'=>false,));?>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Prison<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('prison_id',array('id'=>'prison_id', 'div'=>false,'label'=>false,'class'=>'span11','options'=>$prisonList,'empty'=>'-- Select Prison --','required'));?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Force Number:</label>
                                <div class="controls">
                                  <?php
                                 
                                      echo $this->Form->input('force_number',array(
                                        'div'=>false,
                                        'label'=>false,
                                        'class'=>'span11',
                                        'type'=>'text',
                                        'required'=>false
                                      ));
                                   ?>
                                </div>
                          </div>
                        </div>
                    </div>           
                    <div class="form-actions" align="center">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$ajaxUrl = $this->Html->url(array('controller'=>'users','action'=>'getDistrict'));
echo $this->Html->scriptBlock("
    function getDistrict(){
        var url = '".$ajaxUrl."';
        $.post(url, {'state_id':$('#state_id').val()}, function(res) {
            if (res) {
                $('#district_id').html(res);
            }
        });
    }
",array('inline'=>false));
?> 