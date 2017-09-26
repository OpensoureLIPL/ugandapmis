<?php
if(is_array($data) && count($data)>0){
?>
<div class="container-fluid"><hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> 
                    <h5>Prisoner's Details </h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="prisoner-box">
                                <div class="span2">
                                    <div class="text-left">
                                        <img src="<?php echo $this->webroot;?>files/prisnors/<?php echo $data["Prisoner"]["photo"]?>" class="img"   alt="" style="margin-left: 15px;">
                                    </div>
                                </div>
                                <div class="span5">
                                    <h4 >
                                        <?php echo $data["Prisoner"]["prisoner_no"]?>
                                    </h4>
                                    <h5>Father Name : <?php echo $data["Prisoner"]["father_name"]?></h5>
                                    <h5>Gender : <?php echo $data["Gender"]["name"]?></h5>
                                    <h5>Date of Birth : <?php echo date('d-m-Y',strtotime($data["Prisoner"]["date_of_birth"]));?></h5>
                                    <h5>Place of Birth : <?php echo $data["Prisoner"]["place_of_birth"]?></h5>
                                </div>
                                <div class="span5">
                                    <h4 >
                                        <p><?php echo $data["Prisoner"]["fullname"]?></p>
                                    </h4>
                                    <h5>Mother Name : <?php echo $data["Prisoner"]["mother_name"]?></h5>
                                    <h5>Country : <?php echo $data["Country"]["name"]?></h5>
                                    <h5>Region : <?php echo $data["State"]["name"]?></h5>
                                    <h5>District : <?php echo $data["District"]["name"]?></h5>
                                </div>
                                <p></p>
                            </div>    
                        </div>
                    </div>
                    <br/>
                    <div class="row-fluid">
                        <div class="span3">
                            <div class="prisoner-box modules">
                                <h5 class="text-center">
                                    Admission details
                                </h5>
                                <p class="text-center">
                                    <?php echo $this->Html->link($this->Html->image('gallery/admission.png', array('class'=>'img img-responsive')), array('controller'=>'prisoners', 'action'=>'edit', $data['Prisoner']['uuid']), array('escape'=>false))?>
                                </p>
                            </div>    
                        </div>
                        <div class="span3">
                            <div class="prisoner-box modules">
                                <h5 class="text-center">
                                    <a> Sentences</a>
                                </h5>
                                <p class="text-center">
                                    <?php echo $this->Html->link($this->Html->image('gallery/sentence.png', array('class'=>'img img-responsive')), array('controller'=>'prisoners', 'action'=>'../sentence/index', $data['Prisoner']['uuid']), array('escape'=>false))?>
                                </p>
                            </div>
                        </div>
                        <!-- <div class="span3">
                            <div class="prisoner-box modules">
                                <h5 class="text-center">
                                    Earnings
                                </h5>
                                <p class="text-center">
                                     <?php echo $this->Html->link($this->Html->image('gallery/earnings.png', array('class'=>'img img-responsive')), array('controller'=>'prisoners', 'action'=>'edit', $data['Prisoner']['uuid']), array('escape'=>false))?>
                                </p>
                            </div>
                        </div> -->
                        <div class="span3">
                            <div class="prisoner-box modules">
                                <h5 class="text-center">
                                    Medical Records
                                </h5>
                                <p class="text-center">
                                    <?php echo $this->Html->link($this->Html->image('gallery/medical.png', array('class'=>'img img-responsive')), array('controller'=>'medicalRecords', 'action'=>'add', $data['Prisoner']['uuid']), array('escape'=>false))?>
                                </p>
                            </div>
                        </div>  
                        <div class="span3">
                            <div class="prisoner-box modules">
                                <h5 class="text-center">
                                    Properties
                                </h5>
                                <p class="text-center">
                                    <?php echo $this->Html->link($this->Html->image('gallery/properties.png', array('class'=>'img img-responsive')), array('controller'=>'properties', 'action'=>'index', $data['Prisoner']['uuid']), array('escape'=>false))?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row-fluid">
                        <div class="span3">
                            <div class="prisoner-box modules">
                                <h5 class="text-center">
                                    Court Attendance
                                </h5>
                                <p class="text-center">
                                    <?php echo $this->Html->link($this->Html->image('gallery/court_attendance.png', array('class'=>'img img-responsive')), array('controller'=>'courtattendances', 'action'=>'index', $data['Prisoner']['uuid']), array('escape'=>false))?>
                                </p>
                            </div>  
                        </div>                    
                        <div class="span3">
                            <div class="prisoner-box modules">
                                <h5 class="text-center">
                                    Stages
                                </h5>
                                <p class="text-center">
                                    <?php echo $this->Html->link($this->Html->image('gallery/court_attendance.png', array('class'=>'img img-responsive')), array('controller'=>'stages', 'action'=>'stagesAssign', $data['Prisoner']['uuid']), array('escape'=>false))?>
                                </p>
                            </div>  
                        </div>
                        <div class="span3">
                            <div class="prisoner-box modules">
                                <h5 class="text-center">
                                    <a> Discipline</a>
                                </h5>
                                <p class="text-center">
                                    <?php echo $this->Html->link($this->Html->image('gallery/discipline.png', array('class'=>'img img-responsive')), array('controller'=>'inPrisonOffenceCapture', 'action'=>'index', $data['Prisoner']['uuid']), array('escape'=>false))?>
                                </p>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="prisoner-box modules">
                                <h5 class="text-center">
                                    Discharge
                                </h5>
                                <p class="text-center">
                                    <?php echo $this->Html->link($this->Html->image('gallery/discharge.png', array('class'=>'img img-responsive')), array('controller'=>'discharges', 'action'=>'index', $data['Prisoner']['uuid']), array('escape'=>false))?>
                                </p>
                            </div>
                        </div>    
                    </div>
                    <br/>
                    <div class="row-fluid">
                        <!-- <div class="span3">
                            <div class="prisoner-box modules">
                                <h5 class="text-center">
                                    Transfers
                                </h5>
                                <p class="text-center">
                                    <?php echo $this->Html->link($this->Html->image('gallery/transfers.png', array('class'=>'img img-responsive')), array('controller'=>'prisoners', 'action'=>'edit', $data['Prisoner']['uuid']), array('escape'=>false))?>
                                </p>
                            </div>
                        </div> -->                     
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>