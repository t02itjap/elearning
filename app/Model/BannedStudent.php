<?php
App::uses('User','Model');
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
	//kiem tra xem student $id co bi ban ko
	public function isBanned($uname){
		$user = new User();
		$_user = $user->find('first',array('conditions'=>array('user_name'=>$uname,'level'=>3)));
		if($_user)
			return $this->find('first',array('conditions'=>array('student_id'=>$_user['id'])));
		else 
			return false;
		}	

}