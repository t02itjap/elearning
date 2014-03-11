<?php
echo $this->Html->script ( array (
		'jquery.validate'
) );

echo $this->Session->flash ();
echo $this->Form->create('User',array('type'=>'post',"url" => array (
				"controller" => "users",
				"action" => "teacherName" 
		)));
echo $this->Form->input('username',array('type'=>'text'));
echo $this->Form->button ( "Username忘れた", array (
		"id" => "missPass",
		"type" => "button",
		'onclick' => "return alert('Lien he quan ly de reset mat khau')" 
) );
echo $this->Form->end('login');
?>

<script type="text/javascript">
$(document).ready(function(){
    $("#UserTeacherNameForm").validate();
    $("#UserUsername").rules("add", {
     required:true,
     messages: {
            required: "usernameを入力する"
     }
    });    
});
</script>
