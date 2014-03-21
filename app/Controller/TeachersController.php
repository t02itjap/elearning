<?php

class TeachersController extends AppController {

    public $name = "Teachers";
    var $uses = array('User', 'Test', 'Lesson', 'Bill', 'Category', 'Document', 'TestHistory', 'ChangeableValue', 'Bill');
    var $helpers = array('Html', 'Form', 'Editor');
    public $components = array('Paginator', 'RequestHandler');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'teacher';
        $this->Auth->authorize = 'controller';
    }

    public function isAuthorized() {
        if ($this->Auth->user('level') == 2)
            return true;
        else {
            $this->Session->setFlash("Access deny");
            $this->redirect($this->redirect(array("controller" => "users", "action" => "logout")));
            return false;
        }
    }

    public function summary($id = null) {
        $lesson = $this->Lesson->find('first', array('conditions' => array('id' => $id), 'fields' => array('viewers', 'voters')));
        $snum = $this->Bill->find("count", array('conditions' => array('lesson_id' => $id), 'group' => array('user_id')));
        $students = $this->Bill->find("all", array('conditions' => array('lesson_id' => $id), 'fields' => array('user_id', 'learn_date')));
        $this->set('lesson', $lesson);
        $this->set('snum', $snum);
        $i = - 1;
        foreach ($students as $s) {
            $i ++;
            $info = $this->User->field('user_name', array('id' => $s ['Bill'] ['user_id']));
            $students [$i] ['Bill'] ['user_name'] = $info;
        }

        $this->set(compact('students'));
    }

    public function change_info() {
        $this->set('title_for_layout', '個人情報を変更する');
        $forPass = 'sha1';
        $teacher = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id'))));
        $this->set(compact('teacher'));
        if (isset($this->request->data ['submit_data'])) {
            $data = $this->request->data;
            $checkPassword = sha1($teacher ['User'] ['user_name'] . $data ['User'] ['password'] . $forPass);
            if ($checkPassword == $teacher ['User'] ['password']) {
                if ($teacher ['User'] ['email'] == $data ['User'] ['email'] && $teacher ['User'] ['phone_number'] == $data ['User'] ['phone_number'] && $teacher ['User'] ['address'] == $data ['User'] ['address'] && $teacher ['User'] ['bank_account_code'] == $data ['User'] ['bank_account_code']) {
                    $this->Session->setFlash('情報を変更しなかった。');
                    $this->redirect(array('controller' => 'Teachers', 'action' => 'change_info'));
                } else {
                    $this->User->set(array('bank_account_code' => $data ['User'] ['bank_account_code'], 'address' => $data ['User'] ['address'], 'phone_number' => $data ['User'] ['phone_number']));
                    if ($teacher ['User'] ['email'] != $data ['User'] ['email']) {
                        $this->User->set(array('email' => $data ['User'] ['email']));
                    }
                    if ($this->User->validates()) {
                        $this->User->id = $teacher ['User'] ['id'];
                        if ($this->User->save()) {
                            $this->Session->setFlash('情報を変更することが成功です。');
                            $this->redirect(array('controller' => 'Teachers', 'action' => 'change_info'));
                        }
                    }
                }
            } else {
                $this->Session->setFlash('インプットパスワードが間違い');
                $this->redirect(array('controller' => 'Teachers', 'action' => 'change_info'));
            }
        }
        if (isset($this->request->data ['delete_teacher'])) {
            $this->User->set(array('status_flag' => 0));
            $this->User->id = $teacher ['User'] ['id'];
            if ($this->User->save()) {
                $this->Session->destroy();
                $this->Session->setFlash('あなたのアカウントが今ロックです、再開けるために、管理者に連絡してください。');
                $this->redirect(array('controller' => 'Users', 'action' => 'login'));
            }
        }
    }

    function changeVerify() {
        $id = $this->Auth->user('id');
        $teacher = $this->Verifycode->find('first', array('conditions' => array('user_id' => $id)));
        $this->set(compact('teacher'));

        if ($this->request->is('post')) {
            $data = $this->request->data;
            if (sha1($this->Auth->user('user_name') . $data['User']['verifycode1'] . 'sha1') == $teacher['Verifycode']['verifycode']) {
                if ($data['User']['verifycode2'] == $data['User']['verifycode3']) {
                    $this->Verifycode->id = $this->Auth->user('id');
                    $this->Verifycode->set('verifycode', sha1($this->Auth->user('user_name') . $data['User']['verifycode2'] . 'sha1'));
                    $this->Verifycode->save();
                    $this->Session->setFlash('change thanh cong');
                } else {
                    $this->Session->setFlash('ma xac nhan sai');
                }
            } else {
                $this->Session->setFlash('ma hien tai sai');
            }
        }
    }

    function changePass() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if (sha1($this->Auth->user('user_name') . $data ['User'] ['pass1'] . 'sha1') == $this->Auth->user('password')) {
                if ($data ['User'] ['pass2'] == $data ['User'] ['pass3']) {
                    $this->User->id = $this->Auth->user('id');
                    $this->User->set('password', $data ['User'] ['pass2']);
                    $this->User->save();
                    $this->Session->setFlash('thanh cong');
                } else
                    $this->Session->setFlash('pass xac nhan sai');
            } else
                $this->Session->setFlash('pass hien tai sai');
        }
    }

    function home() {
        //debug($this->Auth->user());
    }

    public function createNewCategory() {
        echo 'abccccc';
        if (isset($_POST['name'])) {
            var_dump($_POST['name']);
            $data = array('category_name' => $_POST['name']);
            $this->Category->create();
            $this->Category->save($data);
            //$this->set('id', $this->Category->id);
            $category = $this->Category->find('first', array('conditions' => array('category_name' => $_POST['name'])));
            $data['id'] = $category['Category']['id'];
            //$this->Category->id;
            $data['name'] = $_POST['name'];
        }

        die;
    }

    public function create_course() {
        $categories = $this->Category->find('all');
        $this->set('categories', $categories);
        if (isset($this->request->data['ok'])) {

            debug($this->request->data);
            $data = $this->request->data;
            $this->Lesson->set(array(
                'lesson_name' => $data['Lesson']['Name'],
                'description' => $data['Lesson']['Description'],
                'create_user_id' => $this->Auth->user('id'),
                'create_date' => date('Y/m/d H:i:s'),
            ));
            $this->Lesson->save();

            $uploadData = $data['Lesson']['file_link_document'];
            $this->Document->set(array(
                'file_link' => $uploadData['name'],
            ));
            if ($this->Document->validates()) {
                $this->Document->save();
                move_uploaded_file($uploadData['tmp_name'], WWW_ROOT . 'files/data' . DS . $uploadData['name']);
            } else {
                $err = $this->Document->validationErrors['file_link']['0'];
                $this->set(compact('err'));
            }

            $uploadData1 = $data['Lesson']['file_link_test'];
            $this->Test->set(array(
                'file_link' => $uploadData1['name'],
            ));
            if ($this->Test->validates()) {
                $this->Test->save();
                move_uploaded_file($uploadData1['tmp_name'], WWW_ROOT . 'files/data' . DS . $uploadData1['name']);
            } else {
                $err1 = $this->Test->validationErrors['file_link']['0'];
                $this->set(compact('err1'));
            }
        }
    }

    public function getStudentTestHistoriesList() {
        $this->paginate = array(
            'limit' => 10,
            'conditions' => array(
                'Test.create_user_id' => $this->Auth->user('id')
            ),
            'field' => array('Test.file_name', 'Lesson.lesson_name', 'TestHistory.score')
        );
        $data = $this->paginate('Test');
        $this->set('data', $data);
    }

    public function getStudentTestHistories($testID) {
        $this->paginate = array(
            'limit' => 10,
            'conditions' => array(
                'Test.id' => $testID
            )
        );
        $data = $this->paginate('TestHistory');
        $this->set('data', $data);
    }

    public function getSalary() {
        $temp = $this->ChangeableValue->find('first', array('conditions' => array('id' => 2)));
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
                'Lesson.create_user_id' => $this->Auth->user('id'),
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
                'Lesson.create_user_id' => $this->Auth->user('id'),
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

    function exportBill($time) {
        $temp = $this->ChangeableValue->find('first', array('conditions' => array('id' => 2)));
        $rate = $temp['ChangeableValue']['current_value'];

        $temp2 = $this->Bill->find('all', array(
            'conditions' => array(
                'Lesson.create_user_id' => $this->Auth->user('id'),
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

}

?>
