<style>
.row-fluid [class*="span"]
{
  margin-left: 0px !important;
}
</style>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                    <h5>Add New Menu</h5>
                    <div style="float:right;padding-top: 3px;">
                        <?php echo $this->Html->link('Menu List',array('action'=>'index'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $this->Form->create('Menu',array('class'=>'form-horizontal'));?>
                    <?php echo $this->Form->input('id', array('type'=>'hidden'))?>
                    <div class="row" style="padding-bottom: 14px;">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Parent :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('parent_id',array('type'=>'select','div'=>false,'label'=>false,'empty'=>'--Select Parent--','options'=>$parentList,'class'=>'span11')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Name<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('name',array('class'=>'span11 validate','div'=>false,'label'=>false,'autocomplete' => 'off')); ?>
                                </div>
                            </div>
                        </div> 
                        <div class="clearfix"></div>                       
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Url :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('url',array('class'=>'form-control','div'=>false,'label'=>false,'autocomplete' => 'off')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Order<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('order',array('type'=>'text','class'=>'form-control validate','div'=>false,'label'=>false,'autocomplete' => 'off')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Is Enable?<?php echo $req; ?> :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('is_enable', array('checked'=>true,'div'=>false,'label'=>false)); ?>
                                </div>
                            </div>
                        </div>                       
                    </div>           
                    <div class="form-actions" align="center">
                        <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-info btn-fill','div'=>false,'label'=>false,'formnovalidate'=>true,'onclick'=>'javascript:return validateForm();'))?>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->Html->scriptBlock("
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
",array('inline'=>false));
?>
