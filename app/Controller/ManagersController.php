<?php

class ManagersController extends AppController {

    var $uses = array('ChangeableValue', 'Bill', 'Lesson');

    function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        
    }

    public function getReceipts() {
        $this->paginate = array(
            'limit' => 10
        );
        $data = $this->paginate('Lesson');
        $this->set('data', $data);
        $rate = $this->ChangeableValue->find('first', array('conditions' => array('id' => 3)));
        $this->set('rate', $rate['ChangeableValue']['current_value']);
    }

    public function changeValues() {
        $data = $this->ChangeableValue->find('all');
        $this->set('data', $data);
        //debug($data);
        if ($this->request->is('post')) {
            $sesson = $this->data['ChangeableValue']['sesson'];
            $rate = $this->data['ChangeableValue']['rate'];
            $maxPasswordRetry = $this->data['ChangeableValue']['maxPasswordRetry'];            
            $this->ChangeableValue->id = 1;
            $this->ChangeableValue->saveField('current_value', $sesson);
            
            $this->ChangeableValue->id = 2;
            $this->ChangeableValue->saveField('current_value', $rate);
            
            $this->ChangeableValue->id = 3;
            $this->ChangeableValue->saveField('current_value', 100 - $rate);
            
            $this->ChangeableValue->id = 4;
            $this->ChangeableValue->saveField('current_value', $maxPasswordRetry);
            $data = $this->ChangeableValue->find('all');
            $this->set('data', $data);
        }
    }

}
