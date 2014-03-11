<?php
App::uses ( 'DboSource', 'Model/Datasource' );
class DocumentsController extends Controller{
//var $uses = array ('User');
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
		$this->set('data', $this->Document->getComments(1));
	}
	public function load(){
		$data=$this->Document->getComments(1);
		foreach ($data as $value) {
			echo '<div class="comment" id="comment_div">
			<img src="" alt="'.$value["u"]["user_name"].'"/>
			<span class="comment_content">'.$value["c"]["comment"].'</span>
			</div>';
		}
	}
	public function read(){
	$d = $this->Document->getDocuments(1);//docment id
	$path=$d['Document']['file_link'];
 	$this->response->file('../webroot/pdf.pdf');//truyen vao $path
 	$this->response->header('Content-Disposition', 'inline');
 	return $this->response;
 }
 public function update(){
 	if (isset($this->request->data['submit_data'])) {
 		$document_id=$this->request->data['Document'];
 		$this->Document->id=$document_id;
 		$this->Document->saveField('copyright_reporters',$this->Document->field('copyright_reporters')+1);
 		$this->redirect(array('controller' => 'documents', 'action' => 'index'));
 	}
 }

	//Huong Viet
 public function delete_document() {
 	if(isset($this->request->data['delete_file'])){
                //debug($this->request->data['hide']);
 		$count = $this->request->data['hide'];
 		$this->Document->id = $count;
 		$this->Document->delete();
 		$this->redirect(array('controller' => 'admins', 'action' => 'getDocument'));
 	}
 	if(isset($this->request->data['block_file'])){
                //debug($this->request->data);die();
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