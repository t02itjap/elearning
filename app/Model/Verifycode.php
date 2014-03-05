<?php
class Verifycode extends AppModel {
	var $name = 'Verifycode';
	var $primaryKey = 'id';
	public $validate = array(
		'question' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap cau hoi',
			),
		),
		'verifycode' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap cau tra loi',
			),
		)
	);
}
?>