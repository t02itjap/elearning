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
                        '勉強したリスト',
                        array(
                            'controller' => 'lessons',
                            'action' => 'learned_lesson'  
                            )
                        ); ?>
                </li>
                <li><a href="#">試験結果</a></li>
            </ul>
        
        </div><!--End #main_nav-->