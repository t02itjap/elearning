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

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<?php echo $this->element('head');?>
<body>
	<div id="container">
		<?php echo $this->element('before_login_header');?>
		<div id="body">
        	<div id="slide_bar">
        		<?php echo $this->element('search');?>
        	</div>
        	<?php echo $this->element('before_login_menu');?>
			<div id="main_content">
				<h2 id='page-title'><?php echo $title_for_layout; ?></h2><br>
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<?php echo $this->element('footer');?>
	</div>
</body>
</html>
