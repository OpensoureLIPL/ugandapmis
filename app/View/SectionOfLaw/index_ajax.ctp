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
            'controller'            => 'SectionOfLaw',
            'action'                => 'indexAjax',
            'offence_id'              => $offence_id,
            'solname'              => $solname,      
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
      <th><?php echo $this->Paginator->sort('SectionOfLaw'); ?></th>
      <th><?php echo $this->Paginator->sort('Offence'); ?></th>
      <th><?php echo $this->Paginator->sort('is_enable'); ?></th>
      <th><?php echo __('Edit'); ?></th>
      <th><?php echo __('Delete'); ?></th>
    </tr>
  </thead>
<tbody>
<?php
$rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
foreach($datas as $laws){
?>
    <tr>
      <td><?php echo $rowCnt; ?>&nbsp;</td>
      <td><?php echo ucwords(h($laws['SectionOfLaw']['name'])); ?>&nbsp;</td>	
      <td><?php echo ucwords(h($laws['Offence']['name'])); ?>&nbsp;</td>   				
      <td><?php if($laws['SectionOfLaw']['is_enable'] == '1'){
      echo "<font color=green>Yes</font>"; 
      }else{
      echo "<font color=red>No</font>"; 
      }?>&nbsp;
      </td>
      <td class="actions">
        <?php echo $this->Form->create('SOLEdit',array('url'=>'/SectionOfLaw/add','admin'=>false));?> 
        <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $laws['SectionOfLaw']['id'])); ?>
        <?php echo $this->Form->end(array('label'=>'Edit','class'=>'btn btn-primary','div'=>false, 'onclick'=>"javascript:return confirm('Are you sure want to edit?')")); ?> 

        </td>
        <td>
            <?php echo $this->Form->create('SOLDelete',array('url'=>'/SectionOfLaw/index','admin'=>false));?> 
            <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $laws['SectionOfLaw']['id'])); ?>
            <?php echo $this->Form->end(array('label'=>'Delete','class'=>'btn btn-danger','div'=>false, 'onclick'=>"javascript:return confirm('Are you sure want to delete?')")); ?>
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
<span style="color:red;font-weight:bold;">No Record Found!!</span>
<?php    
}
?>    