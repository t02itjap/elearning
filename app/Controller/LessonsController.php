<?php
class UsersController extends AppController {
	var $uses = array ('User');
	function beforeFilter(){
		parent::beforeFilter();
	}
	public function index(){
		$data = $this->User->find('all');
                $this->set('data',$data);
                $this->set('lessons', $this->Lesson->getLessons());
	}
}

