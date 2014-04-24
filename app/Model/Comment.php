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


    public function getComments($lesson_id) {
        $condition = array(
            'joins' => array(
                array(
                    'table' => 'tb_lessons',
                    'alias' => 'l',
                    'type' => 'INNER',
                    'conditions' => array(
                        'l.id=Comment.lesson_id'
                    )
                ),
                array(
                    'table' => 'tb_users',
                    'alias' => 'u',
                    'type' => 'INNER',
                    'conditions' => array(
                        'u.id=Comment.user_id'
                    )
                )
            ),
            'fields' => array('Comment.comment', 'u.user_name','l.id'),
            'conditions' => array('l.id' => $lesson_id)
        );
        return $this->find('all', $condition);
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

}