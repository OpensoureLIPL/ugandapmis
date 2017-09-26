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
                    <h5>Create Article/Item</h5>
                    
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                                <?php echo $this->Form->create('Item',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));
                                echo $this->Form->input('id',array('type'=>'hidden'));
                                echo $this->Form->input('prison_id',array(
                                    'type'=>'hidden',
                                    'class'=>'prison_id',
                                    'value'=>$this->Session->read('Auth.User.prison_id')
                                  ));
                                  ?>
                                <div class="row-fluid" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Name Of Item <?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('name',array('div'=>false,'label'=>false,'class'=>'form-control span11','class'=>'form-control ','type'=>'text','placeholder'=>'Enter Name of Item','id'=>'name'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                      <div class="control-group">
                                            <label class="control-label">Price<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('price',array('div'=>false,'label'=>false,'class'=>'form-control span11','class'=>'form-control','type'=>'text','placeholder'=>'Enter Price ','id'=>'first_name'));?>
                                            </div>
                                        </div>
                                    </div>

                                    </div> 
                                    <div class="row-fluid">
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Comment :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->textarea('comment',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter remarks','class'=>'form-control','type'=>'text','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Is Enable?<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php 
                                                if(isset($this->request->data['Item']['is_enable']) && ($this->request->data['Item']['is_enable'] == 0))
                                                {
                                                    echo $this->Form->input('is_enable', array('checked'=>false,'div'=>false,'label'=>false));
                                                }
                                                else 
                                                {
                                                    echo $this->Form->input('is_enable', array('checked'=>true,'div'=>false,'label'=>false));
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    </div> 
                                    
                                     
                                    
                                </div>

                              <div class="form-actions" align="center">
                        <?php echo $this->Form->input('Submit', array('type'=>'submit', 'class'=>'btn btn-success','div'=>false,'label'=>false,'id'=>'submit','formnovalidate'=>true,'onclick'=>"javascript:return validateForm();"))?>
                    </div>
                                <?php echo $this->Form->end();?>
                                    
                           
                             <div id="item_listview"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$itemUrl = $this->Html->url(array('controller'=>'earnings','action'=>'itemAjax'));
$deleteItemUrl = $this->Html->url(array('controller'=>'earnings','action'=>'deleteItem'));
echo $this->Html->scriptBlock("
   
    jQuery(function($) {
         showDataItem();
    }); 
    
    function showDataItem(){
        var url = '".$itemUrl."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#item_listview').html(res);
            }
        });
    }

    //delete working party 
    function deleteItem(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteItemUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDataItem();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

",array('inline'=>false));
?>