<?php
class Comment extends AppModel{
	var $name = "Comment";
	var $primaryKey = 'id';
	public $validate = array(
		'comment'=>array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap comment',
			)
		));
}