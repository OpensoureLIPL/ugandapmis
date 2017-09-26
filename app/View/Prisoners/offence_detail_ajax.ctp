<?php
if(is_array($datas) && count($datas)>0){
    if(!isset($is_excel)){
?>
<div class="row">
    <div class="col-sm-5">
        <ul class="pagination">
<?php //echo '<pre>'; print_r($datas); exit;
    $this->Paginator->options(array(
        'update'                    => '#offencedetail_listview',
        'evalScripts'               => true,
        //'before'                    => '$("#lodding_image").show();',
        //'complete'                  => '$("#lodding_image").hide();',
        'url'                       => array(
            'controller'            => 'Prisoners',
            'action'                => 'offenceDetailAjax',
            'prisoner_id'             => $prisoner_id,

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
    $exUrl = "offenceDetailAjax/prisoner_id:$prisoner_id";
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
            <th>Personal Number</th>
            <th>Offence</th>
            <th>Section Of Law</th>
            <th>Court File No</th>
<?php
if(!isset($is_excel)){
?> 
            <th>Action</th>
<?php
}
?>             
        </tr>
    </thead>
    <tbody>
<?php
    $rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));

    foreach($datas as $data){

      $id = $data['PrisonerOffenceDetail']['id'];
      $puuid = $data['PrisonerOffenceDetail']['puuid'];
      $offence_id = $data['PrisonerOffenceDetail']['offence'];
?>
        <tr>
            <td><?php echo $rowCnt; ?></td>
            <td><?php echo $data['PrisonerOffenceDetail']['personal_no']; ?></td>
            <td><?php echo $data['Offence']['name']; ?></td>
            <td><?php echo $data['SectionOfLaw']['name']; ?></td>
            <td><?php echo $data['PrisonerOffenceDetail']['court_file_no']; ?></td>
<?php
        if(!isset($is_excel)){
?>          <td>    
            <table>
                <tr>
                    <td>
                        <?php echo $this->Form->create('PrisonerDataEdit',array('url'=>'/Prisoners/edit/'.$puuid.'#offence_details','admin'=>false));?> 
                        <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $id));
                        echo $this->Form->input('pdata_type',array('type'=>'hidden','value'=> 'PrisonerOffenceDetail'));
                        ?>
                        <?php echo $this->Form->end(array('label'=>'Edit','class'=>'btn btn-primary','div'=>false, 'onclick'=>"javascript:return confirm('Are you sure want to edit?')")); ?> 
                    </td>
                      <td>
                           <?php echo $this->Form->button('Delete', array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-danger', 'onclick'=>"javascript:deleteOffence('$id');"))?>
                    </td>
                    <td>
                        <?php echo $this->Form->button('Offence Count Details', array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-warning', 'onclick'=>"javascript:goToOffenceCount('$id');"))?>
                    </td>  
                </tr>
            </table>
            <td>
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