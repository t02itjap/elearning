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

	<div class="paging btn-group">
	    <?php
	     //ページングする
	    echo $this->Paginator->first('最初へ');//di den trang dau tien
	    echo $this->Paginator->prev(__('前へ'), array('class' => 'btn'), null, array('class' => 'prev disabled btn'));
	    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn', 'currentClass' => 'disabled'));
	    echo $this->Paginator->next(__('次へ'), array('class' => 'btn'), null, array('class' => 'next disabled btn'));
	    echo $this->Paginator->last('最後へ');//di den trang cuoi cung
	    ?>
	</div>
<?php 
else:
	echo '結果がない！';
endif; ?>
<?php
    echo $this->Paginator->counter(array(
        'format' => __('結果は {:count} レコード {:start}  〜 {:end} 　（{:page}/{:pages}）')
    ));
    //$x=$this->Paginator->params();
    //debug($x['count']+3);
?>
