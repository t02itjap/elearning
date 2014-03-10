<?php 
class Categorie extends AppModel{
	var $name = 'Categorie';
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