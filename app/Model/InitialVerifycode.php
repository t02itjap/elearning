<?php
class InitialVerifycode extends AppModel {
	var $name = 'InitialVerifycode';
	var $primaryKey = 'id';
	public function deleteInitialVerifycodeByUserId($userId){
		$record = $this->find('first',array(
        	'conditions' => array('user_id' => $userId)
        ));
        if($record == NULL) return true;
        else if($this->delete($record['InitialVerifycode']['id'])) return true;
        else return false;
	}
}
?>