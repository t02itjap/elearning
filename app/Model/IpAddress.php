<?php
class IpAddress extends AppModel {
	var $name = 'IpAddress';
	var $primaryKey = 'id';
	public $validate = array(
		'ip_address' => array(
			'check ip' => array(
				'rule' => array('ip','IPv4'),
				'message' => 'ip形態が間違い',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ipを入力してください。',
			),
		),
	);
	public function deleteIpByUserId($userId){
		$check = 1;
		$ipList = $this->find('all',array(
        	'conditions' => array('admin_id' => $userId)
        ));
        if($ipList != NULL) foreach ($ipList as $ip){
            if(!$this->delete($ip['IpAddress']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
	}
}
?>