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
				<li><?php echo $this->Html->link('試験結果',array('controller'=>'Teachers','action'=>'getStudentTestHistoriesList'))?></li>
              	<li><?php echo $this->Html->link('授業を作る',array('controller'=>'Teachers','action'=>'create_course'))?></li>
            	<?php
            	echo $this->Element('Notifications.NotificationInit');
            	echo $this->Element('Notifications.NotificationIcon',array('clear_notifications' => true));
            	?>
            </ul>
            
        
        </div><!--End #main_nav-->
        
