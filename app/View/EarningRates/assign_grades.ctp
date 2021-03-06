<style>
.row-fluid [class*="span"]
{
  margin-left: 0px !important;
}
</style>
<?php
if(isset($this->data['EarningRate']['start_date']) && $this->data['EarningRate']['start_date'] != ''){
    $this->request->data['EarningRate']['start_date'] = date('d-m-Y', strtotime($this->data['EarningRate']['start_date']));
}
if(isset($this->data['EarningRate']['end_date']) && $this->data['EarningRate']['end_date'] != ''){
    $this->request->data['EarningRate']['end_date'] = date('d-m-Y', strtotime($this->data['EarningRate']['end_date']));
}
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                    <h5>Assign/Promote Earning Grades To Prisoner</h5>
                    <div style="float:right;padding-top: 7px;">
                        <?php echo $this->Html->link(__('View Earning Rates'), array('action' => '/'), array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                                <?php echo $this->Form->create('EarningRatePrisoner',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                                <?php echo $this->Form->input('id',array("type"=>"hidden"))?>
                                <?php echo $this->Form->input('uuid',array('type'=>'hidden'))?>
                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                        <label class="control-label">Prisoner No:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prisoner_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$prisonerlist,'empty'=>'---Select Prioner---','placeholder'=>'Enter earning grade name ','id'=>'first_name'));?>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="span6">
                                       
                                        <div class="control-group">
                                             <label class="control-label">Grade<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('earning_rate_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$gradeslist,'empty'=>'---Select Grade---','placeholder'=>'Enter earning grade name ','id'=>'first_name'));?>
                                            </div>
                                        </div>
                                    </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">


                                            <label class="control-label">Assignment/Promotion Date<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_assignment',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter Assignment/Prommotion date', 'data-date-format'=>"dd-mm-yyyy",
                                                     'readonly'=>'readonly','class'=>'form-control mydate','type'=>'text','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                       <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Remarks :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->textarea('remarks',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter Remarks','class'=>'form-control','type'=>'text','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                    
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
$ajaxUrl        = $this->Html->url(array('controller'=>'earningRates','action'=>'assignGradeAjax'));
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

