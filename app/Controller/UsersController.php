<?php
App::uses ( 'DboSource', 'Model/Datasource' );
/**
 * Common controller for login,logout,...
 */
class UsersController extends AppController {
	public $name = "Users";
	var $uses = array (
			'User',
			'TestHistory',
			'Test',
			'Lesson',
			'InitialUser',
			'Verifycode',
			'InitialVerifycode',
			'LockedUser',
			'ChangeableValue' 
	);
	var $helpers = array (
			'Html',
			'Form',
			'Editor' 
	);
	public $components = array (
			'RequestHandler' 
	);
	public function beforeFilter() {
		parent::beforeFilter ();
		$this->layout = 'before_login';
		$this->Auth->allow ( array (
				'home',
				'login',
				'register',
				'teacherLogin',
				'teacherName' 
		) );
	}
	public function login() {		
		// logged in user
		if ($this->Auth->user ())
			$this->redirect ( array (
					"controller" => "Lessons",
					"action" => "view_all_lessons" 
			) );
			// xu ly khi nguoi dung an login
		if ($this->request->is ( 'post' )) {
			$data = $this->request->data;
			// tao chuoi password de so sanh
			$data ['User'] ['password'] = $data ['User'] ['user_name'] . $data ['User'] ['password'] . 'sha1';
			
			$user = $this->User->find ( 'first', array (
					"conditions" => array (
							'user_name' => $data ['User'] ['user_name'],
							'password' => sha1 ( $data ['User'] ['password'] ) 
					) 
			) );

			// kiem tra IP dang bi block
			$guest = $this->LockedUser->find ( 'first', array (
					'conditions' => array (
							'ip_address' => $this->request->clientIp () 
					) 
			) );
			if ($guest) {
				if ($guest ['LockedUser'] ['count'] == 3) {
					if ($this->request->data ['User'] ['user_type'] == 2) {
						$this->redirect ( 'teacherName' );
					} else if ($this->request->data ['User'] ['user_type'] == 3) {
						if ($guest ['LockedUser'] ['lock_flg'] == 1) {
							if ($time = (strtotime ( date ( "Y/m/d H:i:s" ) ) - strtotime ( $guest ['LockedUser'] ['lock_start_time'] )) < 60*$this->ChangeableValue->field ( 'current_value', array (
									'id' => 5 
							) )) {
								$this->Session->setFlash ( 'IP が '.$this->ChangeableValue->field("current_value",array('id'=>5)). ' 分間に'. 'ブロックしている' );
								$this->redirect ( 'login' );
							} else {
								$this->LockedUser->delete ( $guest ['LockedUser'] ['id'] );
								$this->redirect ( 'login' );
							}
						} else {
							$this->LockedUser->id = $guest ['LockedUser'] ['id'];
							$this->LockedUser->set ( array (
									'lock_flg' => 1,
									'lock_start_time' => date ( "Y/m/d H:i:s" ) 
							) );
							$this->LockedUser->save ();
							$this->Session->setFlash ( 'IP が初めにブロックしている' );
							$this->redirect ( 'login' );
						}
					}
				}
			}
			
			if (! empty ( $user )) {
				// kiem tra user active
				if ($user ['User'] ['approve_flag'] == 0) {
					$this->Session->setFlash ( __ ( 'アカウントがまだ確認しない' ) );
					$this->redirect ( 'login' );
				}
				//kiem tra chon loai tai khoan
				if($user['User']['level']!=$data['User']['user_type']){
					$this->Session->setFlash('アカウントタイプを選択することが間違う');
					$this->redirect('login');
				}
				// kiem tra lastIP
				if ($user ['User'] ['level'] == 2 && $user ['User'] ['ip_address'] != $this->request->clientIp ()) {
					$this->Session->setFlash ( __ ( '最後のログインIPと比べて違う' ) );
					$this->redirect ( array (
							'controller' => 'Users',
							'action' => 'teacherLogin',
							$user ['User'] ['id']
					) );
				}
				// kiem tra admin IP
				if ($user ['User'] ['level'] == 1 && $user ['User'] ['ip_address'] != $this->request->clientIp ()) {
					$this->Session->setFlash ( "IPアドレスが間違う" );
					$this->redirect ( "login" );
				}
			}
			
			// login
			$this->request->data['User']['password'] = $data['User']['password'];
			if ($this->Auth->login ()) {
				// save current IP
				$this->User->id = $this->Auth->user ( 'id' );
				$this->User->set ( array (
						'ip_address' => $this->request->clientIp () 
				) );
				$this->User->save ();
				$this->Session->setFlash ( "Hello　" . $this->Auth->user ( 'user_name' ) );
				//xoa lock ip
				$this->LockedUser->deleteAll ( array (
						'ip_address' => $this->request->clientIp () 
				) );
				// redirect to homepage
				$this->redirect ( array (
						"controller" => "Lessons",
						"action" => "view_all_lessons" 
				) );
			} 			// sai username hoac password
			else {
				if ($guest) {
					$this->LockedUser->id = $guest ['LockedUser'] ['id'];
					$this->LockedUser->set ( 'count', $guest ['LockedUser'] ['count'] + 1 );
					$this->LockedUser->save ();
					$this->Session->setFlash ( 'パスワードを入力間違うことが　' . ($guest ['LockedUser'] ['count'] + 1) . ' 回だ' );
				} else {
					$this->LockedUser->create ();
					$this->LockedUser->set ( array (
							'ip_address' => $this->request->clientIp (),
							'count' => 1,
							'lock_flg' => 0 
					) );
					$this->LockedUser->save ();
					$this->Session->setFlash ( 'パスワードを入力間違うことが１回だ' );
				}
			}
		}
	}
	public function teacherName() {
		if ($this->request->is ( "post" )) {
			if ($guest = $this->User->find ( 'first', array (
					'conditions' => array (
							'user_name' => $this->request->data ['User'] ['username'],
							'level' => 2 
					) 
			) )) {
				$this->redirect ( array (
						'controller' => 'Users',
						'action' => 'teacherLogin',
						$guest ['User'] ['id'] 
				) );
			} else
				$this->Session->setFlash ( 'ユーザネームが間違う' );
		}
	}
	public function teacherLogin($id) {
		$teacher = $this->Verifycode->find ( 'first', array (
				'conditions' => array (
						'user_id' => $id 
				) 
		) );
		$this->set ( compact ( 'teacher' ) );
		if ($this->request->is ( 'post' )) {
			$verifycode = $this->request->data;
			$verifycode = sha1 ( $this->User->field ( 'user_name', array (
					'id' => $id 
			) ) . $verifycode ['Verifycode'] ['verifycode'] . 'sha1' );
			if ($verifycode == $teacher ['Verifycode'] ['verifycode']) {
				$this->request->data = $this->User->find ( 'all', array (
						'conditions' => array (
								'id' => $id 
						) 
				) );
				
				$this->Auth->login ();
				//save lastIP
				$this->User->id = $id;
				$this->User->set(array('ip_addres'=>$this->request->clientIp()));
				$this->User->save();
				
				$this->redirect ( array (
						"controller" => "Lessons",
						"action" => "view_all_lessons" 
				) );
				$this->LockedUser->deleteAll ( array (
						'ip_address' => $this->request->clientIp () 
				) );
			} else {
				$this->Session->setFlash ( 'Verifyコードが間違う' );
			}
		}
	}
	public function register() {
		$this->set ( 'title_for_layout', '登録' );
		$forPass = 'sha1';
		if (isset ( $this->request->data ['submit_data'] )) {
			$data = $this->request->data;
			$birthDate = $data ['User'] ['birth_year'] . '-' . $data ['User'] ['birth_month'] . '-' . $data ['User'] ['birth_date'];
			$password = sha1 ( $data ['User'] ['user_name'] . $data ['User'] ['password'] . $forPass );
			$this->User->set ( array (
					'user_name' => $data ['User'] ['user_name'],
					'real_name' => $data ['User'] ['real_name'],
					'password' => $password,
					'email' => $data ['User'] ['email'],
					'birth_date' => $birthDate,
					'level' => $data ['User'] ['user_type'],
					'bank_account_code' => $data ['User'] ['bank_code'],
					'address' => $data ['User'] ['address'],
					'phone_number' => $data ['User'] ['phone_number'] 
			) );
			if ($data ['User'] ['user_type'] == 2) {
				$question = base64_encode ( $data ['User'] ['question'] );
				$verifycode = sha1 ( $data ['User'] ['user_name'] . $data ['User'] ['verifycode'] . $forPass );
				$this->Verifycode->set ( array (
						'question' => $data ['User'] ['question'],
						'verifycode' => $data ['User'] ['verifycode'] 
				) );
			}
			if ($this->User->validates ()) {
				if ($data ['User'] ['user_type'] == 3) {
					$this->User->save ();
					$user = $this->User->find ( 'first', array (
							'fields' => array (
									'id' 
							),
							'conditions' => array (
									'User.user_name' => $data ['User'] ['user_name'] 
							) 
					) );
					$this->InitialUser->set ( array (
							'user_id' => $user ['User'] ['id'],
							'initial_password' => $password 
					) );
					$this->InitialUser->save ();
				} else {
					if ($this->Verifycode->validates ()) {
						$this->User->save ();
						$user = $this->User->find ( 'first', array (
								'fields' => array (
										'id' 
								),
								'conditions' => array (
										'User.user_name' => $data ['User'] ['user_name'] 
								) 
						) );
						$this->InitialUser->set ( array (
								'user_id' => $user ['User'] ['id'],
								'initial_password' => $password 
						) );
						$this->InitialUser->save ();
						$this->Verifycode->set ( array (
								'user_id' => $user ['User'] ['id'],
								'question' => $question,
								'verifycode' => $verifycode 
						) );
						$this->Verifycode->save ();
						$this->InitialVerifycode->set ( array (
								'user_id' => $user ['User'] ['id'],
								'initial_question' => $question,
								'initial_verifycode' => $verifycode 
						) );
						$this->InitialVerifycode->save ();
					} 					// <<<<<<< HEAD
					  // }
					  // $this->redirect ( array (
					  // 'controller' => 'Users',
					  // 'action' => 'login'
					  // ) );
					  // =======
					else {
						if (isset ( $this->Verifycode->validationErrors ['question'] ))
							$questionErr = $this->Verifycode->validationErrors ['question'] ['0'];
						if (isset ( $this->Verifycode->validationErrors ['verifycode'] ))
							$answerErr = $this->Verifycode->validationErrors ['verifycode'] ['0'];
						$this->set ( compact ( 'questionErr', 'answerErr' ) );
					}
				}
				// >>>>>>> d52c32d939ece3dfe183202eb9b19dbd6cb5b7be
			}
		}
	}
	public function logout() {
		$this->Session->destroy ();
		$this->Auth->logout ();
		$this->redirect ( $this->Auth->logoutRedirect );
		exit ();
	}
	public function index() {
		if ($this->Auth->user ())
			$this->loginRedirect ( $this->Auth->user ( "level" ) );
	}
	// <<<<<<< HEAD
	public function get_user_request($user_id = null) {
		$this->showLayout ();
		$user_id = 7;
		$user = $this->User->find ( 'all', array (
				'fields' => array (
						'User.id',
						'User.user_name',
						'User.real_name',
						'User.reg_date',
						'User.level',
						'User.birth_date',
						'User.phone_number',
						'User.email',
						'User.phone_number',
						'User.address',
						'User.bank_account_code' 
				),
				'conditions' => array (
						'User.id' => $user_id,
						'User.approve_flag' => false 
				) 
		) );
		$user = $user [0] ['User'];
		$this->set ( 'requestUser', $user );
		// debug($user);die();
		if ($user ['level'] == 2)
			$this->set ( 'title_for_layout', '先生アカウント' );
			// =======
			// public function get_user_request($user_id = null) {
			// $this->showLayout ();
			// $user_id = 6;
			// $user = $this->User->find ( 'all', array (
			// 'fields' => array (
			// 'User.id',
			// 'User.user_name',
			// 'User.real_name',
			// 'User.reg_date',
			// 'User.level',
			// 'User.birth_date',
			// 'User.phone_number',
			// 'User.email',
			// 'User.phone_number',
			// 'User.address',
			// 'User.bank_account_code'
			// ),
			// 'conditions' => array (
			// 'User.id' => $user_id
			// )
			// ) );
			// $user = $user [0] ['User'];
			// $this->set ( 'requestUser', $user );
			// // debug($user);die();
			// if ($user ['level'] == 2)
			// $this->set ( 'title_for_layout', '先生アカウント' );
			// >>>>>>> tiendq
		else
			$this->set ( 'title_for_layout', '学生アカウント' );
	}
	public function accept_user($id = null) {
		// debug($id);die();
		$this->showLayout ();
		$success = false;
		
		$count = $this->User->find ( 'count', array (
				'conditions' => array (
						'User.id' => $id 
				) 
		) );
		if ($count != 0) {
			$sql = 'update tb_users
			set approve_flag=true
			where id=' . $id;
			$this->User->query ( $sql );
			$success = true;
		}
		if ($this->RequestHandler->isAjax ()) {
			$this->autoRender = $this->layout = false;
			echo json_encode ( array (
					'success' => ($success == true) ? FALSE : TRUE 
			) );
			
			exit ();
		}
		$this->redirect ( array (
				'controller' => 'lessons',
				'action' => 'manage_lessons' 
		) );
	}
	public function remove_user($id = null) {
		// debug($id);die();
		$this->showLayout ();
		$success = false;
		
		$count = $this->User->find ( 'count', array (
				'conditions' => array (
						'User.id' => $id 
				) 
		) );
		if ($count != 0) {
			$this->User->delete ( $id );
			$success = true;
		}
		
		if ($this->RequestHandler->isAjax ()) {
			$this->autoRender = $this->layout = false;
			echo json_encode ( array (
					'success' => ($success == true) ? FALSE : TRUE 
			) );
			exit ();
		}
	}
	public function viewtestresult() {
		$data = $this->Test->TestHistory->find ( 'all', array (
				'conditions' => array (
						'TestHistory.user_id' => '2' 
				) 
		) );
		$lesson_id = Array ();
		foreach ( $data as $k => $value ) {
			$lesson_id [] = $value ['Test'] ['lesson_id'];
		}
		$lesson_name = Array ();
		foreach ( $lesson_id as $id ) {
			$lesson_name [] = $this->Lesson->findById ( $id );
		}
		for($i = 0; $i < count ( $lesson_name ); $i ++) {
			$data [$i] ['Lesson'] = $lesson_name [$i] ['Lesson'];
			if ($this->request->is ( 'post' )) {
				$this->loadModel ( "User" );
				if ($this->Auth->login ()) {
					if (! $this->Auth->user ( "approve_flag" ) === 1) {
					} else {
						pr ( $this->Auth->user () );
						die ();
						if ($this->Auth->user ( "level" ) === 1) {
							$level = "admin";
						}
						if ($this->Auth->user ( "level" ) === 2) {
							$level = "teacher";
						} else
							$level = "user";
						$this->Cookie->write ( 'Auth.User', $this->Auth->user (), true, '1209600' );
						$this->Session->setFlash ( "Hello" . " " . $level . " " . $this->Auth->user ( 'user_name' ) );
						$this->redirect ( $this->Auth->redirect () );
					}
				} else {
					$this->Session->setFlash ( 'ユーザネームとかパースワードとか間違いです' );
				}
			}
		}
	}
	public function manager_home() {
		$this->layout = 'manager';
		$this->set ( 'title_for_layout', 'システムの管理ツール' );
	}
	protected function showLayout() {
		if ($this->Auth->loggedIn ()) {
			switch ($this->Auth->User ( 'level' )) {
				case '1' :
					$this->layout = 'manager';
					break;
				
				case '2' :
					$this->layout = 'teacher';
					break;
				
				case '3' :
					$this->layout = 'student';
					break;
				
				default :
					// code...
					break;
			}
			$this->set ( 'level', $this->Auth->User ( 'level' ) );
		} else {
			$this->layout = 'before_login';
		}
	}
}
