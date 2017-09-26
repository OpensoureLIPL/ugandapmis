<?php
if(isset($this->data['MedicalSickRecord']['check_up_date']) && $this->data['MedicalSickRecord']['check_up_date'] != ''){
    $this->request->data['MedicalSickRecord']['check_up_date'] = date('d-m-Y', strtotime($this->data['MedicalSickRecord']['check_up_date']));
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
                    <h5>Add New Medical Records</h5>
                    <div style="float:right;padding-top: 3px;">
                        <?php echo $this->Html->link('Prisoners List',array('controller'=>'prisoners','action'=>'index'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                        <ul class="nav nav-tabs">
                            <li><a href="#health_checkup" id="medicalChekupDiv">Health Checkup</a></li>
                            <li><a href="#sick" id="medicalSickDiv">Sick</a></li>
                            <li><a href="#seriouslyill" id="medicalSeriousIllDiv">Seriously Ill</a></li>
                            <li><a href="#death" id="medicalDeathDiv">Death</a></li>
                            
                            <!-- <li class="pull-right controls"> -->
                            <li class="controls pull-right">
                                <ul class="nav nav-tabs">
                                    <li><a href="#prev">&lsaquo; Prev</a></li>
                                    <li><a href="#next">Next &rsaquo;</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="tabscontent">
                            <div id="health_checkup">
                                      <?php echo $this->Form->create('MedicalCheckupRecord',array('class'=>'form-horizontal','type'=>'file'));?>
                                <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('uuid', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('prisoner_id', array('type'=>'hidden', 'value'=>$prisoner_id))?>
                                <div class="row" style="padding-bottom: 14px;">
                                  <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Checkup Date Time<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('checkup_date_time',array('div'=>false,'label'=>false,'class'=>'form-control datetimepicker span11','type'=>'text', 'placeholder'=>'Enter Date of Checkup','required','readonly'=>'readonly','id'=>'check_up_date'));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Medical Officer<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('medical_officer_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$medicalOfficers, 'empty'=>'-- Select Medical Officers --','required','id'=>'disease_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Checkup Details<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('check_up_details',array('type'=>'textarea', 'div'=>false,'label'=>false,'class'=>'form-control','required','id'=>'treatment', 'cols'=>30, 'rows'=>3));?>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Supported Files:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('supported_files',array('type'=>'file','div'=>false,'label'=>false,'class'=>'form-control','required','id'=>'supported_files'));?>
                                                <br /><span>(upload jpg,jpeg,png,gif,pdf type file)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                </div>
                                <div class="form-actions" align="center">
                                    <?php echo $this->Form->button('Add More', array('type'=>'submit', 'div'=>false,'label'=>false, 'class'=>'btn btn-success', 'formnovalidate'=>true, 'onclick'=>"javascript:return confirm('Are you sure to add more?')"))?>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div class="table-responsive" id="checkupListingDiv">

                                </div>
                            </div> 
                            <div id="sick">
                                <?php echo $this->Form->create('MedicalSickRecord',array('class'=>'form-horizontal','type'=>'file'));?>
                                <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('uuid', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('prisoner_id', array('type'=>'hidden', 'value'=>$prisoner_id))?>
                                <div class="row" style="padding-bottom: 14px;">
                                  <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of checkup<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('check_up_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Checkup','required','readonly'=>'readonly'));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Diseases<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('disease_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$diseaseList, 'empty'=>'-- Select Deseases --','required','id'=>'disease_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Treatment<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('treatment',array('type'=>'textarea', 'div'=>false,'label'=>false,'class'=>'form-control','required','id'=>'treatment', 'cols'=>30, 'rows'=>3));?>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Attachment<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('attachment',array('type'=>'file','div'=>false,'label'=>false,'class'=>'form-control','required','id'=>'attachment'));?>
                                                <br /><span>(upload jpg,jpeg,png,gif,pdf type file)</span>
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
                            <div id="seriouslyill">
                                <?php echo $this->Form->create('MedicalSeriousIllRecord',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                                <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('uuid', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('prisoner_id', array('type'=>'hidden', 'value'=>$prisoner_id))?>
                                <div class="row" style="padding-bottom: 14px;">
                                  <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of checkup<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('check_up_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Checkup','required','readonly'=>'readonly'));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Deseases<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('disease_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$diseaseList, 'empty'=>'-- Select Deseases --','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Hospital<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('hospital_id',array('type'=>'select', 'div'=>false,'label'=>false,'class'=>'form-control','required','id'=>'hospital_id', 'empty'=>'--Select Hospital--', 'options'=>$hospitalList));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Remarks :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('remark',array('type'=>'textarea', 'div'=>false,'label'=>false,'class'=>'form-control','required', 'cols'=>30, 'rows'=>3));?>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-actions" align="center">
                                    <?php echo $this->Form->button('Add More', array('type'=>'submit', 'div'=>false,'label'=>false,'formnovalidate'=>true, 'class'=>'btn btn-success', 'onclick'=>"javascript:return confirm('Are you sure to add more?')"))?>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div class="table-responsive" id="seriousIllListingDiv">

                                </div>                                
                            </div>
                            <div id="death">
                                <?php echo $this->Form->create('MedicalDeathRecord',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                                <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('uuid', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('prisoner_id', array('type'=>'hidden', 'value'=>$prisoner_id))?>                                
                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Cause Of Death<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('death_cause',array('type'=>'text', 'div'=>false,'label'=>false,'class'=>'form-control','required','id'=>'cause', 'cols'=>30, 'rows'=>3));?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of Death<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('check_up_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Death','required','readonly'=>'readonly'));?>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="clearfix"></div>                           
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Place Of Death<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('death_place',array('type'=>'textarea', 'div'=>false,'label'=>false,'class'=>'form-control','required','id'=>'death_place', 'cols'=>30,'rows'=>3));?>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Pathologist Sign<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('pathologist_attach',array('type'=>'file', 'div'=>false,'label'=>false,'class'=>'form-control','required'));?>
                                                <br /><span>(upload jpg,jpeg,png,gif,pdf type file)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>                           
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Medical Officer<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('medical_officer',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','required'=>false));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Supported Files<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('attachment',array('type'=>'file', 'div'=>false,'label'=>false,'class'=>'form-control','required'=>false));?>
                                                <br /><span>(upload jpg,jpeg,png,gif,pdf type file)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-actions" align="center">
                                    <?php echo $this->Form->button('Save', array('type'=>'submit', 'div'=>false,'label'=>false,'class'=>'btn btn-success', 'onclick'=>"javascript:return confirm('Are you sure to save?')"))?>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div class="table-responsive" id="deathListingDiv"></div>
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
$medicalChekupUrl         = $this->Html->url(array('controller'=>'medicalRecords','action'=>'medicalCheckupData'));
$deleteMedicalChekupUrl   = $this->Html->url(array('controller'=>'medicalRecords','action'=>'deleteMedicalCheckupRecords'));
$medicalSickUrl         = $this->Html->url(array('controller'=>'medicalRecords','action'=>'medicalSickData'));
$deleteMedicalSickUrl   = $this->Html->url(array('controller'=>'medicalRecords','action'=>'deleteMedicalSickRecords'));
$medicalSeriousIllUrl   = $this->Html->url(array('controller'=>'medicalRecords','action'=>'showMedicalSeriousIllRecords'));
$deleteMedicalSeriUrl   = $this->Html->url(array('controller'=>'medicalRecords','action'=>'deleteMedicalSeriousillRecords'));
$medicalDeathUrl        = $this->Html->url(array('controller'=>'medicalRecords','action'=>'showMedicalDeathRecords'));
$deleteMedicalDeathUrl  = $this->Html->url(array('controller'=>'medicalRecords','action'=>'deleteMedicalDeathRecords'));
echo $this->Html->scriptBlock("
    var tab_param = '';
    var tabs;
    jQuery(function($) {

        showCommonHeader();

        tabs = $('.tabscontent').tabbedContent({loop: true}).data('api');
        // Next and prev actions
        $('.controls a').on('click', function(e) {
            var action = $(this).attr('href').replace('#', ''); 
            tabs[action]();
            e.preventDefault();
        });
        showMedicalChekupRecords();
        //showMedicalSickRecords();
        $('#medicalChekupDiv').on('click', function(e){
           showMedicalChekupRecords();
        }); 
        $('#medicalSickDiv').on('click', function(e){
           showMedicalSickRecords();
        });
        $('#medicalSeriousIllDiv').on('click', function(e){
            showMedicalSeriousIllRecords();
        });
        $('#medicalDeathDiv').on('click', function(e){
            showMedicalDeathRecords();
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
        if(tab_param == 'sick'){
            showMedicalSickRecords();
        }else if(tab_param == 'seriouslyill'){
            showMedicalSeriousIllRecords();
        }else if(tab_param == 'death'){
            showMedicalDeathRecords();
        }
          
    });
    function showMedicalChekupRecords()
    {
        var prisoner_id = ".$prisoner_id.";
        var uuid        = '".$uuid."';
        var url         = '".$medicalChekupUrl."';
        url = url + '/prisoner_id:'+prisoner_id;
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            if (res) {
                $('#checkupListingDiv').html(res);
            }
        }); 
    }
    function deleteMedicalChekupRecord(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteMedicalChekupUrl."';
                $.post(url, {'paramId':paramId}, function(res) {
                    if(res == 'SUCC'){
                        showMedicalChekupRecords();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }
    function showMedicalSickRecords(){
        var prisoner_id = ".$prisoner_id.";
        var uuid        = '".$uuid."';
        var url         = '".$medicalSickUrl."';
        url = url + '/prisoner_id:'+prisoner_id;
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            if (res) {
                $('#sickListingDiv').html(res);
            }
        }); 
    }
    function deleteMedicalSickRecords(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteMedicalSickUrl."';
                $.post(url, {'paramId':paramId}, function(res) {
                    if(res == 'SUCC'){
                        showMedicalSickRecords();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }
    function showMedicalSeriousIllRecords(){
        var prisoner_id = ".$prisoner_id.";
        var uuid        = '".$uuid."';
        var url         = '".$medicalSeriousIllUrl."';
        url = url + '/prisoner_id:'+prisoner_id;
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            if (res) {
                $('#seriousIllListingDiv').html(res);
            }
        });         
    }
    function deleteMedicalSeriousillRecords(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteMedicalSeriUrl."';
                $.post(url, {'paramId':paramId}, function(res) {
                    if(res == 'SUCC'){
                        showMedicalSeriousIllRecords();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }
    function showMedicalDeathRecords(){
        var prisoner_id = ".$prisoner_id.";
        var uuid        = '".$uuid."';
        var url         = '".$medicalDeathUrl."';
        url = url + '/prisoner_id:'+prisoner_id;
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            if (res) {
                $('#deathListingDiv').html(res);
            }
        });        
    }
    function deleteMedicalDeathRecords(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteMedicalDeathUrl."';
                $.post(url, {'paramId':paramId}, function(res) {
                    if(res == 'SUCC'){
                        showMedicalDeathRecords();
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
        //console.log(prisoner_id);  
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
<script>
    

     $('.datetimepicker').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});
</script>