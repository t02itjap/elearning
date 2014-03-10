<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Test extends AppModel{
    var $name="Test";
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
