<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Shift Deployment List</h5>
                    <div style="float:right;padding-top: 7px;">
                        <?php echo $this->Html->link(__('Add  Shift Deployment'), array('action' => 'add'), array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $this->Form->create('Search',array('class'=>'form-horizontal'));?>
                    <div class="row">
                       <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Shift:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('shift_id',array('div'=>false,'label'=>false,'type'=>'select','options'=>$shiftList,'empty'=>'-- Select Shift --','class'=>'form-control','required','id'=>'shift_id'));?>
                                </div>
                            </div>
                        </div>  
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Force:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('',array('div'=>false,'label'=>false,'type'=>'select','options'=>$forceList,'empty'=>'-- Select Force --','class'=>'form-control','required','id'=>'force_id'));?>
                                </div>
                            </div>
                        </div>
                    
                       
                    </div>        
                    <div class="form-actions" align="center">
                        <?php echo $this->Form->button('Search', array('type'=>'button','class'=>'btn btn-success','div'=>false,'label'=>false,'onclick'=>'javascript:showData();'))?>
                        <?php echo $this->Form->button('Reset', array('type'=>'reset', 'class'=>'btn btn-warning', 'div'=>false, 'label'=>false,'onclick'=>'javascript:resetForm();'))?>
                    </div>
                    <?php echo $this->Form->end();?> 
                    <div class="table-responsive" id="listingDiv">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$ajaxUrl      = $this->Html->url(array('controller'=>'ShiftDeployments','action'=>'indexAjax'));
echo $this->Html->scriptBlock("
    $(document).ready(function(){
        showData();
    });
    function showData(){
        var url = '".$ajaxUrl."';
        var shift_id = $('#shift_id').val();
        var force_id = $('#force_id').val();
        url = url + '/shift_id:' + shift_id+ '/force_id:' + force_id;
        $.post(url, {}, function(res) {
            if (res) {
                //console.log(res);
                $('#listingDiv').html(res);
            }
        });    
    }

    function resetForm()
    {
        $('#shift_id').val('');
        $('#force_id').val('');
        $('#s2id_shift_id span').html(' -- Select Shift --');
        $('#s2id_force_id span').html(' -- Select Force --');
        showData();
    }

",array('inline'=>false));
?>  
<script type="text/javascript">
$(document).ready(function(){
    $('.from').datepicker({ dateFormat: 'yy-mm-dd' });
});
$(document).ready(function(){
    $('.to').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>











