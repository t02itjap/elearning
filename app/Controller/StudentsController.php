<?php

App::uses('DboSource', 'Model/Datasource');

/**
 * User controller for login,logout,...
 * 
 */
class StudentsController extends AppController {

    public $name = "Students";
    var $uses = array('User', 'LearnHistory', 'Bill', 'Lesson', 'Test', 'TestHistory');
    var $helpers = array('Html', 'Form', 'Editor', 'Csv');
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'student';
    }

    public function change_info() {
        $this->set('title_for_layout', '個人情報を変更する');
        $student = $this->User->find('first', array(
            'conditions' => array('User.id' => $this->Auth->user('id')),
        ));
        $this->set(compact('student'));
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