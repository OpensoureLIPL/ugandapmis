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
        'before'                    => '$("#lodding_image").show();',
        'complete'                  => '$("#lodding_image").hide();',
        'url'                       => array(
            'controller'            => 'prisoners',
            'action'                => 'indexAjax',
            'prisoner_no'           => $prisoner_no,
            'prisoner_name'         => $prisoner_name,   
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
    $exUrl = "indexAjax/prisoner_no:$prisoner_no/prisoner_name:$prisoner_name";
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
            <th>Profile Photo</th>
            <th>Prisoner No.</th>
            <th>Name</th>
            <th>Father Name</th>
            <th>Mother Name</th>
            <th>Date of birth</th>
            <th>Place of birth</th>
            <th>Gender</th>
            
<?php
if(!isset($is_excel)){
?> 
            <th>Status</th>
            <th>Edit other detail</th>
            <th>Medical Records</th>
            <th>Properties</th>
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
        $prisoner_id = $data['Prisoner']['id'];
?>
        <tr>
            <td><?php echo $rowCnt; ?></td>
            <td>
<?php
        if($data['Prisoner']['photo'] != ''){
            echo $this->Html->image('../files/prisnors/'.$data["Prisoner"]["photo"], array('escape'=>false, 'width'=>'75px', 'alt'=>''));
        }else if($data["Prisoner"]["name"] == Configure::read('GENDER_FEMALE')){
            echo $this->Html->image('female.jpg', array('escape'=>false, 'width'=>'75px', 'alt'=>''));
        }else{
            echo $this->Html->image('male.png', array('escape'=>false, 'width'=>'75px', 'alt'=>''));
        }
                
?>
            </td>
            <td><?php echo $data["Prisoner"]["prisoner_no"]?></td>
            <td><?php echo $data["Prisoner"]["fullname"]?> </td>
            <td><?php echo $data["Prisoner"]["father_name"]?></td>
            <td><?php echo $data["Prisoner"]["mother_name"]?></td>
            <td><?php echo date('d-m-Y',strtotime($data["Prisoner"]["date_of_birth"]));?></td>
            <td><?php echo $data["Prisoner"]["place_of_birth"]?></td>
            <td><?php echo $data["Gender"]["name"]?></td>
<?php
        if(!isset($is_excel)){
?>              
            <td>
                      <?php
                      if($data['Prisoner']['is_enable'] == 1){
                        echo $this->Html->link("Click To Disable",array(
                          'controller'=>'prisoners',
                          'action'=>'disable',$prisoner_id
                        ),array(
                          'escape'=>false,
                          'class'=>'btn btn-primary btn-mini',
                          'onclick'=>"return confirm('Are you sure you want to disable?');"
                        ));
                      }else{
                        echo $this->Html->link("Click To Enable",array(
                          'controller'=>'prisoners',
                          'action'=>'enable',$prisoner_id
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
                      echo $this->Html->link('Other Detail',array(
                        'action'=>'edit',$prisoner_id
                      ),array(
                          'escape'=>false,
                          'class'=>'btn btn-success btn-mini'
                        ));
                       ?>
                                  </td>
                                   <td>
               <?php
                      echo $this->Html->link('Medical Records',array(
                        'controller'=>'medicalRecords',
                        'action'=>'add',$data['Prisoner']['uuid']
                      ),array(
                          'escape'=>false,
                          'class'=>'btn btn-success btn-mini'
                        ));
                       ?>
                                  </td>
                                  <td>
               <?php
                      echo $this->Html->link('Properties',array(
                        'controller'=>'properties',
                        'action'=>'add',$prisoner_id
                      ),array(
                          'escape'=>false,
                          'class'=>'btn btn-success btn-mini'
                        ));
                       ?>
                                  </td>
            <td>
<?php
            if($usertype_id == Configure::read('RECEPTIONIST_USERTYPE')){
                if($data["Prisoner"]["is_final_save"] == 0){
                    echo $this->Html->link('Trash',array('action'=>'trash',$prisoner_id),array('escape'=>false,'class'=>'btn btn-danger btn-mini','onclick'=>"return confirm('Are you sure you want to delete?');"));
                }else if($data["Prisoner"]["is_final_save"] == 1 && $data["Prisoner"]["is_verify"] == 0){
                    echo '<span style="color:red;font-weight:bold;">Not verified yet!</span>';
                }else if($data["Prisoner"]["is_verify"] == 1 && $data["Prisoner"]["is_approve"] == 0){
                    echo '<span style="color:red;font-weight:bold;">Verified but not approve!</span>';
                }else if($data["Prisoner"]["is_approve"] == 1){
                    echo '<span style="color:green;font-weight:bold;">Approved !</span>';
                }
            }else if($usertype_id == Configure::read('OFFICERINCHARGE_USERTYPE')){
                if($data["Prisoner"]["is_final_save"] == 1 && $data["Prisoner"]["is_verify"] == 0){
                    echo $this->Html->link('Verify', 'javascript:void(0);',array('escape'=>false,'class'=>'btn btn-danger btn-mini','onclick'=>"javascript:verifyPrisoner($prisoner_id);"));
                }else if($data["Prisoner"]["is_verify"] == 1 && $data["Prisoner"]["is_approve"] == 0){
                    echo '<span style="color:red;font-weight:bold;">Not approve yet!</span>';
                }else if($data["Prisoner"]["is_approve"] == 1){
                    echo '<span style="color:green;font-weight:bold;">Approved !</span>';
                }
            }else if($usertype_id == Configure::read('PRINCIPALOFFICER_USERTYPE')){
                if($data["Prisoner"]["is_verify"] == 1 && $data["Prisoner"]["is_approve"] == 0){
                    echo $this->Html->link('Approve',array('action'=>'trash',$data['Prisoner']['id']),array('escape'=>false,'class'=>'btn btn-danger btn-mini','onclick'=>"javascript:approvePrisoner($prisoner_id);"));
                }else if($data["Prisoner"]["is_approve"] == 1){
                    echo '<span style="color:green;font-weight:bold;">Approved !</span>';
                }
            }               
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