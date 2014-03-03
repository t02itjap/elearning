<?php
<<<<<<< HEAD
debug($lessons);
=======
print_r($lessons);
>>>>>>> master
echo $this->Html->css('style'); 
foreach ($lessons as $lesson): 
?>
	<div class='class'>
		<ul>
			<li class='cate'>カテゴリ：<?php echo $lesson['Lesson']['category_id']; ?></li>
			<li>授業名：<?php echo $lesson['Lesson']['lesson_name']; ?></li>
			<li>作る日：<?php echo $lesson['Lesson']['create_date']; ?></li>
			<li>説明：<?php echo $lesson['Lesson']['description']; ?></li>
			<li>先生：<?php echo $lesson['User']['user_name']; ?></li>
			<li>学費：20,000 VND</li>
			<li><a href='#' class='see'>見る</a></li>
		</ul>
	</div>
<<<<<<< HEAD
<?php endforeach; ?>
=======
<?php endforeach; ?>
>>>>>>> master
