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
                    <h5>Earning Rates History Records</h5>
                   <div style="float:right;padding-top: 7px;">
                        <?php echo $this->Html->link(__('View Earning Rates'), array('action' => '/index'), array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                                <?php echo $this->Form->create('EarningRateHistory',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                                <?php echo $this->Form->input('id',array("type"=>"hidden"))?>
                                <?php echo $this->Form->input('uuid',array('type'=>'hidden'))?>
                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Earning Grade<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('earning_grade_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$gradeslist,'empty'=>'---Select Grade---','placeholder'=>'Enter earning grade name ','id'=>'earning_grade_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                       <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Amount :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('amount',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter Amount','class'=>'form-control','id'=>'amount','type'=>'text','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">


                                            <label class="control-label">Start Date<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('start_date',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter Start date', 'data-date-format'=>"dd-mm-yyyy",
                                                     'readonly'=>'readonly','class'=>'form-control mydate','type'=>'text','id'=>'start_date','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="span6">
                                       <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">End Date :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('end_date',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter end date', 'data-date-format'=>"dd-mm-yyyy",
                                                     'readonly'=>'readonly','class'=>'form-control mydate','type'=>'text','id'=>'end_date','required'));?>
                                            </div>
                                        </div>
                                    </div>-->
                                    </div> 
                                    <div class="clearfix"></div> 
                                   
                                    </div>
                                </div>

                              <div class="form-actions" align="center">
                                    <?php echo $this->Form->input('Filter', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true,'onclick'=>"javascript:return validateForm();"))?>
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


<?php
$ajaxUrl        = $this->Html->url(array('controller'=>'earningRates','action'=>'historyAjax'));
echo $this->Html->scriptBlock("
    $(document).ready(function(){
        showData();
    });
    function showData(){
        var url   = '".$ajaxUrl."';
        url = url + '/earning_grade_id:'+$('#earning_grade_id').val();
        url = url + '/amount:'+$('#amount').val();
        url = url + '/start_date:'+$('#start_date').val();
        //url = url + '/end_date:'+$('#end_date').val();
        $.post(url, {}, function(res) {
            $('#listingDiv').html(res);
        });           
    }
",array('inline'=>false));
?>

