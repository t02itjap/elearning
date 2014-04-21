    <div id="header">
    <input type="hidden" id="refresh" value="no">
    <?php echo $this->Html->image('logo.jpg',array(
    	'width' => '500px', 'height' => '100px'));?>
        <ul>
             <li>
	        	<?php echo $this->Html->link(
				    'ログアウト',
				    array(
				        'controller' => 'users',
				        'action' => 'logout'	
				    	)
				); ?>
			</li>
            <li><a href="#">Q&A </a></li>
        </ul>
        
    </div>