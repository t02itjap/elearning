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

echo $this->Form->input('pass',array(
		"label" => false,
		"type" => "password",
		// "name" => "pass",
		"placeholder" => "パスワード",
		"class" => "must"
));
echo $this->Form->button ( "パスワードが忘れた", array (
		"id" => "missPass",
		"type" => "button",
		'onclick' => "return alert('パスワードをリセットために、管理者に連絡する')" 
) );
echo $this->Form->end(array(
		"label" => 'ログイン',
		'class' => 'link-button',
		'div' => false
));
?>

<script type="text/javascript">
$(document).ready(function(){
    $("#UserTeacherPassForm").validate();
    $("#UserPass").rules("add", {
     required:true,
     messages: {
            required: "パスワードを入力する"
     }
  	});    
});
</script>