<head>
<?php
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies. ?>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
	echo $this->Html->meta ( 'icon' );
	
	echo $this->Html->css ( array (
			'cake.generic',
			'jquery-ui.custom',
			'bootstrap',
			'style'
	) );
	echo $this->Html->css('/notifications/css/notifications');
	
	echo $this->Html->script('/notifications/js/notifications');
	echo $this->Html->script ( array (
			'jquery-1.7.2.min','jquery-ui-1.8.4.custom.min','jquery-1.11.0.min', 'script-common.js'
	) );
	echo $this->Html->script ( array (
			'jquery-idleTimeout','bootstrap'
	) );
	echo $this->fetch ( 'meta' );
	echo $this->fetch ( 'css' );
	echo $this->fetch ( 'script' );
	// echo $this->Element('Notifications.NotificationInit');
	?>
</head>