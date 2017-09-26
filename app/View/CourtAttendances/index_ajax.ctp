<?php
if(is_array($datas) && count($datas)>0){
?>
<div class="row">
    <div class="col-sm-5">
        <ul class="pagination">
<?php
    $this->Paginator->options(array(
        'update'                        => '#listingDiv',
        'evalScripts'                   => true,
        //'before'                      => '$("#lodding_image").show();',
        //'complete'                    => '$("#lodding_image").hide();',
            'url'                       => array(
            'controller'                => 'courtattendances',
            'action'                    => 'indexAjax',
            'case_no'                   => $case_no,
            'court_id'                  => $court_id,
            'magisterial_id'            => $magisterial_id,
            'attendance_time'           => $attendance_time,
            'attendance_date'           => $attendance_date,
            'production_warrent_no'     => $production_warrent_no,
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
            <th><?php echo $this->Paginator->sort('Production Warrent No.'); ?></th>
            <th><?php echo $this->Paginator->sort('Schedule Date'); ?></th>
            <th><?php echo $this->Paginator->sort('Schedule Time'); ?></th>
            <th><?php echo $this->Paginator->sort('Magisterial Area'); ?></th>
            <th><?php echo $this->Paginator->sort('Court'); ?></th>
            <th><?php echo $this->Paginator->sort('Case No.'); ?></th>
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
            <td><?php echo ucwords(h($data['Courtattendance']['production_warrent_no'])); ?>&nbsp;</td> 
            <td><?php echo ucwords(h(date('d-m-Y', strtotime($data['Courtattendance']['attendance_date'])))); ?>&nbsp;</td>
            <td><?php echo ucwords(h($data['Courtattendance']['attendance_time'])); ?>&nbsp;</td> 
            <td><?php echo ucwords(h($data['Magisterial']['name'])); ?>&nbsp;</td>
            <td><?php echo ucwords(h($data['Court']['name'])); ?>&nbsp;</td>
            <td><?php echo ucwords(h($data['Courtattendance']['case_no'])); ?>&nbsp;</td>
            <td class="actions">
            <?php echo $this->Form->create('CourtattendanceEdit',array('url'=>'/courtattendances/index/'.$uuid,'admin'=>false));?> 
            <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $data['Courtattendance']['id'])); ?>
            <?php echo $this->Form->end(array('label'=>'Edit','class'=>'btn btn-primary btn-mini','div'=>false, 'onclick'=>"javascript:return confirm('Are you sure want to edit?')")); ?> 
            </td>
            <td>
            <?php echo $this->Form->create('CourtattendanceDelete',array('url'=>'/courtattendances/index/'.$uuid,'admin'=>false));?> 
            <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $data['Courtattendance']['id'])); ?>
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