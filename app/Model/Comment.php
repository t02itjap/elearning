<?php
class Comment extends AppModel{
	var $name = "Comment";
	var $primaryKey = 'id';
	public $validate = array(
		'comment'=>array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap comment',
			)
		));

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'Lesson'=>array(
            'className'=>'Lesson',
            'foreignKey'=>'lesson_id'
        )
    );

    public function getComments($lesson_id=null){
        $comments=$this->find('all', array(
                'fields'=>array('Comment.comment', 'User.user_name', 'Lesson.id'),
                'conditions'=>array('Lesson.id'=>$lesson_id)
            ));
        //debug($comments);die();
        return $comments;
    }
    public function deleteCommentByUserId($userId){
    	$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('user_id' => $userId)
        ));
        if($recordList != NULL) foreach ($recordList as $record){
            if(!$this->delete($record['Comment']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
    }
    public function deleteCommentByLessonId($LessonId){
    	$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('lesson_id' => $LessonId)
        ));
        if($recordList != NULL) foreach ($recordList as $record){
            if(!$this->delete($record['Comment']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
    }
}