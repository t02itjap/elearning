        <div id="main_nav">
            <ul>
                <li>
                	<?php echo $this->Html->link(
					    'ホームページ',
					    array(
					        'controller' => 'lessons',
					        'action' => 'view_all_lessons'	
					    	)
						); ?>
				</li>
				<li>
                	<?php echo $this->Html->link(
					    '授業リスト',
					    array(
					        'controller' => 'lessons',
					        'action' => 'manage_lessons'	
					    	)
						); ?>
				</li>
                <li><a href="#">学生の試験結果</a></li>
                <li><a href="#">授業を作る</a></li>
            </ul>
        
        </div><!--End #main_nav-->