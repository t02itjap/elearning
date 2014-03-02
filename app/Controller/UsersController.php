<?php
class UsersController extends AppController {
	var $uses = array ('User','TestHistory','Test','Lesson');
	function beforeFilter(){
		parent::beforeFilter();
	}
	public function index(){
                $data = $this->Test->TestHistory->find('all',
                        array(
                            'conditions'=>array(
                                'TestHistory.user_id'=>'2',//thay cai 2 = $this->Auth->user('id')
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