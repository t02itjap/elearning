<?php
class LessonsController extends AppController {
	var $uses = array('User', 'Lesson', 'Bill', 'LessonOfCategory', 'BannedStudent', 'ChangeableValue');
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
		$this->Auth->allow ( array ('home', 'login', 'register', 'search_result2' ) );
	}

	//ユーザのホームページにある授業リスト
	public function view_all_lessons(){
		//先生のホームページに別の先生のすべて授業だけ
		//debug($this->LessonOfCategory->getLIdAndCName());die();
		switch ($this->Auth->User('level')) {
			case '1':
				$this->paginate = array(
				'limit'=>3,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array('Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);		
				break;

			case '2':
				$this->paginate = array(
				'limit'=>3,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array('Lesson.create_user_id !='=>$this->Auth->User('id'), 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);	
				break;

			case '3':
				$teacherIds=$this->BannedStudent->find('all', array(
						'fields'=>array('BannedStudent.teacher_id'),
						'conditions'=>array('BannedStudent.student_id'=>$this->Auth->User('id'))
				));
				//debug($teacherIds);die();
				foreach ($teacherIds as $key) {
					$teacherIdSet[]=$key['BannedStudent']['teacher_id'];
				}
				//debug($teacherIdSet);die();
				$this->paginate = array(
				'limit'=>3,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array('Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false, 'NOT'=>array('Lesson.create_user_id'=>$teacherIdSet))
				);		
				break;
			default:
				# code...
				break;
		}

		//debug($lessonCost[0]['ChangeableValue']['current_value']);die();
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		//get lesson cost
		$lessonCost=$this->ChangeableValue->find('all', array(
			'fields'=>array('ChangeableValue.current_value'),
			'conditions'=>array('ChangeableValue.id'=>6)
			));
		$this->set ('cost', $lessonCost[0]['ChangeableValue']['current_value']);
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
		//get lesson cost
		$lessonCost=$this->ChangeableValue->find('all', array(
			'fields'=>array('ChangeableValue.current_value'),
			'conditions'=>array('ChangeableValue.id'=>6)
			));
		$this->set ('cost', $lessonCost[0]['ChangeableValue']['current_value']);
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
		if($this->Auth->User('level')==3){
			$teacherIds=$this->BannedStudent->find('all', array(
						'fields'=>array('BannedStudent.teacher_id'),
						'conditions'=>array('BannedStudent.student_id'=>$this->Auth->User('id'))
			));
			foreach ($teacherIds as $key) {
				$teacherIdSet[]=$key['BannedStudent']['teacher_id'];
			}
			$this->paginate = array(
			'limit'=>1,
			'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
			'conditions'=>array('Lesson.id'=>$lessons_id, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false, 'NOT'=>array('Lesson.create_user_id'=>$teacherIdSet))
			);	
		}
		else{
			$this->paginate = array(
			'limit'=>1,
			'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
			'conditions'=>array('Lesson.id'=>$lessons_id, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
			);	
		}
		
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		//get lesson cost
		$lessonCost=$this->ChangeableValue->find('all', array(
			'fields'=>array('ChangeableValue.current_value'),
			'conditions'=>array('ChangeableValue.id'=>6)
			));
		$this->set ('cost', $lessonCost[0]['ChangeableValue']['current_value']);
		$this->showLayout();
		$this->set('title_for_layout', $category_name.'カテゴリを含む授業');
	}

	public function search_result1(){
		if(!empty($this->data)&&
			($this->request->data['teacher_name']!=null||
				$this->request->data['course_name']!=null||
				$this->request->data['category_name'])){
			$teacher_name=$this->request->data['teacher_name'];
			$course_name=$this->request->data['course_name'];
			$category_name=$this->request->data['category_name'];
			$this->Session->write('teacher_name', $teacher_name);
			$this->Session->write('course_name', $course_name);
			$this->Session->write('category_name', $category_name);
		}
		else{
			if($this->Session->check('teacher_name')&&$this->Session->check('course_name')&&$this->Session->check('category_name')){
				$teacher_name=$this->Session->read('teacher_name');
				$course_name=$this->Session->read('course_name');
				$category_name=$this->Session->read('category_name');
			}
		}

		//start search
		if($teacher_name!=null&&$course_name==null&&$category_name==null){
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
				'conditions'=>array('User.user_name LIKE'=>'%'.$teacher_name.'%', 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
		}
		if($teacher_name==null&&$course_name!=null&&$category_name==null){
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
				'conditions'=>array('Lesson.lesson_name LIKE'=>'%'.$course_name.'%', 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
		}
		if($teacher_name==null&&$course_name==null&&$category_name!=null){
			$lIdAndCName=$this->LessonOfCategory->getLIdAndCName1($category_name);
			$lessons_id = Array();
			foreach($lIdAndCName as $key){
				$lessons_id[] = $key['LessonOfCategory']['lesson_id'];
			}
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
				'conditions'=>array('Lesson.id'=>$lessons_id, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
		}
		if($teacher_name!=null&&$course_name!=null&&$category_name==null){
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
				'conditions'=>array('User.user_name LIKE'=>'%'.$teacher_name.'%', 'Lesson.lesson_name LIKE'=>'%'.$course_name.'%',
								'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
		}
		if($teacher_name!=null&&$course_name==null&&$category_name!=null){
			$lIdAndCName=$this->LessonOfCategory->getLIdAndCName1($category_name);
			$lessons_id = Array();
			foreach($lIdAndCName as $key){
				$lessons_id[] = $key['LessonOfCategory']['lesson_id'];
			}
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
				'conditions'=>array('Lesson.id'=>$lessons_id, 'User.user_name LIKE'=>'%'.$teacher_name.'%',
								'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
		}
		if($teacher_name==null&&$course_name!=null&&$category_name!=null){
			$lIdAndCName=$this->LessonOfCategory->getLIdAndCName1($category_name);
			$lessons_id = Array();
			foreach($lIdAndCName as $key){
				$lessons_id[] = $key['LessonOfCategory']['lesson_id'];
			}
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
				'conditions'=>array('Lesson.id'=>$lessons_id, 'Lesson.lesson_name LIKE'=>'%'.$course_name.'%',
								'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
		}
		if($teacher_name!=null&&$course_name!=null&&$category_name!=null){
			$lIdAndCName=$this->LessonOfCategory->getLIdAndCName1($category_name);
			$lessons_id = Array();
			foreach($lIdAndCName as $key){
				$lessons_id[] = $key['LessonOfCategory']['lesson_id'];
			}
			$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
				'conditions'=>array('Lesson.id'=>$lessons_id, 'Lesson.lesson_name LIKE'=>'%'.$course_name.'%',
								'User.user_name LIKE'=>'%'.$teacher_name.'%',
								'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
				);
		}

		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		$this->showLayout();
		$this->set('title_for_layout', '検索結果'); 
	}
	
	public function search_result2(){
		$isand=false;
		if(!empty($this->data)&&$this->request->data['keyword']!=null){
			$keyword=$this->request->data['keyword'];
			$type=$this->data['Lesson']['type'];
			$this->Session->write('keyword', $keyword);
			$this->Session->write('type', $type);
			//debug($keyword);
			//debug($type);die();
		}
		else if($this->Session->check('keyword')&&$this->Session->check('type')){
			$keyword=$this->Session->read('keyword');
			$type=$this->Session->read('type');
			//debug($keyword);
		}
		$andpos=strpos($keyword, '+');
		$orpos=strpos($keyword, '-');
		
		if(($andpos!=0&&$orpos!=0&&$andpos<=$orpos)||$orpos==0)
		{
			$keywords=explode('+', $keyword);
			$isand=true;
		}
		else{
			$keywords=explode('-', $keyword);
			$isand=false;
		}
		
		//debug($keywords);
		switch ($type) {
			case 'teacher':
			foreach ($keywords as $key) {
				$condition1[]=array('User.user_name LIKE'=>'%'.$key.'%');
			}
			if($isand){
				$conditions=array($condition1, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false);		
			}
			else
				$conditions=array('OR'=>$condition1, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false);

			if($this->Auth->User('level')==3){
				$teacherIds=$this->BannedStudent->find('all', array(
							'fields'=>array('BannedStudent.teacher_id'),
							'conditions'=>array('BannedStudent.student_id'=>$this->Auth->User('id'))
				));
				foreach ($teacherIds as $key) {
					$teacherIdSet[]=$key['BannedStudent']['teacher_id'];
				}
				$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array($conditions, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false, 'NOT'=>array('Lesson.create_user_id'=>$teacherIdSet))
				);	
			}
			else
				$this->paginate = array(
					'limit'=>1,
					'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
					'conditions'=>array($conditions, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
					);
			break;

			case 'lesson':
			foreach ($keywords as $key) {
				$condition1[]=array('Lesson.lesson_name LIKE'=>'%'.$key.'%');
			}
			if($isand){
				$conditions=array($condition1, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false);		
			}
			else
				$conditions=array('OR'=>$condition1, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false);
			if($this->Auth->User('level')==3){
				$teacherIds=$this->BannedStudent->find('all', array(
							'fields'=>array('BannedStudent.teacher_id'),
							'conditions'=>array('BannedStudent.student_id'=>$this->Auth->User('id'))
				));
				foreach ($teacherIds as $key) {
					$teacherIdSet[]=$key['BannedStudent']['teacher_id'];
				}
				$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array($conditions, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false, 'NOT'=>array('Lesson.create_user_id'=>$teacherIdSet))
				);	
			}
			else
				$this->paginate = array(
					'limit'=>1,
					'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
					'conditions'=>array($conditions, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
					);
			break;

			case 'category':
			$lIdAndCName=$this->LessonOfCategory->getLIdAndCName2($keyword);
			$lessons_id = Array();
			foreach($lIdAndCName as $key){
				$lessons_id[] = $key['LessonOfCategory']['lesson_id'];
			}
			if($this->Auth->User('level')==3){
				$teacherIds=$this->BannedStudent->find('all', array(
							'fields'=>array('BannedStudent.teacher_id'),
							'conditions'=>array('BannedStudent.student_id'=>$this->Auth->User('id'))
				));
				foreach ($teacherIds as $key) {
					$teacherIdSet[]=$key['BannedStudent']['teacher_id'];
				}
				$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array('Lesson.id'=>$lessons_id, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false, 'NOT'=>array('Lesson.create_user_id'=>$teacherIdSet))
				);	
			}
			else
				$this->paginate = array(
					'limit'=>1,
					'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
					'conditions'=>array('Lesson.id'=>$lessons_id, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
					);
			break;

			case 'description':
			foreach ($keywords as $key) {
				$condition1[]=array('Lesson.description LIKE'=>'%'.$key.'%');
			}
			if($isand){
				$conditions=array($condition1, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false);		
			}
			else
				$conditions=array('OR'=>$condition1, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false);
			if($this->Auth->User('level')==3){
				$teacherIds=$this->BannedStudent->find('all', array(
							'fields'=>array('BannedStudent.teacher_id'),
							'conditions'=>array('BannedStudent.student_id'=>$this->Auth->User('id'))
				));
				foreach ($teacherIds as $key) {
					$teacherIdSet[]=$key['BannedStudent']['teacher_id'];
				}
				$this->paginate = array(
				'limit'=>1,
				'fields'=> array('Lesson.id', 'Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'User.user_name'),
				'conditions'=>array($conditions, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false, 'NOT'=>array('Lesson.create_user_id'=>$teacherIdSet))
				);	
			}
			else
				$this->paginate = array(
					'limit'=>1,
					'fields'=> array('Lesson.lesson_name', 'Lesson.description', 'Lesson.create_date', 'Lesson.create_user_id', 'User.user_name'),
					'conditions'=>array($conditions, 'Lesson.delete_flag'=>false, 'Lesson.lock_flag'=>false)
					);
			break;

			default:
		   		# code...
			break;
		}
		$lessons = $this->paginate('Lesson');
		$this->set ( compact ( 'lessons' ));
		//get lesson cost
		$lessonCost=$this->ChangeableValue->find('all', array(
			'fields'=>array('ChangeableValue.current_value'),
			'conditions'=>array('ChangeableValue.id'=>6)
			));
		$this->set ('cost', $lessonCost[0]['ChangeableValue']['current_value']);
		$this->showLayout();
		$this->set('title_for_layout', '検索結果');  
	}
	//検索ボックスで検索された授業
	public function search_result(){
		if(!empty($this->data)&&$this->request->data['keyword']!=null){
			$keyword=$this->request->data['keyword'];
			$type=$this->data['Lesson']['type'];
			$this->Session->write('keyword', $keyword);
			$this->Session->write('type', $type);
			//debug($keyword);
			//debug($type);die();
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
		//get lesson cost
		$lessonCost=$this->ChangeableValue->find('all', array(
			'fields'=>array('ChangeableValue.current_value'),
			'conditions'=>array('ChangeableValue.id'=>5)
			));
		$this->set ('cost', $lessonCost[0]['ChangeableValue']['current_value']);
		$this->showLayout();	
		$this->set('title_for_layout', '勉強した授業リスト');	
	}

}
?>
