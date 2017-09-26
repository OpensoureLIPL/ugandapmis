<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Users List</h5>
                    <div style="float:right;padding-top: 7px;">
                        <?php echo $this->Html->link('Add Menu',array('action'=>'addMenu'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $this->Form->create('Search',array('class'=>'form-horizontal'));?>
                    <div class="row" style="padding-bottom: 14px;">
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Parent :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('parent_id',array('type' => 'select','div'=>false,'label'=>false,'class'=>'span11','id'=>'parent_id','empty' => '--Select--','options' => $Parent));?>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Name :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('name',array('div'=>false,'label'=>'Name','class'=>'span11','id'=>'name'));?>
                                </div>
                            </div>
                        </div>  

                    </div>           
                    <div class="form-actions" align="center">
                        <?php echo $this->Form->button('Search', array('type'=>'button','class'=>'btn btn-primary','div'=>false,'label'=>false,'onclick'=>'javascript:showData();'))?>
                        <?php echo $this->Form->button('Reset', array('type'=>'reset', 'class'=>'btn btn-warning', 'div'=>false, 'label'=>false))?>
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
$ajaxUrl = $this->Html->url(array('controller'=>'Menus','action'=>'indexAjax'));
echo $this->Html->scriptBlock("
    $(document).ready(function(){
        showData();
    });
    function showData(){
        var url = '".$ajaxUrl."';
        url = url + '/parent_id:' + $('#parent_id').val();
        url = url + '/name:' + $('#name').val();
        $.post(url, {}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
            }
        });    
    }
        function confirmdelete(){
        var c=confirm('Are you sure to delete ?');
        if(c == false){
            return false;
        }else{
            return true;
        }
    }
",array('inline'=>false));
?>

