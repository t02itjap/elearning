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
        "Bill",
    	"BannedStudent"
    );
    public $components = array("RequestHandler");

    public function beforeFilter()
    {
        parent::beforeFilter();
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
        $this->paginate =array('limit'=>10,
        		'conditions'=> array(
        			'BannedStudent.teacher_id'=>$id,
        ));
        
        debug($this->paginate('BannedStudent'));
        //kiem tra xem co hoc sinh ko
        if(isset($this->request->data)){
        	if($ban= $this->User->find('first',array(
        									'conditions'=>array(
        											'user_name'=>$data['ban']))))
        	{
        		$this->BannedStudent->create();
        		$data = array('BannedStudent'=> array(
        									'teacher_id' => $this->Auth->user('user_name'),
        									'student_id' => $ban['User']['user_name']								
        		));
        		$this->BannedStudent->save($data);
        	}else {
        		$this->Session->setFlash('KO co student nao???');
        	}
        }
    }
    
    function changeVerify() {
    	
    }

    function home()
    {
        //debug($this->Auth->user());
    }
}
