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
	public function isBanned($uname,$teacher){
		$user = new User();
		$_user = $user->find('first',array('conditions'=>array('user_name'=>$uname,'level'=>3)));
		if($_user)
			return $this->find('first',array('conditions'=>array('student_id'=>$_user['User']['id'],'teacher_id'=>$teacher)));
		else 
			return false;
	}
	public function deleteRecordByTeacherId($userId){
		$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('teacher_id' => $userId)
        ));
        if($recordList != NULL)
        	foreach ($recordList as $record){
            	if(!$this->delete($record['BannedStudent']['id'])){
            		$check = 0;
            		break;
            	}
        	}
        if($check == 1) return true;
        else return false;
	}
	public function deleteRecordByStudentId($userId){
		$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('student_id' => $userId)
        ));
        if($recordList != NULL) foreach ($recordList as $record){
            if(!$this->delete($record['BannedStudent']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
	}
}