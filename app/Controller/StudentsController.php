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
		$forPass = 'sha1';
		$student = $this->User->find('first', array(
			'conditions' => array('User.id' => $this->Auth->user('id')),
		));
		$this->set(compact('student'));
		if(isset($this->request->data['submit_data'])){
			$data = $this->request->data;
			$checkPassword = sha1($student['User']['user_name'].$data['User']['password'].$forPass);
			if($checkPassword == $student['User']['password']){ 
				if($student['User']['email'] == $data['User']['email'] && $student['User']['phone_number'] == $data['User']['phone_number'] && $student['User']['address'] == $data['User']['address'] && $student['User']['bank_account_code'] == $data['User']['bank_account_code']){
					$this->Session->setFlash('情報を変更しなかった。');
					$this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
				}
				else{
					$this->User->set (array(
						'bank_account_code' => $data['User']['bank_account_code'],
						'address' => $data['User']['address'],
						'phone_number' => $data['User']['phone_number'],
					));
					if($student['User']['email'] != $data['User']['email']){
						$this->User->set (array(
							'email' =>$student['User']['email'],
						));					
					}
					if($this->User->validates()){
						$this->User->id = $student['User']['id'];
						if($this->User->save()){
							$this->Session->setFlash('情報を変更することが成功です。');
							$this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
						}
					}
				}	
			}
			else{
				$this->Session->setFlash('インプットパスワードが間違い');
				$this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
			}
		}
		if(isset($this->request->data['delete_student'])){
			$this->User->set(array(
				'status_flag' => 0,
			));
			$this->User->id = $student['User']['id'];
			if($this->User->save()){
				$this->Session->destroy();
				$this->Session->setFlash('あなたのアカウントが今ロックです、再開けるために、管理者に連絡してください。');
				$this->redirect(array('controller' => 'Users', 'action' => 'login'));
			}
		}
	}
}
?>