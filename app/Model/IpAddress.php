<?php
class IpAddress extends AppModel {
	var $name = 'IpAddress';
	var $primaryKey = 'id';
	public $validate = array(
		'ip_address' => array(
			'check ip' => array(
				'rule' => array('ip','IPv4'),
				'message' => 'ip形態が間違い',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ipを入力してください。',
			),
		),
	);
}
?>