<?php 
class Lesson extends AppModel{
	public function getLessons(){
	$condition=array(
		'joins'=>array(
			array(
				'table'=>'tb_users',
				'alias'=>'User',
				'type'=>'INNER',
				'conditions'=>array(
					'User.id=Lesson.create_user_id',
					'User.id'=>2	
					)
				)
			),
		'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.category_id', 'User.user_name')
		);
	return $this->find('all', $condition);
	}
}
?>
