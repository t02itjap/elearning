<?php
class LessonsController extends AppController {
	var $uses = array('User', 'Lesson', 'Bill', 'LessonOfCategory');
	var $components = array('Session');
	//var $helpers = array('Ajax','Javascript');

/*
	var $uses = array ('User');
	$data= array();
>>>>>>> 2be1f5077ad250cac8ce44b372e03e0dc8dbebab
*/
function beforeFilter(){
	parent::beforeFilter();
	//$this->layout= "student";
		$this->Auth->authenticate = array ('Form' => array ('userModel' => 'User', 'fields' => array ('username' => 'user_name', 'password' => 'password' ) )//'scope' => array('User.')
			);
		$this->Auth->allow ( array ('home', 'login', 'register' ) );
	}
	public function index(){
	}

	//ユーザのホームページにある授業リスト
	public function view_all_lessons(){
		//先生のホームページに別の先生のすべて授業だけ
		//debug($this->LessonOfCategory->getLIdAndCName());die();
		if($this->Auth->User('level')==2){
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array('Lesson.create_user_id !='=>$this->Auth->User('id'), 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
		}
		//先生のホームページにシステムのすべて授業
		else{
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array('Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);	
		}
		
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		$this->showLayout();
		$this->set('title_for_layout', '授業リスト');
	}

	//管理される授業リスト
	public function manage_lessons(){
		//先生たちが自分で作った授業
		if($this->Auth->User('level')==2){
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array('Lesson.create_user_id'=>$this->Auth->User('id'), 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
			$this->set('title_for_layout', '作った授業リスト');
		}
		//管理者が管理するシステムのすべて授業
		else{
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array('Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
			$this->set('title_for_layout', '授業リスト');	
		}
		
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		$this->showLayout();
		
	}

	//カテゴリで検索された授業
	public function lessons_by_category($category_id=null, $category_name=null){
		//debug($this->Auth->User());
		//debug($category_id);die();
		$lIdAndCName=$this->LessonOfCategory->getLIdAndCName();
		//debug($lIdAndCName);die();
		$lessons_id = Array();
		foreach($lIdAndCName as $key){
			if($key['LessonOfCategory']['category_id']==$category_id)
				$lessons_id[] = $key['LessonOfCategory']['lesson_id'];
		}
		$this->paginate = array(
			'limit'=>1,
			'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
			'conditions'=>array('Lesson.id'=>$lessons_id, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
			);
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		$this->showLayout();
		$this->set('title_for_layout', $category_name.'カテゴリを含む授業');
	}

	//検索ボックスで検索された授業
	public function search_result(){
		if(!empty($this->data)&&$this->data['Lesson']['keyword']!=null){
			$keyword=$this->data['Lesson']['keyword'];
			$type=$this->data['Lesson']['type'];
			$this->Session->write('keyword', $keyword);
			$this->Session->write('type', $type);
		}
		else if($this->Session->check('keyword')&&$this->Session->check('type')){
			$keyword=$this->Session->read('keyword');
			$type=$this->Session->read('type');
			//debug($keyword);
		}

		switch ($type) {
			case 'teacher':
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
				'conditions'=>array('User.user_name LIKE'=>'%'.$keyword.'%', 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
			break;

			case 'lesson':
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
				'conditions'=>array('Lesson.lesson_name LIKE'=>'%'.$keyword.'%', 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
			break;

			case 'category':
			$lIdAndCName=$this->LessonOfCategory->getLIdAndCName1($keyword);
			$lessons_id = Array();
			foreach($lIdAndCName as $key){
				$lessons_id[] = $key['LessonOfCategory']['lesson_id'];
			}
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
				'conditions'=>array('Lesson.id'=>$lessons_id, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
			break;

			default:
		   		# code...
			break;
		}
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		$this->showLayout();
		$this->set('title_for_layout', '検索結果');  
	}

	protected function showLayout(){
		//debug($this->Auth->User());
		if($this->Auth->loggedIn()){
			switch ($this->Auth->User('level')) {
				case '1':
				$this->layout = 'manager';
				break;
				
				case '2':
				$this->layout = 'teacher';
				break;

				case '3':
				$this->layout = 'student';
				break;

				default:
					# code...
				break;
			}
			$this->set('level', $this->Auth->User('level'));
		}
		else
		{
			$this->layout='before_login';
		}
// =======
// 		// $data = $this->User->find('all');
//   //               $this->set('data',$data);
//   //               $this->set('index', $this->Lesson->getLessons());
//                 // $thiss->set('index', $this->Lesson->getLessons());
//               //  $this->redirect(array('controller' => 'Lessons', 'action' => 'sc20'));
	}
	public function sc20(){
		//$this->set(array('controller' => 'Lessons', 'action' => 'sc20'));
	}



	function title_report($id=null) {

		$success=false;
		$count=$this->Lesson->find('count', array(
			'conditions'=>array('Lesson.title_reporters LIKE'=>'%'.$this->Auth->User('id').'%', 'Lesson.id'=>$id)		
			));
		if($count==0){
			$result=$this->Lesson->find('all', array(
				'fields'=>array('Lesson.title_reporters', 'Lesson.title_violation'),
				'conditions'=>array('Lesson.id'=>$id)
				)
			);

			if($result[0]['Lesson']['title_reporters']==null||$result[0]['Lesson']['title_reporters']=='')
				$title_reporters=$this->Auth->User('id');
			else
				$title_reporters=$result[0]['Lesson']['title_reporters'].','.$this->Auth->User('id');
			$sql='update tb_lessons
			set title_reporters="'.$title_reporters.'",
			title_violation=true
			where id='.$id;

			$this->Lesson->query($sql);
			$success=true;
		}

	// output JSON on AJAX request
		if($this->RequestHandler->isAjax()) {
			$this->autoRender = $this->layout = false;
			echo json_encode(array('success'=>($success==true) ? FALSE : TRUE, 'lesson_id'=>$id));
			exit;
		}		
	}

	public function delete_lesson($id=null) {
		$success=false;
		$count=$this->Lesson->find('count', array(
			'conditions'=>array('Lesson.id'=>$id)		
			));
		if($count!=0){
			$sql='update tb_lessons
			set delete_flag=true
			where id='.$id;

			$this->Lesson->query($sql);
			$success=true;
		}
		
		if($this->RequestHandler->isAjax()) {
			$this->autoRender = $this->layout = false;
			echo json_encode(array('success'=>($success==true) ? FALSE : TRUE, 'lesson_id'=>$id));
			exit;
		}
	}

	public function learned_lesson(){
		$idSet=$this->Bill->getLearnedLessonsId($this->Auth->User('id'));
		$idArray=array();
		foreach ($idSet as $lesson_id) {
			$idArray[]=$lesson_id['Bill']['lesson_id'];
		}
		$this->paginate = array(
			'limit'=>1,
			'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
			'conditions'=>array('Lesson.id'=>$idArray, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
			);
		//debug($idArray);die();
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		$this->showLayout();	
		$this->set('title_for_layout', '勉強した授業リスト');	
	}

}
?>

