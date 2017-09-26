<?php
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
            'controller'            => 'officers',
            'action'                => 'indexAjax',
            'prison_id'             => $prison_id,

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
    $exUrl = "indexAjax/prison_id:$prison_id";
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
            <th>First Name</th>
            <th>Last Name</th>
            <th>Force Number</th>
            <th>D.O.B</th>
            <th>Rank</th>
            
<?php
if(!isset($is_excel)){
?> 
            <th>Status</th>
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
            <td><?php echo $rowCnt; ?></td>
            <td><?php echo $data['Officer']['first_name']; ?></td>
            <td><?php echo $data['Officer']['last_name']; ?></td>
            <td><?php echo $data['Officer']['force_number']; ?></td>
            <td><?php echo date('d-m-Y',strtotime($data['Officer']['dob'])); ?></td>
            <td><?php echo $data['Officer']['rank']; ?></td>
           
            
<?php
        if(!isset($is_excel)){
?>              
            <td>
                      <?php
                      if($data['Officer']['is_enable'] == 1){
                        echo $this->Html->link("Click To Disable",array(
                          'controller'=>'officers',
                          'action'=>'disable',
                          $data['Officer']['id']
                        ),array(
                          'escape'=>false,
                          'class'=>'btn btn-primary btn-mini',
                          'onclick'=>"return confirm('Are you sure you want to disable?');"
                        ));
                      }else{
                        echo $this->Html->link("Click To Enable",array(
                          'controller'=>'officers',
                          'action'=>'enable',
                          $data['Officer']['id']
                        ),array(
                          'escape'=>false,
                          'class'=>'btn btn-danger btn-mini',
                          'onclick'=>"return confirm('Are you sure you want to enable?');"
                        ));
                      }
                                 ?>
            </td>
            <td>
               <?php
                      echo $this->Html->link('Edit',array(
                        'action'=>'edit',
                        $data['Officer']['id']
                      ),array(
                          'escape'=>false,
                          'class'=>'btn btn-success btn-mini',
                          'onclick'=>"return confirm('Are you sure you want to edit?');"
                        ));
                       ?>
                                  </td>
                                  <td>
                                       <?php

                       echo $this->Html->link('Trash',array(
                           'action'=>'trash',
                           $data['Officer']['id']
                         ),array(
                            'escape'=>false,
                            'class'=>'btn btn-danger btn-mini',
                            'onclick'=>"return confirm('Are you sure you want to delete?');"
                          ));
                       
                        ?>
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
    <span style="color:red;">No records found!</span>
<?php    
}
?>                    