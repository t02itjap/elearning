<?php
class LessonsController extends AppController {
	var $uses = array ('User');
	function beforeFilter(){
		parent::beforeFilter();
		$this->layout= "before_login";
	}
	public function index(){
		// $data = $this->User->find('all');
  //               $this->set('data',$data);
  //               $this->set('index', $this->Lesson->getLessons());
                // $this->set('index', $this->Lesson->getLessons());
              //  $this->redirect(array('controller' => 'Lessons', 'action' => 'sc20'));
	}
	public function sc20(){
		//$this->set(array('controller' => 'Lessons', 'action' => 'sc20'));
	}
}

