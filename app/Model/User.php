<?php
class User extends AppModel {
	var $name = 'User';
	var $primaryKey = 'id';
    
    function checkUserExist($username){
               	$result = $this->find("count", array(
                               	"conditions" => array("user_name" => $username)
               	));
               	return $result ;
       	}
}