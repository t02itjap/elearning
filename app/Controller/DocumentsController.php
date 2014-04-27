<?php
App::uses ( 'DboSource', 'Model/Datasource' );
class DocumentsController extends AppController{
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

	public function viewDoc($id=null, $lesson_id=null){
		//debug($id.'---'.$lesson_id);die();
		if($this->Auth->user('level')==2){
			$this->layout= "teacher";
		}
		//if (!isset($id))  $this->redirect(array('controller' => 'documents', 'action' => 'viewDoc', 2));
		$reporters = $this->Document->field('copyright_reporters',array('id'=>$id));
		if(strpos($reporters,',')){
			$reporter = explode(',', $reporters);
		}else $reporter = array($reporters);
// 		debug($reporter);
		$isCopyright = true;
		if(in_array($this->Auth->user('id'),$reporter)){
			$isCopyright = false;
		}
		$this->set('isCopyright',$isCopyright);
		$this->set('clear', '');
		$this->set('lesson_id', $lesson_id);
		$doc = $this->Document->findById($id);
// 		$teacher = $this->User->findById($doc['Document']['create_user_id']);
		$this->set('doc',$doc);
// 		debug($doc);die();
		//debug($doc);die;
		$file = $this->webroot.$doc['Document']['file_link'];
		//$file = str_replace('\', $replace, $subject)
		$this->set('file',$file);
		$this->set('id',$id);
		//debug($file);die;
		//Copyright
		if (isset($this->request->data['submit_data'])){
			$this->Document->id=$id;
			if($this->Document->field('copyright_violation') == 0 ){
				$this->Document->set(array('copyright_violation'=>1));
			}
			$this->Document->set(array('copyright_reporters'=>($this->Document->field('copyright_reporters').','.$this->Auth->user('id'))));
			$this->Document->save();
			$this->Session->setFlash('Copyright違反を報告成功した');
		}
		//Comment
		if (isset($this->request->data['Document']['txtComment'])&&$this->request->data['Document']['txtComment']!='') {
			//debug($this->request->data);
			$data = $this->request->data;
			date_default_timezone_set("Asia/Ho_Chi_Minh");
			$dt = new DateTime();
			//echo $dt->format('Y-m-d H:i:s');
			//debug($this->Auth->user('id'));die();
			$this->Comment->create();
			$this->Comment->set(
				array('comment'=>$this->request->data['Document']['txtComment'],
					'user_id'=>$this->Auth->user('id'),
					'comment_date'=>$dt->format('Y-m-d H:i:s'),
					'lesson_id'=>$doc['Lesson']['id']
					)
				);
			$this->Comment->save();
		}
	//if ($this->Comment->validates()) {
		//loadComment
		$this->set('data', $this->Comment->getComments($doc['Lesson']['id']));
		//$this->set('data', $this->Document->getComments($doc['Lesson']['id']));
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