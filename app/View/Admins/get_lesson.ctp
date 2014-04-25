


<?php //debug($users); die(); ?>

<div id="acc_manage">
	<span>授業を管理します。</span>
    <?php
				echo $this->Form->create ( 'Lesson' );
				echo $this->Form->input ( 'lesson_name', array (
						'label' => '授業検索' 
				) );
				echo $this->Form->end ( '検索' );
				?>
    <?php if(isset($data)&&$data!=null): ?>
    <!--
    <span><input type="text"/></span>
    <span><button>検索</button></span>-->
	<table class='table table-striped' style='table-layout: fixed'>
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('Lesson.id', 'ID'); ?></th>
				<th><?php echo $this->Paginator->sort('Lesson.lesson_name', '授業名'); ?></th>
				<th><?php echo $this->Paginator->sort('User.user_name', '作った人'); ?></th>
				<th><?php echo $this->Paginator->sort('Lesson.create_date', '作った時間'); ?></th>
				<!--<th><?php echo $this->Paginator->sort('Lesson.category_id', 'カテゴリー'); ?></th> -->
				<th>タイトル違反</th>
				<th>ブロック</th>
			</tr>
		</thead>
		<tbody> 
        <?php
					$sum = 0;
					foreach ( $data as $item ) {
						
						?>
                    <tr>
				<td class='content-center'><?php echo $item['Lesson']['id']; ?></td>
				<td class='content-center'><?php echo $this->Html->link($item['Lesson']['lesson_name'],array('controller'=>'teachers','action'=>'manage_course',$item['Lesson']['id']));?></td>
				<td class='content-center'><?php echo $item['User']['user_name']; ?></td>
				<td class='content-center'><?php echo $item['Lesson']['create_date']; ?></td>
				<!--<td class='content-center'><?php echo $item['Lesson']['category_id']; ?></td>-->
                        <?php
						$count = '違反ない';
						$temp = $item ['Lesson'] ['title_violation'];
						
						if ($temp == 1) {
							$count = '違反';
						}
						
						$count1 = 'ブロックない';
						$temp = $item ['Lesson'] ['lock_flag'];
						
						if ($temp == 1) {
							$count1 = 'ブロック';
						}
						
						?>
                        <td class='content-center'><?php echo $count;?></td>
				<td class='content-center'><?php echo $count1;?></td>
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
						echo $message;
					}
					?>
<?php endif; ?>


 <?php if(isset($users)): ?>

<?php endif; ?>
<?php echo $this->element('paging');?>































