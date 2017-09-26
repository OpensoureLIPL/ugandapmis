 <?php
if(is_array($datas) && count($datas)>0){
?>
<div class="row">
    <div class="col-sm-5">
        <ul class="pagination">
<?php
    $this->Paginator->options(array(
        'update'                    => '#listingDiv',
        'evalScripts'               => true,
        //'before'                  => '$("#lodding_image").show();',
        //'complete'                => '$("#lodding_image").hide();',
        'url'                       => array(
            'controller'            => 'Menus',
            'action'                => 'indexAjax',
            'parent_id'             => $parent_id,
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
 <table id="districtTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo $this->Paginator->sort('Sl no'); ?></th>                
                <th><?php echo $this->Paginator->sort('Parent'); ?></th>
                <th><?php echo $this->Paginator->sort('Name'); ?></th>
                <th><?php echo $this->Paginator->sort('Url'); ?></th>
                <th><?php echo $this->Paginator->sort('Order'); ?></th>
                <th><?php echo $this->Paginator->sort('is_enable'); ?></th>
                <th><?php echo __('Actions'); ?></th>
              </tr>
            </thead>
            <tbody>
            <?php
              $rowCnt = $this->Paginator->counter(array('format' => __('{:start}')));
              foreach($datas as $menu){
            ?>
              <tr>
                	<td><?php echo $rowCnt; ?>&nbsp;</td>
        					<td><?php echo ucwords(h($menu['MainMenu']['parentname'])); ?>&nbsp;</td>
        					<td><?php echo ucwords(h($menu['Menu']['name'])); ?>&nbsp;</td>	
        					<td><?php echo ucwords(h($menu['Menu']['url'])); ?>&nbsp;</td>
        					<td><?php echo ucwords(h($menu['Menu']['order'])); ?>&nbsp;</td>							
        					<td><?php if($menu['Menu']['is_enable'] == '1'){
        							                    echo "<font color=green>Yes</font>"; 
        						                }else{
        							                    echo "<font color=red>No</font>"; 
        						                }?>&nbsp;
                	</td>					
          				<td class="actions">          					
                    <!-- edit form -->
                    <div style="float:left; padding: 10px;">
                      <?php echo $this->Form->create('MenuEdit',array('url'=>'/Menus/addMenu','admin'=>false)); ?>  
                        <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $menu['Menu']['id'])); ?>
                      <?php echo $this->Form->end(array('label'=>'Edit','class'=>'btn btn-primary','div'=>false,'onclick'=>'javascript:return confirm("Are you sure want to edit?")'));?>
                    </div>
                    <!-- edit form -->

                    <!--delete form -->
                    <div style="float:left; padding: 10px;">
                      <?php echo $this->Form->create('MenuDelete',array('url'=>'/Menus/addMenu','admin'=>false)); ?>  
                        <?php echo $this->Form->input('id',array('type'=>'hidden','value'=> $menu['Menu']['id'])); ?>
                      <?php echo $this->Form->end(array('label'=>'Delete','class'=>'btn btn-danger','div'=>false,'onclick'=>'javascript:return confirm("Are you sure want to delete?")'));?>  
                    <!--delete form -->
                    </div>
          				</td>
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
                ...
                <?php    
                }
                ?> 