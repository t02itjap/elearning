<?php
App::uses ( 'DboSource', 'Model/Datasource' );
/**
 * User controller for login,logout,...
 * 
 */

class UsersController extends AppController {
	public $name = "Users";
	var $uses = array ('User', 'TestHistory', 'Test', 'Lesson','InitialUser','Verifycode','InitialVerifycode');
	var $helpers = array('Html', 'Form', 'Editor');
	public $components = array ('RequestHandler');
	public function beforeFilter() {
		parent::beforeFilter ();
		$this->layout = 'before_login';
		$this->Auth->authenticate = array ('Form' => array ('userModel' => 'User', 'fields' => array ('username' => 'user_name', 'password' => 'password' ) )//'scope' => array('User.')
		 );
		$this->Auth->allow ( array ('home', 'login', 'register' ) );
	}
	
	public function login() {
		//logged in user
		if ($this->Auth->user ())
			$this->redirect ( $this->Auth->redirect () );
		
		//
		if ($this->request->is ( 'post' )) {
			$this->loadModel ( "User" );
			$this->request->data['User']['password'] = $this->request->data['User']['user_name'].$this->request->data['User']['password'].'sha1';
			if ($this->Auth->login ()) {
				if ($this->Auth->user ( "level" ) === 1) {
					echo "admin";
				} else
					echo "user";
				$this->Session->setFlash ( "Hello" . $this->Auth->user ( 'user_name' ) );
				$this->redirect ( $this->Auth->redirect () );
			} else {
				$this->Session->setFlash ( 'メールとかパースワードとか間違いです' );
			}
		}
	}
	
	function register() {
		$this->set ( 'title_for_layout', '登録' );
		$forPass = 'sha1';
		if (isset ( $this->request->data ['submit_data'] )) {
			$data = $this->request->data;
			$birthDate = $data['User']['birth_year'].'-'.$data['User']['birth_month'].'-'.$data['User']['birth_date'];
			debug ( $data );
			$password = sha1($data['User']['user_name'].$data['User']['password'].$forPass);
			$this->User->set (array(
				'user_name'=> $data['User']['user_name'],
				'real_name' => $data['User']['real_name'],
				'password' => $password,
				'email' => $data['User']['email'],
				'birth_date' => $birthDate,
				'user_name' => $data['User']['user_name'],
				'level' => $data['User']['user_type'],
				'bank_account_code' => $data['User']['bank_code'],
				'address' => $data['User']['address'],
				'phone_number' => $data['User']['phone_number'],
				'profile_img' => $data['User']['profile_img']['name'],
			));
			if($data['User']['user_type'] == 2){
				$question = base64_encode($data['User']['question']);
				$verifycode = sha1( $data['User']['user_name'].$data['User']['verifycode'].$forPass);
				$this->Verifycode->set (array(
					'question' => $data['User']['question'],
					'verifycode' => $data['User']['verifycode'],
				));
			}
			if ($this->User->validates ()) {
				if($data['User']['user_type'] == 3){
					move_uploaded_file($data['User']['profile_img']['tmp_name'], WWW_ROOT . 'img/profile_img'. DS . $data['User']['profile_img']['name']);
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
				}
				else{					
					if($this->Verifycode->validates()){
						move_uploaded_file($data['User']['profile_img']['tmp_name'], WWW_ROOT . 'img/profile_img'. DS . $data['User']['profile_img']['name']);
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
						$this->Verifycode->set(array(
							'user_id' => $user['User']['id'],
							'question' => $question,
							'verifycode' => $verifycode,
						));
						$this->Verifycode->save();
						$this->InitialVerifycode->set(array(
							'user_id' => $user['User']['id'],
							'question' => $question,
							'verifycode' => $verifycode,
						));
						$this->InitialVerifycode->save();
					}
				}
				$this->redirect(array('controller' => 'Users', 'action' => 'login'));
			}
		}
	}
	public function logout() {
		$this->Cookie->destroy ();
		$this->Auth->logout ();
		$this->redirect ( $this->Auth->logoutRedirect );
		exit ();
	}
	
	public function index(){
                
 }

public function viewtestresult() {
    $data = $this->Test->TestHistory->find('all',
                        array(
                            'conditions'=>array(
                                'TestHistory.user_id'=>'2' //$this->Auth->user('id')
                               )
                            )
                        );
                $lesson_id = Array();
                foreach($data as $k=>$value){
                    $lesson_id[] = $value['Test']['lesson_id'];
                } 
                $lesson_name = Array();
                foreach($lesson_id as $id){
                    $lesson_name[] = $this->Lesson->findById($id);
                }
                for($i=0;$i<count($lesson_name);$i++){
                    $data[$i]['Lesson'] =$lesson_name[$i]['Lesson'];
                }
                $this->set('data',$data);
                 
	}

        
}
