<?php
       	echo $this->Html->script("inputcheck");
       	// 登録フォーム
       	echo $this->Form->create("User", array(
                       	"url" => array("controller" =>"users", "action" => "register") ,
                       	"type" => "post",
                       	"id" => "formRegister",
                       	"class" => "form1",
                       	"onsubmit" =>"return checkForm()"
       	));
       	echo $this->Session->flash();
       	echo $this->Html->tag("h1", "登録");
       	echo $this->Form->input("user_name", array(
                       	"label" => "username",
                       	"type" => "text",
                       	"placeholder" => "ユーザネーム"
       	));
       	echo $this->Form->input("password", array(
                       	"label" => "password",
                       	"type" => "password",
                       	"placeholder" => "パースワード",
       	));
       	echo $this->Form->input("email", array(
                       	"label" => "email",
                       	"type" => "email",
                       	"placeholder" => "mail",

       	));
        echo $this->Form->button("Reset",array("type" => "reset"));
        
        echo $this->Form->end("登録", array(
                        "label" => false
        ));
?>
<script>
//登録フォームの検証
InvalidInputHelper(document.getElementById("UserUserName"), {
    emptyText: "ユーザネームを入力してください"

});
InvalidInputHelper(document.getElementById("UserPassword"), {
    defaultText: "パースワードを入力してください",
    emptyText: "パースワードを入力してください",
});
InvalidInputHelper(document.getElementById("UserEmail"), {
    defaultText: "メールを入力してください",
    emptyText: "メールを入力してください"
});
function checkForm(){
        var uname = document.getElementById("UserUserName");
        if($(uname).val() == ""){
                uname.setCustomValidity("ユーザネームを入力してください");
                return false;
        }else
              uname.setCustomValidity("");
        var pass = document.getElementById("UserPassword");
        if($(pass).val() == ""){
                pass.setCustomValidity("パースワードを入力してください");
                return false;
        }else
              pass.setCustomValidity("");
        var email = document.getElementById("UserEmail");
        if($(email).val() == ""){
                email.setCustomValidity("メールを入力してください");
                return false;
 }else
              email.setCustomValidity("");
        return true;
}
</script>