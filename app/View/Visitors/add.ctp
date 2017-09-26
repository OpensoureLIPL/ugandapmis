<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
					<h5>Add New Record Visitors </h5>
					<div style="float:right;padding-top: 7px;">
						<?php echo $this->Html->link(__('Visitors Record List'), array('action' => 'index'), array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
						&nbsp;&nbsp;
					</div>
				</div>
				<div class="widget-content nopadding">
					<?php echo $this->Form->create('Visitor',array('class'=>'form-horizontal'));?>
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
								<label class="control-label">Prisoner Number <?php echo MANDATORY; ?> :</label>
								<div class="controls">
									<?php echo $this->Form->input('prisoner_no',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'select','options'=>$prisonerList, 'empty'=>'-- Select Prisoner Number --','required','id'=>'prisoner_no'));?>
								</div>
							</div>
						</div>
						</div>
					   <div class="row-fluid">
						<div class="span6">
							<div class="control-group">
								<label class="control-label">Visitor Name  :</label>
								<div class="controls">
									<?php echo $this->Form->text('visitor_name',array('div'=>false,'label'=>false,'placeholder'=>'Enter Visitor Name ','class'=>'form-control','required'));?>
								</div>
							</div>
						</div>
						<div class="span6">
							<div class="control-group">
								<label class="control-label">From<?php echo MANDATORY; ?> :</label>
								<div class="controls">
									<?php
									 echo $this->Form->textarea('from',array('div'=>false,'label'=>false,'placeholder'=>'Enter From','type'=>'text','class'=>'form-control','required'));?>
								</div>
							</div>
						</div>
						</div>
						<div class="row-fluid">
						<div class="span6">
							<div class="control-group">
								<label class="control-label">Purpose of Visit :</label>
								<div class="controls">
									<?php echo $this->Form->textarea('purpose_of_visit',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter Purpose of Visit','class'=>'form-control','required'));?>
								</div>
							</div>
						</div>
						 <div class="span6">
							<div class="control-group">
								<label class="control-label">Duration :</label>
								<div class="controls">
									<?php echo $this->Form->textarea('duration',array('div'=>false,'label'=>false,'placeholder'=>'Enter Duration','class'=>'form-control','required'));?>
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
</script>
