<?php
class LessonsController extends AppController {
	var $uses = array ('User');
	$data= array();
	function beforeFilter(){
		parent::beforeFilter();
		$this->layout= "student";
		$this->Auth->authenticate = array ('Form' => array ('userModel' => 'User', 'fields' => array ('username' => 'user_name', 'password' => 'password' ) )//'scope' => array('User.')
		 );
		$this->Auth->allow ( array ('home', 'login', 'register' ) );
	}
	public function index(){
		// $data = $this->User->find('all');
  //               $this->set('data',$data);
  //               $this->set('index', $this->Lesson->getLessons());
                // $thiss->set('index', $this->Lesson->getLessons());
              //  $this->redirect(array('controller' => 'Lessons', 'action' => 'sc20'));
	}
	public function sc20(){
		//$this->set(array('controller' => 'Lessons', 'action' => 'sc20'));
			
	}
}

