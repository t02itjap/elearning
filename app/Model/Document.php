<?php

class Document extends AppModel {

    var $name = 'Document';
    var $primaryKey = 'id';
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'create_user_id'
        ),
        'Lesson'=>array(
            'className'=>'Lesson',
            'foreignKey' => 'lesson_id'
        )
    );

    public function checkValid($fileName, $folder) {
        $uploaddir = WWW_ROOT . 'files/'.$folder.'/';
        $check = FALSE;
        //check file
        $allowedExts = array("gif", "jpeg", "jpg", "png", "pdf", "mp3", "mp4", "wav", "tsv");
        $temp = explode(".", $fileName);
        $extension = end($temp);
        if (in_array($extension, $allowedExts)
                && !file_exists($uploaddir . $fileName)) {
            $check = TRUE;
        }
        return $check;
    }

    public function getDocuments($id) {
        $condition = array(
            'conditions' => array('Document.id' => $id),
            'fields' => array('Document.file_link')
        );
        return $this->find('first', $condition);
    }
}