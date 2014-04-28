<?php
//debug($lessons);
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
		<div class='class'>
			<ul>
				<li>授業名：<?php echo $lesson['Lesson']['lesson_name']; ?></li>
				<li>作った日：<?php echo $lesson['Lesson']['create_date']; ?></li>
				<li>説明：<?php echo $lesson['Lesson']['description']; ?></li>
				<li>先生：<?php echo $lesson['User']['user_name']; ?></li>
				<li>学費：<?php echo $cost; ?> VND</li>
				<?php 
				if(isset($level)){
					switch ($level) {
						case '3':
							echo '<li>';
							echo $this->Html->link('見る',array('controller'=>'students','action'=>'view_lesson_to_learn',$lesson['Lesson']['id']),array('class'=>'link-button'));
							echo '</li>';
							break;

						case '2':
							//echo "<li><a href='#' class='see'>見る</a></li>";
							echo '<li>';
							if($this->Session->read('Auth.User.id')==$lesson['Lesson']['create_user_id']){
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
								echo "<li>";
								echo $this->Html->link(
										'授業サマリー',
										array(
												'controller' => 'teachers',
												'action' => 'summary',
												$lesson['Lesson']['id']
										),
										array('class'=>'see link-button')
								);
								echo "</li>";
							}
							else{
								echo "<li>";
								echo $this->Html->link(
								    'タイトル違反',
								    array(
								        'controller' => 'lessons',
								        'action' => 'title_report',
								        $lesson['Lesson']['id']
								    	),
								    array('class'=>'confirm_report link-button')
									);
								echo "</li>";
							}
							//echo "<li><a href='#' class='see'>タイトル違反</a></li>";
							break;
						default:
							# code...
							break;
					}
				}
			?>
			</ul>
		</div>
	<?php endforeach; ?>
<?php 
else:
	echo '結果がない！';
endif; ?>
<?php echo $this->element('paging');?>