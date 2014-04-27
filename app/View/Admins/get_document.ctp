<?php //debug($users); die(); ?>

<div id="acc_manage">
	<?php echo $this->Session->flash();?>
    <?php
				echo $this->Form->create ( 'Document' );
				echo '<div style = "float: left; margin-left: 5px; margin-top:3px">';
				echo $this->Form->input ( 'file_name', array (
						'placeholder' => 'ファイル検索', 'label' => false
				) );
				echo '</div>';
				echo '<div style = "float: left; margin-left: 5px; margin-top:0px">';
				echo $this->Form->button('検索', array('type' => 'submit', 'name' => 'data[submit_data]', 'class' => 'link-button', 'id' => 'submit_button'));
				echo '</div>';
				echo $this->Form->end ();
				?>
    <?php if(isset($data)&&$data!=null): ?>
    <!--
    <span><input type="text"/></span>
    <span><button>検索</button></span>-->
	<table class='table table-striped' style='table-layout: fixed;font-size:14px;'>
		<thead>
			<tr>
				<th style="width:20px;"><?php echo $this->Paginator->sort('Document.id', 'ID'); ?></th>
				<th style="width:50px;"><?php echo $this->Paginator->sort('Document.file_name', 'ファイル名'); ?></th>
				<th><?php echo $this->Paginator->sort('Document.lesson_id', '授業名'); ?></th>
				<th><?php echo $this->Paginator->sort('Document.create_date', 'アップロード時間'); ?></th>
				<th><?php echo $this->Paginator->sort('Document.create_user_id', 'アップロード者'); ?></th>
				
				<th style="width:100px;"><?php echo 'ファイルリンク' ;?></th>
				<th>Copyright違反</th>
				<th style="width:40px;"></th>
				<th style="width:40px;"></th>
			</tr>
		</thead>
		<tbody> 
        <?php
					$sum = 0;
// 					debug($data);die();
					foreach ( $data as $item ) {
						
		?>
                    <tr>
                        <?php
						echo $this->Form->create ( 'Document', array (
								'type' => 'post',
								'controller' => 'admins',
								'action' => 'delete_document' 
						) );
						?>
                        <?php
						
							echo $this->Form->hidden ( 'hide', array (
								'value' => $item ['Document'] ['id'],
								'name' => 'data[hide]' 
						) );
						?>
                        <td class='content-center'><?php echo $item['Document']['id']; ?></td>
				
				<td class='content-center'><?php echo $this->Html->link($item['Document']['file_name'], array('controller' => 'Admins', 'action' => 'managerDocument', $item['Document']['id'])); ?></td>
				<td class='content-center'><?php echo $item['Lesson']['lesson_name']; ?></td>
				<td class='content-center'><?php echo $item['Document']['create_date']; ?></td>
				
				<td class='content-center'><?php echo $item['User']['user_name']; ?></td>
				<td class='content-center'><?php echo $item['Document']['file_link'] ?></td>
                        <td class='content-center'><?php 
                        if(!empty($item['Document']['copyright_reporters']))
                        {
                        if(strpos($item['Document']['copyright_reporters'],',')){
							$reporter = explode(',', $item['Document']['copyright_reporters']);
							echo count($reporter);
                        }else echo '1';
                        }else echo '0';
                        ?></td>
				<td class='content-center'><?php echo $this->Html->link('勧告',array('controller'=>'admins','action'=>'copyrightNotify',$item['Document']['create_user_id'],$item['Document']['id']));?></td>
				<td class='content-center'><?php echo $this->Html->link('削除',array('controller'=>'admins','action'=>'deleteDoc',$item['Document']['id']));?></td>
				
			</tr>
                    
                <?php
					}
					?>   
        </tbody>
	</table>
</div>
				 <?php
else :
					{
						echo '結果がない';
					}
					?>
<?php endif; ?>


 <?php if(isset($users)): ?>

<?php endif; ?>
<?php echo $this->element('paging');?>