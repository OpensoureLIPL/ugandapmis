<style>
.row-fluid [class*="span"]
{
  margin-left: 0px !important;
}
</style>
<?php //echo '<pre>'; print_r($this->request->data); echo '</pre>';?>
<div class="container-fluid">
    <div class="row-fluid">
    <div id="commonheader"></div>
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                    
                    <div style="float:right;padding-top: 3px;">
                        <?php echo $this->Html->link('Prisoners List',array('action'=>'index'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                
                <div class="widget-content nopadding">
                    <div class="">
                        <ul class="nav nav-tabs">
                            <li><a href="#personal_info">Personal Details</a></li>
                            <li><a href="#id_proof_details" id="id_proof">ID Proof Details</a></li>
                            <li><a href="#kin_details" id="kin_details_tab">Kin Details</a></li>
                            <?php if(isset($this->request->data['Prisoner']['gender_id']) && ($this->request->data['Prisoner']['gender_id'] == 2))
                            {?>
                                <li><a href="#child_details" id="child_details_tab">Recording of Children</a></li>
                            <?php }?>
                            <li><a href="#admission_details">Admission Details</a></li>
                            <li><a href="#special_needs" id="special_needs_tab">Special Needs</a></li>
                            <li><a href="#offence_details" id="offence_details_tab">Offence Capture</a></li>
                            <li><a href="#offence_counts" id="offence_counts_tab">Offence Counts Details</a></li>
                            <li><a href="#recaptured_details" id="recaptured_details_tab">Recaptured Details</a></li>
                            <!-- <li class="pull-right controls"> -->
                            <li class="controls pull-right">
                                <ul class="nav nav-tabs">
                                    <li><a href="#prev">&lsaquo; Prev</a></li>
                                    <li><a href="#next">Next &rsaquo;</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="tabscontent">
                            <div id="personal_info">
                                <?php echo $this->Form->create('Prisoner',array('class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
                                <?php echo $this->Form->input('id');?>
                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">First Name<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('first_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter First Name','id'=>'first_name'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Surname<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('last_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Surname','required','id'=>'last_name'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Father's Name<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('father_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Father's Name",'required','id'=>'father_name'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Mother's Name :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('mother_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Mother's Name",'required'=>false,'id'=>'mother_name'));?>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of Birth<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_birth',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Birth','required','readonly'=>'readonly','id'=>'date_of_birth'));?>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Place Of Birth<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('place_of_birth',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Place Of Birth','required','id'=>'place_of_birth'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div>                                                                     
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Sex<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('gender_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$genderList, 'empty'=>'-- Select Gender --','required','id'=>'gender_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Country Of Origin<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('country_id',array('div'=>false,'label'=>false,'onChange'=>'showRegions(this.value)','class'=>'form-control span11','type'=>'select','options'=>$countryList, 'empty'=>'-- Select Country --','required','id'=>'country_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Nationality<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('nationality_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Nationality','required'=>false,'id'=>'nationality_name','readonly'=>'readonly'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Region<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('state_id',array('div'=>false,'label'=>false,'onChange'=>'showDistricts(this.value)','class'=>'form-control span11','type'=>'select','options'=>$stateList, 'empty'=>'-- Select Region --','required','id'=>'state_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                     
                                    <div class="clearfix"></div> 
                                    
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Tribe<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('tribe_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$tribeList, 'empty'=>'-- Select Tribe --','required','id'=>'tribe_id'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">District Of Origin:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('district_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$districtList, 'empty'=>'-- Select District --','required'=>false,'id'=>'district_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Classification<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('classification_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$classificationList, 'empty'=>'-- Select Classification --','required','id'=>'classification_id'));?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Permanent Address :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('permanent_address',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'textarea','placeholder'=>'Enter permanent address','id'=>'permanent_address','rows'=>3,'required'=>false));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Photo :</label>
                                            <div class="controls">
                                                <div>
                                                    <?php if(isset($this->request->data["Prisoner"]["photo"]))
                                                    {?>
                                                        <img src="<?php echo $this->webroot; ?>app/webroot/files/prisnors/<?php echo $this->request->data["Prisoner"]["photo"];?>" alt="" width="150px" height="150px">
                                                    <?php }?>
                                                </div>
                                                <?php echo $this->Form->input('photo',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'file','id'=>'photo'));?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Apparent religion :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('apparent_religion',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Apparent Religion','required'=>false));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>                          
                                </div>

                                <div class="form-actions" align="center">
                                    <button type="submit" id="saveBtn" class="btn btn-success" formnovalidate="true">Save</button>
                                </div>
                                <?php echo $this->Form->end();?>
                            </div>
                            <div id="id_proof_details" class="lorem">
                                <?php echo $this->Form->create('PrisonerIdDetail',array('class'=>'form-horizontal','url' => '/prisoners/prisnorsIdInfo'));?>
                                <?php echo $this->Form->input('id');?>
                                <?php  echo $this->Form->input('prisoner_id',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['id']
                                      ));

                                      echo $this->Form->input('puuid',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['uuid']
                                      ));

                                ?>
                                
                                <div class="row-fluid" style="padding-bottom: 14px;">
                                   <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Id Name<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('id_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$id_name, 'empty'=>'-- Select Id --','required'=>false,'id'=>'id_name'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Id Number<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('id_number',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Id Number','required'=>false,'id'=>'id_number'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                </div>
                                <div class="form-actions" align="center">
                                    <button type="submit" tabcls="next" id="saveBtn_iddetail" class="btn btn-success" formnovalidate="true">Save</button>
                                </div>
                                <?php echo $this->Form->end();?>

                                <div id="personalid_listview">
                                </div>
                            </div>
                            <div id="kin_details">
                                <?php echo $this->Form->create('PrisonerKinDetail',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','url' => '/prisoners/PrisonerKinDetail'));?>
                                <?php echo $this->Form->input('id');?>
                                <?php  echo $this->Form->input('prisoner_id',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['id']
                                      ));
                                      echo $this->Form->input('puuid',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['uuid']
                                      ));
                                ?>
                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">First Name<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('first_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter First Name','required','id'=>'first_name'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Surname<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('last_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Surname','required','id'=>'last_name'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Relationship<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('relationship',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Relationship",'required','id'=>'relationship'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Sex<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('gender_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$genderList, 'empty'=>'-- Select Gender --','required','id'=>'gender_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                     
                                    <div class="clearfix"></div>                   
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Phone Number :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('phone_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Phone Number','required'=>false,'id'=>'phone_no'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Physical Address<?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->textarea('physical_address',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Physical Address','required'=>false,'id'=>'physical_address'));?>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="clearfix"></div>                           
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Village<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                
                                                <?php echo $this->Form->input('village',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Village",'required','id'=>'village'));?>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Parish<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                
                                                <?php echo $this->Form->input('parish',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Parish",'required','id'=>'parish'));?>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Gombolola:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('gombolola',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Gombolola",'required'=>false,'id'=>'gombolola'));?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">District:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('district_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$allDistrictList, 'empty'=>'-- Select District --','required'=>false,'id'=>'district_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>  
                                    
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Name Of Chief:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('chief_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Name of chief','required'=>false,'id'=>'chief_name'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="clearfix"></div>  

                                                          
                                </div>

                                <div class="form-actions" align="center">
                                    <button type="submit" tabcls="next" id="saveBtn" class="btn btn-success">Save</button>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div id="prisonerkindata_listview">
                                </div>
                            </div>
                            <div id="child_details">
                                <?php echo $this->Form->create('PrisonerChildDetail',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','url' => '/prisoners/prisonerChildDetail'));
                                    echo $this->Form->input('id');
                                    echo $this->Form->input('prisoner_id',array(
                                            'type'=>'hidden',
                                            'class'=>'prisoner_id',
                                            'value'=>$this->request->data['Prisoner']['id']
                                          ));
                                    echo $this->Form->input('puuid',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['uuid']
                                      ));
                                ?>

                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Prisoner Number<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prisoner_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Prisoner Number','id'=>'prisoner_no', 'readonly','value'=>$this->request->data['Prisoner']['prisoner_no']));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Name Of Child <?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Name Of Child','required','id'=>'name'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of Birth<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('dob',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Birth','required','readonly'=>'readonly','id'=>'dob'));?>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Place Of Birth<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('birth_place',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Place Of Birth','required','id'=>'birth_place'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Father's Name<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('father_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Father's name",'required','id'=>'father_name'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Gender<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('gender_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$genderList, 'empty'=>'-- Select Gender --','required','id'=>'gender_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                     
                                    <div class="clearfix"></div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Child Medical<br/> Condition :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->textarea('medical_cond',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Child Medical Condition','required'=>false,'id'=>'medical_cond'));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Date of Handover:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('handover_dt',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Handover','required','readonly'=>'readonly','id'=>'handover_dt'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Name Of Person<br/> Receiving:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('rcv_person',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Name Of Person Receiving",'required'=>false,'id'=>'rcv_person'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Address of person receiving :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->textarea('rcv_person_add',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Address of person receiving','required'=>false,'id'=>'rcv_person_add'));?>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="clearfix"></div>                      
                                </div>

                                <div class="form-actions" align="center">
                                    <button type="submit" tabcls="next" id="saveBtn" class="btn btn-success">Save</button>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div id="prisonerchilddata_listview"></div>
                            </div>
                             <div id="admission_details">
                                <?php echo $this->Form->create('PrisonerAdmissionDetail',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','url' => '/prisoners/prisonerAdmissionDetail'));
                                echo $this->Form->input('id',array('type'=>'hidden'));
                                echo $this->Form->input('prisoner_id',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['id']
                                      ));
                                echo $this->Form->input('puuid',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['uuid']
                                      ));
                                ?>
                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Personal Number<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('personal_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Personal Number','id'=>'personal_no'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Prisoner Number<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prisoner_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Name Of Child','required','id'=>'prisoner_no',  'readonly','value'=>$this->request->data['Prisoner']['prisoner_no']));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Prison Station<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php 
                                                echo $this->Form->input('prisoner_station',array(
                                                    'type'=>'hidden',
                                                    'class'=>'prison_station',
                                                    'value'=>$prison_id
                                                  ));
                                                echo $this->Form->input('prison_station_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Prison Station','required','readonly','value'=>$prison_name, 'id'=>'prison_station_name'));?>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Offence<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php 
                                                $idname = "'section_of_law'";
                                                echo $this->Form->input('offence',array('div'=>false,'label'=>false,'onChange'=>'showSOLaws(this.value,'.$idname.')','class'=>'form-control span11','type'=>'select','options'=>$offenceList, 'empty'=>'-- Select Offence --','required','id'=>'offence'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Court File No<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('court_file_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Court File No",'required','id'=>'court_file_no'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Section Of Law<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php 
                                                echo $this->Form->input('section_of_law',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$soLawList, 'empty'=>'-- Select Section Of Law --','required','id'=>'section_of_law'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Case File No. <?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('case_file_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'CASE FILE No.','required'=>false,'id'=>'case_file_no',));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">C.R.B No.<?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('crb_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter C.R.B No.','required'=>false,'id'=>'crb_no'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Court<?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('court',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Court",'required'=>false,'id'=>'court'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">District where offence was committed :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('district_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$allDistrictList, 'empty'=>'-- Select District --','required'=>false,'id'=>'district_id'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">No of Previous <br/>Conviction <?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('no_of_prev_conviction',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter No of Previous Conviction",'required'=>false,'id'=>'no_of_prev_conviction'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Date of Committal:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_committal',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Committal','required','readonly'=>'readonly','id'=>'date_of_committal'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div>  
                                     <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Date of Sentence:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_sentence',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Sentence','required','readonly'=>'readonly','id'=>'date_of_sentence'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Date of Conviction:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_conviction',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Conviction','required','readonly'=>'readonly','id'=>'date_of_conviction'));?>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="clearfix"></div>
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Marital Status<?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('marital_status_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$maritalStatusList, 'empty'=>'-- Select Marital Status --','required'=>false,'id'=>'marital_status_id'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div>
                                   <h4 class="text-center"> Sentence Details</h4>
                                   <?php echo $this->Form->input('PrisonerSentenceDetail.id',array('type'=>'hidden'));?>
                                   <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Years:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('PrisonerSentenceDetail.years',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Years','required'=>false,'id'=>'years',));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Months:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('PrisonerSentenceDetail.months',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Months','required'=>false,'id'=>'months'));?>
                                            </div>
                                        </div>
                                    </div>  

                                   <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Days:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('PrisonerSentenceDetail.days',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Days','required'=>false,'id'=>'days',));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">No Of Strokes:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('PrisonerSentenceDetail.no_of_strokes',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter No Of Strokes','required'=>false,'id'=>'no_of_strokes'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">E.M No. of days:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('PrisonerSentenceDetail.em_no_of_days',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter E.M No. of days','required'=>false,'id'=>'em_no_of_days',));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Class<?php echo $req; ?> :</label>
                                           <div class="controls">
                                                <?php echo $this->Form->input('PrisonerSentenceDetail.class',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$classificationList, 'empty'=>'-- Select Class --','required','id'=>'class'));?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Fine (Amount) In addition to imprisonment or default of further sentence:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('PrisonerSentenceDetail.fine_with_imprisonment',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Fine (Amount)','required'=>false,'id'=>'fine_amount',));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Fine (Amount)  Only or in default Imprisonment:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('PrisonerSentenceDetail.fine_amount',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Fine (Amount)','required'=>false,'id'=>'fine_amount'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Receipt Number :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('PrisonerSentenceDetail.receipt_number',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Receipt Number ','required'=>false,'id'=>'receipt_number',));?>
                                            </div>
                                        </div>
                                    </div>    
                                </div>

                                <div class="form-actions" align="center">
                                    <button type="save" tabcls="next" id="saveBtn" class="btn btn-success">Save</button>
                                </div>
                                <?php echo $this->Form->end();?>
                            </div>
                            <div id="special_needs">
                                <?php echo $this->Form->create('PrisonerSpecialNeed',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','url' => '/prisoners/prisonerSpecialNeed'));
                                echo $this->Form->input('id',array('type'=>'hidden'));
                                echo $this->Form->input('prisoner_id',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['id']
                                      ));
                                echo $this->Form->input('puuid',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['uuid']
                                      ));
                                echo $this->Form->input('prison_station',array(
                                        'type'=>'hidden',
                                        'class'=>'prison_station',
                                        'value'=>$prison_id
                                      ));
                                ?>
                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Prison Station<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prison_station_name',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Prison Station','required','readonly','value'=>$prison_name, 'id'=>'prison_station_name'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Prisoner Number<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prisoner_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Name Of Child','required','id'=>'prisoner_no',  'readonly','value'=>$this->request->data['Prisoner']['prisoner_no']));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Type Of Disability :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('type_of_disability',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$disabilityList, 'empty'=>'-- Select Type Of Disability --','id'=>'type_of_disability'));?>
                                            </div>
                                        </div>
                                    </div>   
                                    
                                    <div class="clearfix"></div> 
                                        
                                </div>

                                <div class="form-actions" align="center">
                                    <button type="submit" tabcls="next" id="saveBtn" class="btn btn-success">Save</button>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div id="specialneed_listview"></div>
                            </div>
                            <div id="offence_details">
                                <?php echo $this->Form->create('PrisonerOffenceDetail',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','url' => '/prisoners/prisonerOffenceDetail'));
                                echo $this->Form->input('id',array('type'=>'hidden'));
                                echo $this->Form->input('prisoner_id',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['id']
                                      ));
                                echo $this->Form->input('prisoner_no',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_no',
                                        'value'=>$this->request->data['Prisoner']['prisoner_no']
                                      ));
                                echo $this->Form->input('puuid',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['uuid']
                                      ));
                                $unique_personal_no = $funcall->prisonerPersonalNumber($this->request->data['Prisoner']['uuid']);
                                ?>
                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Personal Number<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('personal_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Personal Number','required','id'=>'personal_no', 'value'=>$unique_personal_no, 'readonly'));?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Offence<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php 
                                                $idname = "'ofnc_section_of_law'";
                                                echo $this->Form->input('offence',array('div'=>false,'label'=>false,'onChange'=>'showSOLaws(this.value,'.$idname.')','class'=>'form-control span11','type'=>'select','options'=>$offenceList, 'empty'=>'-- Select Offence --','required','id'=>'offence'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Court File No<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('court_file_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Court File No",'required','id'=>'court_file_no'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Section Of Law<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('section_of_law',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$ofnc_soLawList, 'empty'=>'-- Select Section Of Law --','required','id'=>'ofnc_section_of_law'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Case File No.<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('case_file_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'CASE FILE No.','required'=>false,'id'=>'case_file_no',));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">C.R.B No.<?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('crb_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter C.R.B No.','required'=>false,'id'=>'crb_no'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Court <?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('court',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter Court",'required'=>false,'id'=>'court'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">District where offence was committed :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('district_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$allDistrictList, 'empty'=>'-- Select District --','required'=>false,'id'=>'district_id'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">No of Previous <br/>Convictions <?php echo $req; ?>:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('no_of_prev_conviction',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>"Enter No of Previous Conviction",'required'=>false,'id'=>'no_of_prev_conviction'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Date of Committal:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_commital',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Committal','required'=>false,'readonly'=>'readonly','id'=>'date_of_commital'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div>
                                    </div>

                                <div class="form-actions" align="center">
                                    <button type="submit" tabcls="next" id="saveBtn" class="btn btn-success">Save</button>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div id="offencedetail_listview"></div>
                            </div>
                            <div id="offence_counts">
                                <?php echo $this->Form->create('PrisonerOffenceCount',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','url' => '/prisoners/prisonerOffenceCount'));
                                echo $this->Form->input('id',array('type'=>'hidden'));
                                echo $this->Form->input('prisoner_id',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['id']
                                      ));
                                echo $this->Form->input('prisoner_no',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_no',
                                        'value'=>$this->request->data['Prisoner']['prisoner_no']
                                      ));
                                echo $this->Form->input('puuid',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['uuid']
                                      ));
                                ?>
                                <div class="row" style="padding-bottom: 14px;">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Offence ID<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php //echo $this->Form->input('offence_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Offence','required','id'=>'offence_id'));?>
                                                <?php 
                                                echo $this->Form->input('offence_id',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$offenceIdList, 'empty'=>'-- Select Offence --','required'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Count Description<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->textarea('count_desc',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Count Description','required','id'=>'count_desc'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                    
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Date of Committal:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_commital',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Committal','required'=>false,'readonly'=>'readonly','id'=>'ofnc_date_of_commital'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    
                                     <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Date of Sentence:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_sentence',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Sentence','required'=>false,'readonly'=>'readonly','id'=>'ofnc_date_of_sentence'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div>  
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Date of Conviction<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_conviction',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Conviction','required','readonly'=>'readonly','id'=>'ofnc_date_of_conviction'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Requires Confirmation :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('requires_confirmation',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$yesno, 'empty'=>'-- Select District --','required'=>false,'id'=>'requires_confirmation'));?>
                                            </div>
                                        </div>
                                    </div>     
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Prisoner Waiting For Confirmation :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prisoner_waiting_confirmation',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$yesno, 'empty'=>'-- Select District --','required'=>false,'id'=>'prisoner_waiting_confirmation'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="span6">
                                         <div class="control-group">
                                            <label class="control-label">Date of Confirmation:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_confirmation',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Confirmation','required'=>false,'readonly'=>'readonly','id'=>'date_of_confirmation'));?>
                                            </div>
                                        </div>
                                    </div>     
                                    <div class="clearfix"></div>
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Appealed Against sentence:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('appealed_against_sentence',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$yesno, 'empty'=>'-- Select District --','required'=>false,'id'=>'appealed_against_sentence'));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Appeal status:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('appeal_status',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$aplstatus, 'empty'=>'-- Select District --','required'=>false,'id'=>'appeal_status'));?>
                                            </div>
                                        </div>
                                    </div>  
                                   <div class="clearfix"></div> 
                                   <div class="span6">
                                         <div class="control-group">
                                            <label class="control-label">Date of Dismissal of Appeal:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('date_of_dismissal_appeal',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Dismissal of Appeal','required'=>false,'readonly'=>'readonly','id'=>'date_of_dismissal_appeal'));?>
                                            </div>
                                        </div>
                                    </div>     
                                    <div class="clearfix"></div>
                                   <h4 class="text-center"> Sentence Details</h4>
                                   <?php echo $this->Form->input('Offence.PrisonerSentenceDetail.id',array('type'=>'hidden'));
                                   echo $this->Form->input('Offence.PrisonerSentenceDetail.id',array('type'=>'hidden'));
                                   echo $this->Form->input('Offence.PrisonerSentenceDetail.sentence_type',array(
                                        'type'=>'hidden',
                                        'class'=>'sentence_type',
                                        'value'=>'offence'
                                      ));
                                    echo $this->Form->input('puuid',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['uuid']
                                      ));
                                   ?>

                                   <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Years:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('Offence.PrisonerSentenceDetail.years',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Years','required'=>false,'id'=>'years',));?>
                                            </div>
                                        </div>
                                    </div>                           
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Months:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('Offence.PrisonerSentenceDetail.months',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Months','required'=>false,'id'=>'months'));?>
                                            </div>
                                        </div>
                                    </div>  

                                   <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Days:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('Offence.PrisonerSentenceDetail.days',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Days','required'=>false,'id'=>'days',));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">No Of Strokes:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('Offence.PrisonerSentenceDetail.no_of_strokes',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter No Of Strokes','required'=>false,'id'=>'no_of_strokes'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">E.M No. of days:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('Offence.PrisonerSentenceDetail.em_no_of_days',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter E.M No. of days','required'=>false,'id'=>'em_no_of_days',));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Class<?php echo $req; ?> :</label>
                                           <div class="controls">
                                                <?php echo $this->Form->input('Offence.PrisonerSentenceDetail.class',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$classificationList, 'empty'=>'-- Select Class --','required','id'=>'classification_id'));?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Fine (Amount) With Imprisonment:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('Offence.PrisonerSentenceDetail.fine_with_imprisonment',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Fine (Amount)','required'=>false,'id'=>'fine_with_imprisonment',));?>
                                            </div>
                                        </div>
                                    </div>                             
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Fine (Amount):</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('Offence.PrisonerSentenceDetail.fine_amount',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Fine (Amount)','required'=>false,'id'=>'fine_amount'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Receipt Number :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('Offence.PrisonerSentenceDetail.receipt_number',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Receipt Number ','required'=>false,'id'=>'receipt_number',));?>
                                            </div>
                                        </div>
                                    </div>    
                                
                                
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Court where sentence was awarded:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->text('Offence.PrisonerSentenceDetail.court_whr_sentence_awarded',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text', 'placeholder'=>'Enter Court where sentence was awarded','required'=>false,'id'=>'court_whr_sentence_awarded',));?>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="clearfix"></div>   
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Section Of Law<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php 
                                                echo $this->Form->input('Offence.PrisonerSentenceDetail.section_of_law',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'select','options'=>$soLawList, 'empty'=>'-- Select Section Of Law --','required','id'=>'section_of_law'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    </div> 
                                <div class="form-actions" align="center">
                                    <button type="submit" tabcls="next" id="saveBtn" class="btn btn-success">Save</button>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div id="offencecount_listview"></div>
                            </div>
                            <div id="recaptured_details">
                                <?php echo $this->Form->create('PrisonerRecaptureDetail',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','url' => '/prisoners/prisonerRecaptureDetail'));
                                echo $this->Form->input('id',array('type'=>'hidden'));
                                echo $this->Form->input('prisoner_id',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['id']
                                      ));
                                echo $this->Form->input('puuid',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_id',
                                        'value'=>$this->request->data['Prisoner']['uuid']
                                      ));
                                ?>
                                <div class="row" style="padding-bottom: 14px;">
                                    
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Prisoner Number<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('prisoner_no',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Name Of Child','required','id'=>'prisoner_no',  'readonly','value'=>$this->request->data['Prisoner']['prisoner_no']));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Surname<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('surname',array('div'=>false,'label'=>false,'class'=>'form-control span11','type'=>'text','placeholder'=>'Enter Surname','required','id'=>'surname'));?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="clearfix"></div> 
                                    <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Date of Escape:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('escape_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Escape','required'=>false,'readonly'=>'readonly','id'=>'escape_date'));?>
                                            </div>
                                        </div>
                                    </div>  
                                    
                                     <div class="span6">
                                       <div class="control-group">
                                            <label class="control-label">Date of Recapture:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('recapture_date',array('div'=>false,'label'=>false,'class'=>'form-control mydate span11','type'=>'text', 'placeholder'=>'Enter Date of Recapture','required'=>false,'readonly'=>'readonly','id'=>'recapture_date'));?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix"></div> 
                                        
                                </div>

                                <div class="form-actions" align="center">
                                    <button type="submit" tabcls="next" id="saveBtn" class="btn btn-success">Save</button>
                                </div>
                                <?php echo $this->Form->end();?>
                                <div id="recapture_listview"></div>
                            </div>
                             <!--<div id="tab-3" class="lorem">
                             <?php //echo $this->Form->create('RelationshipDetail',array('class'=>'form-horizontal','url' => '/prisoners/prisnorsIdInfo'));?>
                              <?php //echo $this->Form->end();?>
                             </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
//goto offence count
    function goToOffenceCount(id)
    {
        $('#offence_counts_tab').click();
        //$("#PrisonerOffenceCountOffenceId option[value='" + id + "']").attr("selected", "true");
        $("select#PrisonerOffenceCountOffenceId").val(id);
    }

function showRegions(id) 
{ 
    var strURL = '<?php echo $this->Html->url(array('controller'=>'prisoners','action'=>'stateList'));?>';
    
    $.post(strURL,{"country_id":id},function(data){  
        
        if(data) { 
            $('#state_id').html(data); 
            
        }
        else
        {
            alert("Error...");  
        }
    });
}
function showDistricts(id) 
{ 
    var strURL = '<?php echo $this->Html->url(array('controller'=>'users','action'=>'getDistrict'));?>';
    
    $.post(strURL,{"state_id":id},function(data){  
        
        if(data) { 
            $('#district_id').html(data); 
            
        }
        else
        {
            alert("Error...");  
        }
    });
}
//get section of laws
function showSOLaws(id,solid)
{
    var solURL = '<?php echo $this->Html->url(array('controller'=>'prisoners','action'=>'getSectionOfLaws'));?>';
    
    $.post(solURL,{"offence_id":id},function(data){  
        
        if(data) { 
            $('#'+solid).html(data); 
            
        }
        else
        {
            alert("Error...");  
        }
    });
}

$(document).ready(function () {
  
});
$(document).on('click', '#prisone_id_edit', function() {
    var prisonerDetailId=$(this).attr("prisonerDetailId");
    $.ajax(
    {
        type: "POST",
        dataType: "json",
        url: "<?php echo $this->Html->url(array('controller'=>'prisoners','action'=>'prisnoriddetailedit'));?>",
        data: {
            prisonerDetailId: prisonerDetailId,
           
        },
        cache: true,
        beforeSend: function()
        {  
          //$('tbody').html('');
        },
        error: function ( jqXHR, textStatus, errorThrown) {
             alert("errorThrown: " + errorThrown + " textStatus:" + textStatus);
        },
        success: function (data) {

          $('#id_name option[value='+data.id_name+']').attr('selected','selected');
          //$("#id_name").val(data.id_name);
          $("#PrisonerIdDetailId").val(data.id);
          $("#id_number").val(data.id_number);
          $("#id").val(data.id);
          location.reload();
        },
        
    });
});

$(document).on('change', '#country_id', function() {
  var country_id=$(this).val();
   $.ajax(
    {
        type: "POST",
        dataType: "html",
        url: "<?php echo $this->Html->url(array('controller'=>'prisoners','action'=>'getNationName'));?>",
        data: {
            country_id: country_id,
           
        },
        cache: true,
        beforeSend: function()
        {  
          //$('tbody').html('');
        },
        error: function ( jqXHR, textStatus, errorThrown) {
             alert("errorThrown: " + errorThrown + " textStatus:" + textStatus);
        },
        success: function (data) {
          $("#nationality_name").val(data);
        },
        
    });
});  
$(function(){
    $("#PrisonerAddForm").validate({
     
      ignore: "",
            rules: {  
                'data[Prisoner][first_name]': {
                    required: true,
                },
                'data[Prisoner][last_name]': {
                    required: true,
                },
                'data[Prisoner][father_name]': {
                    required: true,
                },
                'data[Prisoner][mother_name]': {
                    required: true,
                },
                'data[Prisoner][date_of_birth]': {
                    required: true,
                },
                'data[Prisoner][place_of_birth]': {
                    required: true,
                },
                'data[Prisoner][gender]': {
                    required: true,
                },
                'data[Prisoner][country_id]': {
                    required: true,
                },
                'data[Prisoner][tribe_id]': {
                    required: true,
                }
                
            },
            messages: {
                'data[Prisoner][first_name]': {
                    required: "Please enter first name.",
                },
                'data[Prisoner][last_name]': {
                    required: "Please enter last name.",
                },
                'data[Prisoner][father_name]': {
                    required: "Please enter father name.",
                },
                'data[Prisoner][mother_name]': {
                    required: "Please enter mother name.",
                },
                'data[Prisoner][date_of_birth]': {
                    required: "Please choose date of birth.",
                },
                'data[Prisoner][place_of_birth]': {
                    required: "Please enter place of birth.",
                },
                'data[Prisoner][gender]': {
                    required: "Please select gender.",
                },
                'data[Prisoner][country_id]': {
                    required: "Please select country.",
                },
                'data[Prisoner][tribe_id]': {
                    required: "Please select tribe.",
                }
            },
               
    });
  });


</script>
<?php
$prisoner_uuid = $this->request->data['Prisoner']['uuid'];
$ajaxUrl = $this->Html->url(array('controller'=>'users','action'=>'getDistrict'));
$ajaxUrl_id_proof = $this->Html->url(array('controller'=>'prisoners','action'=>'idProofAjax'));
$deleteIdProofUrl = $this->Html->url(array('controller'=>'prisoners','action'=>'deleteIdProof'));
echo $this->Html->scriptBlock("
   var tabs;
    jQuery(function($) {
         showDataIdProof();
        tabs = $('.tabscontent').tabbedContent({loop: true}).data('api');
        // Next and prev actions
        $('.controls a').on('click', function(e) {
            var action = $(this).attr('href').replace('#', ''); 
            tabs[action]();
            e.preventDefault();
        });  
       $('#id_proof').on('click', function(e) {
            showDataIdProof();
            e.preventDefault();
       });
    }); 
    
    function showDataIdProof(){
        var url = '".$ajaxUrl_id_proof."';
        url = url + '/prisoner_id:'+'".$prisoner_uuid."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#personalid_listview').html(res);
            }
        });
    }

    //delete id proof 
    function deleteIdProof(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteIdProofUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDataIdProof();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

",array('inline'=>false));

//get kin details list
$ajaxUrl_kindetail = $this->Html->url(array('controller'=>'prisoners','action'=>'kinDetailAjax'));
$deleteKinUrl = $this->Html->url(array('controller'=>'prisoners','action'=>'deleteKin'));
echo $this->Html->scriptBlock("
   var tabs;
    jQuery(function($) {
         showDataKin();
        tabs = $('.tabscontent').tabbedContent({loop: true}).data('api');
        // Next and prev actions
        $('.controls a').on('click', function(e) {
            var action = $(this).attr('href').replace('#', ''); 
            tabs[action]();
            e.preventDefault();
        });  
       $('#kin_details_tab').on('click', function(e) {
            showDataKin();
            e.preventDefault();
       });
    }); 
    
    function showDataKin(){
        var url = '".$ajaxUrl_kindetail."';
        url = url + '/prisoner_id:'+'".$prisoner_uuid."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#prisonerkindata_listview').html(res);
            }
        });
    }

    //delete kin 
    function deleteKin(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteKinUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDataKin();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

",array('inline'=>false));

//get child details list
$ajaxUrl_childdetail = $this->Html->url(array('controller'=>'prisoners','action'=>'childDetailAjax'));
$deleteChildUrl = $this->Html->url(array('controller'=>'prisoners','action'=>'deleteChild'));
$deleteSpecialNeedUrl = $this->Html->url(array('controller'=>'prisoners','action'=>'deleteSpecialNeed'));
$deleteOffenceUrl = $this->Html->url(array('controller'=>'prisoners','action'=>'deleteOffence'));
$deleteOffenceCountUrl = $this->Html->url(array('controller'=>'prisoners','action'=>'deleteOffenceCount'));
$deleteRecaptureUrl = $this->Html->url(array('controller'=>'prisoners','action'=>'deleteRecapture'));

echo $this->Html->scriptBlock("
   var tabs;
    jQuery(function($) {
         showDataChild();
        tabs = $('.tabscontent').tabbedContent({loop: true}).data('api');
        // Next and prev actions
        $('.controls a').on('click', function(e) {
            var action = $(this).attr('href').replace('#', ''); 
            tabs[action]();
            e.preventDefault();
        });  
       $('#child_details_tab').on('click', function(e) {
            showDataChild();
            e.preventDefault();
       });
    }); 
    
    function showDataChild(){
        var url = '".$ajaxUrl_childdetail."';
        url = url + '/prisoner_id:'+'".$prisoner_uuid."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#prisonerchilddata_listview').html(res);
            }
        });
    }

    //delete child 
    function deleteChild(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteChildUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDataChild();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

    //delete special need 
    function deleteSpecialNeed(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteSpecialNeedUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDataSpecialNeeds();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

    //delete offence
    function deleteOffence(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteOffenceUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDataOffenceDetail();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

    //delete offence count
    function deleteOffenceCount(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteOffenceCountUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDataOffenceCount();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

    //delete offence count
    function deleteRecapture(paramId){
        if(paramId){
            if(confirm('Are you sure to delete?')){
                var url = '".$deleteRecaptureUrl."';
                $.post(url, {'paramId':paramId}, function(res) { 
                    if(res == 'SUCC'){
                        showDataRecapture();
                    }else{
                        alert('Invalid request, please try again!');
                    }
                });
            }
        }
    }

    

",array('inline'=>false));
//get prisoner's special needs list
$ajaxUrl_specialneeds = $this->Html->url(array('controller'=>'prisoners','action'=>'specialNeedAjax'));
echo $this->Html->scriptBlock("
   var tabs;
    jQuery(function($) {
         showDataSpecialNeeds();
        tabs = $('.tabscontent').tabbedContent({loop: true}).data('api');
        // Next and prev actions
        $('.controls a').on('click', function(e) {
            var action = $(this).attr('href').replace('#', ''); 
            tabs[action]();
            e.preventDefault();
        });  
       $('#special_needs_tab').on('click', function(e) {
            showDataChild();
            e.preventDefault();
       });
    }); 
    
    function showDataSpecialNeeds(){
        var url = '".$ajaxUrl_specialneeds."';
        url = url + '/prisoner_id:'+'".$prisoner_uuid."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#specialneed_listview').html(res);
            }
        });
    }
",array('inline'=>false));
//get prisoner's offence detail list
$ajaxUrl_offencedetail = $this->Html->url(array('controller'=>'prisoners','action'=>'offenceDetailAjax'));
echo $this->Html->scriptBlock("
   var tabs;
    jQuery(function($) {
         showDataOffenceDetail();
        tabs = $('.tabscontent').tabbedContent({loop: true}).data('api');
        // Next and prev actions
        $('.controls a').on('click', function(e) {
            var action = $(this).attr('href').replace('#', ''); 
            tabs[action]();
            e.preventDefault();
        });  
       $('#offence_details_tab').on('click', function(e) {
            showDataOffenceDetail();
            e.preventDefault();
       });
    }); 
    
    function showDataOffenceDetail(){
        var url = '".$ajaxUrl_offencedetail."';
        url = url + '/prisoner_id:'+'".$prisoner_uuid."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#offencedetail_listview').html(res);
            }
        });
    }
",array('inline'=>false));
//get prisoner's offence count detail list
$ajaxUrl_offencecnt = $this->Html->url(array('controller'=>'prisoners','action'=>'offenceCountDetailAjax'));
echo $this->Html->scriptBlock("
   var tabs;
    jQuery(function($) {
         showDataOffenceCount();
        tabs = $('.tabscontent').tabbedContent({loop: true}).data('api');
        // Next and prev actions
        $('.controls a').on('click', function(e) {
            var action = $(this).attr('href').replace('#', ''); 
            tabs[action]();
            e.preventDefault();
        });  
       $('#offence_counts_tab').on('click', function(e) {
            showDataOffenceCount();
            e.preventDefault();
       });
    }); 
    
    function showDataOffenceCount(){
        var url = '".$ajaxUrl_offencecnt."';
        url = url + '/prisoner_id:'+'".$prisoner_uuid."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#offencecount_listview').html(res);
            }
        });
    }
",array('inline'=>false));

//get prisoner's recapture detail list
$commonHeaderUrl    = $this->Html->url(array('controller'=>'Prisoners','action'=>'getCommonHeder'));
$prisoner_id = $this->request->data['Prisoner']['id'];
$uuid = $this->request->data['Prisoner']['uuid'];
$ajaxUrl_recapture = $this->Html->url(array('controller'=>'prisoners','action'=>'recaptureDetailAjax'));
echo $this->Html->scriptBlock("
   var tabs;
    jQuery(function($) {

        showCommonHeader();
        
         showDataRecapture();
        tabs = $('.tabscontent').tabbedContent({loop: true}).data('api');
        // Next and prev actions
        $('.controls a').on('click', function(e) {
            var action = $(this).attr('href').replace('#', ''); 
            tabs[action]();
            e.preventDefault();
        });  
       $('#recaptured_details_tab').on('click', function(e) {
            showDataRecapture();
            e.preventDefault();
       });
    }); 
    
    function showDataRecapture(){
        var url = '".$ajaxUrl_recapture."';
        url = url + '/prisoner_id:'+'".$prisoner_uuid."';
        $.post(url, {}, function(res) {
            if (res) {
                $('#recapture_listview').html(res);
            }
        });
    }
    //common header
    function showCommonHeader(){
        var prisoner_id = ".$prisoner_id.";;
        console.log(prisoner_id);  
        var uuid        = '".$uuid."';
        var url         = '".$commonHeaderUrl."';
        url = url + '/prisoner_id:'+prisoner_id;
        url = url + '/uuid:'+uuid;
        $.post(url, {}, function(res) {
           
            if (res) {
                $('#commonheader').html(res);
            }
        }); 
    }
",array('inline'=>false));
?> 