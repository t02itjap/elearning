<?php

App::uses('DboSource', 'Model/Datasource');

/**
 * User controller for login,logout,...
 */
class StudentsController extends AppController {

    public $name = "Students";
// <<<<<<< HEAD
    var $uses = array('User', 'LearnHistory', 'Bill', 'Lesson', 'Test', 'TestHistory', 'LessonOfCategory');
    var $helpers = array('Html', 'Form', 'Editor', 'Csv');
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'student';
        $this->Auth->authorize = 'controller';
    }

    function isAuthorized() {
        if ($this->Auth->user('level') == 3)
            return true;
        else {
            $this->Session->setFlash("Access deny");
            $this->redirect($this->redirect(array("controller" => "users", "action" => "logout")));
            return false;
        }
    }

    function changePass() {
    	$this->set('title_for_layout', 'パスワードを変更する。');
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if (sha1($this->Auth->user('user_name') . $data ['User'] ['pass1'] . 'sha1') == $this->User->field("password", array("id" => $this->Auth->user("id")))) {
                $this->User->id = $this->Auth->user('id');
                $this->User->set('password', $data ['User'] ['pass2']);
                $this->User->save();
                $this->Session->setFlash('パスワード変更が成功した');
            } else
                $this->Session->setFlash('現在パスワードが間違う');
        }
    }

    public function change_info() {
        $forPass = 'sha1';
        $this->set('title_for_layout', '個人情報を変更する');
        $forPass = 'sha1';
        $student = $this->User->find('first', array(
            'conditions' => array('User.id' => $this->Auth->user('id')),
                ));
        $this->set(compact('student'));
        if (isset($this->request->data['submit_data'])) {
            $data = $this->request->data;
            $checkPassword = sha1($student['User']['user_name'] . $data['User']['password'] . $forPass);
            if ($checkPassword == $student['User']['password']) {
                if ($student['User']['email'] == $data['User']['email'] && $student['User']['phone_number'] == $data['User']['phone_number'] && $student['User']['address'] == $data['User']['address'] && $student['User']['bank_account_code'] == $data['User']['bank_account_code']) {
                    $this->Session->setFlash('情報を変更しなかった。');
                    $this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
                } else {
                    $this->User->set(array(
                        'bank_account_code' => $data['User']['bank_account_code'],
                        'address' => $data['User']['address'],
                        'phone_number' => $data['User']['phone_number'],
                    ));
                    if ($student['User']['email'] != $data['User']['email']) {
                        $this->User->set(array(
                            'email' => $data['User']['email'],
                        ));
                    }
                    if ($this->User->validates()) {
                        $this->User->id = $student['User']['id'];
                        if ($this->User->save()) {
                            $this->Session->setFlash('情報を変更することが成功です。');
                            $this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
                        }
                    }
                }
            } else {
                $this->Session->setFlash('インプットパスワードが間違い');
                $this->redirect(array('controller' => 'Students', 'action' => 'change_info'));
            }
        }
        if (isset($this->request->data['delete_student'])) {
            $this->User->set(array(
                'status_flag' => 0,
            ));
            $this->User->id = $student['User']['id'];
            if ($this->User->save()) {
                $this->Session->destroy();
                $this->Session->setFlash('あなたのアカウントが今ロックです、再開けるために、管理者に連絡してください。');
                $this->redirect(array('controller' => 'Users', 'action' => 'login'));
            }
        }
    }

    public function home() {
        debug($this->Auth->user());
    }

    public function view_lesson_to_learn($id) {
        if (!isset($id)) {
            throw new NotFoundException('404 not found');
        }
        $data = $this->Lesson->findById($id);
        $user_id = $this->Auth->user('id');
        $lesson = $this->Lesson->find('first', array('conditions' => array('Lesson.id' => $id)));
        $category = $this->LessonOfCategory->find('all', array('conditions' => array('lesson_id' => $id)));
        if (!$data) {
            throw new NotFoundException('Can`t find Lesson');
        }
        //check bill
        $flag = false;
        $tmp = $this->Bill->find('first', array('conditions' => array(
                'lesson_id' => $id,
                'user_id' => $this->Auth->user('id')
                )));
        if ($tmp) {
            $flag = true;
        }
        $this->set('id', $id);
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('flag', $flag);
        $this->set('lesson', $lesson);
        $this->set('category', $category);
        //like
        $likeString = $data['Lesson']['voters'];
        $flagLike = false;
        $countLike = 0;
        if ($likeString != '') {
            $liked_user_id_array = explode(',', $likeString);
            if (strlen($likeString) == 1) {
                $countLike = 1;
            } else {
                $countLike = count($liked_user_id_array);
            }
            if (in_array($user_id, $liked_user_id_array)) {
                $flagLike = true;
            }
        }
        $this->set('flagLike', $flagLike);
        $this->set('countLike', $countLike);
    }

    public function likeLesson() {
        if (isset($_POST)) {
            $tmpData = $this->Lesson->findById($_POST['lesson_id']);
            $votersString = $tmpData['Lesson']['voters'];
            if ($votersString != '') {
                $votersString .= ',';
            }
            $votersString .= $_POST['user_id'];
            $this->Lesson->id = $_POST['lesson_id'];
            $this->Lesson->set('voters', $votersString);
            $this->Lesson->save();
        }
        die;
    }

    public function payForLesson() {
        $this->autoRender = false;
        if (isset($_POST)) {
            $data = $_POST;
            $this->Bill->create();
            $this->Bill->set('lesson_cost', 20000);
            $this->Bill->set('learn_date', date('Y/m/d H:i'));
            if ($this->Bill->save($data)) {
                echo true;
            }else
                echo false;
        }
        die;
    }

    public function getFees() {  
    	$this->set('title_for_layout', '課金情報');      
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
        //$this->set('data', $data);
        //debug($data);
        $this->Session->write('data', $data);
    }

    public function getTestHistories() {

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