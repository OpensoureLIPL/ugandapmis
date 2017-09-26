<style>
.nodisplay{display:none;}
</style>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                <?php if($transfer_type == 'outgoing')
                {?> 
                    <h5>Prisoner Outgoing Transfer</h5> 
                <?php }
                else 
                {?>
                    <h5>Prisoner Incoming Transfer</h5> 
                <?php }?>
                    
                    
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                        <?php 
                        if($usertype_id == 5)
                        { 
                            if($transfer_type == 'outgoing')
                            {
                                echo $this->Form->create('PrisonerTransfer',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));
                                echo $this->Form->input('id',array('type'=>'hidden'));
                                echo $this->Form->input('transfer_from_station_id',array(
                                    'type'=>'hidden',
                                    'class'=>'transfer_from_station_id',
                                    'value'=>$this->Session->read('Auth.User.prison_id')
                                ));
                                echo $this->Form->input('is_enable',array('type'=>'hidden','value'=>1));
                                ?>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Prisoner Number <?php echo $req; ?>:</label>
                                                <div class="controls">
                                                    <?php echo $this->Form->input('prisoner_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$prisonerList, 'empty'=>'-- Select Prisoner Number --','required','id'=>'prisoner_id'));?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Date Of Transfer<?php echo $req; ?> :</label>
                                                <div class="controls">
                                                    <?php echo $this->Form->input('transfer_date',array('div'=>false,'label'=>false,'class'=>'form-control span11 mydate','type'=>'text', 'placeholder'=>'Enter Transfer Date','required','readonly'=>'readonly','id'=>'transfer_date'));?>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Original Prison <?php echo $req; ?>:</label>
                                                <div class="controls">
                                                    <?php echo $this->Form->input('original_prison',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','value'=>$current_prison_name, 'placeholder'=>'Original Prison','required','readonly','id'=>'original_prison'));?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Destination Prison <?php echo $req; ?>:</label>
                                                <div class="controls">
                                                    <?php echo $this->Form->input('transfer_to_station_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$prisonList, 'empty'=>'-- Select Station --','required','id'=>'transfer_to_station_id'));?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Escorting Officer <?php echo $req; ?>:</label>
                                                <div class="controls">
                                                    <?php echo $this->Form->input('escorting_officer',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$escortingOfficerList, 'empty'=>'-- Select Escorting Officer --','required','id'=>'escorting_officer'));?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Reason <?php echo $req; ?>:</label>
                                                <div class="controls">
                                                    <?php echo $this->Form->input('reason',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Reason','required','type'=>'textarea','id'=>'reason','rows'=>2));?>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>



                                  <div class="form-actions" align="center">
                                    <?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true,'onclick'=>"javascript:return validateForm();"))?>
                                </div>
                                <?php echo $this->Form->end();
                            }
                            else 
                            {
                                echo $this->Form->create('Search',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));
                                ?>
                                <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Prisoner Number <?php echo $req; ?>:</label>
                                                <div class="controls">
                                                    <?php echo $this->Form->input('prisoner_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$prisonerList, 'empty'=>'-- Select Prisoner Number --','required','id'=>'prisoner_id'));?>
                                                    <div class="error-message nodisplay" id="prisoner_id_err">Prisoner Number is required.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Transfer Date<?php echo $req; ?> :</label>
                                                <div class="controls">
                                                    <?php echo $this->Form->input('transfer_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate','type'=>'text', 'placeholder'=>'Select Transfer Date','required','readonly'=>'readonly','id'=>'transfer_date'));?>
                                                    <div class="error-message nodisplay" id="transfer_date_err">Transfer Date is required.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-actions" align="center">
                                    <?php echo $this->Form->input('Search', array('type'=>'button', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true,'onclick'=>"javascript:return searchTransfer();"))?>
                                </div>
                                <?php echo $this->Form->end();
                            }
                            
                        }
                        else
                        {
                            echo $this->Form->create('Search',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));
                            ?>
                            <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Prisoner Number <?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prisoner_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$prisonerList, 'empty'=>'-- Select Prisoner Number --','required','id'=>'prisoner_id'));?>
                                                <div class="error-message nodisplay" id="prisoner_id_err">Prisoner Number is required.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Transfer Date<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('transfer_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate','type'=>'text', 'placeholder'=>'Select Transfer Date','required','readonly'=>'readonly','id'=>'transfer_date'));?>
                                                <div class="error-message nodisplay" id="transfer_date_err">Transfer Date is required.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-actions" align="center">
                                <?php echo $this->Form->input('Search', array('type'=>'button', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true,'onclick'=>"javascript:return searchTransfer();"))?>
                            </div>
                            <?php echo $this->Form->end();
                        }
                        ?>
                                
                        <div id="listingDiv"></div>
                         
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
$ajaxUrl = $this->Html->url(array('controller'=>'PrisonerTransfers','action'=>'indexAjax'));
$deleteUrl = $this->Html->url(array('controller'=>'PrisonerTransfers','action'=>'deleteTransfer'));
$forwardUrl = $this->Html->url(array('controller'=>'PrisonerTransfers','action'=>'forwardTransfer'));
$inTransferUrl = $this->Html->url(array('controller'=>'PrisonerTransfers','action'=>'setTransferInStatus'));
echo $this->Html->scriptBlock("

    function searchTransfer()
    {
        var url = '".$ajaxUrl."';
        var prisoner_id = $('#prisoner_id').val();
        var transfer_date = $('#transfer_date').val();
        if(prisoner_id == '' || transfer_date == '')
        { 
            if(prisoner_id == '')
            {
                $('#prisoner_id_err').removeClass('nodisplay');
            }
            else 
            {
                $('#prisoner_id_err').addClass('nodisplay');
            }
            if(transfer_date == '')
            {
                $('#transfer_date_err').removeClass('nodisplay');
            }
            else 
            {
                $('#transfer_date_err').addClass('nodisplay');
            }
        }
        else 
        {
            $.post(url, $('#SearchIndexForm').serialize(), function(res) {
                if (res) {
                    $('#listingDiv').html(res);
                }
            });
        }
        return false;
    }
   
    jQuery(function($) {
         showData();
    }); 
    
    function showData(){
        var url = '".$ajaxUrl."';
        var transfer_type = '".$transfer_type."';
        $.post(url, {'transfer_type':transfer_type}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        });
    }

    //delete transfer
    function deleteTransfer(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showData();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

    //forward transfer 
    function forwardTransfer(paramId, status){
        if(paramId){
            if(confirm('Are you sure to forward?')){
                var url = '".$forwardUrl."';
                $.post(url, {'paramId':paramId, 'status':status}, function(res) { 
                    if(res == 'SUCC'){
                        showData();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

    //In Transfer Status
    function changeInTransferStatus(paramId, status, displayStatus){
        if(paramId){
            if(confirm('Are you sure to '+displayStatus+'?')){
                var url = '".$inTransferUrl."';
                $.post(url, {'paramId':paramId, 'status':status}, function(res) { 
                    if(res == 'SUCC'){
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
