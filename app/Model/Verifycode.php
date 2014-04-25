<?php
class Verifycode extends AppModel {
	var $name = 'Verifycode';
	var $primaryKey = 'id';
	public $validate = array(
		'question' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '質問を入力してください。',
			),
		),
		'verifycode' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '答えを入力してください。',
			),
		)
	);
	public function deleteVerifycodeByUserId($userId){
		$record = $this->find('first',array(
        	'conditions' => array('user_id' => $userId)
        ));
        if($record == NULL) return true;
        else if($this->delete($record['Verifycode']['id'])) return true;
        else return false;
	}
}
?>