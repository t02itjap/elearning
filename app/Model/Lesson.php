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
            //Het phan Thang viet
        );
/*        
        public $hasMany = array(
            'User' => array(
                'className' => 'User'
            )
        );
 */
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
