<?php
App::uses ( 'DboSource', 'Model/Datasource' );
/**
 * Common controller for login,logout,...
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
		//$this->Auth->authenticate = array ('Form' => array ('userModel' => 'User', 'fields' => array ('username' => 'user_name', 'password' => 'password','role' => 'level') )//'scope' => array('User.')
//		 );
		$this->Auth->allow ( array ('home', 'login', 'register' ) );
	}
	
	public function login() {
	   //debug($this->Auth->user());die();
		//logged in user
		if ($this->Auth->user ())
			$this->loginRedirect($this->Auth->user("level"));
		//
        $missPass = "";
        $this->set(compact('missPass'));
        //xu ly khi nguoi dung an login
		if ($this->request->is ( 'post' )) {
			$this->loadModel ( "User" );
           //debug($this->request->data);
            //tao chuoi password de so sanh
			$this->request->data['User']['password'] = $this->request->data['User']['user_name'].$this->request->data['User']['password'].'sha1';
			//dung username va password
            if ($this->Auth->login ()) {
                //debug($this->Auth->user());die();
			     //check active user
			     if($this->Auth->user("approve_flag") === 0){
			         $this->Session->setFlash ( "Tai khoan " . $this->Auth->user ('user_name')." chua active.Hay lien he voi quan ly." );
			         $this->redirect($this->Auth->logout());
                 }
                 $this->loginRedirect($this->Auth->user('level'));
			     $this->Session->setFlash ( "Hello" . $this->Auth->user ( 'user_name' ) );
				
			} 
            //sai username hoac password
            else {
				$this->Session->setFlash ( 'ユーザネームとかパースワードとか間違いです' );
                //luu so lan nhap sai vao session
                if($this->Session->read('login_fail'))
                {
                    $login_fail = $this->Session->read('login_fail') + 1;
                }else{
                    $login_fail = 1;
                }
                $this->Session->write("login_fail",$login_fail,5);
                if($this->Session->read('login_fail')<4){
                $missPass = "Da nhap sai ".$this->Session->read('login_fail')." lan";
                }else 
                    if($this->Session->read('login_fail')==4 ){
                    if($this->request->data['User']['level']==3){
                        $missPass = "IP bi block trong 30 phut";
                    }
                    if($this->request->data['User']['level']==2) {
                        
                    }
                    $missPass = "IP dang bi block";
                }else{
                    if($this->Session->read('login_fail')==4 ){
                    if($this->request->data['User']['level']==3){
                        $missPass = "IP da bi block";
                    }
                    if($this->request->data['User']['level']==2) {
                        
                    }
                }
                }
                $this->set(compact('missPass'));
                //}
			}
		}
	}
    
    protected function loginRedirect($level){
        //$level != null
        if ($level == 1) {
					   $this->redirect(array("controller" => "admins","action" => "home"));
				} if($level== 2){
					   $this->redirect(array("controller" => "teachers","action" => "home"));
                       }else {
                        $this->redirect(array("controller" => "students","action" => "home"));
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
         if ($this->Auth->user ())
			$this->loginRedirect($this->Auth->user("level"));       
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
<<<<<<< HEAD
        if ($this->request->is('post')) {
            $this->loadModel("User");
            if ($this->Auth->login()) {
                if(!$this->Auth->user("approve_flag")=== 1){
                    
                }else{
                    pr($this->Auth->user());die();
                    if($this->Auth->user("level") === 1 ){
                         $level = "admin";
                    }if($this->Auth->user("level") === 2 ){
                        $level = "teacher";
                    }    
                    else $level = "user";
                    $this->Cookie->write('Auth.User', $this->Auth->user(), true, '1209600');
                    $this->Session->setFlash("Hello"." ".$level." ".$this->Auth->user('user_name'));
                    $this->redirect($this->Auth->redirect());
                    }
                } else {
                    $this->Session->setFlash('ユーザネームとかパースワードとか間違いです');
                }
        }
    }
    
    function register(){
                $this->loadModel("User");
                if($this->request->isPost()){
                        $data = $this->request->data;
                        if($this->User->checkUserExist($data["User"]["user_name"]) ==0){
                                $data["User"]["password"] = Security::hash($data["User"]["password"], 'md5', false);
                                $this->User->save($data);
                                $this->Session->setFlash("登録は成功でおめでとうございます。");
                                $this->redirect(array("action" => "login"));
                        }else
                              $this->Session->setFlash("ゆーざネームが利用された。");
=======
                $lesson_name = Array();
                foreach($lesson_id as $id){
                    $lesson_name[] = $this->Lesson->findById($id);
                }
                for($i=0;$i<count($lesson_name);$i++){
                    $data[$i]['Lesson'] =$lesson_name[$i]['Lesson'];
>>>>>>> master
                }
                $this->set('data',$data);
                 
	}

        
}
