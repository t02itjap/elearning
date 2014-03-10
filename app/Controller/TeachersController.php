<?php

/**
 * User controller for login,logout,...
 * 
 */
class TeachersController extends AppController {
    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

    var $uses = array('Category', 'Lesson', 'Document', 'Test');

    /*   public function createCourse() {
      $categories = $this->Category->find('all');
      $this->set('categories', $categories);
      if(isset($this->request->data['ok'])){
      $uploadData = $this->request->data;
      debug($uploadData);}
      } */

    public function createNewCategory() {
        echo 'abccccc';
        if (isset($_POST['name'])) {
            var_dump($_POST['name']);
            $data = array('category_name' => $_POST['name']);
            $this->Category->create();
            $this->Category->save($data);
            //$this->set('id', $this->Category->id);
            $category = $this->Category->find('first', array('conditions' => array('category_name' => $_POST['name'])));
            $data['id'] = $category['Category']['id'];
            //$this->Category->id;
            $data['name'] = $_POST['name'];
        }

        die;
    }

    public function create_course() {
        $categories = $this->Category->find('all');
        $this->set('categories', $categories);
        if (isset($this->request->data['ok'])) {

            debug($this->request->data);
            $data = $this->request->data;
            $this->Lesson->set(array(
                'lesson_name' => $data['Lesson']['Name'],
                'description' => $data['Lesson']['Description'],
                'create_user_id' => $this->Auth->user('id'),
                'create_date' => date('Y/m/d H:i:s'),
            ));
            $this->Lesson->save();

            $uploadData = $data['Lesson']['file_link_document'];
            $this->Document->set(array(
                'file_link' => $uploadData['name'],
            ));
            if ($this->Document->validates()) {
                $this->Document->save();
                move_uploaded_file($uploadData['tmp_name'], WWW_ROOT . 'files/data' . DS . $uploadData['name']);
            } else {
                $err = $this->Document->validationErrors['file_link']['0'];
                $this->set(compact('err'));
            }

            $uploadData1 = $data['Lesson']['file_link_test'];
            $this->Test->set(array(
                'file_link' => $uploadData1['name'],
            ));
            if ($this->Test->validates()) {
                $this->Test->save();
                move_uploaded_file($uploadData1['tmp_name'], WWW_ROOT . 'files/data' . DS . $uploadData1['name']);
            } else {
                $err1 = $this->Test->validationErrors['file_link']['0'];
                $this->set(compact('err1'));
            }
        }
    }

}

?>
