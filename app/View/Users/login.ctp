
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
if ($missPass)
	echo $this->Html->tag ( "h2", $missPass );
echo $this->Html->tag ( "h1", "ログイン" );
// $userType[1] = "管理者";
$userType [2] = "先生";
$userType [3] = "学生";

echo $this->Form->input ( "user_type", array (
		"label" => "Select user type",
		"type" => "select",
		"options" => $userType,
		"id" => "user_type",
		"div" => 'false' 
) );
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
		"type" => "reset",
		"id" => "btnSubmit" 
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
			alert("Lien he quan ly de reset mat khau");
      	});       
               //,
//               errorPlacement: function(error, element) {
//			if ( element.is(":radio") )
//				error.appendTo( element.parent().next().next() );
//			else if ( element.is(":checkbox") )
//				error.appendTo ( element.next() );
//			else
//				error.appendTo( element.parent().next() );
//		},
            
         });
</script>