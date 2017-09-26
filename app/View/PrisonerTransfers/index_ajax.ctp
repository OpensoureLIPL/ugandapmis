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
            'controller'            => 'PrisonerTransfers',
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
      <th><?php echo $this->Paginator->sort('Prisoner Number'); ?></th>
      <th>Origin Station</th>
      <th>Destination Station</th>
      <th>Escorting Officer</th>
      <th>Date Of Transfer</th>
      <th>Reason</th>
      <?php
      if(!isset($is_excel)){
      ?> 
        <th>Action</th>
      <?php }?>
    </tr>
  </thead>
<tbody>
<?php
$rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
foreach($datas as $data){
    $id = $data['PrisonerTransfer']['id'];
    if($usertype_id == 5)
    {
      if($transfer_type == 'outgoing')
      {
        $displayStatus = 'Final save';
        $status = 'Saved';
      }
      else 
      {
        $displayStatus = 'Recieve';
        $status = 'Recieved';
      }
      $prevstatus = 'Process';
    }
    if($usertype_id == 4)
    {
      $status = 'Reviewed';
      $displayStatus = 'Review';
      if($transfer_type == 'outgoing')
      {
        $prevstatus = 'Saved';
      }
      else 
      {
        $prevstatus = 'Recieved';
      }
    }
    if($usertype_id == 3)
    {
      $status = 'Approved';
      $displayStatus = 'Approve';
      $prevstatus = 'Reviewed';
    }  
?>
    <tr>
      <td><?php echo $rowCnt; ?>&nbsp;</td>
      <td><?php echo $data['Prisoner']['prisoner_no']; ?></td>
      <td><?php echo $data['Prison']['name'];?></td>
      <td><?php echo $data['ToPrison']['name'];?></td>
      <td><?php echo $data['User']['name'];?></td>
      <td><?php echo date('d-m-Y', strtotime($data['PrisonerTransfer']['transfer_date'])); ?></td>
      <td><?php echo $data['PrisonerTransfer']['reason'];?></td>
      <?php
      if(!isset($is_excel)){
      ?>   
        <td>
          <table>
            <tr>
                <?php 
                if($usertype_id == 5)
                {
                  if($transfer_type == 'outgoing')
                  {
                    if($data['PrisonerTransfer']['status'] == 'Process')
                    {?>
                      <td>
                        <?php 
                        echo $this->Form->create('PrisonerTransferEdit',array('url'=>'/PrisonerTransfers','admin'=>false));?> 
                        <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $id));
                        ?>
                        <?php echo $this->Form->end(array('label'=>'Edit','class'=>'btn btn-primary','div'=>false, 'onclick'=>"javascript:return confirm('Are you sure want to edit?')")); ?>
                      </td>
                      <td>
                        <?php echo $this->Form->button('Delete', array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-danger', 'onclick'=>"javascript:deleteTransfer('$id');"))?>
                      </td>
                    <?php 
                    }
                  }
                }
              if($usertype_id != 5 || $transfer_type == 'recieve')
              {
                ?>
                <td>
                  <?php 
                  echo $this->Html->link('Detail',array(
                           'action'=>'../prisoners/details',
                           $data['Prisoner']['uuid']
                         ),array(
                            'escape'=>false,
                            'class'=>'btn btn-primary'
                          ));
                  ?>
                </td>
              <?php 
              }
              if($transfer_type == 'recieve')
              {?>
                
                <?php if($data['PrisonerTransfer']['instatus'] == $prevstatus)
                {?>
                  <td>
                    <?php echo $this->Form->button('Reject', array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-danger', 'onclick'=>"javascript:changeInTransferStatus('$id','Rejected','Reject');"))?>
                  </td>
                  <td>
                    <?php echo $this->Form->button($displayStatus, array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-warning', 'onclick'=>"javascript:changeInTransferStatus('$id','$status','$displayStatus');"))?>
                  </td>
                <?php }
                else 
                {?>
                  <td>
                    <?php echo $this->Form->button($data['PrisonerTransfer']['instatus'], array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-gray'))?>
                  </td>
                <?php }
              }

              if($transfer_type == 'outgoing')
              {
                if($data['PrisonerTransfer']['status'] == $prevstatus)
                {
                  if($usertype_id != 5){?>
                    <td>
                      <?php echo $this->Form->button('Reject', array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-danger', 'onclick'=>"javascript:forwardTransfer('$id','Rejected');"))?>
                    </td>
                  <?php }?>
                  <td>
                    <?php echo $this->Form->button($displayStatus, array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-warning', 'onclick'=>"javascript:forwardTransfer('$id','$status');"))?>
                  </td>
                  <?php 
                }
                else 
                {?>
                  <td>
                    <?php echo $this->Form->button($data['PrisonerTransfer']['status'], array('type'=>'button', 'div'=>false, 'label'=>false, 'class'=>'btn btn-gray'))?>
                  </td>
                <?php }
              }?>
            </tr>
          </table>
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