<?php 
class Category extends AppModel{
	var $name = 'Category';
	var $primaryKey = 'id';

	public function getAllCategories(){
		$conditions=array(
			'fields'=>'category_name',
			'limit'=>10	
		);
		return $this->find('all', $conditions);
	}
}
?>