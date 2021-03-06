<?php
App::uses ( 'DboSource', 'Model/Datasource' );

/**
 * User controller for login,logout,...
 */
class StudentsController extends AppController {
	var $costId = 6;
	public $name = "Students";
	// <<<<<<< HEAD
	var $uses = array (
			'BannedStudent',
			'Bill',
			'Category',
			'ChangeableValue',
			'Comment',
			'User',
			'InitialUser',
			'Verifycode',
			'InitialVerifycode',
			'IpAddress',
			'Test',
			'Lesson',
			'Document',
			'LearnHistory',
			'LessonOfCategory',
			'TestHistory',
			'LockedUser' 
	);
	var $helpers = array (
			'Html',
			'Form',
			'Editor',
			'Csv' 
	);
	public $components = array (
			'RequestHandler' 
	);
	public function beforeFilter() {
		parent::beforeFilter ();
		$this->layout = 'student';
		$this->Auth->authorize = 'Controller';
	}
	function isAuthorized() {
		if ($this->Auth->user ( 'level' ) == 3)
			return true;
		else {
			$this->Session->setFlash ( "Access deny" );
			$this->redirect ( $this->redirect ( array (
					"controller" => "users",
					"action" => "logout" 
			) ) );
			return false;
		}
	}
	function changePass() {
		$this->set ( 'title_for_layout', 'パスワードを変更する。' );
		if ($this->request->is ( 'post' )) {
			$data = $this->request->data;
			if (sha1 ( $this->Auth->user ( 'user_name' ) . $data ['User'] ['pass1'] . 'sha1' ) == $this->User->field ( "password", array (
					"id" => $this->Auth->user ( "id" ) 
			) )) {
				$this->User->id = $this->Auth->user ( 'id' );
				$this->User->set ( 'password', sha1 ( $this->Auth->user ( 'user_name' ) . $data ['User'] ['pass2'] . 'sha1' ) );
				$this->User->save ();
				$this->Session->setFlash ( 'パスワード変更が成功した' );
			} else
				$this->Session->setFlash ( '現在パスワードが間違う' );
		}
	}
	public function change_info() {
		$forPass = 'sha1';
		$this->set ( 'title_for_layout', '個人情報を変更する' );
		$forPass = 'sha1';
		$student = $this->User->find ( 'first', array (
				'conditions' => array (
						'User.id' => $this->Auth->user ( 'id' ) 
				) 
		) );
		$this->set ( compact ( 'student' ) );
		if (isset ( $this->request->data ['submit_data'] )) {
			$data = $this->request->data;
			$checkPassword = sha1 ( $student ['User'] ['user_name'] . $data ['User'] ['password'] . $forPass );
			if ($checkPassword == $student ['User'] ['password']) {
				$bankCode = $data ['User'] ['cardPart1'] . '-' . $data ['User'] ['cardPart2'] . '-' . $data ['User'] ['cardPart3'] . '-' . $data ['User'] ['cardPart4'] . '-' . $data ['User'] ['cardPart5'];
				if ($student ['User'] ['email'] == $data ['User'] ['email'] && $student ['User'] ['phone_number'] == $data ['User'] ['phone_number'] && $student ['User'] ['address'] == $data ['User'] ['address'] && $student ['User'] ['bank_account_code'] == $bankCode) {
					$this->Session->setFlash ( '情報を変更しなかった。' );
					$this->redirect ( array (
							'controller' => 'Students',
							'action' => 'change_info' 
					) );
				} else {
					$bankCode = $data ['User'] ['cardPart1'] . '-' . $data ['User'] ['cardPart2'] . '-' . $data ['User'] ['cardPart3'] . '-' . $data ['User'] ['cardPart4'] . '-' . $data ['User'] ['cardPart5'];
					$this->User->set ( array (
							'bank_account_code' => $bankCode,
							'address' => $data ['User'] ['address'],
							'phone_number' => $data ['User'] ['phone_number'] 
					) );
					if ($student ['User'] ['email'] != $data ['User'] ['email']) {
						$this->User->set ( array (
								'email' => $data ['User'] ['email'] 
						) );
					}
					if ($this->User->validates ()) {
						$this->User->id = $student ['User'] ['id'];
						if ($this->User->save ()) {
							$this->Session->setFlash ( '情報を変更することが成功です。' );
							$this->redirect ( array (
									'controller' => 'Students',
									'action' => 'change_info' 
							) );
						}
					}
				}
			} else {
				$this->Session->setFlash ( 'インプットパスワードが間違い' );
				$this->redirect ( array (
						'controller' => 'Students',
						'action' => 'change_info' 
				) );
			}
		}
		if (isset ( $this->request->data ['delete_student'] )) {
			if ($this->Lesson->deleteVoter($student ['User'] ['id']) && $this->Lesson->deleteReporter($student ['User'] ['id']) && $this->User->deleteUser ( $student ['User'] ['id'] ) && $this->TestHistory->deleteTestHistoryByUserId ( $student ['User'] ['id'] ) && $this->InitialUser->deleteInitialUserByUserId ( $student ['User'] ['id'] ) && $this->Comment->deleteCommentByUserId ( $student ['User'] ['id'] ) && $this->Bill->deleteBillByUserid ( $student ['User'] ['id'] ) && $this->BannedStudent->deleteRecordBystudentId ( $student ['User'] ['id'] )) {
				$this->Session->destroy ();
				$this->Session->setFlash ( 'このアカウントが今削除です' );
				$this->redirect ( array (
						'controller' => 'Users',
						'action' => 'login' 
				) );
			}
		}
	}
	public function home() {
		// debug($this->Auth->user());
	}
	public function view_lesson_to_learn($id) {
		if (! isset ( $id )) {
			throw new NotFoundException ( '404 not found' );
		}
		
		$reporters = $this->Lesson->field ( 'copyright_reporters', array (
				'id' => $id 
		) );
// 		debug($reporters);die();
		$isCopyright = true;
		if (!empty ( $reporters )) {
				$reporter = explode ( ',', $reporters );
// 				debug($reporter);die();
			
			if (in_array ( $this->Auth->user ( 'id' ), $reporter )) {
				$isCopyright = false;
			}
		}
		$this->set ( 'isCopyright', $isCopyright );
// 		debug($isCopyright);
		$data = $this->Lesson->findById ( $id );
		$user_id = $this->Auth->user ( 'id' );
		$lesson = $this->Lesson->find ( 'first', array (
				'conditions' => array (
						'Lesson.id' => $id 
				) 
		) );
		$category = $this->LessonOfCategory->find ( 'all', array (
				'conditions' => array (
						'lesson_id' => $id 
				) 
		) );
		if (! $data) {
			throw new NotFoundException ( 'Can`t find Lesson' );
		}
		//Copyright
		if (isset($this->request->data['submit_data'])){
			$this->Lesson->id=$id;
			if($this->Lesson->field('copyright_violation') == 0 ){
				$this->Lesson->set(array('copyright_violation'=>1));
			}
			$this->Lesson->set(array('copyright_reporters'=>($this->Lesson->field('copyright_reporters').','.$this->Auth->user('id'))));
			$this->Lesson->save();
			$this->Session->setFlash('Copyright違反を報告成功した');
			$this->redirect(array('controller'=>'students','action'=>'view_lesson_to_learn',$id));
		}
		// check bill
		$flag = false;
		$tmp = $this->Bill->find ( 'first', array (
				'conditions' => array (
						'lesson_id' => $id,
						'user_id' => $this->Auth->user ( 'id' ) 
				) 
		) );
		if ($tmp) {
			$flag = true;
		}
		$this->set ( 'id', $id );
		$this->set ( 'user_id', $this->Auth->user ( 'id' ) );
		$this->set ( 'flag', $flag );
		$this->set ( 'lesson', $lesson );
		$this->set ( 'category', $category );
		$lessonCost = $this->ChangeableValue->find ( 'all', array (
				'fields' => array (
						'ChangeableValue.current_value' 
				),
				'conditions' => array (
						'ChangeableValue.id' => $this->costId 
				) 
		) );
		$this->set ( 'cost', $lessonCost [0] ['ChangeableValue'] ['current_value'] );
		// like
		$likeString = $data ['Lesson'] ['voters'];
		$flagLike = false;
		$countLike = 0;
		if ($likeString != '') {
			$liked_user_id_array = explode ( ',', $likeString );
			if (strlen ( $likeString ) == 1) {
				$countLike = 1;
			} else {
				$countLike = count ( $liked_user_id_array );
			}
			if (in_array ( $user_id, $liked_user_id_array )) {
				$flagLike = true;
			}
		}
		$this->set ( 'flagLike', $flagLike );
		$this->set ( 'countLike', $countLike );
	}
	public function likeLesson() {
		if (isset ( $_POST )) {
			$tmpData = $this->Lesson->findById ( $_POST ['lesson_id'] );
			$votersString = $tmpData ['Lesson'] ['voters'];
			if ($votersString != '') {
				$votersString .= ',';
			}
			$votersString .= $_POST ['user_id'];
			$this->Lesson->id = $_POST ['lesson_id'];
			$this->Lesson->set ( 'voters', $votersString );
			$this->Lesson->save ();
		}
		die ();
	}
	public function payForLesson() {
		$this->autoRender = false;
		if (isset ( $_POST )) {
			$data = $_POST;
			$teacherIds = $this->BannedStudent->find ( 'all', array (
					'fields' => array (
							'BannedStudent.teacher_id' 
					),
					'conditions' => array (
							'BannedStudent.student_id' => $this->Auth->User ( 'id' ) 
					) 
			) );
			foreach ( $teacherIds as $key ) {
				$teacherIdSet [] = $key ['BannedStudent'] ['teacher_id'];
			}
			$ownerId = $this->Lesson->field ( 'Lesson.create_user_id', array (
					'id' => $data ['lesson_id'] 
			) );
			if (! empty ( $teacherIdSet ) && in_array ( $ownerId, $teacherIdSet )) {
				echo '1';
			} else {
				$this->Bill->create ();
				$lessonCost = $this->ChangeableValue->find ( 'all', array (
						'fields' => array (
								'ChangeableValue.current_value' 
						),
						'conditions' => array (
								'ChangeableValue.id' => $this->costId 
						) 
				) );
				$this->Bill->set ( 'lesson_cost', $lessonCost [0] ['ChangeableValue'] ['current_value'] );
				$this->Bill->set ( 'learn_date', date ( 'Y/m/d H:i' ) );
				// echo '2'; die();
				if ($this->Bill->save ( $data )) {
					echo '2';
				} else
					echo '3';
			}
		}
		die ();
	}
	public function getFees() {
		$this->set ( 'title_for_layout', '課金情報' );
		if ($this->request->is ( 'post' )) {
			$year = $this->data ['YearMonth'] ['year'] ['year'];
			$month = $this->data ['YearMonth'] ['month'] ['month'];
			if ($year != "" && $month != "") {
				$time = $year . '-' . $month;
			} else {
				$time = date ( 'Y-m' );
			}
			
			$this->Session->write ( 'time', $time );
		}
		$time = $this->Session->read ( 'time' );
		// debug($time);
		if (empty ( $time )) {
			$time = date ( 'Y-m' );
			$this->Session->write ( 'time', $time );
		}
		
		$temp2 = $this->Bill->find ( 'all', array (
				'conditions' => array (
						'Bill.user_id' => $this->Auth->user ( 'id' ),
						'Bill.learn_date LIKE ' => $time . '%' 
				) 
		) );
		
		$this->set ( 'temp2', $temp2 );
		$sum = 0;
		foreach ( $temp2 as $item ) {
			$sum += $item ['Bill'] ['lesson_cost'];
		}
		$this->set ( 'sum', $sum );
		// debug($temp2);
		// debug($sum);
		$this->paginate = array (
				'limit' => 10,
				'conditions' => array (
						'Bill.user_id' => $this->Auth->user ( 'id' ),
						'Bill.learn_date LIKE ' => $time . '%' 
				) 
		);
		$data = $this->paginate ( 'Bill' );
		// $this->set('data', $data);
		// debug($data);
		$this->Session->write ( 'data', $data );
	}
	public function getTestHistories() {
		$this->TestHistory->recursive = 2;
		$this->paginate = array (
				'limit' => 10,
				'conditions' => array (
						'TestHistory.user_id' => $this->Auth->user ( 'id' ) 
				) 
		);
		$data = $this->paginate ( 'TestHistory' );
		$this->set ( 'data', $data );
	}
	public function category() {
		$this->paginate = array (
				'limit' => 3,
				'fields' => array (
						'Category.id',
						'Category.category_name' 
				) 
		// 'order'=>'Category.category_name'
				);
		$categoryList = $this->paginate ( 'Category' );
		$this->set ( compact ( 'categoryList' ) );
	}
	function exportBill($time) {
		$temp2 = $this->Bill->find ( 'all', array (
				'conditions' => array (
						'Bill.user_id' => $this->Auth->user ( 'id' ),
						'Bill.learn_date LIKE ' => $time . '%' 
				) 
		) );
		$this->set ( 'temp2', $temp2 );
		$this->layout = null;
		$this->autoLayout = false;
	}
}

?>