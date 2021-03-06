<?php

class Document extends AppModel {

    var $name = 'Document';
    var $primaryKey = 'id';
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'create_user_id'
        ),
        'Lesson'=>array(
            'className'=>'Lesson',
            'foreignKey' => 'lesson_id'
        )
    );

    public function checkValid($fileName, $folder) {
        $uploaddir = WWW_ROOT . 'files/'.$folder.'/';
        $check = FALSE;
        //check file
        $allowedExts = array("gif", "jpeg", "jpg", "png", "pdf", "mp3", "mp4", "wav", "tsv");
        $temp = explode(".", $fileName);
        $extension = end($temp);
        if (in_array($extension, $allowedExts)
                && !file_exists($uploaddir . $fileName)) {
            $check = TRUE;
        }
        return $check;
    }

    public function getDocuments($id) {
        $condition = array(
            'conditions' => array('Document.id' => $id),
            'fields' => array('Document.file_link')
        );
        return $this->find('first', $condition);
    }

    public function getComments($lesson_id) {
        $condition = array(
            'joins' => array(
                array(
                    'table' => 'tb_lessons',
                    'alias' => 'l',
                    'type' => 'INNER',
                    'conditions' => array(
                        'l.id=Document.lesson_id'
                    )
                ),
                array(
                    'table' => 'tb_comments',
                    'alias' => 'c',
                    'type' => 'INNER',
                    'conditions' => array(
                        'l.id=c.lesson_id'
                    )
                ),
                array(
                    'table' => 'tb_users',
                    'alias' => 'u',
                    'type' => 'INNER',
                    'conditions' => array(
                        'u.id=c.user_id'
                    )
                )
            ),
            'fields' => array('c.comment', 'u.user_name', 'Document.id', 'l.id'),
            'conditions' => array('l.id' => $lesson_id)
        );
        return $this->find('all', $condition);
    }
    public function deleteDocumentByUserId($userId){
    	$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('Document.create_user_id' => $userId)
        ));
        if($recordList != NULL) foreach ($recordList as $record){
            if(!$this->delete($record['Document']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1){
        	return true;
        }
        else return false;
    }
    public function deleteDocumentByLessonId($LessonId){
    	$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('lesson_id' => $lessonId)
        ));
        if($recordList != NULL) foreach ($recordList as $record){
        	$file = WWW_ROOT . 'files/'.$record['Document']['create_user_id'].'/'.$record['Document']['file_name'];
        	unlink($file);
            if(!$this->delete($record['Document']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
    }
}