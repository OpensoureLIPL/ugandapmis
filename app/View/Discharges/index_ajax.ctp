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
            'url'                   => array(
            'controller'            => 'CourtsController',
            'action'                => 'indexAjax',
            'date_of_discharge'     => $date_of_discharge,
            'discharge_type_id'     => $discharge_type_id,
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
            <th><?php echo $this->Paginator->sort('Date of Discharge'); ?></th>
            <th><?php echo $this->Paginator->sort('Discharge Type'); ?></th>
            <th><?php echo $this->Paginator->sort('Finger Print'); ?></th>
            <th><?php echo $this->Paginator->sort('Signature'); ?></th>
            <th><?php echo $this->Paginator->sort('Supported Docs'); ?></th>
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
            <td><?php echo ucwords(h(date('d-m-Y', strtotime($data['Discharge']['date_of_discharge'])))); ?>&nbsp;</td> 
            <td><?php echo ucwords(h($data['DischargeType']['name'])); ?>&nbsp;</td>
            <td>
                <?php echo $this->Html->link('View', '../files/prisnors/DISCHARGE/'.$data["Discharge"]["finger_print"], array('escape'=>false,'target'=>'_blank', 'class'=>'btn btn-primary'))?>
            </td> 
            <td>
                <?php echo $this->Html->link('View', '../files/prisnors/DISCHARGE/'.$data["Discharge"]["signature"], array('escape'=>false,'target'=>'_blank', 'class'=>'btn btn-primary'))?>
            </td>
            <td>
                <?php echo $this->Html->link('View', '../files/prisnors/DISCHARGE/'.$data["Discharge"]["attachment"], array('escape'=>false,'target'=>'_blank', 'class'=>'btn btn-primary'))?>
            </td>
            <td class="actions">
                <?php echo $this->Form->create('DischargeEdit',array('url'=>'/discharges/index/'.$uuid,'admin'=>false));?> 
                <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $data['Discharge']['id'])); ?>
                <?php echo $this->Form->end(array('label'=>'Edit','class'=>'btn btn-primary btn-mini','div'=>false, 'onclick'=>"javascript:return confirm('Are you sure want to edit?')")); ?> 
            </td>
            <td>
                <?php echo $this->Form->create('DischargeDelete',array('url'=>'/discharges/index/'.$uuid,'admin'=>false));?> 
                <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $data['Discharge']['id'])); ?>
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