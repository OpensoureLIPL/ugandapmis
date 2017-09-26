<?php
    header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    if($file_type == 'xls'){
        header ("Content-type: application/vnd.ms-excel");
    }else if($file_type == 'doc'){
        header ("Content-type: application/vnd.ms-word");
    }
    header ("Content-Disposition: attachment; filename=\"$file_name" );
    header ("Content-Description: Generated Report" );
    echo $content_for_layout;
?>