<div class="container-fluid"><hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> 
                    <h5>Prisoners</h5>
                    <div style="float:right;padding-top: 7px;">
                        <button type="button" class="btn btn-success btn-mini" data-toggle="modal" data-target="#myModal">Existing Prisoner</button>
                        <?php echo $this->Html->link('New Prisoner',array('action'=>'add'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Existing Prisoner</h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo $this->Form->create('existingPrisoner',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','url' => '/prisoners/existingPrisoner','onsubmit'=>"return isExistingPrisoner();"));?>
                                        <div class="row" style="padding-bottom: 14px;">
                                            <div class="span12">
                                                <div class="control-group">
                                                    <label class="control-label">Prisoner Number<?php echo $req; ?> :</label>
                                                    <div class="controls">
                                                        <?php echo $this->Form->input('prisoner_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Prisoner Number','required','id'=>'prisoner_no'));?>
                                                    </div>
                                                </div>
                                            </div>                  
                                        </div>
                                        <div class="form-actions" align="center" style="background:#fff;">
                                            <?php echo $this->Form->button('Continue', array('type'=>'submit', 'div'=>false,'label'=>false, 'class'=>'btn btn-success'))?>
                                        </div>
                                        <?php echo $this->Form->end();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $this->Form->create('Search',array('class'=>'form-horizontal'));?>
                    <div class="row" style="padding-bottom: 14px;">
                        <div class="span5">
                            <div class="control-group">
                                <label class="control-label">Prisoner No. :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('sprisoner_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Prisoner No.','id'=>'sprisoner_no'));?>
                                </div>
                            </div>
                        </div>
                        <div class="span5">
                            <div class="control-group">
                                <label class="control-label">Prisoner Name :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('prisoner_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Prisoner Name','id'=>'prisoner_name'));?>
                                </div>
                            </div>
                        </div>
                        <div class="span2" align="center" valign="center">
                            <?php echo $this->Form->button('Search', array('type'=>'button', 'div'=>false,'label'=>false, 'class'=>'btn btn-success', 'formnovalidate'=>true, 'onclick'=>'javascript:showData();'))?>
                        </div>                        
                    </div> 
                    <?php echo $this->Form->end();?> 
                     <div class="widget-content">
                        <div class="table-responsive" id="listingDiv">

                        </div>
                    </div>
                </div>                
                <div class="widget-content" id="listingDiv">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$ajaxUrl            = $this->Html->url(array('controller'=>'prisoners','action'=>'indexAjax'));
$finalSaveAjaxUrl       = $this->Html->url(array('controller'=>'prisoners','action'=>'finalSavePrisoner'));
$trashAjaxUrl       = $this->Html->url(array('controller'=>'prisoners','action'=>'trashPrisoner'));
$verifyAjaxUrl      = $this->Html->url(array('controller'=>'prisoners','action'=>'verifyPrisoner'));
$approveAjaxUrl     = $this->Html->url(array('controller'=>'prisoners','action'=>'approvePrisoner'));
echo $this->Html->scriptBlock("
    $(document).ready(function(){
        showData();
    });
    function showData(){
        var url = '".$ajaxUrl."';
        if($('#sprisoner_no').val() != ''){
            var prisoner_no = $('#sprisoner_no').val().replace('/', '-')
            url = url + '/prisoner_no:'+prisoner_no;
        }
        url = url + '/prisoner_name:'+$('#prisoner_name').val();
        $.post(url, {}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        });
    }
    function finalSavePrisoner(uuid){
        if(uuid){
            if(confirm('Are you sure to save finally?')){
                var url = '".$finalSaveAjaxUrl."';
                $.post(url, {'uuid':uuid}, function(res) {
                    if (res == 'SUCC') {
                        showData();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }
    function trashPrisoner(uuid){
        if(uuid){
            if(confirm('Are you sure to delete?')){
                var url = '".$trashAjaxUrl."';
                $.post(url, {'uuid':uuid}, function(res) {
                    if (res == 'SUCC') {
                        showData();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }
    function verifyPrisoner(uuid){
        if(uuid){
            if(confirm('Are you sure to verify?')){
                var url = '".$verifyAjaxUrl."';
                $.post(url, {'uuid':uuid}, function(res) { alert(res)
                    if (res == 'SUCC') {
                        showData();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }
    function approvePrisoner(uuid){ 
        if(uuid){
            if(confirm('Are you sure to approve?')){
                var url = '".$approveAjaxUrl."';
                $.post(url, {'uuid':uuid}, function(res) { alert(res)
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