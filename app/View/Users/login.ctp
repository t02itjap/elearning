<center>
<?php
echo $this->Html->script ( array (
		'jquery.validate' 
) );
echo $this->Form->create ( "User", array (
		"url" => array (
				"controller" => "users",
				"action" => "login" 
		),
		"type" => "post",
		"id" => "formLogin",
		"class" => "form1" 
) );
echo $this->Session->flash ();
// $userType[1] = "管理者";
$userType [2] = "先生";
$userType [3] = "学生";

echo $this->Form->input ( "user_type", array (
		"label" => "アカウントタイプを選択する",
		"type" => "select",
		"options" => $userType,
		"id" => "user_type" 
) );
echo $this->Form->input ( "user_name", array (
		"label" => false,
		"type" => "text",
		"value" =>'',
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
echo $this->Form->end ( array (
		"label" => 'ログイン',
		'class' => 'link-button',
		'div' => false
) );
?>
</center>
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