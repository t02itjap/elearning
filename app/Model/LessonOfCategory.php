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
    public $hasAndBelongsToMany = array(
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

}

?>