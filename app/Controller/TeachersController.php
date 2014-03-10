<?php
App::uses ( 'DboSource', 'Model/Datasource' );
/**
 * User controller for login,logout,...
 * 
 */

class TeachersController extends AppController {
	public $name = "Teachers";
	var $uses = array ('User', 'Test', 'Lesson', 'Bill' );
	var $helpers = array ('Html', 'Form', 'Editor' );
	public $components = array ('RequestHandler' );
	public function beforeFilter() {
		parent::beforeFilter ();
		$this->layout = 'teacher';
		$this->Auth->authorize = 'controller';
	}
	public function isAuthorized() {
		if ($this->Auth->user ( 'level' ) == 2)
			return true;
		else {
			$this->Session->setFlash ( "Access deny" );
			$this->redirect ( $this->redirect ( array ("controller" => "users", "action" => "logout" ) ) );
			return false;
		}
	}
	public function summary($id = null) {
		$lesson = $this->Lesson->find ( 'first', array ('conditions' => array ('id' => $id ), 'fields' => array ('viewers', 'voters' ) ) );
		$snum = $this->Bill->find ( "count", array ('conditions' => array ('lesson_id' => $id ), 'group' => array ('user_id' ) ) );
		$students = $this->Bill->find ( "all", array ('conditions' => array ('lesson_id' => $id ), 'fields' => array ('user_id', 'learn_date' ) ) );
		$this->set ( 'lesson', $lesson );
		$this->set ( 'snum', $snum );
		$i = - 1;
		foreach ( $students as $s ) {
			$i ++;
			$info = $this->User->field ( 'user_name', array ('id' => $s ['Bill'] ['user_id'] ) );
			$students [$i] ['Bill'] ['user_name'] = $info;
		}
		
		$this->set ( compact ( 'students' ) );
	}
	
	public function change_info() {
		$this->set ( 'title_for_layout', '個人情報を変更する' );
		$forPass = 'sha1';
		$teacher = $this->User->find ( 'first', array ('conditions' => array ('User.id' => $this->Auth->user ( 'id' ) ) ) );
		$this->set ( compact ( 'teacher' ) );
		if (isset ( $this->request->data ['submit_data'] )) {
			$data = $this->request->data;
			$checkPassword = sha1 ( $teacher ['User'] ['user_name'] . $data ['User'] ['password'] . $forPass );
			if ($checkPassword == $teacher ['User'] ['password']) {
				if ($teacher ['User'] ['email'] == $data ['User'] ['email'] && $teacher ['User'] ['phone_number'] == $data ['User'] ['phone_number'] && $teacher ['User'] ['address'] == $data ['User'] ['address'] && $teacher ['User'] ['bank_account_code'] == $data ['User'] ['bank_account_code']) {
					$this->Session->setFlash ( '情報を変更しなかった。' );
					$this->redirect ( array ('controller' => 'Teachers', 'action' => 'change_info' ) );
				} else {
					$this->User->set ( array ('bank_account_code' => $data ['User'] ['bank_account_code'], 'address' => $data ['User'] ['address'], 'phone_number' => $data ['User'] ['phone_number'] ) );
					if ($teacher ['User'] ['email'] != $data ['User'] ['email']) {
						$this->User->set ( array ('email' => $data ['User'] ['email'] ) );
					}
					if ($this->User->validates ()) {
						$this->User->id = $teacher ['User'] ['id'];
						if ($this->User->save ()) {
							$this->Session->setFlash ( '情報を変更することが成功です。' );
							$this->redirect ( array ('controller' => 'Teachers', 'action' => 'change_info' ) );
						}
					}
				}
			} else {
				$this->Session->setFlash ( 'インプットパスワードが間違い' );
				$this->redirect ( array ('controller' => 'Teachers', 'action' => 'change_info' ) );
			}
		}
		if (isset ( $this->request->data ['delete_teacher'] )) {
			$this->User->set ( array ('status_flag' => 0 ) );
			$this->User->id = $teacher ['User'] ['id'];
			if ($this->User->save ()) {
				$this->Session->destroy ();
				$this->Session->setFlash ( 'あなたのアカウントが今ロックです、再開けるために、管理者に連絡してください。' );
				$this->redirect ( array ('controller' => 'Users', 'action' => 'login' ) );
			}
		}
	}
	function changeVerify() {
	
	}
	
	function home() {
		//debug($this->Auth->user());
	}
}
?>
