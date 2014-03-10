<?php 
class Document extends AppModel{
	var $name = 'Document';
	var $primaryKey = 'id';
	public function getDocuments($id){
		$condition =array(
			'conditions'=>array('Document.id'=>$id),
			'fields'=>array('Document.file_link')
			);
		return $this->find('first',$condition);
	}
	public function getComments($lesson_id){
	$condition = array(
		'joins'=>array(
			array(
				'table'=>'tb_lessons',
				'alias'=>'l',
				'type'=>'INNER',
				'conditions'=>array(
					'l.id=Document.lesson_id'
					)
				),
			array(
				'table'=>'tb_comments',
				'alias'=>'c',
				'type'=>'INNER',
				'conditions'=>array(
					'l.id=c.lesson_id'
					)
				),
			array(
				'table'=>'tb_users',
				'alias'=>'u',
				'type'=>'INNER',
				'conditions'=>array(
					'u.id=c.user_id'
					)
				)
			),
		'fields'=>array('c.comment','u.user_name','Document.id','l.id'),
		'conditions'=>array('l.id'=>$lesson_id)
		);
	return $this->find('all',$condition);
}

}