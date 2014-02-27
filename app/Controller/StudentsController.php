<?php
class StudentsController extends AppController {
	var $name = 'Student';
	var $uses = array ('User');
	function beforeFilter(){
		parent::beforeFilter();
	}
	public function index(){
		$this->set ( 'title_for_layout', '学生のリスト' );
		$this->paginate = array ('limit' => 4, 
			'conditions' => array('User.approve_flag' => '0', 'User.status_flag' => '1'),
			'current' => 1,
			'order' => 'reg_date'
		);
		$studentList = $this->paginate('User');
		$this->set ( compact ( 'studentList' ));
	}
}