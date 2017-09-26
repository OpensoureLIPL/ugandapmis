<?php //echo '<pre>'; print_r($prisonerAttendanceList); exit;
if(is_array($datas) && count($datas)>0){
    if(!isset($is_excel)){
?>
<div class="row">
    <div class="col-sm-5">
        <ul class="pagination">
<?php
    $this->Paginator->options(array(
        'update'                    => '#listingDiv',
        'evalScripts'               => true,
        //'before'                    => '$("#lodding_image").show();',
        //'complete'                  => '$("#lodding_image").hide();',
        'url'                       => array(
            'controller'            => 'Earnings',
            'action'                => 'showPrisoners'

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
    $exUrl = "showPrisoners";
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
<?php echo $this->Form->create('PrisonerAttendance',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','url' => '/earnings/attendances'));?>                   
<table class="table table-bordered data-table">
    <thead>
        <tr>
            <?php
            if(!isset($is_excel)){
            ?> 
                <th>
                    <button type="submit" tabcls="next" id="saveBtn" class="btn btn-success" onclick="saveAttendance();">Save</button>
                </tdh>
            <?php }?> 
            <th>SL#</th>
            <th>Prisoner No</th>
            <th>Prisoner Name</th>
        </tr>
    </thead>
    <tbody>
<?php
    echo $this->Form->input('Attendance.attendance_date',array(
        'type'=>'hidden',
        'class'=>'attendance_date',
        'value'=>date('Y-m-d', strtotime($attendance_date))
      ));
    echo $this->Form->input('Attendance.working_party_id',array(
        'type'=>'hidden',
        'class'=>'working_party_id',
        'value'=>$working_party_id
    ));
    echo $this->Form->input('Attendance.prison_id',array(
        'type'=>'hidden',
        'class'=>'prison_id',
        'value'=>$this->Session->read('Auth.User.prison_id')
    ));
    $rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
    $i = 0;
    foreach($datas as $data){

      $id = $data['WorkingPartyPrisoner']['id'];
      $prisoner_id = $data['Prisoner']['id'];
 
?>
        <tr>
            <?php
            if(!isset($is_excel)){
            ?>   
                <td>
                
                <?php 
                if(isset($prisonerAttendanceList) && !empty($prisonerAttendanceList) && in_array($prisoner_id, $prisonerAttendanceList))
                {
                    echo $this->Form->input('PrisonerAttendance.'.$i.'.prisoner_id', array(
                      'type'=>'checkbox', 'value'=>$prisoner_id,'hiddenField' => false, 'label'=>false,'checked',
                      'format' => array('before', 'input', 'between', 'label', 'after', 'error' ) 
                ));
                }
                else 
                {
                    echo $this->Form->input('PrisonerAttendance.'.$i.'.prisoner_id', array(
                      'type'=>'checkbox', 'value'=>$prisoner_id,'hiddenField' => false, 'label'=>false,
                      'format' => array('before', 'input', 'between', 'label', 'after', 'error' ) 
                ));
                }
                ?>
                </td>
            <?php } ?>
            <td><?php echo $rowCnt; ?></td>
            <td><?php echo $data['Prisoner']['prisoner_no']; ?></td>
            <td><?php echo $data['Prisoner']['fullname']; ?></td>

        </tr>
<?php
        $rowCnt++;
        $i++;
    }
?>
    </tbody>
</table>
<?php echo $this->Form->end();?>
<?php
}else{
?>
    <span style="color:red;">No records found!</span>
<?php    
}
$ajaxUrl    = $this->Html->url(array('controller'=>'Earnings','action'=>'attendances'));
?> 
<script type="text/javascript">
function saveAttendance()
{
    vsr url = '<?php echo $ajaxUrl;?>';
    $.post(url, $('#PrisonerAttendanceShowPrisonersForm').serialize(), function(res) {

        if (res) {
            //$('#listingDiv').html(res);
        }
    });
}
</script>                   