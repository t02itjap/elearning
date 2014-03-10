<?php

App::uses('DboSource', 'Model/Datasource');
/**
 * Teacher Controller
 * 
 */

class TeachersController extends AppController
{

    public $name = 'Teachers';
    public $uses = array(
        "User",
        "Test",
        "Lesson",
        "Bill");
    public $components = array("RequestHandler");

    public function beforeFilter()
    {
        parent::beforeFilter();
        //$this->loadModel("User");
        $this->layout = 'teacher';
        $this->Auth->authorize = "controller";

    }

    function isAuthorized()
    {
        if ($this->Auth->user('level') == 2)
            return true;
        else {
            $this->Session->setFlash("Access deny");
            $this->redirect($this->redirect(array("controller" => "users", "action" =>
                    "logout")));
            return false;
        }
    }

    function summary($id = null)
    {
        $lesson = $this->Lesson->find('first', array('conditions' => array('id' => $id),
                'fields' => array('viewers','voters')));
        $snum = $this->Bill->find("count",array(
                                            'conditions'=>array(
                                                    'lesson_id'=> $id),
                                           // 'fields'=> array(
//                                                    'DISTINCT user_id'),
                                            'group' => array(
                                                    'user_id')));
        $students = $this->Bill->find("all",array(
                                            'conditions'=>array(
                                                    'lesson_id'=> $id),
                                            'fields'=> array(
                                                    'user_id','learn_date')));
        $this->set('lesson',$lesson);
        $this->set('snum',$snum);
        $i=-1;
        foreach($students as $s)
            {
                $i++;
                $info = $this->User->field('user_name',array('id'=>$s['Bill']['user_id']));
                $students[$i]['Bill']['user_name']=$info;
            }
        
        $this->set(compact('students'));
        //debug($students);
    }
    
    function changeVerify() {
    	
    }

    function home()
    {
        //debug($this->Auth->user());
    }
}
