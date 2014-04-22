<?php
echo $this->Html->script ( array (
		'jquery.validate' 
) );
echo $this->Form->create ( "User", array (
		"url" => array (
				"controller" => "admins",
				"action" => "index" 
		),
		"type" => "post",
		"id" => "formLogin",
		"class" => "form1" 
) );
echo $this->Session->flash ();

echo $this->Form->input ( "user_name", array (
		"label" => false,
		"type" => "text",
		// "name" => "uname",
		"placeholder" => "ユーザネーム",
		"class" => "must",
		"div" => 'false' 
) );

echo $this->Form->input ( "password", array (
		"label" => false,
		"type" => "password",
		// "name" => "pass",
		"placeholder" => "パスワード",
		"class" => "must" 
) );

echo $this->Form->button ( "リセット", array (
		"type" => "reset"		
) );
echo $this->Form->button ( "パスワード忘れた", array (
		"id" => "missPass",
		"type" => "button" 
) );
echo $this->Form->end ( "ログイン", array (
		"label" => false 
) );
?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#formLogin").validate();
        $("#UserUserName").rules("add", {
         required:true,
         messages: {
                required: "ユーザネームを入力する"
         }
        });
        $("#UserPassword").rules("add", {
         required:true,
         messages: {
                required: "パスワードを入力する"
         }
      	});

      	$("#missPass").click(function(){
			alert("パスワードをリセットため、管理者に連絡する");
      	});      
            
         });
</script>
