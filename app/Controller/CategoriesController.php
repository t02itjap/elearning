<?php
class CategoriesController extends AppController {
	function beforeFilter(){
		parent::beforeFilter();
	}
	function category(){
		//debug($this->Categories->getAllCategories());die();	
		//$this->set('categories',$this->Categories->getAllCategories());
	}
}
?>