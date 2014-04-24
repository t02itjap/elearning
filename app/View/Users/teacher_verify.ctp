
<?php
echo $this->Html->script ( array (
		'jquery.validate'
) );

echo $this->Session->flash ();
echo $this->Form->create('Verifycode',array('type'=>'post',"url" => array (
				"controller" => "users",
				"action" => "teacherVerify" ,
				$teacher['Verifycode']['user_id'],
				$teacher['type'],
				$teacher['inputPass']
		)));
echo $this->Form->input('question',array('label'=>'秘密質問','type'=>'text'));
echo $this->Form->input('verifycode',array('label'=>'答え','type'=>'text'));
echo $this->Form->button ( "VerifyCode忘れた", array (
		"id" => "missPass",
		"type" => "button",
		'onclick' => "return alert('Verifyコードをリセットために、管理者に連絡する')" 
) );
echo $this->Form->end(array('label'=>'ログイン','class'=>'link-button','div'=>false));
?>

<script type="text/javascript">
$(document).ready(function(){
    $("#VerifycodeTeacherLoginForm").validate();
    $("#VerifycodeQuestion").rules("add", {
     required:true,
     messages: {
            required: "質問を入力する"
     }
    });
    $("#VerifycodeVerifycode").rules("add", {
     required:true,
     messages: {
            required: "答えを入力する"
     }
  	});    
});
</script>
