<?php
//debug($lessons);
echo $this->Html->css('style'); 
$result=$this->Paginator->params();
//debug($result);
if($result['count']>=1):
	echo "<div id='arr_type'>";
	echo "並ぶタイプ：";
	echo $this->Paginator->sort('lesson_name', '授業名');
	echo "&nbsp;-&nbsp;";
	echo $this->Paginator->sort('create_date', '作った日');
	echo "</div>";
	foreach ($lessons as $lesson): 
	?>
		<div class='class'>
			<ul>
				<li>授業名：<?php echo $lesson['Lesson']['lesson_name']; ?></li>
				<li>作った日：<?php echo $lesson['Lesson']['create_date']; ?></li>
				<li>説明：<?php echo $lesson['Lesson']['description']; ?></li>
				<li>先生：<?php echo $lesson['User']['user_name']; ?></li>
				<li>学費：20,000 VND</li>
				<?php 
				if(isset($level)){
					switch ($level) {
						case '1':
							echo "<li><a href='#' class='see'>見る</a></li>";
							break;

						case '2':
							echo "<li><a href='#' class='see'>見る</a></li>";
							if($this->Session->read('Auth.User.id')==$lesson['Lesson']['create_user_id']){
								echo $this->Html->link(
								    '削除',
								    array(
								        'controller' => 'lessons',
								        'action' => 'delete_lesson',
								        $lesson['Lesson']['id']
								    	),
								    array('class'=>'confirm_delete')
									);
								echo "</li>";
								echo "<li><a href='#' class='see'>情報サマリー</a></li>";
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
								    array('class'=>'confirm_report')
									);
								echo "</li>";
							}
							//echo "<li><a href='#' class='see'>タイトル違反</a></li>";
							break;
						
						case '3':
							echo "<li><a href='#' class='see'>見る</a></li>";
							break;

						default:
							# code...
							break;
					}
				}
				else
					echo "<li><a href='#' class='see'>見る</a></li>";
			?>
			</ul>
		</div>
	<?php endforeach; ?>

	<div class="paging btn-group">
	    <?php
	    echo $this->Paginator->first('最初へ');//di den trang dau tien
	    echo $this->Paginator->prev(__('前へ'), array('class' => 'btn'), null, array('class' => 'prev disabled btn'));
	    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn', 'currentClass' => 'disabled'));
	    echo $this->Paginator->next(__('次へ'), array('class' => 'btn'), null, array('class' => 'next disabled btn'));
	    echo $this->Paginator->last('最後へ');//di den trang cuoi cung
	    ?>
	</div>
<?php 
else:
	echo 'Khong co ket qua!';
endif; ?>
<?php
    echo $this->Paginator->counter(array(
        'format' => __('Kết quả tìm được có {:count} bản ghi bắt đầu từ {:start}  〜 {:end} 　（{:page}/{:pages}）')
    ));
    //$x=$this->Paginator->params();
    //debug($x['count']+3);
?>
