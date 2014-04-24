<?php
echo $this->Html->script ( array (
		'jquery.validate'
) );

echo $this->Session->flash ();
echo $this->Form->create('User',array('type'=>'post',"url" => array (
				"controller" => "users",
				"action" => "teacherName" 
		)));
echo $this->Form->input('username',array(
		"label" => false,
		"type" => "text",
		"value" =>'',
		// "name" => "uname",
		"placeholder" => "ユーザネーム",
		"class" => "must",
		"div" => 'false'
));
echo $this->Form->button ( "ユーザネーム忘れた", array (
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
    $("#UserTeacherNameForm").validate();
    $("#UserUsername").rules("add", {
     required:true,
     messages: {
            required: "ユーザネームを入力する"
     }
    });    
});
</script>
