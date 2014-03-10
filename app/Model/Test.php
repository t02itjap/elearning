<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Test extends AppModel{
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
    
}
?>
