<?php
if(is_array($datas) && count($datas)>0){
    $rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
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
    </div>
</div>
<div class="row-fluid">
<?php    
    //$rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
    $rowCnt = 0;
    foreach($datas as $data){  
        $uuid = $data["Prisoner"]["uuid"];
?>
    <div class="span3">
        <div class="prisoner-box">
            <div class="text-center">

<?php       
        if($data['Prisoner']['photo'] != ''){
            $image = $this->Html->image('../files/prisnors/'.$data["Prisoner"]["photo"], array('escape'=>false, 'class'=>'img', 'alt'=>''));
        }else if($data["Prisoner"]["name"] == Configure::read('GENDER_FEMALE')){
            $image = $this->Html->image('female.png', array('escape'=>false, 'class'=>'img', 'alt'=>''));
        }else{
            $image = $this->Html->image('male.png', array('escape'=>false, 'class'=>'img', 'alt'=>''));
        }      
        echo $this->Html->link($image , array('controller'=>'prisoners', 'action'=>'details', $data["Prisoner"]["uuid"]), array('escape'=>false));     
?>         
            </div>
            <h5 class="text-center"><?php echo $data["Prisoner"]["prisoner_no"]?></h5>
            <p class="text-center"><?php echo $data["Prisoner"]["fullname"]?></p>
            <div class="text-center">
                <?php //echo $this->Html->link('<i class="icon-eye-open"></i>' , array('controller'=>'prisoners', 'action'=>'details', $uuid), array('escape'=>false, 'class'=>'btn btn-success')); ?>
                <!-- <a  class="btn btn-info" ><i class="icon-check"></i></a>  -->
                
                <?php 
                if($usertype_id == Configure::read('RECEPTIONIST_USERTYPE'))
                {
                    if($data["Prisoner"]["is_final_save"] == 0)
                    {
                        echo $this->Html->link('<i class="icon-save" ></i>','javascript:void(0);',array('escape'=>false,'class'=>'btn btn-success','title'=>'Final Save','onclick'=>"javascript:finalSavePrisoner('$uuid');"));
                        
                        echo '&nbsp;&nbsp;'.$this->Html->link('<i class="icon-trash" ></i>','javascript:void(0);',array('escape'=>false,'class'=>'btn btn-danger','title'=>'Delete','onclick'=>"javascript:trashPrisoner('$uuid');"));
                    }
                    else if($data["Prisoner"]["is_final_save"] == 1 && $data["Prisoner"]["is_verify"] == 0){
                        
                        echo '<span style="color:red;font-weight:bold;">Not verified yet!</span>';
                    }
                    else if($data["Prisoner"]["is_verify"] == 1 && $data["Prisoner"]["is_approve"] == 0){

                        echo '<span style="color:red;font-weight:bold;">Verified but not approve!</span>';
                    }
                    else if($data["Prisoner"]["is_approve"] == 1){

                        echo '<span style="color:green;font-weight:bold;">Approved !</span>';
                    }
                }
                else if($usertype_id == Configure::read('OFFICERINCHARGE_USERTYPE'))
                {
                    if($data["Prisoner"]["is_final_save"] == 1 && $data["Prisoner"]["is_verify"] == 0){
                        
                        echo $this->Html->link('Verify
','javascript:void(0);',array('escape'=>false,'class'=>'btn btn-warning','onclick'=>"javascript:verifyPrisoner('$uuid');"));
                    }
                    else if($data["Prisoner"]["is_verify"] == 1 && $data["Prisoner"]["is_approve"] == 0){
                        echo '<span style="color:red;font-weight:bold;">Not approve yet!</span>';
                    }
                    else if($data["Prisoner"]["is_approve"] == 1){
                        echo '<span style="color:green;font-weight:bold;">Approved !</span>';
                    }
                }
                else if($usertype_id == Configure::read('PRINCIPALOFFICER_USERTYPE'))
                {
                    if($data["Prisoner"]["is_verify"] == 1 && $data["Prisoner"]["is_approve"] == 0){
                       
                       echo $this->Html->link('Approve
','javascript:void(0);',array('escape'=>false,'class'=>'btn btn-success','onclick'=>"javascript:approvePrisoner('$uuid');"));
                    }else if($data["Prisoner"]["is_approve"] == 1){
                        echo '<span style="color:green;font-weight:bold;">Approved !</span>';
                    }
                }
                ?>
            </div>
        </div> 
    </div>
<?php
        $rowCnt++;
        if($rowCnt % 4 == 0){
?>
</div>
<br />
<div class="row-fluid">
<?php            
        }
    }
?>
</div>
<?php    
}else{
?>
    ...
<?php    
}
?>                    