<?php

class LessonOfCategory extends AppModel {

    var $name = 'LessonOfCategory';
    var $primaryKey = 'id';
    var $foreignKey = 'category_id';
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id'
        ),
        'Lesson' => array(
            'className' => 'Lesson',
            'foreignKey' => 'lesson_id'
        )
    );


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
		$lIdAndCname=array();
		$lIdAndCnameTemp=array();

		if(($andpos!=0&&$orpos!=0&&$andpos<=$orpos)||($orpos==0&&$andpos!=0))
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
		//debug($condition1);
		if($isand){
			for($k=0;$k<count($keywords);$k++){
				$lIdAndCnameTemp[$k]=$this->find('all', array(
				'fields'=>array('LessonOfCategory.lesson_id'),
				'conditions'=>array('Category.category_name LIKE'=>'%'.$keywords[$k].'%'),
				'group'=>'LessonOfCategory.lesson_id'
				));
				if(!empty($lIdAndCnameTemp[$k]))
					for($i=0;$i<count($lIdAndCnameTemp[$k]);$i++){
						$temp[$k][]=$lIdAndCnameTemp[$k][$i]['LessonOfCategory']['lesson_id'];
				}
				else
					$temp[$k][]=-1;
			}
			if(!empty($temp)){
				$lIdAndCname=$temp[0];
				//debug($lIdAndCname);die();
				for($i=1;$i<count($temp);$i++){
					$lIdAndCname=array_intersect($lIdAndCname, $temp[$i]);
				}
			}
		}	
		else{
			$conditions=array('OR'=>$condition1);

			//debug($conditions);
			$temp=$this->find('all', array(
				'fields'=>array('LessonOfCategory.lesson_id'),
				'conditions'=>$conditions,
				'group'=>'LessonOfCategory.lesson_id'
			));
			if(!empty($temp))
				for($i=0;$i<count($temp);$i++){
					$lIdAndCname[$i]=$temp[$i]['LessonOfCategory']['lesson_id'];
				}
		}
		return $lIdAndCname;
	}
	public function deleteLessonOfCategoryByLessonId($lessonId){
		$check = 1;
		$recordList = $this->find('all',array(
        	'conditions' => array('lesson_id' => $lessonId)
        ));
        if($recordList != NULL) foreach ($recordList as $record){
            if(!$this->delete($record['LessonOfCategory']['id'])){
            	$check = 0;
            	break;
            }
        }
        if($check == 1) return true;
        else return false;
	}
}

?>