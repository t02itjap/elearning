<?php
//debug($lessons);
echo $this->Session->flash();
echo $this->Html->css('style'); 
$result=$this->Paginator->params();
//debug($result);
if($result['count']>=1):
	echo "<div id='arr_type'>";
	//授業を並べる
	echo "並ぶタイプ：";
	echo $this->Paginator->sort('lesson_name', '授業名');
	echo "&nbsp;-&nbsp;";
	echo $this->Paginator->sort('create_date', '作った日');
	echo "</div>";
	//授業情報を表す
	foreach ($lessons as $lesson): 
	?>
	<div class='class' id='<?php echo $lesson['Lesson']['id']; ?>'>
		<ul class='ultest'>
			<li>授業名：<?php echo $lesson['Lesson']['lesson_name']; ?></li>
			<li>作った日：<?php echo $lesson['Lesson']['create_date']; ?></li>
			<li>説明：<?php echo $lesson['Lesson']['description']; ?></li>
			<li>先生：<?php echo $lesson['User']['user_name']; ?></li>
			<li>学費：<?php echo $cost; ?> VND</li>
			<?php
			echo "<li><a href='".$this->webroot."teachers/manage_course/".$lesson['Lesson']['id']."' class='link-button'>見る</a></li>";
			echo "<li>";
			echo $this->Html->link(
		    '削除',
		    array(
		        'controller' => 'lessons',
		        'action' => 'delete_lesson',
		        $lesson['Lesson']['id']
		    	),
		    array('class'=>'confirm_delete link-button')
			);
			echo "</li>";
			echo '<li>';
			echo $this->Html->link('情報サマリー', array('controller' => 'Teachers', 'action' => 'summary', $lesson['Lesson']['id']), array('class' => ' link-button'));
			?>
		</ul>
	</div>
	<?php endforeach; ?>
<?php 
else:
	echo '結果がない！';
endif; ?>
<?php echo $this->element('paging');?>
