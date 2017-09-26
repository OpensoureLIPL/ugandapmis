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
            'controller'            => 'SentenceController',
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
      <th>Date Of Sentence</th>
      <th>Date Of Conviction</th>
      <th>Years</th>
      <th>Months</th>
      <th>Days</th>
      <th>Remission</th>
      <th>LPD</th>
      <th>EPD</th>
    </tr>
  </thead>
<tbody>
<?php
$rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
foreach($datas as $data){
?>
    <tr>
      <td><?php echo $rowCnt; ?>&nbsp;</td>
      <td>
        <?php 
          if($data['PrisonerSentenceDetail']['date_of_sentence'] != '0000-00-00')
            echo date('d-m-Y', strtotime($data['PrisonerSentenceDetail']['date_of_sentence']));
          else 
            echo 'N/A'; 
        ?>
      </td>
      <td>
      <?php 
          if($data['PrisonerSentenceDetail']['date_of_conviction'] != '0000-00-00')
            echo date('d-m-Y', strtotime($data['PrisonerSentenceDetail']['date_of_conviction']));
          else 
            echo 'N/A'; 
        ?>
      </td>
      <td><?php echo $data['PrisonerSentenceDetail']['years']; ?></td>
      <td><?php echo $data['PrisonerSentenceDetail']['months']; ?></td>
      <td><?php echo $data['PrisonerSentenceDetail']['days']; ?></td>
      <td><?php //echo $data['PrisonerSentenceDetail']['id'];?></td>
      <td>
      <?php 
          if($data['PrisonerSentenceDetail']['lpd'] != '0000-00-00')
            echo date('d-m-Y', strtotime($data['PrisonerSentenceDetail']['lpd']));
          else 
            echo 'N/A'; 
        ?>
      </td>
      <td>
      <?php 
          if($data['PrisonerSentenceDetail']['epd'] != '0000-00-00')
            echo date('d-m-Y', strtotime($data['PrisonerSentenceDetail']['epd']));
          else 
            echo 'N/A'; 
        ?>
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