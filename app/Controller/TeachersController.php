<?php
App::uses ( 'DboSource', 'Model/Datasource' );
/**
 * User controller for login,logout,...
 * 
 */

class TeachersController extends AppController {
	public $name = "Teachers";
	var $uses = array ('User');
	var $helpers = array('Html', 'Form', 'Editor');
	public $components = array ('RequestHandler');
	public function beforeFilter() {
		parent::beforeFilter ();
		$this->layout = 'teacher';
	}
	public function change_info(){
		$forPass = 'sha1';
		$this->set('title_for_layout', '個人情報を変更する');
		$teacher = $this->User->find('first', array(
			'conditions' => array('User.id' => $this->Auth->user('id')),
		));
		$this->set(compact('teacher'));
		if(isset ( $this->request->data ['submit_data'] )){
			$data = $this->request->data;
			$checkPassword = sha1($teacher['User']['user_name'].$data['User']['password'].$forPass);
			if($checkPassword != $teacher['User']['password']){
				$this->Session->setFlash('インプットパスワードが間違い');
				$this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
			}
			else{
				if($teacher['User']['email'] == $data['User']['email'] && $teacher['User']['bank_account_code'] == $data['User']['bank_account_code'] && $teacher['User']['address'] == $data['User']['address'] && $teacher['User']['phone_number'] == $data['User']['phone_number']){
					$this->Session->setFlash('情報を変更しなかった。');
					$this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
				}
				else{
					$this->User->set (array(
						'bank_account_code' => $data['User']['bank_account_code'],
						'address' => $data['User']['address'],
						'phone_number' => $data['User']['phone_number'],
					));
					if($teacher['User']['email'] != $data['User']['email']){
						$this->User->set (array(
							'email' => $data['User']['email'],
						));
					}
					if($this->User->validates()){
						$this->User->id = $teacher['User']['id'];
						if($this->User->save()){
						$this->Session->setFlash('変更することが成功。');
						$this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
						}
					}
					else{
						$this->Session->setFlash('インプット情報が合式じゃなかった');
					}
				}
			}
		}
		if(isset ( $this->request->data ['delete_student'] )){
			$this->User->set(array(
				'status_flag' => 0,
			));
			$this->User->id = $teacher['User']['id'];
			if($this->User->save()){
				$this->Session->destroy();
				$this->Session->setFlash('あなたのアカウントは今、ロックです。　再開けるために、管理者に連絡してください。');
				$this->redirect(array('controller' => 'Users', 'action' => 'login'));
			}
		}
	}
}
?>