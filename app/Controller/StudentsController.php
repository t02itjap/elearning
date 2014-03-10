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
        $this->Auth->authorize = 'controller';
	}
    
    function isAuthorized(){
        if($this->Auth->user('level') == 3)
            return true;
            else
                {
                    $this->Session->setFlash("Access deny");
                    $this->redirect($this->redirect(array("controller"=>"users","action"=>"logout")));
                    return false;  
                }   
    }
    
	public function change_info(){
		$forPass = 'sha1';
		$this->set('title_for_layout', '個人情報を変更する');
		$student = $this->User->find('first', array(
			'conditions' => array('User.id' => $this->Auth->user('id')),
		));
		$this->set(compact('student'));
		if(isset ( $this->request->data ['submit_data'] )){
			$data = $this->request->data;
			$checkPassword = sha1($student['User']['user_name'].$data['User']['password'].$forPass);
			if($checkPassword != $student['User']['password']){
				$this->Session->setFlash('インプットパスワードが間違い');
				$this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
			}
			else{
				if($student['User']['email'] == $data['User']['email'] && $student['User']['bank_account_code'] == $data['User']['bank_account_code'] && $student['User']['address'] == $data['User']['address'] && $student['User']['phone_number'] == $data['User']['phone_number']){
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
							'email' => $data['User']['email'],
						));
					}
					if($this->User->validates()){
						$this->User->id = $student['User']['id'];
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
			$this->User->id = $student['User']['id'];
			if($this->User->save()){
				$this->Session->destroy();
				$this->Session->setFlash('あなたのアカウントは今、ロックです。　再開けるために、管理者に連絡してください。');
				$this->redirect(array('controller' => 'Users', 'action' => 'login'));
			}
		}
	}
    
    public function home(){
        debug($this->Auth->user());
    }
}
?>