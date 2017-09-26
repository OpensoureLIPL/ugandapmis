<?php
if(is_array($datas) && count($datas)>0){
?>
<div class="row">
    <div class="col-sm-5">
        

    </div>
</div>
<?php
foreach($datas as $key=>$rows){
  
?>
  <h4 class="text-center"><?php echo $key ?></h4>
<table id="districtTable" class="table table-bordered ">
  <thead>
    <tr>   
      <th>Prisoner Type </th>
      <th>Male</th>
      <th>Female</th>
      <th>Total</th>
    </tr>
  </thead>
<tbody>
  <?php foreach($rows as $data){ 
    ?>
    <tr> 
      <td><?php echo ucwords(h($data['prisoner_types']['prisoner_type'])); ?>&nbsp;</td> 
      <td><?php echo ucwords(h($data[0]['males'])); ?>&nbsp;</td>
      <td><?php echo ucwords(h($data[0]['female'])); ?>&nbsp;</td>
      <td><?php echo ucwords(h($data[0]['males']+($data[0]['female']))); ?>&nbsp;</td>
    </tr>
<?php } ?>
  </tbody>
</table>

<?php } ?>
<?php
}else{
?>
<span style="color:red;font-weight:bold;">No Record Found!!</span>
<?php    
}
?>    