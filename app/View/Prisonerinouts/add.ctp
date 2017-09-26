<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
					<h5>Add New Record Prisoner In/out </h5>
					<div style="float:right;padding-top: 7px;">
						<?php echo $this->Html->link(__('Prisoner in/out Record List'), array('action' => 'index'), array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
						&nbsp;&nbsp;
					</div>
				</div>
				<div class="widget-content nopadding">
					<?php echo $this->Form->create('Prisonerinout',array('class'=>'form-horizontal'));?>
					<?php echo $this->Form->input('id', array('type'=>'hidden'))?>
						<div class="row-fluid">
							<div class="span6">
								<div class="control-group">
									<label class="control-label">Date<?php echo MANDATORY; ?> :</label>
									<div class="controls">
									   <?php
								echo $this->Form->input('date',array(
								  'div'=>false,
								  'label'=>false,
								  'type'=>'text',
								  'class'=>'datepicker',
								  'data-date-format'=>"dd-mm-yyyy",
								  'readonly'=>'readonly',
								  'required',
								));
							 ?>
									</div>
								</div>
							</div>     
							<div class="span6">
								<div class="control-group">
									<label class="control-label">Prisoner Number<?php echo MANDATORY; ?>:</label>
									<div class="controls">
										<?php echo $this->Form->input('prisoner_no',array('div'=>false,'label'=>false,'onChange'=>'getPrisonerStationInfo(this.value)','class'=>'form-control','type'=>'select','options'=>$prisonerList, 'empty'=>'-- Select Prisoner Number --','required','id'=>'prisoner_no'));?>
								</div>
								</div>
							</div>
						</div>
					   <div class="row-fluid">
						<div class="span6">
							<div class="control-group">
								<label class="control-label">Prisoner Name <?php echo MANDATORY; ?> :</label>
								<div class="controls">
									<?php echo $this->Form->input('name',array('div'=>false,'label'=>false,'placeholder'=>'Enter Name','class'=>'form-control','required','id'=>'name','readonly'));?>
								</div>
							</div>
						</div>
						<div class="span6">
							<div class="control-group">
								<label class="control-label">Time Out<?php echo MANDATORY; ?> :</label>
								<div class="controls">
									<?php
									 echo $this->Form->input('time_out',array('div'=>false,'label'=>false,'placeholder'=>'Enter Time  Out','type'=>'text','class'=>'datetimepicker form-control','required'));?>
								</div>
							</div>
						</div>
						</div>
						<div class="row-fluid">
						<div class="span6">
							<div class="control-group">
								<label class="control-label">Destination<?php echo MANDATORY; ?> :</label>
								<div class="controls">
									<?php echo $this->Form->input('destination',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter destination','class'=>'form-control','required'));?>
								</div>
							</div>
						</div>
						 <div class="span6">
							<div class="control-group">
								<label class="control-label">Staff Escort Details<?php echo MANDATORY; ?> :</label>
								<div class="controls">
									<?php echo $this->Form->textarea('staff_escort_details',array('div'=>false,'label'=>false,'placeholder'=>'Enter Staff Escort Details ','class'=>'form-control','required'));?>
								</div>
							</div>
						</div>
						</div>
						<div class="row-fluid">
						<div class="span6">
							<div class="control-group">
								<label class="control-label">Gate Pass number<?php echo MANDATORY; ?> :</label>
								<div class="controls">
									<?php echo $this->Form->input('gate_pass_no',array('div'=>false,'label'=>false,'placeholder'=>'Enter Gate Pass Number','class'=>'form-control','required'));?>
								</div>
							</div>
						</div>
						<div class="span6">
							<div class="control-group">
								<label class="control-label">Gate Keeper Name<?php echo MANDATORY; ?> :</label>
								<div class="controls">
									<?php echo $this->Form->input('gate_keeper_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$gateKeepers,'empty'=>'---Select Gate Keeper---','placeholder'=>'Select Gate Keeper','id'=>'first_name'));?>
								</div>
							</div>
						</div>
						
						</div>
						<div class="row-fluid">
						
						 <div class="span6">
							<div class="control-group">
								<label class="control-label">Reason :</label>
								<div class="controls">
									<?php echo $this->Form->textarea('reason',array('div'=>false,'label'=>false,'placeholder'=>'Enter Reason ','class'=>'form-control','required'));?>
								</div>
							</div>
						</div>
						</div>
						
					<div class="form-actions" align="center">
						<?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true,'onclick'=>"javascript:return validateForm();"))?>
					</div>
					<?php echo $this->Form->end();?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
	$('.datetimepicker').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});
	if($('#prisoner_no').val() != '')
	{
		getPrisonerStationInfo($('#prisoner_no').val());
	}
});

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
function getPrisonerStationInfo(id) 
{ 
    $('#name').val('');
    if(id != '')
    {
        var strURL = '<?php echo $this->Html->url(array('controller'=>'app','action'=>'getPrisonerStationInfo'));?>';
    
        $.post(strURL,{"prisoner_id":id},function(data){  
            
            if(data) { 

                var obj = jQuery.parseJSON(data);
                $('#name').val(obj.prisoner_name);
            }
        });
    }
}
</script>
