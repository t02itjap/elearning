<?php

App::uses('DboSource', 'Model/Datasource');

/**
 * User controller for login,logout,...
 * 
 */
class TeachersController extends AppController {

    public $name = "Teachers";
    var $uses = array('Lesson', 'Test', 'TestHistory', 'ChangeableValue', 'Bill');
    var $helpers = array('Html', 'Form', 'Editor');
    public $components = array('Paginator', 'RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        //$this->layout = 'before_login';
        $this->Auth->authenticate = array('Form' => array('userModel' => 'User', 'fields' => array('username' => 'user_name', 'password' => 'password'))//'scope' => array('User.')
        );
        $this->Auth->allow(array('home', 'login', 'register'));
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
        $time = date('Y-m');
        if ($this->request->is('post')) {
            $year = $this->data['YearMonth']['year']['year'];
            $month = $this->data['YearMonth']['month']['month'];
            $time = $year . '-' . $month;
        }
        $temp2 = $this->Bill->find('all', array(
            'conditions' => array(
                'Lesson.create_user_id' => $this->Auth->user('id'),
                'Bill.learn_date LIKE ' => $time.'%'
            ),
            'fields' => array(
                'count(Bill.lesson_id) AS COUNT',
                'sum(Bill.lesson_cost *'.$rate.'/100) AS SUM',
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
        debug($temp2);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => array(
                'Lesson.create_user_id' => $this->Auth->user('id'),
                'Bill.learn_date LIKE ' => $time.'%'
            ),
            'fields' => array('count(Bill.lesson_id) AS COUNT','sum(Bill.lesson_cost *'.$rate.'/100) AS SUM', 'Lesson.lesson_name', 'Bill.learn_date', 'Bill.lesson_cost'),
            'group' => 'Bill.lesson_id'
        );
        $data = $this->paginate('Bill');
        $this->set('data', $data);
        $sum = 0;
                
    }

}
