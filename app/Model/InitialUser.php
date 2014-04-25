<?php
class InitialUser extends AppModel {
	var $name = 'InitialUser';
	var $primaryKey = 'id';
	public function deleteInitialUserByUserId($userId){
		$record = $this->find('first',array(
        	'conditions' => array('user_id' => $userId)
        ));
        if($record == NULL) return true;
        else if($this->delete($record['InitialUser']['id'])) return true;
        else return false;
	}
}
?>