<?php
echo $this->Html->script ( array (
		'jquery.validate'
) );

echo $this->Session->flash ();
echo $this->Form->create('User',array('type'=>'post',"url" => array (
				"controller" => "users",
				"action" => "teacherPass" ,
				$teacher['User']['id']
		)));

echo $this->Form->input('pass',array('type'=>'password'));
echo $this->Form->button ( "パスワードが忘れた", array (
		"id" => "missPass",
		"type" => "button",
		'onclick' => "return alert('Lien he quan ly de reset mat khau')" 
) );
echo $this->Form->end('login');
?>

<script type="text/javascript">
$(document).ready(function(){
    $("#VerifycodeTeacherLoginForm").validate();
    $("#VerifycodeQuestion").rules("add", {
     required:true,
     messages: {
            required: "questionを入力する"
     }
    });
    $("#VerifycodeVerifycode").rules("add", {
     required:true,
     messages: {
            required: "answerを入力する"
     }
  	});    
});
</script>