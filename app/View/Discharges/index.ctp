<?php
if(isset($this->data['GatePass']['gp_date']) && $this->data['GatePass']['gp_date'] != ''){
    $this->request->data['GatePass']['gp_date'] = date('d-m-Y', strtotime($this->data['GatePass']['gp_date']));
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
                    <h5>Discharge Records</h5>
                    <div style="float:right;padding-top: 3px;">
                        <?php echo $this->Html->link('Prisoners List',array('controller'=>'prisoners','action'=>'index'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                        <ul class="nav nav-tabs">
                            <li><a href="#discharge_prisoner" id="discharge_prisoner_div">Discharge Prisoner</a></li>
                            <li><a href="#gate_pass" id="gate_pass_div">Gate Pass</a></li>
                            <li><a href="#death_in_custody" id="death_in_custody_div">Death In Custody</a></li>
                            <li><a href="#discharge_on_escape" id="discharge_on_escape_div">Discharge On Escape</a></li>
                            <!-- <li class="pull-right controls"> -->
                            <li class="controls pull-right">
                                <ul class="nav nav-tabs">
                                    <li><a href="#prev">&lsaquo; Prev</a></li>
                                    <li><a href="#next">Next &rsaquo;</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="tabscontent">
                            <div id="discharge_prisoner">
                                <?php echo $this->Form->create('Discharge',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                                <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('uuid', array('type'=>'hidden'))?>    
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of Discharge <?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_discharge',array('type'=>'text', 'div'=>false,'label'=>false,'placeholder'=>'Enter Date of Discharge','readonly'=>'readonly','class'=>'form-control mydate','required', 'id'=>'date_of_discharge'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Discharge Type<?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('discharge_type_id',array('type'=>'select', 'div'=>false,'label'=>false,'type'=>'select','empty'=>'--Select Discharge type--','options'=>$dischargetypeList,'class'=>'form-control','required', 'id'=>'discharge_type_id'));?>
                                            </div>
                                        </div>
                                    </div>                            
                                </div> 
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Finger Print<?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('finger_print',array('type'=>'file', 'div'=>false,'label'=>false,'class'=>'form-control','required'));?>
                                            </div>
                                        </div>
                                    </div>                     
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Signature <?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('signature',array('type'=>'file', 'div'=>false,'label'=>false,'class'=>'form-control','required'));?>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Supported Docs <?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('attachment',array('type'=>'file', 'div'=>false,'label'=>false,'class'=>'form-control','required'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                </div>
                                <div class="form-actions" align="center">
                                    <?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true))?>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div class="table-responsive" id="listingDiv"></div>
                            </div> 
                            <div id="gate_pass">
                                <?php echo $this->Form->create('GatePass',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                                <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('uuid', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('is_nable', array('type'=>'hidden','value'=>1))?>
                                <?php 
                                echo $this->Form->input('prisoner_uuid',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_uuid',
                                        'value'=>$uuid
                                      ));
                                ?>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Escort <?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('escort',array('type'=>'text', 'div'=>false,'label'=>false,'placeholder'=>'Enter Escort','class'=>'form-control span11','required', 'id'=>'escort'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Destination <?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('destination',array('type'=>'text', 'div'=>false,'label'=>false,'placeholder'=>'Enter Escort','class'=>'form-control span11','required', 'id'=>'destination'));?>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date<?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('gp_date',array('type'=>'text', 'div'=>false,'label'=>false,'placeholder'=>'Select Date','readonly'=>'readonly','class'=>'form-control mydate span11','required', 'id'=>'gp_date'));?>
                                            </div>
                                        </div>
                                    </div>                     
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Purpose <?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('purpose',array('type'=>'textarea', 'div'=>false,'label'=>false,'placeholder'=>'Enter Escort','class'=>'form-control span11','required', 'id'=>'purpose','rows'=>2));?>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="form-actions" align="center">
                                    <?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true))?>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div class="table-responsive" id="gatePassListingDiv"></div>
                            </div>
                            <div id="death_in_custody">
                                <?php echo $this->Form->create('DeathInCustody',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                                <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('uuid', array('type'=>'hidden'))?>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of Death <?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_death',array('type'=>'text', 'div'=>false,'label'=>false,'placeholder'=>'Select Date of Death','readonly'=>'readonly','class'=>'form-control mydate','required', 'id'=>'date_of_death'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Place Of Death :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('place_of_death',array('type'=>'text', 'div'=>false,'label'=>false,'class'=>'form-control','required', 'id'=>'place_of_death'));?>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Pathologist Signeture :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('pathologist_sign',array('type'=>'file', 'div'=>false,'label'=>false,'class'=>'form-control','required'));?>
                                            </div>
                                        </div>
                                    </div>                     
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Cause Of Death :</label>
                                            <div class="controls">
                                               <?php echo $this->Form->textarea('cause_death',array('div'=>false,'label'=>false,'class'=>'form-control','required', 'id'=>'cause_death'));?>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Medical Officer  :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('medical_officer_id',array('type'=>'select', 'div'=>false,'label'=>false,'type'=>'select','empty'=>'--Select Medical Officer--','options'=>$medicalOfficers,'class'=>'form-control','required', 'id'=>'medicalOfficers'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                </div>
                                <div class="form-actions" align="center">
                                    <?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true))?>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div class="table-responsive" id="DeathInCustodyListingDiv"></div>
                            </div>
                            <div id="discharge_on_escape">
                                <?php echo $this->Form->create('DischargeEscape',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                                <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                                <?php echo $this->Form->input('uuid', array('type'=>'hidden'))?>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of Escape <?php echo MANDATORY; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_escape',array('type'=>'text', 'div'=>false,'label'=>false,'placeholder'=>'Enter Date of Escape','readonly'=>'readonly','class'=>'form-control mydate span11','required', 'id'=>'date_of_escape'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Time of Escape :</label>
                                            <div class="controls">
                                               <?php echo $this->Form->input('time_of_escape',array('div'=>false,'label'=>false,'class'=>'form-control span11 mytime','type'=>'text', 'placeholder'=>'Enter Schedule Time ','required','readonly'=>'readonly','id'=>'attendance_time'));?>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Place :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('place',array('type'=>'text', 'div'=>false,'label'=>false,'class'=>'form-control span11','required', 'id'=>'place_of_death'));?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Sentences :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('sentence_id',array('type'=>'select', 'div'=>false,'label'=>false,'type'=>'select','empty'=>'--Select Sentences--','options'=>$sentences,'class'=>'form-control span11','required', 'id'=>'medicalOfficers'));?>
                                            </div>
                                        </div>
                                    </div>                     
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Person from whose custody escaped :</label>
                                            <div class="controls">
                                               <?php echo $this->Form->textarea('person_whom_custody_escaped',array('div'=>false,'label'=>false,'class'=>'form-control span11','required', 'id'=>'cause_death'));?>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Escaped from inside or outside :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('escaped_inside_outside',array('type'=>'text', 'div'=>false,'label'=>false,'class'=>'form-control span11','required', 'id'=>'escaped_inside_outside'));?>
                                            </div>
                                        </div>
                                    </div>                     
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of Recapture :</label>
                                            <div class="controls">
                                               <?php echo $this->Form->input('date_of_recapture',array('type'=>'text', 'div'=>false,'label'=>false,'placeholder'=>'Enter Date of recapture','readonly'=>'readonly','class'=>'form-control mydate span11','required', 'id'=>'date_of_recapture'));?>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row-fluid">
                                    <!-- <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Sentences :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('sentence_id',array('type'=>'select', 'div'=>false,'label'=>false,'type'=>'select','empty'=>'--Select Sentences--','options'=>$sentences,'class'=>'form-control span11','required', 'id'=>'medicalOfficers'));?>
                                            </div>
                                        </div>
                                    </div>  -->
                                    <div class="clearfix"></div> 
                                </div>
                                <div class="form-actions" align="center">
                                    <?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true))?>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div class="table-responsive" id="DischargeOnEscapeListingDiv"></div>                     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$ajaxUrl        = $this->Html->url(array('controller'=>'discharges','action'=>'indexAjax'));
$gatepassajaxUrl        = $this->Html->url(array('controller'=>'discharges','action'=>'gatepassAjax'));
$commonHeaderUrl    = $this->Html->url(array('controller'=>'Prisoners','action'=>'getCommonHeder'));
$deathincustodyajaxUrl = $this->Html->url(array('controller'=>'discharges','action'=>'DeathInCustodyAjax'));
$dischargeonescapeajaxUrl = $this->Html->url(array('controller'=>'discharges','action'=>'DischargeEscapeAjax'));
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
        showDischargePrisoner();
        $('#discharge_prisoner_div').on('click', function(e){
           showDischargePrisoner();
        }); 
        showGatePass();
        $('#gate_pass_div').on('click', function(e){
           showGatePass();
        });
        showDeathInCustody();
        $('#death_in_custody_div').on('click', function(e){
           showDeathInCustody();
        });
        showDischargeOnEscape();
        $('#discharge_on_escape_div').on('click', function(e){
           showDischargeOnEscape();
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
        if(tab_param == 'discharge_prisoner'){
            showDischargePrisoner();
        }else if(tab_param == 'gate_pass'){
            showGatePass();
        }else if(tab_param == 'death_in_custody'){
            showDeathInCustody();
        }
        else if(tab_param == 'discharge_on_escape'){
            showDischargeOnEscape();
        }
          
    });

    //show data discharge in custody 
    function showDischargeOnEscape(){
        var url   = '".$dischargeonescapeajaxUrl."';
        var uuid  = '".$uuid."';
        //url = url + '/date_of_escape:'+$('#date_of_escape').val();
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            $('#DischargeOnEscapeListingDiv').html(res);
        });           
    }

    //show death in custody 
    function showDeathInCustody(){
        var url   = '".$deathincustodyajaxUrl."';
        var uuid  = '".$uuid."';
        //url = url + '/date_of_death:'+$('#date_of_death').val();
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            $('#DeathInCustodyListingDiv').html(res);
        });           
    }
    
    //show gate pass record
    function showGatePass(){
        var url   = '".$gatepassajaxUrl."';
        var uuid  = '".$uuid."';
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            $('#gatePassListingDiv').html(res);
        });           
    }

    function showDischargePrisoner(){
        var url   = '".$ajaxUrl."';
        var uuid  = '".$uuid."';
        url = url + '/date_of_discharge:'+$('#date_of_discharge').val();
        url = url + '/discharge_type_id:'+$('#discharge_type_id').val();
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            $('#listingDiv').html(res);
        });           
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