<?php
App::uses ( 'DboSource', 'Model/Datasource' );
/**
 * User controller for login,logout,...
 * 
 */

class AdminsController extends AppController {
	public $name = "Admins";
	var $uses = array ('User','InitialUser','Verifycode','InitialVerifycode','IpAddress','Bill','Lesson', 'Document');
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
			$this->IpAddress->set(array('ip_address' => $data['User']['ip_address']));
			if ($this->User->validates () && $this->IpAddress->validates()) {
				$this->User->save();
				$user = $this->User->find('first',array(
					'fields' => array('id'),
					'conditions' => array('User.user_name' => $data['User']['user_name'] )
					));
				$this->IpAddress->set(array('admin_id' => $user['User']['id']));
				$this->IpAddress->save();
				$this->InitialUser->set(array(
					'user_id' => $user['User']['id'],
					'initial_password' => $password,
					));
				$this->InitialUser->save();
				$this->redirect(array('controller' => 'Admins', 'action' => 'index'));
			}
			if(!$this->IpAddress->validates()){
				$ipAddressErr = $this->IpAddress->validationErrors['ip_address']['0'];
				$this->set(compact('ipAddressErr'));
			}
		}
	}
	function student_manager(){
		$this->set('title_for_layout', '学生アカウントを管理する');
		$forPass = 'sha1';
		$studentId = $this->request->query('student_id');
		$student = $this->User->find('first', array(
			'conditions' => array('User.id' => $studentId),
			));
		$this->set(compact('student'));
		if(isset($this->request->data['submit_data'])){
			$data = $this->request->data;
			if($student['User']['email'] == $data['User']['email'] && $student['User']['phone_number'] == $data['User']['phone_number'] && $student['User']['address'] == $data['User']['address'] && $student['User']['bank_account_code'] == $data['User']['bank_account_code']){
				$this->Session->setFlash('情報を変更しなかった。');
				$this->redirect(array('controller' => 'Admins', 'action' => 'student_manager'));
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
						$this->redirect(array('controller' => 'Admins', 'action' => 'student_manager'));
					}
				}
			}	
		}
		if(isset($this->request->data['delete_student'])){
			$this->User->set(array(
				'status_flag' => 0,
				));
			$this->User->id = $student['User']['id'];
			if($this->User->save()){
				$this->Session->setFlash('このアカウントが今ロックです');
				$this->redirect(array('controller' => 'Admins', 'action' => 'student_manager'));
			}
		}
		if(isset($this->request->data['reset_password'])){
			$initialStudent = $this->InitialUser->find('first', array(
				'conditions' => array(
					'user_id' => $student['User']['id'],
					),
				));
			$this->User->set(array(
				'password' => $initialStudent['InitialUser']['initial_password'],
				));
			$this->User->id = $student['User']['id'];
			if($this->User->save()){
				$this->Session->setFlash('このアカウントのパスワードをリセットすることが成功です。');
				$this->redirect(array('controller' => 'Admins', 'action' => 'student_manager'));
			}
		}
	}
	function teacher_manager(){
		$this->set('title_for_layout', '先生アカウントを管理する');
		$forPass = 'sha1';
		$teacherId = $this->request->query('teacher_id');
		$teacher = $this->User->find('first', array(
			'conditions' => array('User.id' => $teacherId),
			));
		$this->set(compact('teacher'));
		if(isset($this->request->data['submit_data'])){
			$data = $this->request->data;
			if($teacher['User']['email'] == $data['User']['email'] && $teacher['User']['phone_number'] == $data['User']['phone_number'] && $teacher['User']['address'] == $data['User']['address'] && $teacher['User']['bank_account_code'] == $data['User']['bank_account_code']){
				$this->Session->setFlash('情報を変更しなかった。');
				$this->redirect(array('controller' => 'Admins', 'action' => 'teacher_manager'));
			}
			else{
				$this->User->set (array(
					'bank_account_code' => $data['User']['bank_account_code'],
					'address' => $data['User']['address'],
					'phone_number' => $data['User']['phone_number'],
					));
				if($teacher['User']['email'] != $data['User']['email']){
					$this->User->set (array(
						'email' =>$teacher['User']['email'],
						));					
				}
				if($this->User->validates()){
					$this->User->id = $teacher['User']['id'];
					if($this->User->save()){
						$this->Session->setFlash('情報を変更することが成功です。');
						$this->redirect(array('controller' => 'Admins', 'action' => 'teacher_manager'));
					}
				}
			}	
		}
		if(isset($this->request->data['delete_teacher'])){
			$this->User->set(array(
				'status_flag' => 0,
				));
			$this->User->id = $teacher['User']['id'];
			if($this->User->save()){
				$this->Session->setFlash('このアカウントが今ロックです');
				$this->redirect(array('controller' => 'Admins', 'action' => 'teacher_manager'));
			}
		}
		if(isset($this->request->data['reset_password'])){
			$initialTeacher = $this->InitialUser->find('first', array(
				'conditions' => array(
					'user_id' => $teacher['User']['id'],
					),
				));
			$this->User->set(array(
				'password' => $initialTeacher['InitialUser']['initial_password'],
				));
			$this->User->id = $teacher['User']['id'];
			if($this->User->save()){
				$this->Session->setFlash('このアカウントのパスワードをリセットすることが成功です。');
				$this->redirect(array('controller' => 'Admins', 'action' => 'teacher_manager'));
			}
		}
		if(isset($this->request->data['reset_verifycode'])){
			$initialVerifycode = $this->InitialVerifycode->find('first', array(
				'conditions' => array(
					'user_id' => $teacher['User']['id'],
					),
				));
			$verifycode = $this->Verifycode->find('first', array(
				'conditions' => array(
					'user_id' => $teacher['User']['id'],
					),
				));
			$this->Verifycode->set(array(
				'question' => $initialVerifycode['InitialVerifycode']['initial_question'],
				'verifycode' => $initialVerifycode['InitialVerifycode']['initial_verifycode'],
				));
			$this->Verifycode->id = $verifycode['Verifycode']['id'];
			if($this->Verifycode->save()){
				$this->Session->setFlash('このアカウントのVerifyコードをリセットすることが成功です。');
				$this->redirect(array('controller' => 'Admins', 'action' => 'teacher_manager'));
			}
		}
	}
	public function change_info(){
		$this->set('title_for_layout', '個人情報を変更する');
		$forPass = 'sha1';
		$admin = $this->User->find('first', array(
			'conditions' => array('User.id' => $this->Auth->user('id')),
			));
		$ipList = $this->IpAddress->find('all', array(
			'conditions' => array('admin_id' => $admin['User']['id']),
			));
		$this->set(compact('admin','ipList'));
		if(isset($this->request->data['submit_data'])){
			$data = $this->request->data;
			for($i = 0; $i < count($ipList); $i++){
				$ipAddress = 'ip_address'.$i;
				if(isset($data['User'][$ipAddress])){
					$data[$ipAddress] = $data['User'][$ipAddress];
					unset($data['User'][$ipAddress]);
				}
			}
			$this->User->set (array(
				'address' => $data['User']['address'],
				'phone_number' => $data['User']['phone_number'],
				));
			if($admin['User']['email'] != $data['User']['email']){
				$this->User->set (array(
					'email' =>$data['User']['email'],
					));					
			}
			if($this->User->validates()){
				$check = 1;
				for($i = 0;$i < $data['hide']; $i++){
					$ipAddress = 'ip_address'.$i;
					if(isset($data[$ipAddress])){
						$this->IpAddress->set(array('ip_address' => $data[$ipAddress]));
						if($this->IpAddress->validates()) $check = 1;
						else{
							$check = 0;
							break;	
						}
					}
				}
				if($check == 1){
					$this->User->id = $admin['User']['id'];
					$this->User->save();
					$idList = $this->IpAddress->find('all',array(
						'conditions' => array('admin_id' => $admin['User']['id']),
						));
					for($i = 0;$i < count($idList);$i++) $this->IpAddress->delete($idList[$i]['IpAddress']['id']);
						for($i = 0;$i < $data['hide']; $i++){
							$ipAddress = 'ip_address'.$i;
							if(isset($data[$ipAddress])){
								$this->IpAddress->create();
								$this->IpAddress->set(array(
									'admin_id' => $admin['User']['id'],
									'ip_address' => $data[$ipAddress],
									));
								$this->IpAddress->save();
							}
						}
						$this->Session->setFlash('情報を変更することが成功です。');
						$this->redirect(array('controller' => 'Admins', 'action' => 'change_info'));
					}
				}
			}
		}
		public function manager_manager(){
			$this->set('title_for_layout', '管理者アカウントを管理する。');
			$forPass = 'sha1';
			$admin = $this->User->find('first', array(
				'conditions' => array('User.id' => $this->request->query('admin_id')),
				));
			$ipList = $this->IpAddress->find('all', array(
				'conditions' => array('admin_id' => $admin['User']['id']),
				));
			$this->set(compact('admin','ipList'));
			if(isset($this->request->data['submit_data']) && $admin['User']['online_flag'] == 0){
				$data = $this->request->data;
				for($i = 0; $i < count($ipList); $i++){
					$ipAddress = 'ip_address'.$i;
					if(isset($data['User'][$ipAddress])){
						$data[$ipAddress] = $data['User'][$ipAddress];
						unset($data['User'][$ipAddress]);
					}
				}
				$this->User->set (array(
					'address' => $data['User']['address'],
					'phone_number' => $data['User']['phone_number'],
					));
				if($admin['User']['email'] != $data['User']['email']){
					$this->User->set (array(
						'email' =>$data['User']['email'],
						));					
				}
				if($this->User->validates()){
					$check = 1;
					for($i = 0;$i < $data['hide']; $i++){
						$ipAddress = 'ip_address'.$i;
						if(isset($data[$ipAddress])){
							$this->IpAddress->set(array('ip_address' => $data[$ipAddress]));
							if($this->IpAddress->validates()) $check = 1;
							else{
								$check = 0;
								break;	
							}
						}
					}
					if($check == 1){
						$this->User->id = $admin['User']['id'];
						$this->User->save();
						$idList = $this->IpAddress->find('all',array(
							'conditions' => array('admin_id' => $admin['User']['id']),
							));
						for($i = 0;$i < count($idList);$i++) $this->IpAddress->delete($idList[$i]['IpAddress']['id']);
							for($i = 0;$i < $data['hide']; $i++){
								$ipAddress = 'ip_address'.$i;
								if(isset($data[$ipAddress])){
									$this->IpAddress->create();
									$this->IpAddress->set(array(
										'admin_id' => $admin['User']['id'],
										'ip_address' => $data[$ipAddress],
										));
									$this->IpAddress->save();
								}
							}
							$this->Session->setFlash('情報を変更することが成功です。');
							$this->redirect(array('controller' => 'Admins', 'action' => 'manager_manager'));
						}
					}
				}
				if(isset($this->request->data['delete_manager']) && $admin['User']['online_flag'] == 0){
					$this->User->set(array(
						'status_flag' => 0,
						));
					$this->User->id = $admin['User']['id'];
					if($this->User->save()){
						$this->Session->setFlash('このアカウントが今ロックです');
						$this->redirect(array('controller' => 'Admins', 'action' => 'manager_manager'));
					}
				}
				if($admin['User']['online_flag'] == 1 && isset($this->request->data)){
					$this->Session->setFlash('このアカウントが今オンラインです、アカウントの情報を変更できなかった。');
					$this->redirect(array('controller' => 'Admins', 'action' => 'manager_manager'));
				}
			}

	//Athor: Manh Phi.
	//Moneys Export Function 
			public function managerMoney(){
				$monthyear="";
				if(isset($this->request->data['result'])){
					$time = $this->request->data['Admins'];
					$monthyear = $time['year']."-".$time['month']."%";
					// debug($monthyear);
				}

				$data = $this->Bill->find('all', array(
					'fields'=> array('sum(Bill.lesson_cost) AS sum','Bill.user_id'),
					'group'=>'Bill.lesson_id',
					'conditions' => array(
						'Bill.learn_date LIKE ' => $monthyear
						)
					));
				for ($i=0; $i < count($data); $i++) { 
					$user = $this->User->find('first',array(
						'fields'=> array('real_name','phone_number','address','bank_account_code'),
						'conditions'=>array(
							'User.id'=>$data[$i]['Bill']['user_id']
							)
						)
					);
					$data[$i]['user']=$user['User'];
				}
				$this->set('userInfors',$data);
			}

			//Huong Viet
			public function getAccount(){

				if(!empty($this->data)&&$this->data['User']['user_name']!=null){
        //neu co thi truy van du lieu dua vao bien $users
					$count=$this->User->find('count',array('conditions'=>array('user_name LIKE '=>'%'.$this->data['User']['user_name'].'%','User.approve_flag'=> 1)));
            //goi du lieu tu controller len view
					if($count!=0)
					{
                //$this->set('users',$users);


						$this->paginate = array(
							'limit' => 10,
							'field' => array('User.id', 'User.user_name', 'User.real_name'),
							'conditions'=>array('user_name LIKE '=>'%'.$this->data['User']['user_name'].'%','User.approve_flag'=> 1
								));
						$data = $this->paginate('User');
						$this->set('data', $data);            
					}
					else
						$this->set('message', '結果がない');   
					
				}

				else{
					$this->paginate = array(
						'limit' => 10,
						'conditions' => array(
							'User.approve_flag'=> 1
							),
						'field' => array('User.id', 'User.user_name', 'User.real_name')

						);
					$data = $this->paginate('User');
					$this->set('data', $data);
				}
				
				
			}



			public function getDocument(){


				if(isset($this->request->data['delete_file'])){
					debug($data['delete_file']);die();
				}
				if(!empty($this->data)&&$this->data['Document']['file_name']!=null){
        //neu co thi truy van du lieu dua vao bien $users
					$count=$this->Document->find('count',array('conditions'=>array('file_name LIKE '=>'%'.$this->data['Document']['file_name'].'%')));
            //goi du lieu tu controller len view
					if($count!=0)
					{

						$this->paginate = array(
							'limit' => 10,
							'conditions'=>array('file_name LIKE '=>'%'.$this->data['Document']['file_name'].'%'
								));
						$data = $this->paginate('Document');
						$this->set('data', $data);            
					}
					else
						$this->set('message', '結果がない');   
					
				}

				else{
					$this->paginate = array(
						'limit' => 10,
						);
					$data = $this->paginate('Document');
            //debug($data); die();
					$this->set('data', $data);
				}

			}


			public function getConfirmAccount(){


				if(!empty($this->data)&&$this->data['User']['user_name']!=null){
        //neu co thi truy van du lieu dua vao bien $users
					$count=$this->User->find('count',array('conditions'=>array('user_name LIKE '=>'%'.$this->data['User']['user_name'].'%','User.approve_flag'=> 0)));
            //goi du lieu tu controller len view
					if($count!=0)
					{
                //$this->set('users',$users);


						$this->paginate = array(
							'limit' => 10,
							'field' => array('User.id', 'User.user_name', 'User.real_name'),
							'conditions'=>array('user_name LIKE '=>'%'.$this->data['User']['user_name'].'%','User.approve_flag'=> 0
								));
						$data = $this->paginate('User');
						$this->set('data', $data);            
					}
					else
						$this->set('message', '結果がない');   
					
				}

				else{
					$this->paginate = array(
						'limit' => 10,
						'conditions' => array(
							'User.approve_flag'=> 0
							),
						'field' => array('User.id', 'User.user_name', 'User.real_name')
						);
					$data = $this->paginate('User');
            //debug($data); die();
					$this->set('data', $data);
				}
				
			}



			public function getLesson(){

				if(!empty($this->data)&&$this->data['Lesson']['lesson_name']!=null){
        //neu co thi truy van du lieu dua vao bien $users
					$count=$this->Lesson->find('count',array('conditions'=>array('lesson_name LIKE '=>'%'.$this->data['Lesson']['lesson_name'].'%')));
            //goi du lieu tu controller len view
					if($count!=0)
					{
                //$this->set('users',$users);


						$this->paginate = array(
							'limit' => 10,
							'conditions'=>array('lesson_name LIKE '=>'%'.$this->data['Lesson']['lesson_name'].'%'
								));
						$data = $this->paginate('Lesson');
						$this->set('data', $data);            
					}
					else
						$this->set('message', '結果がない');   
					
				}

				else{
					$this->paginate = array(
						'limit' => 10,
						);
					$data = $this->paginate('Lesson');
            //debug($data); die();
					$this->set('data', $data);
				}
			}


			public function delete_document() {
				if(isset($this->request->data['delete_file'])){
                //debug($this->request->data['hide']);
					$count = $this->request->data['hide'];
					$this->Document->id = $count;
					$this->Document->delete();
					$this->redirect(array('controller' => 'admins', 'action' => 'getDocument'));
				}
				if(isset($this->request->data['block_file'])){
               // debug($this->request->data['hide']);die();
					$count = $this->request->data['hide'];
					$this->Document->id = $count;
					if($this->Document->lock_flag==0){
						$this->Document->set(array(
							'lock_flag' => 1,
							));
					}
					
					if($this->Document->lock_flag==1){
						$this->Document->set(array(
							'lock_flag' => 0,
							));
					}

					$this->Document->save();
					$this->redirect(array('controller' => 'admins', 'action' => 'getDocument'));
				}
			}

		}
