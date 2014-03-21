<?php

class ManagersController extends AppController {

    public $name = "Managers";
    var $uses = array('User', 'Test', 'Lesson', 'Bill', 'Category', 'Document', 'TestHistory', 'ChangeableValue', 'Bill');
    var $helpers = array('Html', 'Form', 'Editor');
    public $components = array('Paginator', 'RequestHandler');

    function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        
    }

    public function getReceipts() {
        $this->paginate = array(
            'limit' => 10
        );
        $data = $this->paginate('Lesson');
        $this->set('data', $data);
        $rate = $this->ChangeableValue->find('first', array('conditions' => array('id' => 3)));
        $this->set('rate', $rate['ChangeableValue']['current_value']);
    }

    public function changeValues() {
        $data = $this->ChangeableValue->find('all');
        $this->set('data', $data);
        //debug($data);
        if ($this->request->is('post')) {
            $sesson = $this->data['ChangeableValue']['sesson'];
            $rate = $this->data['ChangeableValue']['rate'];
            $maxPasswordRetry = $this->data['ChangeableValue']['maxPasswordRetry'];
            $this->ChangeableValue->id = 1;
            $this->ChangeableValue->saveField('current_value', $sesson);

            $this->ChangeableValue->id = 2;
            $this->ChangeableValue->saveField('current_value', $rate);

            $this->ChangeableValue->id = 3;
            $this->ChangeableValue->saveField('current_value', 100 - $rate);

            $this->ChangeableValue->id = 4;
            $this->ChangeableValue->saveField('current_value', $maxPasswordRetry);
            $data = $this->ChangeableValue->find('all');
            $this->set('data', $data);
        }
    }

    public function createNewCategory() {
//      新しいカテゴリを作成する機能
        if (isset($_POST['name'])) {
            //var_dump($_POST['name']);
            $data = array('category_name' => $_POST['name']);   //新しいデータベースを作成
            $this->Category->create();
            $this->Category->save($data);                       //データベースにデータを保存する
            //$this->set('id', $this->Category->id);
            //$category = $this->Category->find('first', array('conditions' => array('category_name' => $_POST['name'])));
            $data['id'] = $this->Category->id;
            //$this->Category->id;
            $data['name'] = $_POST['name'];
            //カテゴリテーブルの情報を取得する
            echo json_encode($data);
        }

        die; //デバッグのため停止
    }

    public function manage_course() {
        //新しいレッスンを作成する 
        $categories = $this->Category->find('all');
        $this->set('categories', $categories);
        //カテゴリテーブルを取得
        if (isset($this->request->data['ok'])) {                //教師のユーザーのクリックを提出した場合
            //debug($this->request->data);                        //データがプログラマに表示さ
            $data = $this->request->data;
            $this->Lesson->set(array(
                'lesson_name' => $data['Lesson']['Name'],
                'description' => $data['Lesson']['Description'],
                'create_user_id' => $this->Auth->user('id'),
                'create_date' => date('Y/m/d H:i:s'),
            ));
            //新しいレッスンのテーブルのデータベースを作成する 
            $this->Lesson->save();
            $lesson_id = $this->Lesson->id;
            //データベースにデータを保存する
            $uploadData = $data['Lesson']['file_link_document'];
            foreach ($uploadData as $upData) {
                //debug($upData);
                $this->Document->create();
                //新しいドキュメントのテーブルのデータベースを作成する 
                //if ($this->Document->validates()) {
                $this->Document->set(array(
                    'file_link' => $upData['name'],
                    'file_name' => $upData['name'],
                    'create_user_id' => $this->Auth->user('id'),
                    'lesson_id' => $lesson_id
                ));
                $this->Document->save();
                move_uploaded_file($upData['tmp_name'], WWW_ROOT . 'files/data' . DS . $upData['name']);
//                } else {
//                    $err = $this->Document->validationErrors['file_link']['0'];
//                    $this->set(compact('err'));
//                }
            }
            //検証]をチェックし、新しいドキュメントをアップロードする 

            $uploadData1 = $data['Lesson']['file_link_test'];
            $this->Test->set(array(
                'file_link' => $uploadData1['name'],
            ));
            //新しいテストのテーブルのデータベースを作成する 
            if ($this->Test->validates()) {
                $this->Test->save();
                move_uploaded_file($uploadData1['tmp_name'], WWW_ROOT . 'files/data' . DS . $uploadData1['name']);
            } else {
                $err1 = $this->Test->validationErrors['file_link']['0'];
                $this->set(compact('err1'));
            }
            //検証]をチェックし、新しいテストをアップロードする 
        }
    }

}
