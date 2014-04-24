<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Test extends AppModel{
    var $name="Test";
    
    public function checkValid($fileName) {
        $uploaddir = WWW_ROOT . 'files/';
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
    public function getTests($lesson_id){
        $condition = array(
            'conditions'=>array('lesson_id'=>$lesson_id)
            );
        return $this->find('first',$condition);
    }
}
?>
