<?php
class BannedStudent extends AppModel {
	var $name = 'BannedStudent';
	var $primaryKey = 'id';
	
	public $belongsTo = array(
			'Teacher' => array(
				'className'=>'User',
				'foreignKey' => 'teacher_id'),
			'Student' => array(
				'className' => 'User',
				'foreignKey'=> 'student_id' 	
			)
	);
}