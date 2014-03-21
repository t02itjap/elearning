<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d ( 'cake_dev', 'CakePHP: the rapid development php framework' );
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset();?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
	echo $this->Html->meta ( 'icon' );
	
	echo $this->Html->css ( array (
			'cake.generic',
			'style',
			'jquery-ui.custom' 
	) );
	echo $this->Html->script ( array (
			'jquery-1.7.2.min' 
	) );
	echo $this->Html->script ( array (
			'jquery-ui-1.8.4.custom.min' 
	) );
	echo $this->Html->script ( array (
			'jquery-idleTimeout' 
	) );
	echo $this->fetch ( 'meta' );
	echo $this->fetch ( 'css' );
	echo $this->fetch ( 'script' );
	?>
</head>
<body>
	<div id="container">
		<?php echo $this->element('header');?>
		<div id="body">
			<div id="slide_bar">
        		<?php echo $this->element('acc_info');?>
        		<?php echo $this->element('search');?>
        		<?php echo $this->element('category');?>
        	</div>
        	<?php echo $this->element('student_menu');?>
			<div id="main_content">
				<h2 id='page-title'><?php echo $title_for_layout; ?></h2>
				<br>
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
                    <?php echo $this->element("sql_dump");?>
		<?php echo $this->element('footer');?>
	</div>
	<script type="text/javascript" charset="utf-8">
		  $(document).ready(function(){
		   $(document).idleTimeout({
		     inactivity: <?=$sessiontime*1000*60?>, 
     		 noconfirm: 10000, 
     		 sessionAlive: 6*60*60*1000,
     		 alive_url:"/elearning/users/login",
     		 redirect_url:"/elearning/users/logout",
     		 logout_url:"/elearning/users/logout"
		   });
		  });
		</script>
</body>
</html>
