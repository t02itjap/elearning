<?php
class TeachersController extends AppController {
    public $name = "Teachers";
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
    var $helpers = array('Html', 'Form', 'Editor');
    public $components = array('Paginator', 'RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'teacher';
        $this->Auth->authorize = 'Controller';
    }

    public function isAuthorized() {
        if ($this->Auth->user('level') == 2 || $this->Auth->user('level') == 1)
            return true;
        else {
            $this->Session->setFlash("Access deny");
            $this->redirect($this->redirect(array("controller" => "users", "action" => "logout")));
            return false;
        }
    }

    public function summary($id = 1) {
        $this->set('title_for_layout', '授業サマリー');
        // get lesson summary info
        $lesson = $this->Lesson->find('first', array(
            'conditions' => array(
                'Lesson.id' => $id
            ),
            'fields' => array(
                'viewers',
                'voters'
            )
                ));

        $lesson ['Lesson'] ['voters'] = explode(",", $lesson ['Lesson'] ['voters']);
        $lesson ['Lesson'] ['vote_count'] = count($lesson ['Lesson'] ['voters']);

        $snum = $this->Bill->find("count", array(
            'conditions' => array(
                'lesson_id' => $id
            ),
            'group' => array(
                'user_id'
            )
                ));

        // get learned student
        $this->paginate = array(
            'fields' => array(
                'user_id',
                'learn_date'
            ),
            'conditions' => array(
                'lesson_id' => $id
            )
        );

        $students = $this->paginate('Bill');
        $this->set('lesson', $lesson);
        $this->set('snum', $snum);
        $i = - 1;
        foreach ($students as $s) {
            $i++;
            $info = $this->User->field('user_name', array(
                'id' => $s ['Bill'] ['user_id']
                    ));
            $students [$i] ['Bill'] ['user_name'] = $info;
        }

        $this->set(compact('students'));
        // get ban student list
        $this->paginate = array(
            'limit' => 5,
            'conditions' => array(
                'teacher_id' => $this->Auth->user('id')
            )
        );

        $banList = $this->paginate('BannedStudent');

        $this->set(compact('banList'));

        // block button action
        if ($this->request->is('post')) {
            if (isset($this->request->data ['block'])) {
                $ban = $this->request->data;
                if (!$stu = $this->User->find('first', array(
                    'conditions' => array(
                        'user_name' => $ban ['BannedStudent'] ['StudentName'],
                        'level' => 3
                    )
                        ))) {
                    $this->Session->setFlash("ユーザネームが存在しない");
                    return;
                }
                if (!$this->BannedStudent->isBanned($ban ['BannedStudent'] ['StudentName'])) {
                    $this->BannedStudent->create();
                    $this->BannedStudent->set(array(
                        'teacher_id' => $this->Auth->user('id'),
                        'student_id' => $stu ['User'] ['id'],
                        'reason' => $ban ['BannedStudent'] ['Reason'],
                        'banned_date'=>date("Y-m-d h:i:s", time())
                    ));
                    $this->BannedStudent->save();
                    $this->Session->setFlash('ブロックが成功した');
                    $this->redirect(array('controller' => 'teachers', 'action' => 'summary', $lesson['Lesson']['id']));
                } else {
                    $this->Session->setFlash("ユーザネームがブロックした");
                }
            }
        }
    }

    public function unblock($banId, $lessonId) {
        $this->autoRender = false;
        $this->BannedStudent->delete($banId);
        $this->redirect(array('controller' => 'Teachers', 'action' => 'summary', $lessonId));
    }

    public function change_info() {
        $this->set('title_for_layout', '個人情報を変更する');
        $forPass = 'sha1';
        $teacher = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id'))));
        $this->set(compact('teacher'));
        if (isset($this->request->data ['submit_data'])) {
            $data = $this->request->data;
            $checkPassword = sha1($teacher ['User'] ['user_name'] . $data ['User'] ['password'] . $forPass);
            if ($checkPassword == $teacher ['User'] ['password']) {
                $bankCode = $data ['User'] ['bankCodePart1'] . '-' . $data ['User'] ['bankCodePart2'] . '-' . $data ['User'] ['bankCodePart3'] . '-' . $data ['User'] ['bankCodePart4'];
                if ($teacher ['User'] ['email'] == $data ['User'] ['email'] && $teacher ['User'] ['phone_number'] == $data ['User'] ['phone_number'] && $teacher ['User'] ['address'] == $data ['User'] ['address'] && $teacher ['User'] ['bank_account_code'] == $bankCode) {
                    $this->Session->setFlash('情報を変更しなかった。');
                    $this->redirect(array('controller' => 'Teachers', 'action' => 'change_info'));
                } else {
                    $this->User->set(array('bank_account_code' => $bankCode, 'address' => $data ['User'] ['address'], 'phone_number' => $data ['User'] ['phone_number']));
                    if ($teacher ['User'] ['email'] != $data ['User'] ['email']) {
                        $this->User->set(array('email' => $data ['User'] ['email']));
                    }
                    if ($this->User->validates()) {
                        $this->User->id = $teacher ['User'] ['id'];
                        if ($this->User->save()) {
                            $this->Session->setFlash('情報を変更することが成功です。');
                            $this->redirect(array('controller' => 'Teachers', 'action' => 'change_info'));
                        }
                    }
                }
            } else {
                $this->Session->setFlash('インプットパスワードが間違い');
                $this->redirect(array('controller' => 'Teachers', 'action' => 'change_info'));
            }
        }
        if (isset($this->request->data ['delete_teacher'])) {
        	if ($this->User->deleteUser($teacher['User']['id']) &&
            	$this->Verifycode->deleteVerifycodeByUserId($teacher['User']['id']) &&
            	$this->Test->deleteTestByUserId($teacher['User']['id']) &&
            	$this->Lesson->deleteLessonByTeacherId($teacher['User']['id']) &&
            	$this->InitialVerifycode->deleteInitialVerifycodeByUserId($teacher['User']['id']) &&
            	$this->InitialUser->deleteInitialUserByUserId($teacher['User']['id']) &&
            	$this->Document->deleteDocumentByUserId($teacher['User']['id']) &&
            	$this->Comment->deleteCommentByUserId($teacher['User']['id']) &&
            	$this->BannedStudent->deleteRecordByTeacherId($teacher['User']['id'])){
            		$this->Session->destroy ();
                	$this->Session->setFlash('このアカウントが今削除です');
                	$this->redirect(array('controller' => 'Users', 'action' => 'login'));
            }
        }
    }

    function changeVerify() {
    	$this->set('title_for_layout','Verifyコード変更');
        $id = $this->Auth->user('id');
        $teacher = $this->Verifycode->find('first', array(
            'conditions' => array(
                'user_id' => $id
            )
                ));
        $this->set(compact('teacher'));

        if ($this->request->is('post')) {
            $data = $this->request->data;
            if (sha1($this->Auth->user('user_name') . $data ['User'] ['verifycode1'] . 'sha1') == $teacher ['Verifycode'] ['verifycode']) {
                $this->Verifycode->id = $this->Verifycode->field('id',array('user_id'=>$this->Auth->user('id')));
                
                $this->Verifycode->set(array(
                		'question' => base64_encode($data['User']['question1']),
                		'verifycode'=> sha1($this->Auth->user('user_name') . $data ['User'] ['verifycode2'] . 'sha1')));
                $this->Verifycode->save();
                $this->Session->setFlash('Verifyコード変更が成功した');
                $this->redirect('changeVerify');
            } else {
                $this->Session->setFlash('現在Verifyコードが間違う');
            }
        }
    }

    function changePass() {
        $this->set('title_for_layout', 'パスワードを変更する。');
        if ($this->request->is('post')) {
            $data = $this->request->data;
            // debug($this->Auth->user('password'));
            if (sha1($this->Auth->user('user_name') . $data ['User'] ['pass1'] . 'sha1') == $this->User->field('password', array(
                        'id' => $this->Auth->user('id')
                    ))) {
                $this->User->id = $this->Auth->user('id');
                $this->User->set('password', sha1($this->Auth->user('user_name') . $data ['User'] ['pass2'] . 'sha1'));
                $this->User->save();
                $this->Session->setFlash('パスワード変更が成功した');
            } else
                $this->Session->setFlash('現在パスワードが間違う');
        }
    }

    function home() {
        //debug($this->Auth->user());
    }

    public function createNewCategory() {
//      新しいカテゴリを作成する機能
        if (isset($_POST['name'])) {
            $category = $this->Category->find('first', array(
                'conditions' => array(strtolower('category_name') => strtolower($_POST['name']))
                    ));
            if ($category) {
                $data['error'] = 'このカテゴリーが存在でした。';
                echo json_encode($data);
            } else {
                $data = array('category_name' => $_POST['name']);   //新しいデータベースを作成
                $this->Category->create();
                $this->Category->save($data);                       //データベースにデータを保存する
                $data['id'] = $this->Category->id;
                $data['name'] = $_POST['name'];
                echo json_encode($data);
            }
        }

        die; //デバッグのため停止
    }

    public function create_course() {
        //新しいレッスンを作成する 
        $this->set('title_for_layout', '新しい授業を作ること');
        $categories = $this->Category->find('all');
        $this->set('categories', $categories);
        $user_id = $this->Auth->user('id');
        //カテゴリテーブルを取得
        //$categoriesOfLesson = $this->LessonOfCategory->find('all');

        if (isset($this->request->data['ok'])) {                //教師のユーザーのクリックを提出した場合
            //debug($this->request->data);                        //データがプログラマに表示さ
            $data = $this->request->data;
            $bug = 0;
            if(!isset($data['Lesson']['category'])){
            	$bug = 1;
            	$this->set('notHaveCategoryMessage', '<br><span>カテゴリーを作ってください。</span></br>');
            }
            $checkCate = 0;
            if(isset($data['Lesson']['category'])){
                for($i = 0;$i < count($data['Lesson']['category']);$i++){
            		if($data['Lesson']['category'][$i] != 0){
            			$checkCate = 1;
            			break;
            		}
            	}	
            }
            if($checkCate == 0){
            	$bug = 1;
				$this->set('notCheckCategoryMessage', '<br><span>カテゴリーを選んでください。<br></span>');
            }
            $uploadData = $data['Lesson']['file_link_document'];
            foreach ($uploadData as $upData) {
                //debug($upData);
                if($upData['name'] != NULL){
                	$this->Document->create();
                	//新しいドキュメントのテーブルのデータベースを作成する 
                	if ($this->Document->checkValid($upData['name'], $user_id) == false){
                    	$bug = 1;
                		$err = '<br><span>このファイルが存在でした、あるいはこのファイルの形態が間違いです。<span></br>';
                   		$this->set(compact('err'));
                	}
            	}
            }
            //検証]をチェックし、新しいドキュメントをアップロードする 

            $uploadData1 = $data['Lesson']['file_link_test'];
            foreach ($uploadData1 as $upData) {
                if($upData['name'] != NULL){
                	$this->Test->create();
                	//新しいドキュメントのテーブルのデータベースを作成する 
                	if ($this->Test->checkValid($upData['name'], $user_id) == false) {
                    	$bug = 1;
                		$err1 = '<br><span>このファイルが存在でした、あるいはこのファイルの形態が間違いです。<span></br>';
                    	$this->set(compact('err1'));	
                	}
                }
            }
            $this->Lesson->set(array(
                'lesson_name' => $data['Lesson']['Name'],
                'description' => $data['Lesson']['Description'],
                'create_user_id' => $this->Auth->user('id'),
                'create_date' => date('Y/m/d H:i:s'),
            ));
            if($this->Lesson->validates() == false){
            	$bug = 1;
            }
            //新しいレッスンのテーブルのデータベースを作成する 
			if($bug == 0){
				$this->Lesson->set(array(
	                'lesson_name' => $data['Lesson']['Name'],
	                'description' => $data['Lesson']['Description'],
	                'create_user_id' => $this->Auth->user('id'),
	                'create_date' => date('Y/m/d H:i:s'),
	            	));
				$this->Lesson->save();
            	$lesson_id = $this->Lesson->id;
            	foreach ($data['Lesson']['category'] as $value) {
                	if ($value != '0') {
                    	$this->LessonOfCategory->create();
                    	$this->LessonOfCategory->set('lesson_id', $lesson_id);
                    	$this->LessonOfCategory->set('category_id', $value);
                    	$this->LessonOfCategory->save();
                	}
            	}
			    //データベースにデータを保存する
            	$uploadData = $data['Lesson']['file_link_document'];
            	foreach ($uploadData as $upData) {
            		if($upData['name'] != NULL){
            			$this->Document->create();
            			$this->Document->set(array(
	                        'file_link' => 'files' . DS . $user_id . DS . $upData['name'],
	                        'file_name' => $upData['name'],
	                        'create_user_id' => $this->Auth->user('id'),
	                        'lesson_id' => $lesson_id,
	                        'create_date' => date('Y/m/d H:i:s'),
                    	));
                    	$this->Document->save();
                    	if (!file_exists(WWW_ROOT . 'files' . DS . $user_id)) {
                        	mkdir(WWW_ROOT . 'files' . DS . $user_id, 0700);
                    	}
                    	move_uploaded_file($upData['tmp_name'], WWW_ROOT . 'files' . DS . $user_id . DS . $upData['name']);
            		}
            	}
            //検証]をチェックし、新しいドキュメントをアップロードする 

            	$uploadData1 = $data['Lesson']['file_link_test'];
            	foreach ($uploadData1 as $upData) {
                //debug($upData);
                	if($upData['name'] != NULL){
                		$this->Test->create();
                		$this->Test->set(array(
	                        'file_link' => 'files' . DS . $user_id . DS . $upData['name'],
	                        'file_name' => $upData['name'],
	                        'create_user_id' => $this->Auth->user('id'),
	                        'lesson_id' => $lesson_id,
	                        'create_date' => date('Y/m/d H:i:s'),
	                    ));
                    	$this->Test->save();
                    	if (!file_exists(WWW_ROOT . 'files' . DS . $user_id)) {
                        	mkdir(WWW_ROOT . 'files' . DS . $user_id, 0700);
                    	}
                    	move_uploaded_file($upData['tmp_name'], 'files' . DS . $user_id . DS . $upData['name']);
                	}
            	}
            	$this->Session->setFlash('新しい授業を作ることが成功です。');
            	$this->redirect(array('controller' => 'Lessons', 'action' => 'manage_lessons'));
			}
            //検証]をチェックし、新しいテストをアップロードする 
        }
    }

    public function manage_course($id_lesson) {
        if (!$id_lesson) {
            throw new NotFoundException('このページが存在じゃありません。');
        }
        $lesson = $this->Lesson->find('first', array('conditions' => array('Lesson.id' => $id_lesson)));
        if (!$lesson) {
            throw new NotFoundException('このページが存在じゃありません。');
        }
        $this->set('title_for_layout', '授業管理');
        //新しいレッスンを作成する 
        $categories = $this->Category->find('all');
        $this->set('categories', $categories);
        //カテゴリテーブルを取得
        if (isset($this->request->data['delete'])) {
            $this->Lesson->id = $id_lesson;
            $this->Lesson->set(array(
                'delete_flag' => 1
            ));
            $this->Lesson->save();
        } else if (isset($this->request->data['ok'])) {                //教師のユーザーのクリックを提出した場合
            //debug($this->request->data); die;                       //データがプログラマに表示さ
            $this->Lesson->id = $id_lesson;
            $data = $this->request->data;
            $this->Lesson->set(array(
                'create_user_id' => $this->Auth->user('id'),
                'create_date' => date('Y/m/d H:i:s'),
            ));
            if ($data['Lesson']['Name'] != NULL)
                $this->Lesson->set('lesson_name', $data['Lesson']['Name']);
            if ($data['Lesson']['Description'] != NULL)
                $this->Lesson->set('description', $data['Lesson']['Description']);
            //新しいレッスンのテーブルのデータベースを作成する 
            $this->Lesson->save();
            $lesson_id = $this->Lesson->id;
            foreach ($data['Lesson']['category'] as $value) {
                if ($value != '0') {
                    $this->LessonOfCategory->create();
                    $this->LessonOfCategory->set('lesson_id', $lesson_id);
                    $this->LessonOfCategory->set('category_id', $value);
                    $this->LessonOfCategory->save();
                }
            }
            //データベースにデータを保存する
            if (isset($data['Lesson']['file_link_document'])) {
                $uploadData = $data['Lesson']['file_link_document'];
                foreach ($uploadData as $upData) {
                    //debug($upData);
                    $this->Document->create();
                    //新しいドキュメントのテーブルのデータベースを作成する 
                    $user_id = $this->Auth->user('id');
                    if ($this->Document->checkValid($upData['name'],$user_id)) {
                        $this->Document->set(array(
                            'file_link' => 'files' . DS . $user_id . DS . $upData['name'],
                            'file_name' => $upData['name'],
                            'create_user_id' => $this->Auth->user('id'),
                            'lesson_id' => $id_lesson
                        ));
                        $this->Document->save();
                        
                        if (!file_exists(WWW_ROOT . 'files' . DS . $user_id)) {
                            mkdir(WWW_ROOT . 'files' . DS . $user_id, 0700);
                        }
                        move_uploaded_file($upData['tmp_name'], 'files' . DS . $user_id . DS . $upData['name']);
                    } else {
                        $this->Session->setFlash('ファイル存在したとかファイル名が存在したとか');
                    }
                }
            }
            //検証]をチェックし、新しいドキュメントをアップロードする 
            if (isset($data['Lesson']['file_link_test'])) {
                $uploadData1 = $data['Lesson']['file_link_test'];
                foreach ($uploadData1 as $upData) {
                    //debug($upData);
                    $this->Test->create();
                    //新しいドキュメントのテーブルのデータベースを作成する 
                    if ($this->Test->checkValid($upData['name'])) {
                        $this->Test->set(array(
                            'file_link' => 'files' . DS . $user_id . DS . $upData['name'],
                            'file_name' => $upData['name'],
                            'create_user_id' => $this->Auth->user('id'),
                            'lesson_id' => $id_lesson
                        ));
                        $this->Test->save();
                        if (!file_exists(WWW_ROOT . 'files' . DS . $user_id)) {
                            mkdir(WWW_ROOT . 'files' . DS . $user_id, 0700);
                        }
                        move_uploaded_file($upData['tmp_name'], 'files' . DS . $user_id . DS . $upData['name']);
                    } else {
                        $this->Session->setFlash('ファイル存在したとかファイル名が存在したとか');
                    }
                }
            }
            //検証]をチェックし、新しいテストをアップロードする 
        }
        //22-3-2014
        $dataCourse = $this->Lesson->find('first',array('conditions'=> array('Lesson.id' => $id_lesson)));
        $this->set('dataCourse',$dataCourse);
        $dataCategory = $this->LessonOfCategory->find('list', array(
            'fields' => array('category_id'),
            'conditions' => array('lesson_id' => $id_lesson),
                ));
        $this->set('dataCategory', $dataCategory);
        $dataLesson = $this->Document->find('all', array(
            'fields' => array(),
            'conditions' => array('lesson_id' => $id_lesson),
                ));
        $this->set('dataLesson', $dataLesson);

        $dataTest = $this->Test->find('all', array(
            'fields' => array(),
            'conditions' => array('lesson_id' => $id_lesson),
                ));
        $this->set('dataTest', $dataTest);
    }

    public function uploadNewDocument() {
        if (isset($_FILES)) {
            $user_id = $this->Auth->user('id');
            $uploaddir = WWW_ROOT . 'files' . DS . $user_id . DS;
            $uploadfile = $uploaddir . basename($_FILES['file-0']['name']);
            $check = FALSE;
            //check file
            if ($this->Document->checkValid($_FILES['file-0']['name'])) {
                $check = TRUE;
                //upload file moi
                move_uploaded_file($_FILES['file-0']['tmp_name'], $uploadfile);
            }
            echo $check;
        }
        die;
    }

    public function uploadNewTest() {
        if (isset($_FILES)) {
            $user_id = $this->Auth->user('id');
            $uploaddir = WWW_ROOT . 'files' . DS . $user_id . DS;
            $uploadfile = $uploaddir . basename($_FILES['file-0']['name']);
            $check = FALSE;
            //check file
            if ($this->Test->checkValid($_FILES['file-0']['name'])) {
                $check = TRUE;
                //upload file moi
                move_uploaded_file($_FILES['file-0']['tmp_name'], $uploadfile);
//=======
//            $this->Test->set(array(
//                'file_link' => $uploadData1['name'],
//            ));
//            if ($this->Test->validates()) {
//                $this->Test->save();
//                move_uploaded_file($uploadData1['tmp_name'], WWW_ROOT . 'files/data' . DS . $uploadData1['name']);
//            } else {
//                $err1 = $this->Test->validationErrors['file_link']['0'];
//                $this->set(compact('err1'));
//>>>>>>> master
            }
            echo $check;
        }
        die;
    }

    public function updateNewDocument() {
        if (isset($_GET)) {
            var_dump($_GET);
            $user_id = $this->Auth->user('id');
            $url = WWW_ROOT . 'files' . DS . $user_id . DS . $_GET['old_name'];
            unlink($url);
            $documentId = $_GET['id'];
            $this->Document->id = $documentId;
            $this->Document->set(array(
                'file_link' => 'files' . DS . $user_id . DS . $_GET['newName'],
                'file_name' => $_GET['newName']
            ));
            $this->Document->save();
        }
        die;
    }

    public function updateNewTest() {
        if (isset($_GET)) {
            var_dump($_GET);
            $user_id = $this->Auth->user('id');
            $url = WWW_ROOT . 'files' . DS . $user_id . DS . $_GET['old_name'];
            unlink($url);
            $documentId = $_GET['id'];
            $this->Test->id = $documentId;
            $this->Test->set(array(
                'file_link' => 'files' . DS . $user_id . DS . $_GET['newName'],
                'file_name' => $_GET['newName']
            ));
            $this->Test->save();
        }
        die;
    }

    public function getStudentTestHistoriesList() {
    	$this->set('title_for_layout', '学生の試験結果');
        $this->paginate = array(
            'limit' => 10,
            'conditions' => array(
                'Test.create_user_id' => $this->Auth->user('id')
            ),
            'field' => array('Test.file_name', 'Lesson.lesson_name', 'TestHistory.score')
        );
        $data = $this->paginate('Test');
        $this->set('data', $data);
    }

    public function getStudentTestHistories($testID) {
    	$this->set('title_for_layout', '試験結果');
        $this->paginate = array(
            'limit' => 10,
            'conditions' => array(
                'Test.id' => $testID
            )
        );
        $data = $this->paginate('TestHistory');
        $this->set('data', $data);
    }

    public function getSalary() {
    	$this->set('title_for_layout', '報酬情報');
        $temp = $this->ChangeableValue->find('first', array('conditions' => array('id' => 2)));
        $rate = $temp['ChangeableValue']['current_value'];
        //$time = date('Y-m');
        if ($this->request->is('post')) {
            $year = $this->data['YearMonth']['year']['year'];
            $month = $this->data['YearMonth']['month']['month'];
            if ($year != "" && $month != "") {
                $time = $year . '-' . $month;
            } else {
                $time = date('Y-m');
            }

            $this->Session->write('time', $time);
        }
        $time = $this->Session->read('time');
        //debug($time);
        if (empty($time)) {
            $time = date('Y-m');
            $this->Session->write('time', $time);
        }

//        debug($time);
//        debug(date('Y', strtotime($time)));
//        debug(date('M', strtotime($time)));
        //$this->set('time', $time);
        $temp2 = $this->Bill->find('all', array(
            'conditions' => array(
                'Lesson.create_user_id' => $this->Auth->user('id'),
                'Bill.learn_date LIKE ' => $time . '%'
            ),
            'fields' => array(
                'count(Bill.lesson_id) AS COUNT',
                'sum(Bill.lesson_cost *' . $rate . '/100) AS SUM',
                'Lesson.lesson_name',
                'Bill.learn_date',
                'Bill.lesson_cost'
            ),
            'group' => 'Bill.lesson_id'

//                ));
                ));
        $sum = 0;
        foreach ($temp2 as $item) {
            $sum += $item[0]['SUM'];
        }
        $this->set('sum', $sum);
        //debug($temp2);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => array(
                'Lesson.create_user_id' => $this->Auth->user('id'),
                'Bill.learn_date LIKE ' => $time . '%'
            ),
            'fields' => array('count(Bill.lesson_id) AS COUNT', 'sum(Bill.lesson_cost *' . $rate . '/100) AS SUM', 'Lesson.lesson_name', 'Bill.learn_date', 'Bill.lesson_cost'),
            'group' => 'Bill.lesson_id'
        );
        $data = $this->paginate('Bill');
        //$this->set('data', $data);
        $this->Session->write('data', $data);
        $sum = 0;
    }

    function exportBill($time) {
        $temp = $this->ChangeableValue->find('first', array('conditions' => array('id' => 2)));
        $rate = $temp['ChangeableValue']['current_value'];

        $temp2 = $this->Bill->find('all', array(
            'conditions' => array(
                'Lesson.create_user_id' => $this->Auth->user('id'),
                'Bill.learn_date LIKE ' => $time . '%'
            ),
            'fields' => array(
                'count(Bill.lesson_id) AS COUNT',
                'sum(Bill.lesson_cost *' . $rate . '/100) AS SUM',
                'Lesson.lesson_name',
                'Bill.learn_date',
                'Bill.lesson_cost'
            ),
            'group' => 'Bill.lesson_id'
                ));
        //debug($temp2);die;
        $this->set('temp2', $temp2);
        $this->layout = null;
        $this->autoLayout = false;
    }
}