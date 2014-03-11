<?php

App::uses('DboSource', 'Model/Datasource');

/**
 * User controller for login,logout,...
 */
class StudentsController extends AppController {
	public $name = "Students";
// <<<<<<< HEAD
	var $uses = array ('User', 'LearnHistory', 'Bill', 'Lesson', 'Test', 'TestHistory');
	var $helpers = array('Html', 'Form', 'Editor','Csv');
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
    
    function changePass() {
    	if ($this->request->is ( 'post' )) {
    		$data = $this->request->data;
    		if (sha1 ( $this->Auth->user ( 'user_name' ) . $data ['User'] ['pass1'] . 'sha1' ) == $this->Auth->user ( 'password' )) {
    			if ($data ['User'] ['pass2'] == $data ['User'] ['pass3']) {
    				$this->User->id = $this->Auth->user ( 'id' );
    				$this->User->set ( 'password', $data ['User'] ['pass2'] );
    				$this->User->save();
    				$this->Session->setFlash('thanh cong');
    			} else
    				$this->Session->setFlash ( 'pass xac nhan sai' );
    		} else
    			$this->Session->setFlash ( 'pass hien tai sai' );
    	}
    }
    
    public function change_info(){
        $forPass = 'sha1';
        $this->set('title_for_layout', '個人情報を変更する');
        $forPass = 'sha1';
        $student = $this->User->find('first', array(
            'conditions' => array('User.id' => $this->Auth->user('id')),
        ));
        $this->set(compact('student'));
        if(isset($this->request->data['submit_data'])){
            $data = $this->request->data;
            $checkPassword = sha1($student['User']['user_name'].$data['User']['password'].$forPass);
            if($checkPassword == $student['User']['password']){ 
                if($student['User']['email'] == $data['User']['email'] && $student['User']['phone_number'] == $data['User']['phone_number'] && $student['User']['address'] == $data['User']['address'] && $student['User']['bank_account_code'] == $data['User']['bank_account_code']){
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
                            $this->Session->setFlash('情報を変更することが成功です。');
                            $this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
                        }
                    }
                }   
            }
            else{
                $this->Session->setFlash('インプットパスワードが間違い');
                $this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
            }
        }
        if(isset($this->request->data['delete_student'])){
            $this->User->set(array(
                'status_flag' => 0,
            ));
            $this->User->id = $student['User']['id'];
            if($this->User->save()){
                $this->Session->destroy();
                $this->Session->setFlash('あなたのアカウントが今ロックです、再開けるために、管理者に連絡してください。');
                $this->redirect(array('controller' => 'Users', 'action' => 'login'));
            }
        }
    }
    
    public function home(){
        debug($this->Auth->user());
    }

    //Thang viet
    public function getHistories() {
        $this->set('title_for_layout', 'Lich su hoc tap');
        $this->paginate = array(
            'limit' => 10,
            'conditions' => array('Bill.user_id' => $this->Auth->user('id')),
            'field' => array('Lesson.lesson_name', 'LearnHistory.learn_date')
                //'order' => 'LearnHistory.learn_date'
            );
        $data = $this->paginate('Bill');
        $this->set(compact('data'));
    }

    public function getFees() {
        $time = date('Y-m');
        if ($this->request->is('post')) {
            $year = $this->data['YearMonth']['year']['year'];
            $month = $this->data['YearMonth']['month']['month'];
            $time = $year . '-' . $month;
        }
        //debug($time);
        $temp2 = $this->Bill->find('all', array(
            'conditions' => array(
                'Bill.user_id' => $this->Auth->user('id'),
                'Bill.learn_date LIKE ' => $time . '%',
                )
            ));
        $this->set('temp2', $temp2);
        $sum = 0;
        foreach ($temp2 as $item) {
            $sum += $item['Bill']['lesson_cost'];
        }
        $this->set('sum', $sum);
        //debug($temp2);
        //debug($sum);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => array(
                'Bill.user_id' => $this->Auth->user('id'),
                'Bill.learn_date LIKE ' => $time . '%'
                )
            );
        $data = $this->paginate('Bill');
        $this->set('data', $data);
        //debug($data);
        $this->set('time', $time);
    }

    public function getTestHistories() {
//            $this->TestHistory->recursive = 2;
//            $data = $this->TestHistory->find('all', array(
//                'conditions' => array('TestHistory.user_id' => $this->Auth->user('id'))
//            ));
//            $this->set('data', $data);
//            //debug($data);
        $this->TestHistory->recursive = 2;
        $this->paginate = array(
            'limit' => 10,
            'conditions' => array('TestHistory.user_id' => $this->Auth->user('id'))
            );
        $data = $this->paginate('TestHistory');
        $this->set('data', $data);
    }

    function exportBill($time) {

        $temp2 = $this->Bill->find('all', array(
            'conditions' => array(
                'Bill.user_id' => $this->Auth->user('id'),
                'Bill.learn_date LIKE ' => $time . '%',
                )
            ));
        $this->set('temp2', $temp2);
        $this->layout = null;
        $this->autoLayout = false;
    }
}
?>