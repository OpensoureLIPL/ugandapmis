<style>
.nodisplay{display:none;}
</style>
<div class="container-fluid">
    <div class="row-fluid">
        <div id="commonheader"></div>
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                <h5>Sentence Details</h5>
                </div>
                <div class="widget-content nopadding">
                    <div class="">
                        <div id="listingDiv"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$commonHeaderUrl    = $this->Html->url(array('controller'=>'Prisoners','action'=>'getCommonHeder'));
$ajaxUrl = $this->Html->url(array('controller'=>'Sentence','action'=>'indexAjax'));

echo $this->Html->scriptBlock(" 
   
    jQuery(function($) {
         showData();
         showCommonHeader();
    }); 
    
    function showData(){
        var url = '".$ajaxUrl."';
        var prisoner_uuid = '".$prisoner_uuid."';
        $.post(url, {'prisoner_uuid':prisoner_uuid}, function(res) {
            if (res) {
                $('#listingDiv').html(res);
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
