
<?php
echo $this->Html->script ( array (
		'jquery.validate'
) );

echo $this->Session->flash ();
echo $this->Form->create('Verifycode',array('type'=>'post',"url" => array (
				"controller" => "users",
				"action" => "teacherLogin" ,
				$teacher['Verifycode']['user_id']
		)));
echo $this->Form->input('question',array('type'=>'text','value'=>base64_decode($teacher['Verifycode']['question']),'disabled'=>true));
echo $this->Form->input('verifycode',array('type'=>'text'));
echo $this->Form->button ( "VerifyCode忘れた", array (
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
