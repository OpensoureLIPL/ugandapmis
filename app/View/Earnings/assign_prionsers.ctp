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
                    <h5>Assign Priosners to Working Parties</h5>
                    
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                                <?php echo $this->Form->create('WorkingPartyPrisoner',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));
                                echo $this->Form->input('id',array('type'=>'hidden'));
                                echo $this->Form->input('prison_id',array(
                                    'type'=>'hidden',
                                    'class'=>'prison_id',
                                    'value'=>$this->Session->read('Auth.User.prison_id')
                                  ));
                                ?>
                                <div class="row-fluid" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of assignment<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('assignment_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate','type'=>'text', 'placeholder'=>'Enter start date','required','readonly'=>'readonly','id'=>'assignment_date'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                      
                                        <div class="control-group">
                                            <label class="control-label">Prisoner Number <?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prisoner_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$prisonerList, 'empty'=>'-- Select Prisoner Number --','required','id'=>'prisoner_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                    </div> 
                                    <div class="row-fluid">
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                         <label class="control-label">Start Date <?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('start_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate','type'=>'text', 'placeholder'=>'Enter start date','required','readonly'=>'readonly','id'=>'start_date'));?>
                                            </div>
                                        </div>
                                    </div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">End Date <?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('end_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate','type'=>'text', 'placeholder'=>'Enter end date','required','readonly'=>'readonly','id'=>'end_date'));?>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                     
                                    <div class="row-fluid" style="padding-bottom: 14px;">
                                    <div class="span6">
                                       <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Remarks :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->textarea('remarks',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter remarks','class'=>'form-control','type'=>'text','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="span6">
                                      
                                        <div class="control-group">
                                            <label class="control-label">Working Party <?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('working_party_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$workingPartyList, 'empty'=>'-- Select Working Party --','required','id'=>'working_party_id'));?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Is Enable?<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php 
                                                if(isset($this->request->data['WorkingPartyPrisoner']['is_enable']) && ($this->request->data['WorkingPartyPrisoner']['is_enable'] == 0))
                                                {
                                                    echo $this->Form->input('is_enable', array('checked'=>false,'div'=>false,'label'=>false));
                                                }
                                                else 
                                                {
                                                    echo $this->Form->input('is_enable', array('checked'=>true,'div'=>false,'label'=>false));
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>  
                                    </div>
                                </div>



                              <div class="form-actions" align="center">
                        <?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true,'onclick'=>"javascript:return validateForm();"))?>
                    </div>
                                <?php echo $this->Form->end();?>
                                    
                           
                             <div id="workingpartyprisoner_listview"></div>
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
        //if(confirm('Are you sure want to save?')){  
            return true;            
        // }else{               
        //     return false;           
        // }        
    }else{   
        return false;
    }  
}

</script>
<?php
$workingPartyPrisonerUrl = $this->Html->url(array('controller'=>'earnings','action'=>'workingPartyPrisonerAjax'));
$deleteworkingPartyPrisonerUrl = $this->Html->url(array('controller'=>'earnings','action'=>'deleteWorkingPartyPrisoner'));
echo $this->Html->scriptBlock("
   
    jQuery(function($) {
         showDataWorkingPartyPrisoner();
    }); 
    
    function showDataWorkingPartyPrisoner(){
        var url = '".$workingPartyPrisonerUrl."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#workingpartyprisoner_listview').html(res);
            }
        });
    }

    //delete working party 
    function deleteworkingPartyPrisoner(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteworkingPartyPrisonerUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDataWorkingPartyPrisoner();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

",array('inline'=>false));
?>

