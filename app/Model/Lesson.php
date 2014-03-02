<?php 
class Lesson extends AppModel{
	public $hasMany = array(
            'Test' => array(
                'className' => 'Test'
            )
        );
/*        
        public $hasMany = array(
            'User' => array(
                'className' => 'User'
            )
        );
 */
}
?>