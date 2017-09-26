<div class="prisoner-box">
                                <div class="span2">
                                    <div class="text-left">
                                        <?php $image = $this->Html->image('../files/prisnors/'.$data["Prisoner"]["photo"], array('escape'=>false, 'class'=>'img', 'alt'=>''));
                                         echo $this->Html->link($image, array('controller'=>'prisoners', 'action'=>'details', $data["Prisoner"]["uuid"]), array('escape'=>false));   ?>
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