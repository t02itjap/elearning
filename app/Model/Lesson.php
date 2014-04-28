<?php

class Lesson extends AppModel {

    //Thang viet
    var $name = 'Lesson';
    var $primaryKey = 'id';
    //Het phan Thang viet
    public $hasMany = array(
        'Test' => array(
            'className' => 'Test'
        ),
        'Document' => array(
            'className' => 'Document'
        ),
        //Thang viet
        'Bill' => array(
            'classname' => 'Bill',
            'foreignKey' => 'lesson_id'
        )
    );

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'create_user_id'
        )
    );

    public function getLessons() {
        $condition = array(
            'joins' => array(
                array(
                    'table' => 'tb_users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => array(
                        'User.id=Lesson.create_user_id',
                        'User.id' => 25
                    )
                )
            ),
            'fields' => array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.category_id', 'User.user_name')
        );
        return $this->find('all', $condition);
    }

    public $validate = array(
		'lesson_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '授業名を入力してください。',
			),
			'check exist' => array(
				'rule' => 'isUnique',
				'message' => 'この授業が存在でした。',
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '授業を描いてください。'
			)
		)
	);
    public  function deleteReporter($stuId){
    	$check = 1;
    	$reportList = $this->find('all',array(
    			'conditions' => array('Lesson.copyright_reporters LIKE ' => '%,'.$stuId.',%')
    	));
//     	debug($reportList);die();
    	
    	if($reportList != NULL) foreach ($reportList as $report){
    		$this->id = $report['Lesson']['id'];
    		$curReporter = $this->field('copyright_reporters');
    		$newReporter = str_replace(','.$stuId.',', ',', $curReporter);
    		$this->set(array('copyright_reporters'=>$newReporter));
    		if(!$this->save()){
    			$check = 0;
    			break;
    		}
    	}
    	if($check == 1) return true;
    	else return false;
    }
    
    public  function deleteVoter($stuId){
    	$check = 1;
    	$likeList = $this->find('all',array(
    			'conditions' => array('Lesson.voters LIKE ' => '%,'.$stuId.',%')
    	));
//     	debug($likeList);die;
    	 
    	if($likeList != NULL)
    		foreach ($likeList as $like){
	    		$this->id = $like['Lesson']['id'];
	    		$curVoter = $this->field('voters');
	    		$newVoter = str_replace(','.$stuId.',', ',', $curVoter);
	    		$this->set(array('copyright_reporters'=>$newVoter));
	    		if(!$this->save()){
	    			$check = 0;
	    			break;
	    		}
    	}
    	if($check == 1) return true;
    	else return false;
    }
    
	public function deleteLessonByTeacherId($teacherId){
    	$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('Lesson.create_user_id' => $teacherId)
        ));
		
        if($recordList != NULL) foreach ($recordList as $record){
            if(!$this->delete($record['Lesson']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
	}
	public function deleteLessonByLessonId($lessonId){
    	if($this->delete($lessonId)) return true;
    	else return false;
	}
}

?>
