<?php 
class LessonsController extends AppController{
	public function index() {
		//var_dump(lessons);
		$this->set('lessons', $this->Lesson->getLessons());
		
	}
}
?>
