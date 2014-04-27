<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Test extends AppModel{
    var $name="Test";
    
    public function checkValid($fileName, $folder) {
        $uploaddir = WWW_ROOT . 'files/'.$folder.'/';
        $check = FALSE;
        //check file
        $allowedExts = array("tsv");
        $temp = explode(".", $fileName);
        $extension = end($temp);
        if (in_array($extension, $allowedExts)
                && !file_exists($uploaddir . $fileName)) {
            $check = TRUE;
        }
        return $check;
    }
    
    public $hasMany = array(
        'TestHistory' => array(
            'className' => 'TestHistory',
            'foreignKey' => 'test_id'
            )
        );
    public $belongsTo = array(
        'Lesson' => array(
            'className' => 'Lesson',
            'foreignKey' => 'lesson_id'
        )
    );
    public function getTests($lesson_id){
        $condition = array(
            'conditions'=>array('lesson_id'=>$lesson_id)
            );
        return $this->find('first',$condition);
    }
    public function deleteTestByUserId($userId){
    	$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('Test.create_user_id' => $userId)
        ));
        if($recordList != NULL) foreach ($recordList as $record){
            if(!$this->delete($record['Test']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
    }
    public function deleteTestByLessonId($LessonId){
    	$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('lesson_id' => $lessonId)
        ));
        if($recordList != NULL) foreach ($recordList as $record){
        	$file = WWW_ROOT . 'files/'.$record['Test']['create_user_id'].'/'.$record['Test']['file_name'];
        	unlink($file);
            if(!$this->delete($record['Test']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
    }
}
?>
