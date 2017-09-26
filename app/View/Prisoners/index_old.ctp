<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Add Prisnors</h5>
                    <div style="float:right;padding-top: 7px;">
                        <?php echo $this->Html->link('Add Prisoner',array('action'=>'add'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $this->Form->create('Search',array('class'=>'form-horizontal'));?>
                    <div class="row" style="padding-bottom: 14px;">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Prisoner No. :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('prisoner_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Prisoner No.','id'=>'prisoner_no'));?>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Prisoner Name :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('prisoner_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Prisoner Name','id'=>'prisoner_name'));?>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="form-actions" align="center">
                        <?php echo $this->Form->button('Search', array('type'=>'button', 'div'=>false,'label'=>false, 'class'=>'btn btn-success', 'formnovalidate'=>true, 'onclick'=>'javascript:showData();'))?>
                    </div>                    
                    <?php echo $this->Form->end();?> 
                     <div class="widget-content">
                        <div class="table-responsive" id="listingDiv">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$ajaxUrl            = $this->Html->url(array('controller'=>'prisoners','action'=>'indexAjax'));
$verifyAjaxUrl      = $this->Html->url(array('controller'=>'prisoners','action'=>'verifyPrisoner'));
$approveAjaxUrl     = $this->Html->url(array('controller'=>'prisoners','action'=>'approvePrisoner'));
echo $this->Html->scriptBlock("
    $(document).ready(function(){
        showData();
    });
    function showData(){
        var url = '".$ajaxUrl."';
        url = url + '/prisoner_no:'+$('#prisoner_no').val();
        url = url + '/prisoner_name:'+$('#prisoner_name').val();
        $.post(url, {}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        });
    }
    function verifyPrisoner(priosner_id){
        if(priosner_id){
            if(confirm('Are you sure want to verify?')){
                var url = '".$verifyAjaxUrl."';
                $.post(url, {'priosner_id':$('#priosner_id').val()}, function(res) {
                    if (res == 'SUCC') {
                        showData();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }
    function approvePrisoner(priosner_id){
        if(priosner_id){
            if(confirm('Are you sure want to approve?')){
                var url = '".$approveAjaxUrl."';
                $.post(url, {'priosner_id':$('#priosner_id').val()}, function(res) {
                    if (res == 'SUCC') {
                        showData();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }    
",array('inline'=>false));
?> 