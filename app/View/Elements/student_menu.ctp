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
                <li><?php echo $this->Html->link('試験結果',array('controller'=>'Students','action'=>'getTestHistories'))?></li>
            	<?php
            	echo $this->Element('Notifications.NotificationInit');
            	echo $this->Element('Notifications.NotificationIcon',array('clear_notifications' => true));
            	?>
            </ul>
        
        </div><!--End #main_nav-->