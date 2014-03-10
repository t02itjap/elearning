<?php
class LessonsController extends AppController {
	var $uses = array('User', 'Lesson', 'Bill');
	var $components = array('Session');
	//var $helpers = array('Ajax','Javascript');

	function beforeFilter(){
		parent::beforeFilter();
	}
	public function index(){

	}

	//ユーザのホームページにある授業リスト
	public function view_all_lessons(){
		//先生のホームページに別の先生のすべて授業だけ
		if($this->Auth->User('level')==2){
			$this->paginate = array(
			'limit'=>1,
			'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.category_id', 'User.user_name', 'Categorie.category_name'),
			'conditions'=>array('Lesson.create_user_id !='=>$this->Auth->User('id'))
			);
		}
		//先生のホームページにシステムのすべて授業
		else{
			$this->paginate = array(
			'limit'=>1,
			'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.category_id', 'User.user_name', 'Categorie.category_name')
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
			'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.category_id', 'User.user_name', 'Categorie.category_name'),
			'conditions'=>array('Lesson.create_user_id'=>$this->Auth->User('id'), 'Lesson.lock_flag'=>false)
			);
			$this->set('title_for_layout', '作った授業リスト');
		}
		//管理者が管理するシステムのすべて授業
		else{
			$this->paginate = array(
			'limit'=>1,
			'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.category_id', 'User.user_name', 'Categorie.category_name'),
			'conditions'=>array('Lesson.lock_flag'=>false)
			);
			$this->set('title_for_layout', '授業リスト');	
		}
		
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		$this->showLayout();
		
	}

	//カテゴリで検索された授業
	public function lessons_by_category($category=null){
		//debug($this->Auth->User());
		$this->paginate = array(
			'limit'=>1,
			'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'Lesson.category_id', 'User.user_name', 'Categorie.category_name'),
			'conditions'=>array('Categorie.category_name'=>$category)
			);
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		$this->showLayout();	
		$this->set('title_for_layout', $category.'カテゴリを含む授業');
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
					'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.category_id', 'Lesson.create_user_id', 'User.user_name', 'Categorie.category_name'),
					'conditions'=>array('User.user_name LIKE'=>'%'.$keyword.'%')
				);
		   		break;

		   	case 'lesson':
		   		$this->paginate = array(
					'limit'=>1,
					'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'Lesson.category_id', 'User.user_name', 'Categorie.category_name'),
					'conditions'=>array('Lesson.lesson_name LIKE'=>'%'.$keyword.'%')
				);
		   		break;

		   	case 'category':
				$this->paginate = array(
					'limit'=>1,
					'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'Lesson.category_id', 'User.user_name', 'Categorie.category_name'),
					'conditions'=>array('Categorie.category_name LIKE'=>'%'.$keyword.'%')
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
					set lock_flag=true
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
			'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.category_id', 'User.user_name', 'Categorie.category_name'),
			'conditions'=>array('Lesson.id'=>$idArray)
		);
		//debug($idArray);die();
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		$this->showLayout();	
		$this->set('title_for_layout', '勉強した授業リスト');	
	}

}
?>

