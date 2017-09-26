<?php
if(isset($this->data['Prisoner']['date_of_birth']) && $this->data['Prisoner']['date_of_birth'] != ''){
    $this->request->data['Prisoner']['date_of_birth']=date('d-m-Y',strtotime($this->data['Prisoner']['date_of_birth']));
}
//echo '<pre>'; print_r($this->request->data['Prisoner']); exit;
?>
<style>
.row-fluid [class*="span"]
{
  margin-left: 0px !important;
}
</style>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                    <h5>Add New Prisoner</h5>
                    <div style="float:right;padding-top: 3px;">
                        <?php echo $this->Html->link('Prisoners List',array('action'=>'index'),array('escape'=>false,'class'=>'btn btn-success btn-mini')); ?>
                        &nbsp;&nbsp;
                    </div>
                </div>
                <div class="widget-content nopadding">
              
                           
                                <?php echo $this->Form->create('Prisoner',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','url' => '/prisoners/add'));
                                if(isset($this->request->data['Prisoner']['id']))
                                {
                                    $prisoner_unique_no = $this->request->data['Prisoner']['prisoner_unique_no'];
                                    echo $this->Form->input('prisoner_unique_no',array(
                                        'type'=>'hidden',
                                        'class'=>'prisoner_unique_no',
                                        'value'=>$prisoner_unique_no
                                    ));
                                    $this->Form->control('id', array('value' => ''));
                                    echo $this->Form->input('exp_photo_name',array(
                                        'type'=>'hidden',
                                        'class'=>'exp_photo_name',
                                        'value'=>$this->request->data['Prisoner']['photo']
                                    ));
                                    echo $this->Form->input('is_ext',array(
                                        'type'=>'hidden',
                                        'class'=>'is_ext',
                                        'value'=>1
                                    ));
                                }
                                ?>
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
                                                <?php echo $this->Form->input('date_of_birth',array('div'=>false,'label'=>false,'class'=>'form-control dob span11','type'=>'text', 'placeholder'=>'Enter Date of Birth','required','readonly'=>'readonly','id'=>'date_of_birth'));?>
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
                                            <label class="control-label">Country of origin<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('country_id',array('div'=>false,'label'=>false,'onChange'=>'showRegions(this.value)','class'=>'form-control span11','type'=>'select','options'=>$countryList, 'empty'=>'-- Select Country --','required','id'=>'country_id'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> 
                                     <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label">Nationality<?php echo $req; ?>:</label>
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
                                            <div class="controls" id="district_id_div">
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
                                            <label class="control-label">Photo<?php echo $req; ?> :</label>
                                            <div class="controls">
                                                <div>
                                                <?php 
                                                    if(isset($this->request->data["Prisoner"]["photo"]) && !is_array($this->request->data["Prisoner"]["photo"]))
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
                                </div>

                                <div class="form-actions" align="center">
                                    <?php echo $this->Form->button('Save', array('type'=>'submit', 'div'=>false,'label'=>false, 'class'=>'btn btn-success', 'formnovalidate'=>true))?>
                                </div>
                                <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
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
$(document).ready(function () {
  
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
        //showRegions(country_id); 
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
                },
                'data[Prisoner][photo]': {
                    required: true,
                },
                
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
                },
                'data[Prisoner][photo]': {
                    required: "Please choose photo.",
                },
            },
               
    });
  });

</script>
<?php
$ajaxUrl = $this->Html->url(array('controller'=>'users','action'=>'getDistrict'));
$userinfoajaxUrl=$this->Html->url(array('controller'=>'prisoners','action'=>'personalInfo'));
$idinfoajaxUrl=$this->Html->url(array('controller'=>'prisoners','action'=>'prisnorsIdInfo'));
echo $this->Html->scriptBlock("
   var tabs;
    jQuery(function($) {
        tabs = $('.tabscontent').tabbedContent({loop: true}).data('api');
        // Next and prev actions
        $('.controls a').on('click', function(e) {
            var action = $(this).attr('href').replace('#', ''); 
            tabs[action]();
            e.preventDefault();
        });  
       
    }); 
    function getDistrict(){
        var url = '".$ajaxUrl."';
        $.post(url, {'state_id':$('#state_id').val()}, function(res) {
            if (res) {
                $('#district_id').html(res);
            }
        });
    }
",array('inline'=>false));
?> 