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
            'controller'            => 'ShiftsController',
            'action'                => 'indexAjax',
            'name'      => $name,
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
      <th><?php echo $this->Paginator->sort('Name'); ?></th>
      <th><?php echo $this->Paginator->sort('Created Date'); ?></th>
      <th><?php echo $this->Paginator->sort('Enable'); ?></th>
      <th><?php echo __('Edit'); ?></th>
      <th><?php echo __('Delete'); ?></th>
    </tr>
  </thead>
<tbody>
<?php
$rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
foreach($datas as $data){
?>
    <tr>
      <td><?php echo $rowCnt; ?>&nbsp;</td>
      
      <td><?php echo ucwords(h($data['Shift']['name'])); ?>&nbsp;</td> 
      <td><?php echo date('d-m-Y', strtotime($data['Shift']['created'])); ?>&nbsp;</td> 
      <td>
      <?php 
      if($data['Shift']['is_enable'] == 1)
      {
        echo 'Yes';
      }
      else
      {
        echo 'No';
      }
      ?>
      </td>   				
      
        <td class="actions">
          <?php echo $this->Form->create('ShiftEdit',array('url'=>'/Shifts/add','admin'=>false));?> 
          <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $data['Shift']['id'])); ?>
          <?php echo $this->Form->end(array('label'=>'Edit','class'=>'btn btn-primary btn-mini','div'=>false, 'onclick'=>"javascript:return confirm('Are you sure want to edit?')")); ?> 
        </td>
        <td>
            <?php echo $this->Form->create('ShiftDelete',array('url'=>'/Shifts/index','admin'=>false));?> 
            <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $data['Shift']['id'])); ?>
            <?php echo $this->Form->end(array('label'=>'Delete','class'=>'btn btn-danger btn-mini','div'=>false, 'onclick'=>"javascript:return confirm('Are you sure want to delete?')")); ?>
      </td>
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