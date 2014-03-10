<?php 
class Lesson extends AppModel{
	//Thang viet
	var $name = 'Lesson';
	var $primaryKey = 'id';
	//Het phan Thang viet
	public $hasMany = array(
		'Test' => array(
			'className' => 'Test'
			),
            //Thang viet
		'Bill' => array(
			'classname' => 'Bill',
			'foreignKey' => 'lesson_id'
			)
		);
/*
	public $hasMany = array(
		'User' => array(
			'className' => 'User'
			// >>>>>>> 2be1f5077ad250cac8ce44b372e03e0dc8dbebab
			)
            //Het phan Thang viet
		);*/

	public $belongsTo = array(
		'User'=> array(
			'className'=>'User',
			'foreignKey'=>'create_user_id'
			),
		'Categorie'=>array(
			'className'=>'Category',
			'foreignKey'=>'category_id'
			)
		);

	public function getLessons(){
		$condition=array(
			'joins'=>array(
				array(
					'table'=>'tb_users',
					'alias'=>'User',
					'type'=>'INNER',
					'conditions'=>array(
						'User.id=Lesson.create_user_id',
						'User.id'=>25	
						)
					)
				),
			'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.category_id', 'User.user_name')
			);
		return $this->find('all', $condition);
	}
	public function getComments($lesson_id){
		$condition = array(
			'joins'=>array(
				array(
					'table'=>'tb_comments',
					'alias'=>'c',
					'type'=>'INNER',
					'conditions'=>array(
						'c.lession_id=Lesson.id'
						)
					)
				),
			'joins'=>array(
				array(
					'table'=>'tb_users',
					'alias'=>'u',
					'type'=>'INNER',
					'conditions'=>array(
						'u.id=c.user_ id'
						)
					)
				),
			'fields'=>array('c.comment','u.user_name'),
			'conditions'=>array('Lesson.id'=>$lession_id)
			);
		return $this->find('all',$condition);
	}
}
// >>>>>>> 2be1f5077ad250cac8ce44b372e03e0dc8dbebab
?>
