<?php
if(is_array($datas) && count($datas)>0){
    if(!isset($is_excel)){
?>
<div class="row">
    <div class="col-sm-5">
        <ul class="pagination">
<?php
    $this->Paginator->options(array(
        'update'                    => '#purchaseItem_listview',
        'evalScripts'               => true,
        //'before'                    => '$("#lodding_image").show();',
        //'complete'                  => '$("#lodding_image").hide();',
        'url'                       => array(
            'controller'            => 'Earnings',
            'action'                => 'purchaseItemAjax'

        )
    ));         
    echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
    echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
    echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null,array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
    echo $this->Js->writeBuffer();
?>
        </ul>
    </div>
    <div class="col-sm-7 text-right" style="padding-top:30px;">
<?php
echo $this->Paginator->counter(array(
    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
));
?>
<?php
    $exUrl = "purchaseItemAjax";
    $urlExcel = $exUrl.'/reqType:XLS';
    $urlDoc = $exUrl.'/reqType:DOC';
    echo($this->Html->link($this->Html->image("excel-2012.jpg",array("height" => "20","width" => "20","title"=>"Download Excel")),$urlExcel, array("escape" => false)));
    echo '&nbsp;&nbsp;';
    echo($this->Html->link($this->Html->image("word-2012.png",array("height" => "20","width" => "20","title"=>"Download Doc")),$urlDoc, array("escape" => false)));
?>
    </div>
</div>
<?php
    }
?>                    
<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th>SL#</th>
            <th>Prisoner Number</th>
            <th>Item</th>
            <th>Price</th>
            <th>Date</th>
<?php
if(!isset($is_excel)){
?> 
            <th>Edit</th>
            <th>Delete</th>
<?php
}
?>             
        </tr>
    </thead>
    <tbody>
<?php
    $rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));

    foreach($datas as $data){

      $id = $data['PurchaseItem']['id'];
?>
        <tr>
            <td><?php echo $rowCnt; ?></td>
            <td><?php echo $data['Prisoner']['prisoner_no']; ?></td>
            <td><?php echo $data['Item']['name']; ?></td>
            <td><?php echo $data['PurchaseItem']['price']; ?></td>
            <td><?php echo date('d-m-Y', strtotime($data['PurchaseItem']['item_rcv_date'])); ?></td>
<?php
        if(!isset($is_excel)){
?>              
            
            <td>
                <?php echo $this->Form->create('PurchaseItemEdit',array('url'=>'/earnings/itemReceivedByPriosner','admin'=>false));?> 
                <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $id));
                ?>
                <?php echo $this->Form->end(array('label'=>'Edit','class'=>'btn btn-primary','div'=>false, 'onclick'=>"javascript:return confirm('Are you sure want to edit?')")); ?> 
            </td>
              <td>
                   <?php echo $this->Form->button('Delete', array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-danger', 'onclick'=>"javascript:deletepurchaseItem('$id');"))?>
            </td>
  <?php
}
  ?>
        </tr>
<?php
        $rowCnt++;
    }
?>
    </tbody>
</table>
<?php
}else{
?>
    ...
<?php    
}
?>                    