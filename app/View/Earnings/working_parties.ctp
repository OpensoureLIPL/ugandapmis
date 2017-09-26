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
                    <h5>Working Parties Record</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                        <?php echo $this->Form->create('WorkingParty',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));
                        echo $this->Form->input('id',array('type'=>'hidden'));
                        echo $this->Form->input('prison_id',array(
                                    'type'=>'hidden',
                                    'class'=>'prison_id',
                                    'value'=>$this->Session->read('Auth.User.prison_id')
                                  ));
                        ?>
                        <div class="row" style="padding-bottom: 14px;">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Date <?php echo $req; ?> :</label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('start_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate','type'=>'text', 'placeholder'=>'Enter start date','required','readonly'=>'readonly','id'=>'start_date'));?>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Name of Working<br> Party  <?php echo $req; ?> :</label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('name',array('div'=>false,'label'=>false,'class'=>'form-control span11','class'=>'form-control ','type'=>'text','placeholder'=>'Enter Name of Working Party','id'=>'name'));?>
                                    </div>
                                </div>
                            </div>
                                   
                            <div class="clearfix"></div> 
                             <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Remarks :</label>
                                    <div class="controls">
                                        <?php echo $this->Form->textarea('remarks',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter remarks','class'=>'form-control','type'=>'text','required'));?>
                                    </div>
                                </div>
                            </div>
                            
                           <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Name of officer In charge   :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('officer_incharge',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter Name of officer In charge ','class'=>'form-control','type'=>'text','required'));?>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Is Enable?<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php 
                                    if(isset($this->request->data['WorkingParty']['is_enable']) && ($this->request->data['WorkingParty']['is_enable'] == 0))
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
                        <div class="clearfix"></div> 
                        
                    </div>

                    <div class="form-actions" align="center">
                        <?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true,'onclick'=>"javascript:return validateForm();"))?>
                    </div>
                    <?php echo $this->Form->end();?>
                               
                    <div id="workingparty_listview"></div>
                    
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
$workingPartyUrl = $this->Html->url(array('controller'=>'earnings','action'=>'workingPartyAjax'));
$deleteworkingPartyUrl = $this->Html->url(array('controller'=>'earnings','action'=>'deleteWorkingParty'));
echo $this->Html->scriptBlock("
   
    jQuery(function($) {
         showDataWorkingParty();
    }); 
    
    function showDataWorkingParty(){
        var url = '".$workingPartyUrl."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#workingparty_listview').html(res);
            }
        });
    }

    //delete working party 
    function deleteworkingParty(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteworkingPartyUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDataWorkingParty();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

",array('inline'=>false));
?>

