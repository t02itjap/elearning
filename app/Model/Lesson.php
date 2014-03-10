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

	public $belongsTo = array(
			'User'=> array(
				'className'=>'User',
				'foreignKey'=>'create_user_id'
				),
			'Categorie'=>array(
				'className'=>'Categorie',
				'foreignKey'=>'category_id'
			)
		);
	}

?>
