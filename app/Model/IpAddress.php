<?php
class IpAddress extends AppModel {
	var $name = 'IpAddress';
	var $primaryKey = 'id';
	public $validate = array(
		'ip_address' => array(
			'check ip' => array(
				'rule' => array('ip','IPv4'),
				'message' => 'ip khong hop le',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap dia chi ip cua manager nay',
			),
		),
	);
}
?>