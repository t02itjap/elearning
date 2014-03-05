<?php
App::uses ( 'DboSource', 'Model/Datasource' );
/**
 * User controller for login,logout,...
 * 
 */

class StudentsController extends AppController {
	public $name = "Students";
	var $uses = array ('User');
	var $helpers = array('Html', 'Form', 'Editor');
	public $components = array ('RequestHandler');
	public function beforeFilter() {
		parent::beforeFilter ();
		$this->layout = 'student';
	}
	public function change_info(){
		$this->set('title_for_layout', '個人情報を変更する');
		$student = $this->User->find('first', array(
			'conditions' => array('User.id' => $this->Auth->user('id')),
		));
		$this->set(compact('student'));
	}
}
?>