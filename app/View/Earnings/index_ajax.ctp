<?php //echo '<pre>'; print_r($datas); exit;
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
            'controller'            => 'Earnings',
            'action'                => 'indexAjax'
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
      <th><?php echo $this->Paginator->sort('Prinsoner NUmber'); ?></th>
      <th><?php echo $this->Paginator->sort('Prinsoner Name'); ?></th>
      <th><?php echo $this->Paginator->sort('Balance B/f'); ?></th>
      <th><?php echo $this->Paginator->sort('Earnings in a month'); ?></th>
      <th><?php echo $this->Paginator->sort('Fines Deducted'); ?></th>
      <th><?php echo $this->Paginator->sort('Expenditure'); ?></th>
      <th><?php echo $this->Paginator->sort('Paysheet'); ?></th>
       <th><?php echo $this->Paginator->sort('Savings'); ?></th>
    </tr>
  </thead>
<tbody>
<?php
$rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
foreach($datas as $data){

  $saving = 0;
  $prisoner_earnings = $funcall->getPrisonerEarning($data['Prisoner']['id'],$start_date,$end_date);
  $total_balance = $funcall->getPrisonerBalance($data['Prisoner']['id'],$start_date);
  $total_expenditure = $funcall->getPrisonerExpenditure($data['Prisoner']['id'],$start_date,$end_date);
  $paysheet = $funcall->getPrisonerPaysheet($data['Prisoner']['id'],$start_date,$end_date);

  if($total_balance > 0)
  {
    $saving = ($total_balance+$prisoner_earnings) - ($total_expenditure+$paysheet);
  }
?>
    <tr>
      <td><?php echo $rowCnt; ?>&nbsp;</td>
      <td><?php echo $data['Prisoner']['fullname']; ?></td>
      <td><?php echo $data['Prisoner']['prisoner_no']; ?></td>
      <td><?php echo $total_balance; ?></td>
      <td><?php echo $prisoner_earnings;?></td>
      <td>0</td>
      <td><?php echo $total_expenditure; ?></td>
      <td><?php echo $paysheet; ?></td>
      <td><?php echo $saving; ?></td>
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