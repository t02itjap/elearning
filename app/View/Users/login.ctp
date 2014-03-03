<?php

echo $this->Html->script("inputcheck");
echo $this->Form->create("User", array(
                                        "url" => array("controller" => "users","action" => "login"),
                                        "type" => "post",
                                        "onSubmit" => "return checkForm()",
                                        "id" =>"formLogin",
                                        "class" => "form1"
                                        ));
echo $this->Session->flash();
echo $this->Html->tag("h1","ログイン");
echo $this->Form->input("user_name",  array(
                                "label" => false,
                                "type"  => "text",
                                "placeholder" => "ユーザネーム"
));

echo $this->Form->input("password",  array(
                                "label" => false,
                                "type"  => "password",
                                "placeholder" => "パスワード"
));

echo $this->Form->button("リセット", array("type" => "reset"));
echo $this->Html->link("パスワード忘れた",array("action" => "missPass"));
echo $this->Form->end("ログイン", array(
                       	"label" => false,
                        "onclick" => "return checkForm()"
       	));
        ?>
        
<script>

InvalidInputHelper(document.getElementById("UserUserName"), {
    emptyText: "ユーザネームを入力してください"

});
InvalidInputHelper(document.getElementById("UserPassword"), {
    defaultText: "パースワードを入力してください",
    emptyText: "パースワードを入力してください",
});

function checkForm(){
        var uname = document.getElementById("UserUserName");
        if($(uname).val() == ""){
                uname.setCustomValidity("ユーザネームを入力してください");
                return false;
        }else{
                uname.setCustomValidity("");
        }
        var pass = document.getElementById("UserPassword");
        if($(pass).val() == ""){
                pass.setCustomValidity("パースワードを入力してください");
                return false;
        }else{
                pass.setCustomValidity("");
                }
        return true;
}
</script>