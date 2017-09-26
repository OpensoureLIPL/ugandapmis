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
                    <h5>Item Received By Prisoners</h5>
                    
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                                <?php echo $this->Form->create('PurchaseItem',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));
                                echo $this->Form->input('id',array('type'=>'hidden'));
                                echo $this->Form->input('prison_id',array(
                                    'type'=>'hidden',
                                    'class'=>'prison_id',
                                    'value'=>$this->Session->read('Auth.User.prison_id')
                                  ));?>
                                 <div class="row-fluid" style="padding-bottom: 14px;">
                                    <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Date <?php echo $req; ?> :</label>
                                                <div class="controls">
                                                    <?php echo $this->Form->input('item_rcv_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate','type'=>'text', 'placeholder'=>'Enter date','required','readonly'=>'readonly','id'=>'item_rcv_date'));?>
                                                </div>
                                            </div>
                                        </div>
                                    
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Prisoner Number<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prisoner_id',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'select','options'=>$prisonerList, 'empty'=>'-- Select Prisoner Number --','required','id'=>'prisoner_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                   </div>
                                <div class="row-fluid" style="padding-bottom: 14px;">
                                    
                                    <div class="span6">
                                      
                                        <div class="control-group">
                                            <label class="control-label">Name Of Item <?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('item_id',array('div'=>false,'label'=>false,'onChange'=>'getItemPrice(this.value)','class'=>'form-control','type'=>'select','options'=>$itemList, 'empty'=>'-- Select Item --','required','id'=>'item_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Price<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('price',array('div'=>false,'label'=>false,'class'=>'form-control span11','class'=>'form-control','type'=>'text','placeholder'=>'Enter Price ','id'=>'price','readonly'));?>
                                            </div>
                                        </div>
                                    </div>
                                    </div> 
                                    <div class="row-fluid">
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Issued By :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('issued_by',array('div'=>false,'label'=>false,'type'=>'text','placeholder'=>'Enter issued by','class'=>'form-control','type'=>'text','required'));?>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <!-- <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Finger Print<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php //echo $this->Form->file('photo',array('div'=>false,'label'=>false,'class'=>'form-control span11','class'=>'form-control','type'=>'text'));?>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Is Enable?<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php 
                                                if(isset($this->request->data['PurchaseItem']['is_enable']) && ($this->request->data['PurchaseItem']['is_enable'] == 0))
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
                                    
                           <div id="purchaseItem_listview"></div>
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
//get item price 
    function getItemPrice(id) 
    { 
        if(id != '')
        {
            var strURL = '<?php echo $this->Html->url(array('controller'=>'earnings','action'=>'getItemPrice'));?>';
        
            $.post(strURL,{"item_id":id},function(data){  
                
                if(data) { 
                    $('#price').val(data); 
                    
                }
            });
        }
        else 
        {
            $('#price').val(''); 
        }
    }
</script>
<?php
$purchaseItemUrl = $this->Html->url(array('controller'=>'earnings','action'=>'purchaseItemAjax'));
$deletepurchaseItemUrl = $this->Html->url(array('controller'=>'earnings','action'=>'deletePurchaseItem'));
echo $this->Html->scriptBlock("
   
    jQuery(function($) {
         showDatapurchaseItem();
    }); 
    
    function showDatapurchaseItem(){
        var url = '".$purchaseItemUrl."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#purchaseItem_listview').html(res);
            }
        });
    }

    //delete working party 
    function deletepurchaseItem(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deletepurchaseItemUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDatapurchaseItem();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

",array('inline'=>false));
?>

