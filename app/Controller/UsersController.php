<?php
App::uses ( 'DboSource', 'Model/Datasource' );
/**
 * User controller for login,logout,...
 * 
 */

class UsersController extends AppController {
	public $name = "Users";
	var $uses = array ('User', 'TestHistory', 'Test', 'Lesson' );
	var $helpers = array('Html', 'Form', 'Editor');
	public $components = array ("RequestHandler" );
	
	public function beforeFilter() {
		parent::beforeFilter ();
		$this->layout = 'before_login';
		$this->Auth->authenticate = array ('Form' => array ('userModel' => 'User', 'fields' => array ('username' => 'user_name', 'password' => 'password' ) )//'scope' => array('User.')
		 );
		$this->Auth->allow ( array ('home', 'login', 'register' ) );
		$this->set ( "title_for_layout", "Elearing" );
	}
	
	public function login() {
		//logged in user
		if ($this->Auth->user ())
			$this->redirect ( $this->Auth->redirect () );
		
		//
		if (empty ( $this->data )) {
			$cookie = $this->Cookie->read ( 'Auth.User' );
			if (! is_null ( $cookie )) {
				if ($this->Auth->login ( $cookie )) {
					$this->redirect ( $this->Auth->redirect () );
				}
			}
		}
		if ($this->request->is ( 'post' )) {
			$this->loadModel ( "User" );
			if ($this->Auth->login ()) {
				if ($this->Auth->user ( "level" ) === 1) {
					echo "admin";
				} else
					echo "user";
				$this->Cookie->write ( 'Auth.User', $this->Auth->user (), true, '1209600' );
				$this->Session->setFlash ( "Hello" . $this->Auth->user ( 'user_name' ) );
				$this->redirect ( $this->Auth->redirect () );
			} else {
				$this->Session->setFlash ( 'ãƒ¡ãƒ¼ãƒ«ã�¨ã�‹ãƒ‘ãƒ¼ã‚¹ãƒ¯ãƒ¼ãƒ‰ã�¨ã�‹é–“é�•ã�„ã�§ã�™' );
			}
		}
	}
	
	function register() {
		$this->set ( 'title_for_layout', '登録' );
		$this->set ( compact ( 'userType', 'questionList' ) );
		if (isset ( $this->request->data ['submit_data'] )) {
			$data = $this->request->data;
			debug ( $data );
			$this->User->set ( $data ['User'] );
			if ($this->User->validates ()) {
				$this->User->create ();
				if ($this->User->save ( $data ['User'], false )) {
					$this->redirect ( array ('action' => 'login' ) );
				}
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