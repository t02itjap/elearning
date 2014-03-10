<?php
class StudentController extends AppController {
	var $name = 'Student';
	var $uses = array ('User','Bill','LearnHistory','Lesson');
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
	//Thang viet
	public function getHistories() {
		$this->set ( 'title_for_layout', 'Lich su hoc tap' );
		$this->paginate = array (
                        'limit' => 10, 
			'conditions' => array('Bill.user_id' => $this->Auth->user('id')),
                        'field' => array('Lesson.lesson_name', 'LearnHistory.learn_date')
			//'order' => 'LearnHistory.learn_date'
			);
		$data = $this->paginate('Bill');
		$this->set ( compact ( 'data' ));
	}
	//Het phan Thang viet
}