<?php
App::uses ( 'DboSource', 'Model/Datasource' );
/**
 * User controller for login,logout,...
 * 
 */

class AdminsController extends AppController {
	public $name = "Admins";
	var $uses = array ('User','InitialUser','IpAddress');
	var $helpers = array('Html', 'Form', 'Editor');
	public $components = array ('RequestHandler');
	public function beforeFilter() {
		parent::beforeFilter ();
		$this->layout = 'manager';
	}
	function register_new_manager() {
		$this->set ( 'title_for_layout', '登録' );
		$forPass = 'sha1';
		if (isset ( $this->request->data ['submit_data'] )) {
			$data = $this->request->data;
			$birthDate = $data['User']['birth_year'].'-'.$data['User']['birth_month'].'-'.$data['User']['birth_date'];
			$password = sha1($data['User']['user_name'].$data['User']['password'].$forPass);
			$this->User->set (array(
				'user_name'=> $data['User']['user_name'],
				'real_name' => $data['User']['real_name'],
				'password' => $password,
				'email' => $data['User']['email'],
				'birth_date' => $birthDate,
				'level' => 1,
				'bank_account_code' => 'khong xac dinh',
				'address' => $data['User']['address'],
				'phone_number' => $data['User']['phone_number'],
			));
			if ($this->User->validates ()) {
				if($data['User']['ip_address']!=''){
					$this->IpAddress->set(array('ip_address' => $data['User']['ip_address']));
					if($this->IpAddress->validates()){
						$this->User->save();
						$this->Ipaddress->save();
						$user = $this->User->find('first',array(
							'fields' => array('id'),
							'conditions' => array('User.user_name' => $data['User']['user_name'] )
						));
						$this->InitialUser->set(array(
							'user_id' => $user['User']['id'],
							'initial_password' => $password,
						));
						$this->InitialUser->save();
						$this->redirect(array('controller' => 'Admins', 'action' => 'index'));
					}
				}
				else{
					$this->User->save();
					$user = $this->User->find('first',array(
						'fields' => array('id'),
						'conditions' => array('User.user_name' => $data['User']['user_name'] )
					));
					$this->InitialUser->set(array(
						'user_id' => $user['User']['id'],
						'initial_password' => $password,
					));
					$this->InitialUser->save();
						$this->redirect(array('controller' => 'Admins', 'action' => 'index'));
				}
				}
		}
	}     
}
