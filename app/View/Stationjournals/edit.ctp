
<div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Modify station journals</h5>
            <div style="float:right;padding-top: 7px;">


            <?php echo $this->Html->link('Station journals',array(
                                    
                                    'action'=>'index'
                                ),array(
                                    'escape'=>false,
                                    'class'=>'btn btn-success btn-mini'
                                )); ?>
              <?php //echo $this->Html->link('Users List',array(
                  //'action'=>'index',
                 // array('escape'=>false,'class'=>'btn btn-success'),
              //));
              ?>
              &nbsp;&nbsp;
          </div>
          </div>
          <div class="widget-content nopadding">
              <?php
                echo $this->Form->create('Stationjournal',array(
                  'class'=>'form-horizontal'
                ));
                echo $this->Form->input('id',array(
                  'type'=>'hidden',
                ));
               ?>
                
                      <div class="row-fluid">
                      <div class="span6">    
                        <div class="control-group">
                          <label class="control-label">Prison Station Id<?php echo MANDATORY; ?></label>
                          <div class="controls">
                            <?php
                                echo $this->Form->input('prison_id',array(
                                  'div'=>false,
                                  'label'=>false,
                                  'class'=>'span11',
                                  'options'=>$prison_id,
                                  'empty'=>'-- Select Prison--',
                                  'required',
                                ));
                             ?>
                          </div>
                        </div>
                        </div>

                      <div class="span6">  
                       <div class="control-group">
                          <label class="control-label">Date<?php echo MANDATORY; ?> :</label>
                          <div class="controls">
                            <?php
                              $journal_date=$this->request->data["Stationjournal"]["journal_date"];
                                echo $this->Form->input('journal_date',array(
                                  'div'=>false,
                                  'label'=>false,
                                  'class'=>'span11 mydate',
                                  'type'=>'text',
                                  'required',
                                  'data-date-format'=>"dd-mm-yyyy",
                                  'value'=>date('d-m-Y',strtotime($journal_date))
                                  
                                ));
                             ?>
                          </div>
                        </div>
                       </div>
                       </div>
                        <div class="row-fluid">
                          <div class="span6">  
                            <div class="control-group">
                            <label class="control-label">State Of Prisoners<?php echo MANDATORY; ?> :</label>
                            <div class="controls">
                              <?php
                                  echo $this->Form->input('prisnors_state',array(
                                    'div'=>false,
                                    'label'=>false,
                                    'class'=>'span11',
                                    'type'=>'textarea',
                                    'required'=>'required',
                                    'rows'=>3
                                  ));
                               ?>
                            </div>
                          </div>
                          </div>
                     
                      <div class="span6">     
                        <div class="control-group">
                          <label class="control-label">State Of Prison<?php echo MANDATORY; ?> :</label>
                          <div class="controls">
                            <?php
                                echo $this->Form->input('prisons_state',array(
                                  'div'=>false,
                                  'label'=>false,
                                  'class'=>'span11',
                                  'type'=>'textarea',
                                  'required'=>'required',
                                  'rows'=>3
                                ));
                             ?>
                          </div>
                        </div>
                        </div>
                      </div>
                      
                            
              
              <div class="form-actions" align="center">
                <button type="submit" class="btn btn-success">Save</button>
              </div>
            <?php
echo $this->Form->end();
             ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  
$(document).ready(function(){
    //$('.datepicker').datepicker();
});


$(function(){
    $("#StationjournalAddForm").validate({
     
      ignore: "",
            rules: {  
                'data[Stationjournal][journal_date]': {
                    required: true,
                },
                'data[Stationjournal][prison_id]': {
                    required: true,
                },
                'data[Stationjournal][prisnors_state]': {
                    required: true,
                },
                'data[Stationjournal][prisons_state]': {
                    required: true,
                },
            },
            messages: {
                'data[Stationjournal][journal_date]': {
                    required: "Please choose date.",
                },
                'data[Stationjournal][prison_id]': {
                    required: "Please select prison station.",
                },
                'data[Stationjournal][prisnors_state]': {
                    required: "Please enter state of prisoners.",
                },
                'data[Stationjournal][journal_date]': {
                    required: "Please enter state of prison.",
                },
               
        
            },
               
    });
  });
</script>