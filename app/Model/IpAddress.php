<?php
class IpAddress extends AppModel {
	var $name = 'IpAddress';
	var $primaryKey = 'ip_adress';
	public $validate = array(
		'ip_address' => array(
			'check ip' => array(
				'rule' => array('ip'),
				'message' => 'ip khong hop le',
			),
			'check exist' => array(
				'rule' => 'isUnique',
				'message' => 'ip nay da duoc su dung',
			),	
		),
	);
}
?>