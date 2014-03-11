<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Test extends AppModel{
    var $name="Test";
    
    public $validate = array(
        'file_link' => array(
            'extension' => array(
                'rule' => array('extension', array('docx')),
                'message' => 'Only tsv files',
            ),
            'existed_file' => array(
                'rule' => 'isUnique',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'This file has been existed',
            ),
        )
    );
    
    public $hasMany = array(
        'TestHistory' => array(
            'className' => 'TestHistory',
            'foreignKey' => 'test_id'
            )
        );
    
    public $belongsTo = array(
        'Lesson' => array(
            'className' => 'Lesson'
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
