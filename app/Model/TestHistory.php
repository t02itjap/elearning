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
    public function deleteTestHistoryByUserId($userId){
    	$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('user_id' => $userId)
        ));
        if($recordList != NULL) foreach ($recordList as $record){
            if(!$this->delete($record['TestHistory']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
    }
}
?>
