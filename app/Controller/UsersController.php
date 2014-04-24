<?php
App::uses ( 'DboSource', 'Model/Datasource' );
/**
 * Common controller for login,logout,...
 */
class UsersController extends AppController {
	var $inputPass = '';
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
		$this->Auth->allow ( array ('home', 'login', 'register', 'teacherPass', 'teacherVerify', 'teacherName' ) );
	}
	public function login() {
		// logged in user
		$this->set ( 'title_for_layout', 'ログイン' );
		if ($this->Auth->user ()) {
			if ($this->Auth->user ( 'level' ) != 1)
				$this->redirect ( array ("controller" => "Lessons", "action" => "view_all_lessons" ) );
			else
				$this->redirect ( array ("controller" => "Admins", "action" => "manager_home" ) );
		}
		// xu ly khi nguoi dung an login
		if ($this->request->is ( 'post' )) {
			$data = $this->request->data;
			// tao chuoi password de so sanh
			$data ['User'] ['password'] = $data ['User'] ['user_name'] . $data ['User'] ['password'] . 'sha1';
			
			$password = sha1 ( $data ['User'] ['password'] );
			$user = $this->User->find ( 'first', array ('conditions' => array ('user_name' => $data ['User'] ['user_name'], 'password' => $password ) ) );
			
			// kiem tra IP dang bi block
			$guest = $this->LockedUser->find ( 'first', array ('conditions' => array ('ip_address' => $this->request->clientIp () ) ) );
			// debug($guest);die();
			if ($guest) {

				if ($guest ['LockedUser'] ['count'] >= ($this->ChangeableValue->field ( "current_value", array (
						'id' => 4 
				) ) - 1)) {
					// if ($this->request->data ['User'] ['user_type'] == 2) {
					// $this->redirect ( 'teacherName' );
					// } else if ($this->request->data ['User'] ['user_type'] == 3) {
					if ($guest ['LockedUser'] ['lock_flg'] == 1) {
						if ((strtotime ( date ( "Y/m/d H:i:s" ) ) - strtotime ( $guest ['LockedUser'] ['lock_start_time'] )) < 60 * $this->ChangeableValue->field ( 'current_value', array (
								'id' => 5 
						) )) {
							// $time = (strtotime ( date ( "Y/m/d H:i:s" ) ) - strtotime ( $guest ['LockedUser'] ['lock_start_time'] ));
							// debug($time);die();
							$this->Session->setFlash ( 'IP が ' . $this->ChangeableValue->field ( "current_value", array (
									'id' => 5 
							) ) . ' 分間に' . 'ブロックしている' );

							$this->redirect ( 'login' );
						} else {
							
							if ($this->request->data ['User'] ['user_type'] == 2)
								$this->redirect ( 'teacherName' );
							else {
								$this->LockedUser->delete ( $guest ['LockedUser'] ['id'] );
								$this->redirect ( 'login' );
							}
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
			
			if (! empty ( $user )) {
				if ($user ['User'] ['level'] == 1) {
					$this->Session->setFlash ( 'ログインページが適当しない' );
					$this->redirect ( 'login' );
				}
				// kiem tra user active
				if ($user ['User'] ['approve_flag'] == 0) {
					$this->Session->setFlash ( __ ( 'アカウントがまだ確認しない' ) );
					$this->redirect ( 'login' );
				}
				// kiem tra chon loai tai khoan
				if ($user ['User'] ['level'] != $data ['User'] ['user_type'] && $user ['User'] ['level'] != 1) {
					$this->Session->setFlash ( 'アカウントタイプを選択することが間違う' );
					$this->redirect ( 'login' );
				}
				// kiem tra lastIP
				if ($user ['User'] ['level'] == 2 && $user ['User'] ['ip_address'] != NULL && $user ['User'] ['ip_address'] != $this->request->clientIp ()) {
					$this->Session->setFlash ( __ ( '最後のログインIPと比べて違う' ) );

					$this->redirect ( array (
							'controller' => 'Users',
							'action' => 'teacherVerify',
							$user ['User'] ['id'],
							'missIP',
							base64_encode($data ['User'] ['password'])
					) );
				}

			}
			
			// login
			$this->request->data ['User'] ['password'] = $data ['User'] ['password'];
			if ($this->Auth->login ()) {
				// save current IP
				$this->User->id = $this->Auth->user ( 'id' );
				$this->User->set ( array ('ip_address' => $this->request->clientIp (), 'online_flag' => 1 ) );
				$this->User->save ();
				$this->Session->setFlash ( "よこそ　" . $this->Auth->user ( 'user_name' ) );
				// xoa lock ip
				$this->LockedUser->deleteAll ( array ('ip_address' => $this->request->clientIp () ) );
				// redirect to homepage
				$this->redirect ( array ("controller" => "Lessons", "action" => "view_all_lessons" ) );
			} // sai username hoac password
else {
				if ($guest) {
					$this->LockedUser->id = $guest ['LockedUser'] ['id'];
					$this->LockedUser->set ( 'count', $guest ['LockedUser'] ['count'] + 1 );
					$this->LockedUser->save ();
					$this->Session->setFlash ( 'パスワードを入力間違うことが　' . ($guest ['LockedUser'] ['count'] + 1) . ' 回だ' );
				} else {
					$this->LockedUser->create ();
					$this->LockedUser->set ( array ('ip_address' => $this->request->clientIp (), 'count' => 1, 'lock_flg' => 0 ) );
					$this->LockedUser->save ();
					$this->Session->setFlash ( 'パスワードを入力間違うことが１回だ' );
				}
			}
		}
	}
	public function teacherName() {

		$this->set ( 'title_for_layout', 'ユーザネーム入力' );
		if ($this->request->is ( "post" )) {
			if ($guest = $this->User->find ( 'first', array (
					'conditions' => array (
							'user_name' => $this->request->data ['User'] ['username'],
							'level' => 2 
					) 
			) )) {
				$this->redirect ( array (
						'controller' => 'Users',
						'action' => 'teacherVerify',
						$guest ['User'] ['id'],
						'block' 
				) );

			} else
				$this->Session->setFlash ( 'ユーザネームが間違う' );
		}
	}
	public function teacherPass($id) {

		$this->set ( 'title_for_layout', 'パスワード入力' );
		$teacher = $this->User->find ( 'first', array (
				'conditions' => array (
						'id' => $id 
				) 
		) );

		$this->set ( compact ( 'teacher' ) );
		if ($this->request->is ( 'post' )) {
			$data = $this->request->data;
			$pass = $teacher ['User'] ['user_name'] . $data ['User'] ['pass'] . 'sha1';
			$this->request->data = $teacher;
			$this->request->data ['User'] ['password'] = $pass;
			
			if ($this->Auth->login ()) {
				$this->LockedUser->deleteAll ( array ('ip_address' => $this->request->clientIp () ) );
				$this->User->id = $id;
				$this->User->set ( array ('ip_address' => $this->request->clientIp (), 'online_flag' => 1 ) );
				$this->User->save ();
				

				$this->LockedUser->deleteAll ( array (
						'ip_address' => $this->request->clientIp ()
				) );
				$this->redirect ( array (
						"controller" => "Lessons",
						"action" => "view_all_lessons" 
				) );
				

			} else
				$this->Session->setFlash ( 'パスワードが間違う' );
		}
	}

	public function teacherVerify($id = null, $type = null,$inputPass = null) {
		if ($id == null || $type == null) {
			throw new NotFoundException ( 'パラメータがない', 404 );
		}
		
		$this->set ( 'title_for_layout', 'Verifyコード入力' );
		$teacher = $this->Verifycode->find ( 'first', array (
				'conditions' => array (
						'user_id' => $id 
				) 
		) );
		$teacher['type'] = $type;
		$teacher['inputPass'] = $inputPass;

		$this->set ( compact ( 'teacher' ) );
		if ($this->request->is ( 'post' )) {
			$verifycode = $this->request->data;
			$verifycode = sha1 ( $this->User->field ( 'user_name', array ('id' => $id ) ) . $verifycode ['Verifycode'] ['verifycode'] . 'sha1' );
			if ($verifycode == $teacher ['Verifycode'] ['verifycode']) {

				if ($type == 'block') {
					$this->redirect ( array (
							'controller' => 'Users',
							'action' => 'teacherPass',
							$id 
					) );
				}
				if ($type == 'missIP') {
					$user = $this->User->find ( 'first', array (
							'conditions' => array (
									'id' => $id 
							) 
					) );
					$this->request->data = $user;
					$this->request->data ['User'] ['password'] = base64_decode($inputPass);
					
					if ($this->Auth->login ()) {
						$this->User->id = $id;
						$this->User->set ( array (
								'ip_address' => $this->request->clientIp () 
						) );
						$this->User->save ();
						
						$this->redirect ( array (
								"controller" => "Lessons",
								"action" => "view_all_lessons" 
						) );
					}
				}

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
			if ($data ['User'] ['user_type'] == 2) {
				$bankCode = $data ['User'] ['bankCodePart1'] . '-' . $data ['User'] ['bankCodePart2'] . '-' . $data ['User'] ['bankCodePart3'] . '-' . $data ['User'] ['bankCodePart4'];
			} else {
				$bankCode = $data ['User'] ['cardPart1'] . '-' . $data ['User'] ['cardPart2'] . '-' . $data ['User'] ['cardPart3'] . '-' . $data ['User'] ['cardPart4'] . '-' . $data ['User'] ['cardPart5'];
			}
			$this->User->set ( array ('user_name' => $data ['User'] ['user_name'], 'real_name' => $data ['User'] ['real_name'], 'password' => $password, 'email' => $data ['User'] ['email'], 'birth_date' => $birthDate, 'level' => $data ['User'] ['user_type'], 'bank_account_code' => $bankCode, 'address' => $data ['User'] ['address'], 'phone_number' => $data ['User'] ['phone_number'] ) );
			if ($data ['User'] ['user_type'] == 2) {
				$question = base64_encode ( $data ['User'] ['question'] );
				$verifycode = sha1 ( $data ['User'] ['user_name'] . $data ['User'] ['verifycode'] . $forPass );
				$this->Verifycode->set ( array ('question' => $data ['User'] ['question'], 'verifycode' => $data ['User'] ['verifycode'] ) );
			}
			if ($this->User->validates ()) {
				if ($data ['User'] ['user_type'] == 3) {
					$this->User->save ();
					$user = $this->User->find ( 'first', array ('fields' => array ('id' ), 'conditions' => array ('User.user_name' => $data ['User'] ['user_name'] ) ) );
					$this->InitialUser->set ( array ('user_id' => $user ['User'] ['id'], 'initial_password' => $password ) );
					$this->InitialUser->save ();
					$this->Session->setFlash ( '登録が成功です。' );
					$this->redirect ( array ('controller' => 'Users', 'action' => 'login' ) );
				} else {
					if ($this->Verifycode->validates ()) {
						$this->User->save ();
						$user = $this->User->find ( 'first', array ('fields' => array ('id' ), 'conditions' => array ('User.user_name' => $data ['User'] ['user_name'] ) ) );
						$this->InitialUser->set ( array ('user_id' => $user ['User'] ['id'], 'initial_password' => $password ) );
						$this->InitialUser->save ();
						$this->Verifycode->set ( array ('user_id' => $user ['User'] ['id'], 'question' => $question, 'verifycode' => $verifycode ) );
						$this->Verifycode->save ();
						$this->InitialVerifycode->set ( array ('user_id' => $user ['User'] ['id'], 'initial_question' => $question, 'initial_verifycode' => $verifycode ) );
						$this->InitialVerifycode->save ();
						$this->Session->setFlash ( '登録が成功です。' );
						$this->redirect ( array ('controller' => 'Users', 'action' => 'login' ) );

					} else {
						if (isset ( $this->Verifycode->validationErrors ['question'] ))
							$questionErr = $this->Verifycode->validationErrors ['question'] ['0'];
						if (isset ( $this->Verifycode->validationErrors ['verifycode'] ))
							$answerErr = $this->Verifycode->validationErrors ['verifycode'] ['0'];
						$this->set ( compact ( 'questionErr', 'answerErr' ) );
					}
				}
			}
		}
	}
	public function logout() {
		$this->User->id = $this->Auth->user ( 'id' );
		$this->User->set ( array ( 'online_flag' => 0 ) );
		$this->User->save ();
		$this->Session->destroy ();
		$this->Auth->logout ();
		$this->redirect ( $this->Auth->logoutRedirect );
		exit ();
	}
	public function index() {
		if ($this->Auth->user ())
			$this->loginRedirect ( $this->Auth->user ( "level" ) );
	}
	
	public function viewtestresult() {
		$data = $this->Test->TestHistory->find ( 'all', array ('conditions' => array ('TestHistory.user_id' => '2' ) ) );
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
