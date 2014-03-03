<?php
   debug($data);
   echo '<ul>';
   foreach ($data as $key=>$value){
       echo '<li>'.$value['TestHistory']['test_date'].'</li>';
       echo '<li>'.$value['User']['user_name'].'</li>';
       echo '<li>'.$value['Test']['lesson_id'].'</li>';
       echo '<li>'.$value['Lesson']['lesson_name'].'</li>';
       echo 'View Test Result';
   }
   echo '</ul>';

    echo $this->Session->flash();
    echo $this->Html->link("logout",array("controller" => "users","action" => "logout"));


?>