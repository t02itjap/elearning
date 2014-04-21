<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TestHistory extends AppModel{
    public $belongsTo = array(
        'User' => array(
            'className' => 'User'
            )
        ,
        'Test' => array(
            'className' => 'Test'
        )
        );
}
?>
