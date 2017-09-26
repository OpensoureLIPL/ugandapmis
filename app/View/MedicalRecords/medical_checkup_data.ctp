<?php
if(is_array($datas) && count($datas)>0){
    if(!isset($is_excel)){
?>
<div class="row">
    <div class="col-sm-5">
        <ul class="pagination">
<?php
    $this->Paginator->options(array(
        'update'                    => '#sickListingDiv',
        'evalScripts'               => true,
        'before'                    => '$("#lodding_image").show();',
        'complete'                  => '$("#lodding_image").hide();',
        'url'                       => array(
            'controller'            => 'medicalRecords',
            'action'                => 'medicalCheckupData',   
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
    $exUrl = "medicalCheckupData";
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
            <th>Checkup Date Time</th>
            <th>Medical Officer</th>
            <th>Check Up Details</th>
            <th>Supported Files</th>
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
?>
        <tr>
            <td><?php 
                  if($rowCnt==1)
                  {
                    echo "<span class='badge badge-success'>Initial Check Up</span> <br>";
                  }  
                  echo $rowCnt;
             ?></td>
            <td><?php echo date('d-m-Y', strtotime($data["MedicalCheckupRecord"]["checkup_date_time"]))?></td>
            <td><?php echo $data["User"]["first_name"].' '. $data["User"]["last_name"]?> </td>
            <td><?php echo $data["MedicalCheckupRecord"]["check_up_details"]?></td>
            <td>
                <?php 
                if($data["MedicalCheckupRecord"]["supported_files"] != '')
                {
                    echo $this->Html->link('View Attachment', '../files/prisnors/MEDICAL/'.$data["MedicalCheckupRecord"]["supported_files"], array('escape'=>false,'target'=>'_blank', 'class'=>'btn btn-primary'));
                }
                else
                {
                    echo 'N/A';
                }
                ?>
            </td>

<?php
        if(!isset($is_excel)){
            $medical_checkup_record_id   = $data['MedicalCheckupRecord']['id'];
            $medical_checkup_record_uuid = $data['MedicalCheckupRecord']['uuid'];
?>              
            <td>
                <?php echo $this->Form->create('MedicalCheckupRecordEdit',array('url'=>'/medicalRecords/add/'.$uuid.'#health_checkup','admin'=>false));?> 
                <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $medical_checkup_record_id)); ?>
                <?php echo $this->Form->end(array('label'=>'Edit','class'=>'btn btn-primary','div'=>false, 'onclick'=>"javascript:return confirm('Are you sure want to edit?')")); ?> 
            </td>
            <td>
                <?php echo $this->Form->button('Delete', array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-danger', 'onclick'=>"javascript:deleteMedicalChekupRecord('$medical_checkup_record_uuid');"))?>
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