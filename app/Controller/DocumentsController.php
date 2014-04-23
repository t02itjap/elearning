<?php
App::uses ( 'DboSource', 'Model/Datasource' );
class DocumentsController extends Controller{
	var $uses = array ('Document','User','Comment');
	//$data= array();
	function beforeFilter(){
		parent::beforeFilter();
		$this->layout= "student";
		// $this->Auth->authenticate = array ('Form' => array ('userModel' => 'User', 'fields' => array ('username' => 'user_name', 'password' => 'password' ) )//'scope' => array('User.')
		//  );
		// $this->Auth->allow ( array ('home', 'login', 'register' ) );
	}
	public function index(){
		//$lesson = new Lesson();
		// $this->redirect(array('controller' => 'documents', 'action' => 'viewDoc','id'=>1));
	}

	public function viewDoc($id){
		if (!isset($id))  $this->redirect(array('controller' => 'documents', 'action' => 'viewDoc', 2));
		$doc = $this->Document->findById($id);
		$file = $this->webroot . $doc['Document']['file_link'];
		$this->set('file',$file);
		$this->set('id',$id);
		//Copyright
		if (isset($this->request->data['submit_data'])){
			$this->Document->id=$id;
			$this->Document->saveField('copyright_reporters',$this->Document->field('copyright_reporters')+1);
		}
		//Comment
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
		}
	//if ($this->Comment->validates()) {
		$this->Comment->save();		
		//loadComment
		$this->set('data', $this->Comment->getComments($id));
		// debug($this->Comment->getComments(1));
		// die;
	}

	//Huong Viet
public function delete_document() {
	if(isset($this->request->data['delete_file'])){
               
		$count = $this->request->data['hide'];
		$this->Document->id = $count;
		$this->Document->delete();
		$this->redirect(array('controller' => 'admins', 'action' => 'getDocument'));
	}
	if(isset($this->request->data['block_file'])){
               
		$count = $this->request->data['hide'];
		$this->Document->id = $count;
		debug($this->Document->id);die();
		if($this->Document->lock_flag==0){
			$this->Document->set(array(
				'lock_flag' => 1,
				));
		}

		if($this->Document->lock_flag==1){
			$this->Document->set(array(
				'lock_flag' => 0,
				));
		}
		$this->Document->save();
		$this->redirect(array('controller' => 'admins', 'action' => 'getDocument'));
	}
}



}