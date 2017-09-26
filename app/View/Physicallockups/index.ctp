<style>
.row-fluid [class*="span"]
{
  margin-left: 0px !important;
}
</style>
<?php
if(isset($this->data['PhysicalLockup']['lock_date']) && $this->data['PhysicalLockup']['lock_date'] != ''){
    $this->request->data['PhysicalLockup']['lock_date'] = date('d-m-Y', strtotime($this->data['PhysicalLockup']['lock_date']));
}

?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                    <h5>Physical Lockup Records</h5>
                      <div style="float:right;padding-top: 7px;">
                        <?php echo $this->Html->link(__('View Report'), array('action' => 'lockupReport'), array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                                <?php echo $this->Form->create('PhysicalLockup',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                                <?php echo $this->Form->input('id',array("type"=>"hidden"))?>
                                <?php echo $this->Form->input('uuid',array('type'=>'hidden'))?>
                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Prisoner Type<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prisoner_type_id',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'select','options'=>$prisonerTypeList,'empty'=>'---Select Prisoner Type---',));?>
                                            </div>
                                        </div>
                                    </div>
                                      
                                    <div class="span6">
                                        <div class="control-group">
                                           <label class="control-label">Lockup Type<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('lockup_type_id',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'select','options'=>$lockupTypeList,'empty'=>'---Select Lockup Type---'));?>
                                            </div>
                                        </div>
                                    
                                    </div> 
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">


                                            <label class="control-label">Date<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('lock_date',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter lock date', 'data-date-format'=>"dd-mm-yyyy",
                                                     'readonly'=>'readonly','class'=>'form-control mydate','type'=>'text','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                       <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Male <?php echo $req; ?>:</label>
                                            <div class="controls">
                                                 <?php echo $this->Form->input('no_of_male',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter no.of males','class'=>'form-control','type'=>'text','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                       <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label"> Female <?php echo $req; ?> :</label>
                                            <div class="controls">
                                                 <?php echo $this->Form->input('no_of_female',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter no.of females','class'=>'form-control','type'=>'text','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                              <div class="form-actions" align="center">
                                    <?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true,'onclick'=>"javascript:return validateForm();"))?>
                              </div>
                                <?php echo $this->Form->end();?>     
                        </div>
                         <div class="table-responsive" id="listingDiv">

                    </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">


function validateForm(){
    var errcount = 0;
    $('.validate').each(function(){
        if($(this).val() == ''){
            errcount++;
            $(this).addClass('error-text');
            $(this).removeClass('success-text'); 
        }else{
            $(this).removeClass('error-text');
            $(this).addClass('success-text'); 
        }        
    });        
    if(errcount == 0){            
        if(confirm('Are you sure want to save?')){  
            return true;            
        }else{               
            return false;           
        }        
    }else{   
        return false;
    }  
}

</script>
<?php
$ajaxUrl        = $this->Html->url(array('controller'=>'physicallockups','action'=>'indexAjax'));
echo $this->Html->scriptBlock("
    $(document).ready(function(){
        showData();
    });
    function showData(){
        var url   = '".$ajaxUrl."';
        //url = url + '/name:'+$('#name').val();
        //url = url + '/grade_description:'+$('#grade_description').val();
        $.post(url, {}, function(res) {
            $('#listingDiv').html(res);
        });           
    }
",array('inline'=>false));
?>

