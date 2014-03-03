<?php
class LearnHistory extends AppModel {
	var $name = 'LearnHistory';
	var $primaryKey = 'id';
		public $belongsTo = array(
		'Bill' => array(
			'className' => 'Bill',
			'foreignKey' => 'bill_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}