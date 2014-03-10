<?php
class CommentsController extends Controller{
	function beforeFilter(){
		parent::beforeFilter();
		$this->layout= "student";
	}
	public function add(){
 if (isset($this->request->data['submit_comment'])) {
	$data = $this->request->data;
	date_default_timezone_set("Asia/Ho_Chi_Minh");
	$dt = new DateTime();
	echo $dt->format('Y-m-d H:i:s');
	$this->Comment->set(
	array('comment'=>$this->request->data['Document']['txtComment'],
	'user_id'=>25,
	'comment_date'=>$dt->format('Y-m-d H:i:s'),
	'lesson_id'=>$this->request->data['Document']['id']
	)
		);
	//if ($this->Comment->validates()) {
		$this->Comment->save();
	//}
		$this->redirect(array('controller' => 'documents', 'action' => 'index'));
// 	# code...
 }
// else echo "???";
	}
public function load(){

	}
}