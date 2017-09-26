<?php
if(isset($this->data['InPrisonOffenceCapture']['offence_date']) && $this->data['InPrisonOffenceCapture']['offence_date'] != ''){
    $this->request->data['InPrisonOffenceCapture']['offence_date'] = date('d-m-Y', strtotime($this->data['InPrisonOffenceCapture']['offence_date']));
}

if(isset($this->data['InPrisonPunishment']['punishment_date']) && $this->data['InPrisonPunishment']['punishment_date'] != ''){
    $this->request->data['InPrisonPunishment']['punishment_date'] = date('d-m-Y', strtotime($this->data['InPrisonPunishment']['punishment_date']));
}
if(isset($this->data['InPrisonPunishment']['punishment_start_date']) && $this->data['InPrisonPunishment']['punishment_start_date'] != ''){
    $this->request->data['InPrisonPunishment']['punishment_start_date'] = date('d-m-Y', strtotime($this->data['InPrisonPunishment']['punishment_start_date']));
}
if(isset($this->data['InPrisonPunishment']['punishment_end_date']) && $this->data['InPrisonPunishment']['punishment_end_date'] != ''){
    $this->request->data['InPrisonPunishment']['punishment_end_date'] = date('d-m-Y', strtotime($this->data['InPrisonPunishment']['punishment_end_date']));
}
?>
<style>
.row-fluid [class*="span"]
{
  margin-left: 0px !important;
}
</style>
<div class="container-fluid">
    <div class="row-fluid">
         <div id="commonheader"></div>

        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                    <h5>Discipline Records</h5>
                    <div style="float:right;padding-top: 3px;">
                        <?php echo $this->Html->link('Prisoners List',array('controller'=>'prisoners','action'=>'index'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                        <ul class="nav nav-tabs">
                            <!-- <li><a href="#health_checkup">Health Checkup</a></li> -->
                            <li><a href="#offences" id="offencesDiv">Offences</a></li>
                            <li><a href="#punishments" id="punishmentsDiv">Punishments</a></li>
                           
                            
                            <!-- <li class="pull-right controls"> -->
                            <li class="controls pull-right">
                                <ul class="nav nav-tabs">
                                    <li><a href="#prev">&lsaquo; Prev</a></li>
                                    <li><a href="#next">Next &rsaquo;</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="tabscontent">
                            <!-- <div id="health_checkup">
                                
                            </div> -->
                            <div id="offences">
                                <?php echo $this->Form->create('InPrisonOffenceCapture',array('class'=>'form-horizontal','type'=>'file'));?>
                                <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('prisoner_id', array('type'=>'hidden', 'value'=>$prisoner_id))?>
                                <?php echo $this->Form->input('uuid', array('type'=>'hidden', ))?>
                                <div class="row" style="padding-bottom: 14px;">
                                  <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of Offence <?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('offence_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Offence','required','readonly'=>'readonly','id'=>'offence_date'));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Offence Name<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('internal_offence_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$offenceList, 'empty'=>'-- Select Offences --','required','id'=>'disease_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Offence Desciption<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('offence_descr',array('type'=>'textarea', 'div'=>false,'label'=>false,'class'=>'form-control','required','id'=>'treatment', 'cols'=>30, 'rows'=>3));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Offence Recorded By<?php echo $req; ?> :</label>
                                             <div class="controls">
                                                <?php echo $this->Form->input('offence_recorded_by',array('type'=>'text', 'div'=>false,'label'=>false,'class'=>'form-control','required','id'=>'offence_recorded_by'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                </div>
                                <div class="form-actions" align="center">
                                    <?php echo $this->Form->button('Add More', array('type'=>'submit', 'div'=>false,'label'=>false, 'class'=>'btn btn-success', 'formnovalidate'=>true, 'onclick'=>"javascript:return confirm('Are you sure to add more?')"))?>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div class="table-responsive" id="sickListingDiv">

                                </div>
                            </div>
                            <div id="punishments">
                                <?php echo $this->Form->create('InPrisonPunishment',array('','class'=>'form-horizontal','type'=>'file'));?>
                                <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('prisoner_id', array('type'=>'hidden', 'value'=>$prisoner_id))?>
                                <?php echo $this->Form->input('uuid', array('type'=>'hidden', ))?>
                                <div class="row" style="padding-bottom: 14px;">
                                  <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Punishment Date <?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('punishment_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Punishment  Date','required','readonly'=>'readonly',));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Offence Name<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('in_prison_offence_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$offencesList, 'empty'=>'-- Select Punishments --','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix"></div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Punishment <br/>Start Date <?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('punishment_start_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Punishment Start Date','required','readonly'=>'readonly'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Punishment <br/> End Date <?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('punishment_end_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Punishment End Date','required','readonly'=>'readonly'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div>
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Punishment Type<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('internal_punishment_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$punishmentsList, 'empty'=>'-- Select Offences --','required','id'=>'disease_id'));?>
                                            </div>
                                        </div>
                                    </div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Remarks <?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('remarks',array('type'=>'textarea', 'div'=>false,'label'=>false,'class'=>'form-control','required','id'=>'remarks', 'cols'=>30, 'rows'=>3));?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix"></div> 
                                </div>
                                <div class="form-actions" align="center">
                                    <?php echo $this->Form->button('Add More', array('type'=>'submit', 'div'=>false,'label'=>false, 'class'=>'btn btn-success', 'formnovalidate'=>true, 'onclick'=>"javascript:return confirm('Are you sure to add more?')"))?>
                                </div>
                                <?php echo $this->Form->end();?>

                                 <div class="table-responsive" id="punishmentsDivs">

                                </div>             
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$commonHeaderUrl    = $this->Html->url(array('controller'=>'Prisoners','action'=>'getCommonHeder'));
$offenceUrl         = $this->Html->url(array('controller'=>'InPrisonOffenceCapture','action'=>'indexAjax'));
$deleteoffenceUrl   = $this->Html->url(array('controller'=>'InPrisonOffenceCapture','action'=>'deleteOffences'));
$punishmentsUrl   = $this->Html->url(array('controller'=>'InPrisonOffenceCapture','action'=>'showPunishmentsRecords'));
$deletePunishmentsUrl   = $this->Html->url(array('controller'=>'InPrisonOffenceCapture','action'=>'deletePunishmentsRecords'));

echo $this->Html->scriptBlock("
    var tab_param = '';
    var tabs;
    jQuery(function($) {
        tabs = $('.tabscontent').tabbedContent({loop: true}).data('api');
        // Next and prev actions
        $('.controls a').on('click', function(e) {
            var action = $(this).attr('href').replace('#', ''); 
            tabs[action]();
            e.preventDefault();
        });
        showOffenceRecords(); 
        showCommonHeader();
       // showCommonHeader();
        $('#offencesDiv').on('click', function(e){
            console.log('clicked');
           showOffenceRecords();
        });
        $('#punishmentsDiv').on('click', function(e){
            showPunishmentRecords();
        });
        
        var cururl = window.location.href;
        var urlArr = cururl.split('/');
        var param = '';
        for(var i=0; i<urlArr.length;i++){
            param = urlArr[i];
        }
        if(param != ''){
            var paramArr = param.split('#');
            for(var i=0; i<paramArr.length;i++){
                tab_param    = paramArr[i];
            }
        }
        console.log(tab_param);
        if(tab_param == 'offences'){
            showOffenceRecords();
        }else if(tab_param == 'punishments'){
            showPunishmentRecords();
        }
    });
    function showOffenceRecords(){
        var prisoner_id = ".$prisoner_id.";
        var uuid        = '".$uuid."';
        var url         = '".$offenceUrl."';
        url = url + '/prisoner_id:'+prisoner_id;
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            if (res) {
                $('#sickListingDiv').html(res);
            }
        }); 
    }
    function deleteOffenceRecords(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteoffenceUrl."';
                $.post(url, {'paramId':paramId}, function(res) {
                    if(res == 'SUCC'){
                        showOffenceRecords();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }
    function showPunishmentRecords(){
        var prisoner_id = ".$prisoner_id.";
        var uuid        = '".$uuid."';
        var url         = '".$punishmentsUrl."';
        url             = url + '/prisoner_id:'+prisoner_id;
        url             = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            if (res) {
                $('#punishmentsDivs').html(res);
            }
        });         
    }
    function deletePunishmentRecords(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deletePunishmentsUrl."';
                $.post(url, {'paramId':paramId}, function(res) {
                    if(res == 'SUCC'){
                        showPunishmentRecords();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }
//common header
    function showCommonHeader(){
        var prisoner_id = ".$prisoner_id.";;
        console.log(prisoner_id);  
        var uuid        = '".$uuid."';
        var url         = '".$commonHeaderUrl."';
        url = url + '/prisoner_id:'+prisoner_id;
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
           
            if (res) {
                $('#commonheader').html(res);
            }
        }); 
    }
    
",array('inline'=>false));


?> 