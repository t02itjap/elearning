<?php
class LearnHistory extends AppModel {
	var $name = 'LearnHistory';
	var $primaryKey = 'id';
		public $belongsTo = array(
		'Bill' => array(
			'className' => 'Bill',
			'foreignKey' => 'bill_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	public function deleteLearnHistoryByBillId($billId){
		$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('bill_id' => $billId)
        ));
        if($recordList != NULL) foreach ($recordList as $record){
            if(!$this->delete($record['LearnHistory']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
	}
}