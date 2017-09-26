<?php
if(isset($this->data['Courtattendance']['attendance_date']) && $this->data['Courtattendance']['attendance_date'] != ''){
    $this->request->data['Courtattendance']['attendance_date'] = date('d-m-Y', strtotime($this->data['Courtattendance']['attendance_date']));
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
                    <h5>Court Attendance Records</h5>
                    <div style="float:right;padding-top: 3px;">
                        <?php echo $this->Html->link('Prisoners List',array('controller'=>'prisoners','action'=>'index'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                        <?php echo $this->Form->create('Courtattendance',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                        <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                        <?php echo $this->Form->input('uuid', array('type'=>'hidden'))?>
                        <div class="row" style="padding-bottom: 14px;">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Production <br/>Warrent No<?php echo $req; ?> :</label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('production_warrent_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Production Warrent No','id'=>'production_warrent_no'));?>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                               <div class="control-group">
                                    <label class="control-label">Schedule Date<?php echo $req; ?> :</label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('attendance_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Schedule Date ','required','readonly'=>'readonly','id'=>'attendance_date'));?>
                                    </div>
                                </div>
                            </div> 
                            <div class="clearfix"></div> 
                            <div class="span6">
                               <div class="control-group">
                                    <label class="control-label">Schedule Time<?php echo $req; ?> :</label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('attendance_time',array('div'=>false,'label'=>false,'class'=>'form-control span11 mytime','type'=>'text', 'placeholder'=>'Enter Schedule Time ','required','readonly'=>'readonly','id'=>'attendance_time'));?>
                                    </div>
                                </div>
                            </div>                                     
                            <div class="span6">
                               <div class="control-group">
                                    <label class="control-label">Magisterial Area<?php echo $req; ?> :</label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('magisterial_id',array('div'=>false,'label'=>false,'type'=>'select','empty'=>'-- Select Magisterial Area --','options'=>$magestrilareaList, 'class'=>'form-control','required', 'id'=>'magisterial_id'));?>
                                    </div>
                                </div>
                            </div>                              
                            <div class="clearfix"></div>     
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Court<?php echo $req; ?> :</label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('court_id',array('div'=>false,'label'=>false,'type'=>'select','empty'=>'--Select Court--','options'=>$courtList, 'class'=>'form-control','required', 'id'=>'court_id'));?>
                                    </div>
                                </div>
                            </div>                                                           
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">Case No.<?php echo $req; ?> :</label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('case_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','required','id'=>'case_no'));?>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>  
                        </div>
                        <div class="form-actions" align="center">
                            <?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit', 'formnovalidate'=>true))?>
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
$courtAjaxUrl   = $this->Html->url(array('controller'=>'courtattendances','action'=>'getCourtByMagisterial'));
$ajaxUrl        = $this->Html->url(array('controller'=>'courtattendances','action'=>'indexAjax'));
$commonHeaderUrl    = $this->Html->url(array('controller'=>'Prisoners','action'=>'getCommonHeder'));
echo $this->Html->scriptBlock("
    $(document).ready(function(){

        showCommonHeader();

        $('#magisterial_id').on('change', function(e){
            var url = '".$courtAjaxUrl."';
            $.post(url, {'magisterial_id':$('#magisterial_id').val()}, function(res){
                $('#court_id').html(res);
            });
        });
        showData();
    });
    function showData(){
        var url   = '".$ajaxUrl."';
        var uuid  = '".$uuid."';
        url = url + '/production_warrent_no:'+$('#production_warrent_no').val();
        url = url + '/attendance_date:'+$('#attendance_date').val();
        url = url + '/attendance_time:'+$('#attendance_time').val();
        url = url + '/magisterial_id:'+$('#magisterial_id').val();
        url = url + '/court_id:'+$('#court_id').val();
        url = url + '/case_no:'+$('#case_no').val();
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
            $('#listingDiv').html(res);
        });           
    }
     $('.mytime').datetimepicker({ dateFormat: 'yy-mm-dd' });

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