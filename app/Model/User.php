<?php
class User extends AppModel {
	var $name = 'User';

        public $hasMany = array(
            'TestHistory' => array(
                'className' => 'TestHistory'
            )
        );
        /*
        public $hasMany = array(
            'Lesson' => array(
                'className' => 'Lesson'
            )
        );
        public $hasMany = array(
            'Test' => array(
                'className' => 'Test'
            )
        );
         * 
         */

	var $primaryKey = 'id';
    
    function checkUserExist($username){
               	$result = $this->find("count", array(
                               	"conditions" => array("user_name" => $username)
               	));
               	return $result ;
       	}

}