<?php 
class Bill extends AppModel{
	//Thang viet
	var $name = 'Bill';
	var $primaryKey = 'id';
	public $hasMany = array(
		'LearnHistory' => array(
			'className' => 'LearnHistory',
			'foreignKey' => 'bill_id'
			)
		);
	public $belongsTo = array(
		'Lesson' => array(
			'className' => 'Lesson',
			'foreignKey' => 'lesson_id'
			)
	);
	//Het phan Thang viet
	public function getBills($user_id=null){
		$condition=array(
			'joins'=>array(
				array(
					'table'=>'tb_users',
					'alias'=>'User',
					'type'=>'INNER',
					'conditions'=>array(
						'User.id=Bill.user_id'
						)
					)
				),
			'fields'=>array(
				'User.real_name','Bill.lesson_cost','Bill.learn_date'
				),
			'conditions'=>array('User.id'=>$user_id)
			);
		return $this->find('all', $condition);

	}
}	

?>