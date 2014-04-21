<?php

class LessonOfCategory extends AppModel {

    var $name = 'LessonOfCategory';
    var $primaryKey = 'id';
    var $foreignKey = 'category_id';
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id'
        )
    );
//    public $hasAndBelongsToMany = array(
//        'Lesson' => array(
//            'className' => 'Lesson',
//            'foreignKey' => 'lesson_id'
//        )
//    );

    //Get lesson id and category name
    public function getLIdAndCName() {
        $lIdAndCname = $this->find('all', array(
            'fields' => array('LessonOfCategory.lesson_id', 'LessonOfCategory.category_id', 'Category.category_name'),
                ));
        //debug($lIdAndCname);die();
        return $lIdAndCname;
    }

    public function getLIdAndCName1($keyword = null) {
        $lIdAndCname = $this->find('all', array(
            'fields' => array('LessonOfCategory.lesson_id', 'LessonOfCategory.category_id', 'Category.category_name'),
            'conditions' => array('Category.category_name LIKE' => '%' . $keyword . '%')
                ));
        //debug($lIdAndCname);die();
        return $lIdAndCname;
    }
	
	public function getLIdAndCName2($keyword=null){
		$isand=false;
		$andpos=strpos($keyword, '+');
		$orpos=strpos($keyword, '-');
		
		if(($andpos!=0&&$orpos!=0&&$andpos<=$orpos)||$orpos==0)
		{
			$keywords=explode('+', $keyword);
			$isand=true;
		}
		else{
			$keywords=explode('-', $keyword);
			$isand=false;
		}
		foreach ($keywords as $key) {
			$condition1[]=array('Category.category_name LIKE'=>'%'.$key.'%');
		}
		if($isand){
			$conditions=array($condition1);		
		}
		else
			$conditions=array('OR'=>$condition1);
		$lIdAndCname=$this->find('all', array(
			'fields'=>array('LessonOfCategory.lesson_id', 'LessonOfCategory.category_id', 'Category.category_name'),
			'conditions'=>$conditions
			));
		//debug($lIdAndCname);die();
		return $lIdAndCname;
	}
}

?>