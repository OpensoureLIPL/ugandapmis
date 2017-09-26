<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
					<h5>
					<?php
					if(isset($this->request->data['Shift']['id']) && ($this->request->data['Shift']['id'] != 0))
					{
						echo 'Edit Shift Deployment';
					}
					else 
					{
						echo 'Add Shift Deployment';
					}
					?>
					</h5>
					<div style="float:right;padding-top: 7px;">
						<?php echo $this->Html->link(__('Shift Deployment List'), array('action' => 'index'), array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
						&nbsp;&nbsp;
					</div>
				</div>
				<div class="widget-content nopadding">
					<?php echo $this->Form->create('ShiftDeployment',array('class'=>'form-horizontal'));?>
					<?php echo $this->Form->input('id', array('type'=>'hidden'))?>
						<div class="row-fluid">
							  
							<div class="span6">
								<div class="control-group">
									<label class="control-label">Shift Id<?php echo MANDATORY; ?>:</label>
									<div class="controls">
										<?php echo $this->Form->input('shift_id',array('div'=>false,'label'=>false,'type'=>'select','options'=>$shiftList,'empty'=>'-- Select Shift --','placeholder'=>'Select Shift','class'=>'form-control','required'));?>
									</div>
								</div>
							</div>
							<div class="span6">
	                            <div class="control-group">
	                                <label class="control-label">Force <?php echo $req; ?> :</label>
	                                <div class="controls">
	                                    <?php echo $this->Form->input('force_id',array('div'=>false,'label'=>false,'type'=>'select','options'=>$forceList,'empty'=>'-- Select Force Id --','placeholder'=>'Select Force Id','class'=>'form-control','required'));?>
	                                </div>
	                            </div>
	                        </div> 
                        	<div class="clear"></div>
                        	<div class="row-fluid"> 
                        	<div class="span6">
	                            <div class="control-group">
	                                <label class="control-label">Date<?php echo $req; ?> :</label>
	                                <div class="controls">
	                                    <?php echo $this->Form->input('shift_date',array('div'=>false,'label'=>false,	'type'=>'text','class'=>'mydate','data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','required'));?>
	                                </div>
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
	$('.datetimepicker').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss',today:'true',endDate:today});
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
