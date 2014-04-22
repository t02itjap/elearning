<?php

App::uses('DboSource', 'Model/Datasource');
App::uses ( 'Folder', 'Utility' );
App::uses ( 'File', 'Utility' );

/**
 * User controller for login,logout,...
 * 
 */
class AdminsController extends AppController {

    public $name = "Admins";
    var $uses = array('User', 'InitialUser', 'Verifycode', 'InitialVerifycode', 'IpAddress', 'Bill', 'Lesson', 'Document', 'ChangeableValue');
    var $helpers = array('Html', 'Form', 'Editor');
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'manager';
        $this->Auth->allow('index');
    }
 public function isAuthorized() {
        if ($this->Auth->user('level') == 1 )
            return true;
        else {
            $this->Session->setFlash("Access deny");
            $this->redirect($this->redirect(array("controller" => "users", "action" => "logout")));
            return false;
        }
    }
    
function index(){
    	$this->layout = 'before_login';
    	$this->set('title_for_layout','管理者ログイン');
    	if ($this->Auth->user ()) {
    			$this->redirect ( array (
    					"controller" => "Lessons",
    					"action" => "view_all_lessons"
    			) );
    	}
    	
    	if($this->request->is('post')){
    		$data = $this->request->data;
    		// 比べるために、パスワードstring を作る
    		$data ['User'] ['password'] = $data ['User'] ['user_name'] . $data ['User'] ['password'] . 'sha1';
    		$password = sha1 ( $data ['User'] ['password'] );
    		$user = $this->User->find ( 'first', array (
    				'conditions' => array (
    						'user_name' => $data ['User'] ['user_name'],
    						'password' => $password
    				)
    		) );
    		
    		if($this->Session->read('missing')== null){
    			$this->Session->write('missing',0);
    		}

    		if(!empty($user)){
    			if($user['User']['level']!=1){
    				$this->Session->setFlash('管理者のアカウントじゃない'.'</br>'.'間違う'.($this->Session->read('missing')+1).'回');
    				$this->Session->write('missing',$this->Session->read('missing')+1);
    				return $this->redirect(array('controller'=>'admins'));
    			}
    			$ip = $this->IpAddress->find('first',array(
    					'conditions' => array(
    							'admin_id' => $user['User']['id']
    			)
    			));
//     			管理者のIPアドレスをチェックする
    			if ($ip['IpAddress']['ip_address'] != $this->request->clientIp ()) {
    				$this->Session->setFlash ( "IPアドレスが間違う".'</br>'.'間違う'.($this->Session->read('missing')+1).'回' );
    				$this->Session->write('missing',$this->Session->read('missing')+1);
    				return $this->redirect (array('controller'=>'admins'));
    			}
    		}   		
    		$this->request->data ['User'] ['password'] = $data ['User'] ['password'];
    		
    		if($this->Auth->login()){
    			
    			$this->User->id = $this->Auth->user('id');
				$this->User->set ( array (
						'ip_address' => $this->request->clientIp (),
						'online_flag' => 1
				) );
				$this->User->save ();
    			$this->Session->delete('missing');
    			$this->redirect ( array (
						"controller" => "Lessons",
						"action" => "view_all_lessons" 
				) );
    		}else{
    			$this->Session->setFlash('ユーザネームとかパスワードとかが間違う'.'</br>'.'間違う'.($this->Session->read('missing')+1).'回');
    			$this->Session->write('missing',$this->Session->read('missing')+1);
    			return $this->redirect(array('controller'=>'admins'));
    		}
    			
    	}
    }

    function register_new_manager() {
        $this->set('title_for_layout', '登録');
        $forPass = 'sha1';
        if (isset($this->request->data ['submit_data'])) {
            $data = $this->request->data;
            $birthDate = $data['User']['birth_year'] . '-' . $data['User']['birth_month'] . '-' . $data['User']['birth_date'];
            $password = sha1($data['User']['user_name'] . $data['User']['password'] . $forPass);
            $this->User->set(array(
                'user_name' => $data['User']['user_name'],
                'real_name' => $data['User']['real_name'],
                'password' => $password,
                'email' => $data['User']['email'],
                'birth_date' => $birthDate,
                'level' => 1,
            	'approve_flag' => 1,
                'bank_account_code' => 'khong xac dinh',
                'address' => $data['User']['address'],
                'phone_number' => $data['User']['phone_number'],
                ));
            $this->IpAddress->set(array('ip_address' => $data['User']['ip_address']));
            if ($this->User->validates() && $this->IpAddress->validates()) {
                $this->User->save();
                $user = $this->User->find('first', array(
                    'fields' => array('id'),
                    'conditions' => array('User.user_name' => $data['User']['user_name'])
                    ));
                $this->IpAddress->set(array('admin_id' => $user['User']['id']));
                $this->IpAddress->save();
                $this->Session->setFlash('新しい管理者を作ることが成功です。');
                $this->redirect(array('controller' => 'Admins', 'action' => 'manager_home'));
            }
            if (!$this->IpAddress->validates()) {
                $ipAddressErr = $this->IpAddress->validationErrors['ip_address']['0'];
                $this->set(compact('ipAddressErr'));
            }
        }
    }

    function student_manager($student_id) {
        $this->set('title_for_layout', '学生アカウントを管理する');
        $forPass = 'sha1';
        $studentId = $student_id;
        $student = $this->User->find('first', array(
            'conditions' => array('User.id' => $studentId),
            ));
        $this->set(compact('student'));
        if (isset($this->request->data['submit_data'])) {
            $data = $this->request->data;
            $bankCode = $data ['User'] ['cardPart1'].'-'.$data ['User'] ['cardPart2'].'-'.$data ['User'] ['cardPart3'].'-'.$data ['User'] ['cardPart4'].'-'.$data ['User'] ['cardPart5'];
            if ($student['User']['email'] == $data['User']['email'] && $student['User']['phone_number'] == $data['User']['phone_number'] && $student['User']['address'] == $data['User']['address'] && $student['User']['bank_account_code'] == $bankCode) {
                $this->Session->setFlash('情報を変更しなかった。');
                $this->redirect(array('controller' => 'Admins', 'action' => 'student_manager',  $student['User']['id']));
            } else {
                $this->User->set(array(
                    'bank_account_code' => $bankCode,
                    'address' => $data['User']['address'],
                    'phone_number' => $data['User']['phone_number'],
                    ));
                if ($student['User']['email'] != $data['User']['email']) {
                    $this->User->set(array(
                        'email' => $student['User']['email'],
                        ));
                }
                if ($this->User->validates()) {
                    $this->User->id = $student['User']['id'];
                    if ($this->User->save()) {
                        $this->Session->setFlash('情報を変更することが成功です。');
                        $this->redirect(array('controller' => 'Admins', 'action' => 'student_manager',  $student['User']['id']));
                    }
                }
            }
        }
        if (isset($this->request->data['delete_student'])) {
            $this->User->set(array(
                'status_flag' => 0,
                ));
            $this->User->id = $student['User']['id'];
            if ($this->User->save()) {
                $this->Session->setFlash('このアカウントが今ロックです');
                $this->redirect(array('controller' => 'Admins', 'action' => 'student_manager', $student['User']['id']));
            }
        }
        if (isset($this->request->data['reset_password'])) {
            $initialStudent = $this->InitialUser->find('first', array(
                'conditions' => array(
                    'user_id' => $student['User']['id'],
                    ),
                ));
            $this->User->set(array(
                'password' => $initialStudent['InitialUser']['initial_password'],
                ));
            $this->User->id = $student['User']['id'];
            if ($this->User->save()) {
                $this->Session->setFlash('このアカウントのパスワードをリセットすることが成功です。');
                $this->redirect(array('controller' => 'Admins', 'action' => 'student_manager', $student['User']['id']));
            }
        }
    }

    function teacherManager($teacher_id) {
        $this->set('title_for_layout', '先生アカウントを管理する');
        $forPass = 'sha1';
        $teacherId = $teacher_id;
        $teacher = $this->User->find('first', array(
            'conditions' => array('User.id' => $teacherId),
            ));
        $this->set(compact('teacher'));
        if (isset($this->request->data['submit_data'])) {
            $data = $this->request->data;
            $bankCode = $data ['User'] ['bankCodePart1'].'-'.$data ['User'] ['bankCodePart2'].'-'.$data ['User'] ['bankCodePart3'].'-'.$data ['User'] ['bankCodePart4'];
            if ($teacher['User']['email'] == $data['User']['email'] && $teacher['User']['phone_number'] == $data['User']['phone_number'] && $teacher['User']['address'] == $data['User']['address'] && $teacher['User']['bank_account_code'] == $bankCode) {
                $this->Session->setFlash('情報を変更しなかった。');
                $this->redirect(array('controller' => 'Admins', 'action' => 'teacherManager', $teacher['User']['id']));
            } else {
                $this->User->set(array(
                    'bank_account_code' => $bankCode,
                    'address' => $data['User']['address'],
                    'phone_number' => $data['User']['phone_number'],
                    ));
                if ($teacher['User']['email'] != $data['User']['email']) {
                    $this->User->set(array(
                        'email' => $teacher['User']['email'],
                        ));
                }
                if ($this->User->validates()) {
                    $this->User->id = $teacher['User']['id'];
                    if ($this->User->save()) {
                        $this->Session->setFlash('情報を変更することが成功です。');
                        $this->redirect(array('controller' => 'Admins', 'action' => 'teacherManager',  $teacher['User']['id']));
                    }
                }
            }
        }
        if (isset($this->request->data['delete_teacher'])) {
            $this->User->set(array(
                'status_flag' => 0,
                ));
            $this->User->id = $teacher['User']['id'];
            if ($this->User->save()) {
                $this->Session->setFlash('このアカウントが今ロックです');
                $this->redirect(array('controller' => 'Admins', 'action' => 'teacherManager', $teacher['User']['id']));
            }
        }
        if (isset($this->request->data['reset_password'])) {
            $initialTeacher = $this->InitialUser->find('first', array(
                'conditions' => array(
                    'user_id' => $teacher['User']['id'],
                    ),
                ));
            $this->User->set(array(
                'password' => $initialTeacher['InitialUser']['initial_password'],
                ));
            $this->User->id = $teacher['User']['id'];
            if ($this->User->save()) {
                $this->Session->setFlash('このアカウントのパスワードをリセットすることが成功です。');
                $this->redirect(array('controller' => 'Admins', 'action' => 'teacherManager', $teacher['User']['id']));
            }
        }
        if (isset($this->request->data['reset_verifycode'])) {
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
            if ($this->Verifycode->save()) {
                $this->Session->setFlash('このアカウントのVerifyコードをリセットすることが成功です。');
                $this->redirect(array('controller' => 'Admins', 'action' => 'teacherManager',  $teacher['User']['id']));
            }
        }
    }

    public function change_info() {
        $this->set('title_for_layout', '個人情報を変更する');
        $forPass = 'sha1';
        $admin = $this->User->find('first', array(
            'conditions' => array('User.id' => $this->Auth->user('id')),
            ));
        $ipList = $this->IpAddress->find('all', array(
            'conditions' => array('admin_id' => $admin['User']['id']),
            ));
        $this->set(compact('admin', 'ipList'));
        if (isset($this->request->data['submit_data'])) {
            $data = $this->request->data;
            for ($i = 0; $i < count($ipList); $i++) {
                $ipAddress = 'ip_address' . $i;
                if (isset($data['User'][$ipAddress])  && $data['User'][$ipAddress] != NULL ) {
                    $data[$ipAddress] = $data['User'][$ipAddress];
                    unset($data['User'][$ipAddress]);
                }
            }
            $this->User->set(array(
                'address' => $data['User']['address'],
                'phone_number' => $data['User']['phone_number'],
                ));
            if ($admin['User']['email'] != $data['User']['email']) {
                $this->User->set(array(
                    'email' => $data['User']['email'],
                    ));
            }
            if ($this->User->validates()) {
                $check = 1;
                for ($i = 0; $i < $data['hide']; $i++) {
                	$invalidFlag = 0;
                    $ipAddress = 'ip_address' . $i;
                    if (isset($data[$ipAddress])) {
                    	for($j = $i+1; $j < $data['hide']; $j++){
                    		$ipAddress1 = 'ip_address'.$j;
                    		if(isset($data[$ipAddress1]) && $data[$ipAddress] == $data[$ipAddress1]){
                    			unset($data[$ipAddress]);
                    			$invalidFlag = 1;
                    			break;
                    		}
                    	}
                    	if($invalidFlag == 1) continue;
                        $this->IpAddress->set(array('ip_address' => $data[$ipAddress]));
                        if ($this->IpAddress->validates())
                            $check = 1;
                        else {
                            $check = 0;
                            break;
                        }
                    }
                }
                if ($check == 1) {
                    $this->User->id = $admin['User']['id'];
                    $this->User->save();
                    $idList = $this->IpAddress->find('all', array(
                        'conditions' => array('admin_id' => $admin['User']['id']),
                        ));
                    for ($i = 0; $i < count($idList); $i++)
                        $this->IpAddress->delete($idList[$i]['IpAddress']['id']);
                    for ($i = 0; $i < $data['hide']; $i++) {
                        $ipAddress = 'ip_address' . $i;
                        if (isset($data[$ipAddress])) {
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

    public function manager_manager($admin_id) {
        $this->set('title_for_layout', '管理者アカウントを管理する。');
        $forPass = 'sha1';
        $admin = $this->User->find('first', array(
            'conditions' => array('User.id' => $admin_id),
            ));
        $ipList = $this->IpAddress->find('all', array(
            'conditions' => array('admin_id' => $admin['User']['id']),
            ));
        $this->set(compact('admin', 'ipList'));
        if (isset($this->request->data['submit_data']) && $admin['User']['online_flag'] == 0) {
            $data = $this->request->data;
            for ($i = 0; $i < count($ipList); $i++) {
                $ipAddress = 'ip_address' . $i;
                if (isset($data['User'][$ipAddress]) && $data['User'][$ipAddress] != NULL ) {
                    $data[$ipAddress] = $data['User'][$ipAddress];
                    unset($data['User'][$ipAddress]);
                }
            }
            $this->User->set(array(
                'address' => $data['User']['address'],
                'phone_number' => $data['User']['phone_number'],
                ));
            if ($admin['User']['email'] != $data['User']['email']) {
                $this->User->set(array(
                    'email' => $data['User']['email'],
                    ));
            }
            if ($this->User->validates()) {
                $check = 1;
                for ($i = 0; $i < $data['hide']; $i++) {
                	$invalidFlag = 0;
                    $ipAddress = 'ip_address' . $i;
                    if (isset($data[$ipAddress])) {
                    	for($j = $i+1; $j < $data['hide']; $j++){
                    		$ipAddress1 = 'ip_address'.$j;
                    		if(isset($data[$ipAddress1]) && $data[$ipAddress] == $data[$ipAddress1]){
                    			unset($data[$ipAddress]);
                    			$invalidFlag = 1;
                    			break;
                    		}
                    	}
                    	if($invalidFlag == 1) continue;
                        $this->IpAddress->set(array('ip_address' => $data[$ipAddress]));
                        if ($this->IpAddress->validates())
                            $check = 1;
                        else {
                            $check = 0;
                            break;
                        }
                    }
                }
                if ($check == 1) {
                    $this->User->id = $admin['User']['id'];
                    $this->User->save();
                    $idList = $this->IpAddress->find('all', array(
                        'conditions' => array('admin_id' => $admin['User']['id']),
                        ));
                    for ($i = 0; $i < count($idList); $i++)
                        $this->IpAddress->delete($idList[$i]['IpAddress']['id']);
                    for ($i = 0; $i < $data['hide']; $i++) {
                        $ipAddress = 'ip_address' . $i;
                        if (isset($data[$ipAddress])) {
                            $this->IpAddress->create();
                            $this->IpAddress->set(array(
                                'admin_id' => $admin['User']['id'],
                                'ip_address' => $data[$ipAddress],
                                ));
                            $this->IpAddress->save();
                        }
                    }
                    $this->Session->setFlash('情報を変更することが成功です。');
                    $this->redirect(array('controller' => 'Admins', 'action' => 'manager_manager', $admin['User']['id']));
                }
            }
        }
        if (isset($this->request->data['delete_manager']) && $admin['User']['online_flag'] == 0) {
            $this->User->set(array(
                'status_flag' => 0,
                ));
            $this->User->id = $admin['User']['id'];
            if ($this->User->delete()) {
                $this->Session->setFlash('このアカウントが今ロックです');
                $this->redirect(array('controller' => 'Admins', 'action' => 'getAccount'));
            }
        }
        if ($admin['User']['online_flag'] == 1 && isset($this->request->data)) {
            $this->Session->setFlash('このアカウントが今オンラインです、アカウントの情報を変更できなかった。');
            $this->redirect(array('controller' => 'Admins', 'action' => 'manager_manager', $admin['User']['id']));
        }
    }

//Athor: Manh Phi.
//Moneys Export Function 
    public function managerMoney() {
        $monthyear = "";
        if (isset($this->request->data['result'])) {
            $time = $this->request->data['Admins'];
            $monthyear = $time['year'] . "-" . $time['month'] . "%";
        }

        $data = $this->Bill->find('all', array(
            'fields' => array('sum(Bill.lesson_cost) AS sum', 'Bill.user_id'),
            'group' => 'Bill.lesson_id',
            'conditions' => array(
                'Bill.learn_date LIKE ' => $monthyear
                )
            ));
        for ($i = 0; $i < count($data); $i++) {
            $user = $this->User->find('first', array(
                'fields' => array('user_name','real_name', 'phone_number', 'address', 'bank_account_code'),
                'conditions' => array(
                    'User.id' => $data[$i]['Bill']['user_id']
                    )
                )
            );
            $data[$i]['user'] = $user['User'];
        }
        $this->set('userInfors', $data);
        $this->Session->write('userInfors',$data);
    }

    public function exportMoney(){
        $data = $this->Session->read('userInfors');
        $date = date('Y-m');        
        //Write file!
        $file = fopen('C:\xampp\htdocs\elearning\app\webroot\ELS-UBT-'.$date.'.tsv','w');
        for ($i=0; $i <count($data) ; $i++) { 
            $line = $data[$i]['user']['user_name'] . "\t" . $data[$i]['user']['real_name'] . "\t" . $data[$i][0]['sum'] . "\t" . $data[$i]['user']['address'] . "\t" . $data[$i]['user']['phone_number'] . "\t" . '54' . $data[$i]['user']['bank_account_code'] . "\n";
            fwrite($file,$line);
        }
        fwrite($file,'END＿＿＿END＿＿＿END' . "\t" . date('Y') . "\t" . date('n'));
        fclose($file);
        $this->response->file('webroot\ELS-UBT-'.$date.'.tsv',array(
            'download'=>true,
            'name'=>'ELS-UBT-'.$date.'.tsv'
            ));
        return $this->reponse;            
    }

//Huong Viet`    
function managerDocument($document_id) {
        $this->set('title_for_layout', 'アップロードファイルを管理する');
        $documentId=$document_id;
        $document=$this->Document->find('first',array(
            'conditions' => array('Document.id' => $documentId),
            ));
        $this->set(compact('document'));

        if(isset($this->request->data['delete_file'])){
                //debug($this->request->data['hide']);
            $count = $this->request->data['delete_file'];
            $this->Document->id = $count;
            $this->Document->delete();
            $this->redirect(array('controller' => 'admins', 'action' => 'getDocument'));
        }
        if(isset($this->request->data['block_file'])){
                //debug($this->request->data);die();
            $count = $this->request->data['block_file'];
            $this->Document->id = $count;
        //debug($this->Document->id);die();
            if($this->Document->lock_flag == 0){
            $this->Document->set(array(
                'lock_flag' => 1,
                ));
            $this->Document->save();
            }
            
            $this->Session->setFlash('このアップロードファイルをブロックした。');
            $this->redirect(array('controller' => 'admins', 'action' => 'getDocument'));
            
        }


    }
     public function getDocument() {


        if (isset($this->request->data['delete_file'])) {
            //debug($data['delete_file']);
            //die();
        }
        if (!empty($this->data) && $this->data['Document']['file_name'] != null) {
//neu co thi truy van du lieu dua vao bien $users
            $count = $this->Document->find('count', array('conditions' => array('file_name LIKE ' => '%' . $this->data['Document']['file_name'] . '%')));
//goi du lieu tu controller len view
            if ($count != 0) {

                $this->paginate = array(
                    'limit' => 10,
                    'conditions' => array('file_name LIKE ' => '%' . $this->data['Document']['file_name'] . '%'
                        ));
                $data = $this->paginate('Document');
                $this->set('data', $data);
            } else
            $this->set('message', '結果がない');
        }

        else {
            $this->paginate = array(
                'limit' => 10,
                );
            $data = $this->paginate('Document');
//debug($data); die();
            $this->set('data', $data);
        }
    }
    
    
    
    
    
    
    public function getAccount() {

    if(!empty($this->data))
		{
			if($this->data['User']['user_name']!=null){
        //neu co thi truy van du lieu dua vao bien $users
        	//debug($user_name); 
        	//debug($this->data['User']['user_name']);die();
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
                $this->set('message', 'çµ�æžœã�Œã�ªã�„');   
             
            
        	}
        	if($this->data['User']['level']!=null){
        		$this->paginate = array(
                'limit' => 10,
                'conditions' => array(
                    'User.approve_flag'=> 1,'User.level'=>$this->data['User']['level']
                    ),
            );
            $data = $this->paginate('User');

            $this->set('data', $data);
        	}

        	

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

    

    public function getConfirmAccount() {
    if(!empty($this->data))
		{
			if($this->data['User']['user_name']!=null){
        //neu co thi truy van du lieu dua vao bien $users
        	//debug($user_name); 
        	//debug($this->data['User']['user_name']);die();
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
        	}
        	if($this->data['User']['level']!=null){
        		$this->paginate = array(
                'limit' => 10,
                'conditions' => array(
                    'User.approve_flag'=> 0,'User.level'=>$this->data['User']['level']
                    ),
            );
            $data = $this->paginate('User');
            $this->set('data', $data);
        	}
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
            $this->set('data', $data);
            }

        
       
    }

    public function getLesson() {

        if (!empty($this->data) && $this->data['Lesson']['lesson_name'] != null) {
//neu co thi truy van du lieu dua vao bien $users
            $count = $this->Lesson->find('count', array('conditions' => array('lesson_name LIKE ' => '%' . $this->data['Lesson']['lesson_name'] . '%')));
//goi du lieu tu controller len view
            if ($count != 0) {
//$this->set('users',$users);


                $this->paginate = array(
                    'limit' => 10,
                    'conditions' => array('lesson_name LIKE ' => '%' . $this->data['Lesson']['lesson_name'] . '%'
                        ));
                $data = $this->paginate('Lesson');
                $this->set('data', $data);
            } else
            $this->set('message', '結果がない');
        }

        else {
            $this->paginate = array(
                'limit' => 10,
                );
            $data = $this->paginate('Lesson');
//debug($data); die();
            $this->set('data', $data);
        }
    }

    public function delete_document() {
        if (isset($this->request->data['delete_file'])) {
//debug($this->request->data['hide']);
            $count = $this->request->data['hide'];
            $this->Document->id = $count;
            $this->Document->delete();
            $this->redirect(array('controller' => 'admins', 'action' => 'getDocument'));
        }
        if (isset($this->request->data['block_file'])) {
// debug($this->request->data['hide']);die();
            $count = $this->request->data['hide'];
            $this->Document->id = $count;
            if ($this->Document->lock_flag == 0) {
                $this->Document->set(array(
                    'lock_flag' => 1,
                    ));
            }

            if ($this->Document->lock_flag == 1) {
                $this->Document->set(array(
                    'lock_flag' => 0,
                    ));
            }

            $this->Document->save();
            $this->redirect(array('controller' => 'admins', 'action' => 'getDocument'));
        }
    }

    public function getReceipts() {
//        //授業のデータを取る
//        $this->paginate = array(
//            'limit' => 10
//        );
//        $data = $this->paginate('Lesson');
//        $this->set('data', $data);
//        
//        //可変値を取る
//        $rate = $this->ChangeableValue->find('first', array('conditions' => array('id' => 3)));
//        $this->set('rate', $rate['ChangeableValue']['current_value']);


        $temp = $this->ChangeableValue->find('first', array('conditions' => array('id' => 3)));
        $rate = $temp['ChangeableValue']['current_value'];
        //$time = date('Y-m');
        if ($this->request->is('post')) {
            $year = $this->data['YearMonth']['year']['year'];
            $month = $this->data['YearMonth']['month']['month'];
            if ($year != "" && $month != "") {
                $time = $year . '-' . $month;
            } else {
                $time = date('Y-m');
            }

            $this->Session->write('time', $time);
        }
        $time = $this->Session->read('time');
        //debug($time);
        if (empty($time)) {
            $time = date('Y-m');
            $this->Session->write('time', $time);
        }

//        debug($time);
//        debug(date('Y', strtotime($time)));
//        debug(date('M', strtotime($time)));
        //$this->set('time', $time);
        $temp2 = $this->Bill->find('all', array(
            'conditions' => array(
                'Bill.learn_date LIKE ' => $time . '%'
                ),
            'fields' => array(
                'count(Bill.lesson_id) AS COUNT',
                'sum(Bill.lesson_cost *' . $rate . '/100) AS SUM',
                'Lesson.lesson_name',
                'Bill.learn_date',
                'Bill.lesson_cost'
                ),
            'group' => 'Bill.lesson_id'
            ));
        $sum = 0;
        foreach ($temp2 as $item) {
            $sum += $item[0]['SUM'];
        }
        $this->set('sum', $sum);
        //debug($temp2);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => array(
                'Bill.learn_date LIKE ' => $time . '%'
                ),
            'fields' => array('count(Bill.lesson_id) AS COUNT', 'sum(Bill.lesson_cost *' . $rate . '/100) AS SUM', 'Lesson.lesson_name', 'Bill.learn_date', 'Bill.lesson_cost'),
            'group' => 'Bill.lesson_id'
            );
        $data = $this->paginate('Bill');
        //$this->set('data', $data);
        $this->Session->write('data', $data);
        $sum = 0;
    }

    public function changeValues() {
        //可変値を取る
        $data = $this->ChangeableValue->find('all');
        $this->set('data', $data);
        //debug($data);
        if ($this->request->is('post')) {
            //フォルムからデータを取る
            $sesson = $this->data['ChangeableValue']['sesson'];
            $rate = $this->data['ChangeableValue']['rate'];
            $maxPasswordRetry = $this->data['ChangeableValue']['maxPasswordRetry'];
            $lockTime = $this->data['ChangeableValue']['lockTime'];
            $lessonCost = $this->data['ChangeableValue']['lessonCost'];
            $learningTime = $this->data['ChangeableValue']['learningTime'];
            $autoBackupTime = $this->data['ChangeableValue']['autoBackupTime'];
            //データベースに格納する
            $this->ChangeableValue->id = 1;
            $this->ChangeableValue->saveField('current_value', $sesson);

            $this->ChangeableValue->id = 2;
            $this->ChangeableValue->saveField('current_value', $rate);

            $this->ChangeableValue->id = 3;
            $this->ChangeableValue->saveField('current_value', 100 - $rate);

            $this->ChangeableValue->id = 4;
            $this->ChangeableValue->saveField('current_value', $maxPasswordRetry);

            $this->ChangeableValue->id = 5;
            $this->ChangeableValue->saveField('current_value', $lockTime);
            
            $this->ChangeableValue->id = 6;
            $this->ChangeableValue->saveField('current_value', $lessonCost);
            
            $this->ChangeableValue->id = 7;
            $this->ChangeableValue->saveField('current_value', $learningTime);
            
            $this->ChangeableValue->id = 8;
            $this->ChangeableValue->saveField('current_value', $autoBackupTime);
            
            $data = $this->ChangeableValue->find('all');
            $this->set('data', $data);
        }
    }
    
    function exportBill($time) {
        $temp = $this->ChangeableValue->find('first', array('conditions' => array('id' => 3)));
        $rate = $temp['ChangeableValue']['current_value'];

        $temp2 = $this->Bill->find('all', array(
            'conditions' => array(
                'Bill.learn_date LIKE ' => $time . '%'
                ),
            'fields' => array(
                'count(Bill.lesson_id) AS COUNT',
                'sum(Bill.lesson_cost *' . $rate . '/100) AS SUM',
                'Lesson.lesson_name',
                'Bill.learn_date',
                'Bill.lesson_cost'
                ),
            'group' => 'Bill.lesson_id'
            ));
        //debug($temp2);die;
        $this->set('temp2', $temp2);
        $this->layout = null;
        $this->autoLayout = false;
    }

    public function changePass(){
    	$this->set('title_for_layout', 'パスワードを変更。');
    	if ($this->request->is ( 'post' )) {
    		$data = $this->request->data;
    		//debug($this->Auth->user('password'));
    		if (sha1 ( $this->Auth->user ( 'user_name' ) . $data ['User'] ['pass1'] . 'sha1' ) == $this->User->field( 'password',array('id'=>$this->Auth->user('id')))) {
    			$this->User->id = $this->Auth->user ( 'id' );
    			$this->User->set ( 'password', sha1 ( $this->Auth->user ( 'user_name' ) . $data ['User'] ['pass2'] . 'sha1' ) );
    			$this->User->save();
    			$this->Session->setFlash('パスワード変更が成功した');
    		} else
           $this->Session->setFlash ( '現在パスワードが間違う' );
       }
   }
	public function manager_home() {
		$this->layout = 'manager';
		$this->set ( 'title_for_layout', 'システムの管理ツール' );
	}
	public function get_user_request($user_id = null) {
		//$this->showLayout ();
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
		if ($user ['level'] == 2)
			$this->set ( 'title_for_layout', '先生アカウント' );
		else
			$this->set ( 'title_for_layout', '学生アカウント' );
	}
	public function accept_user($id = null) {
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
			$this->Session->setFlash('アカウントを確認することが成功です。');
			$this->redirect ( array (
				'controller' => 'Admins',
				'action' => 'getConfirmAccount' 
			) );
		}
	}
	public function remove_user($id = null) {
		//$this->showLayout ();
		$success = false;
		
		$count = $this->User->find ( 'count', array (
				'conditions' => array (
						'User.id' => $id 
				) 
		) );
		if ($count != 0) {
			$this->User->delete ( $id );
			$this->Session->setFlash('アカウントを拒否することが成功です。');
			$this->redirect ( array (
				'controller' => 'Admins',
				'action' => 'getConfirmAccount' 
			) );
		}
	}
	
public function database_manager() {
		$this->set ( 'title_for_layout', 'バックアップとリストアデータベース' );
		$dir = new Folder ( WWW_ROOT . 'files/db' );
		$files = $dir->find ( '.*\.sql' );
		$files_info = array ();
		foreach ( $files as $file_name ) {
			$file = new File ( $dir->pwd () . DS . $file_name );
			$info = $file->info ();
			$info ['created_date'] = date ( 'H:i:s - d/m/Y ', $file->lastChange () );
			$info ['created_time'] = $file->lastChange ();
			array_push ( $files_info, $info );
		}
		$price = array ();
		foreach ( $files_info as $key => $row ) {
			$price [$key] = $row ['created_time'];
		}
		array_multisort ( $price, SORT_DESC, $files_info );
		$this->set ( compact ( 'files_info' ) );
	}
	
	public function delete_file(){
		$this->autoRender = false;
		if(isset($this->params['named']['file'])){
			$source = WWW_ROOT.'files/db/'.$this->params['named']['file'];
			var_dump($source);
			unlink($source);
		}
		$this->Session->setFlash(__('The backup have been deleted'));
		$this->redirect(array('controller' => 'admins', 'action' => 'database_manager'));
	}
	
	public function delete_all(){
	
		$this->autoRender = false;
		$dir = new Folder(WWW_ROOT.'files/db');
		$dir->chmod(WWW_ROOT.'files/db',0777, true, array());
		$files = $dir->find('.*\.sql');
		foreach ($files as $file) {
			unlink($dir->pwd().DS.$file);
		}
		$this->Session->setFlash(__('All The backup have been deleted'));
		$this->redirect(array('controller' => 'admins', 'action' => 'database_manager'));
	}
	public function backup_database() {
		$this->autoRender = false;
		$databaseName = 'elearning';
		$fileName = WWW_ROOT . 'files/db/' . $databaseName . '-backup-' . date ( 'Y-m-d_H-i-s' ) . '.sql';
		
		$cmd = 'cd "C:/xampp/mysql/bin" & mysqldump.exe --user=root --host=localhost elearning > ' . $fileName;
		
		exec ( $cmd );
		$this->Session->setFlash ( __ ( 'Database has been backuped' ) );
		$this->redirect(array('controller' => 'admins', 'action' => 'database_manager'));
	}
	public function restore_database() {
		$this->autoRender = false;
		if (isset ( $this->params ['named'] ['file'] )) {
			$mysql_host = 'localhost';
			$mysql_username = 'root';
			$mysql_password = '';
			$db_name = 'elearning';
			$source = WWW_ROOT . 'files/db/' . $this->params ['named'] ['file'];
			$command = 'cd "C:/xampp/mysql/bin" & mysql.exe --user=root --host=localhost elearning < ' . $source;
// 			var_dump ( $command );
			exec ( $command );
		}
		$this->Session->setFlash ( __ ( 'Database has been restored' ) );
		$this->redirect ( array (
				'controller' => 'admins',
				'action' => 'database_manager' 
		) );
	}

}
