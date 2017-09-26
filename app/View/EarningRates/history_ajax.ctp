<?php
if(is_array($datas) && count($datas)>0){
?>
<div class="row">
    <div class="col-sm-5">
        <ul class="pagination">
<?php
    $this->Paginator->options(array(
        'update'                    => '#listingDiv',
        'evalScripts'               => true,
        //'before'                  => '$("#lodding_image").show();',
        //'complete'                => '$("#lodding_image").hide();',
            'url'                       => array(
            'controller'            => 'EarningRatesController',
            'action'                => 'historyAjax',
            'earning_grade_id'      => $earning_grade_id,
            'amount'                => $amount,
            'start_date'            => $start_date,
            'end_date'              => $end_date,
           
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
    </div>
</div>
<table id="districtTable" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th><?php echo $this->Paginator->sort('Sl no'); ?></th>                
      <th><?php echo $this->Paginator->sort('Grade Name'); ?></th>
      
      <th><?php echo $this->Paginator->sort('Rate'); ?></th>
       <th><?php echo $this->Paginator->sort('Start Date'); ?></th>
      <th><?php echo $this->Paginator->sort('End Date'); ?></th>
      
      
      
      
      
    </tr>
  </thead>
<tbody>
<?php
$rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
foreach($datas as $data){
?>
    <tr>
      <td><?php echo $rowCnt; ?>&nbsp;</td>
      <td><?php echo ucwords(h($data['EarningGrade']['name'])); ?>&nbsp;</td> 
      
      <td><?php echo ucwords(h($data['EarningRateHistory']['amount'])); ?>&nbsp;</td>
      <td><?php echo ucwords(h($data['EarningRateHistory']['start_date'])); ?>&nbsp;</td> 
      <td><?php echo ucwords(h($data['EarningRateHistory']['end_date'])); ?>&nbsp;</td>
      
     
         				
      
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
<span style="color:red;font-weight:bold;">No Record Found!!</span>
<?php    
}
?>    