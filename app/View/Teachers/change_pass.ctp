<?php echo $this->Html->script ( array (
		'jquery.validate' 
) );?>


<div id="main_content">
	<h2>Verifyコード変更する。</h2>
	<?php echo $this->Session->flash();?>
                <?php echo $this->Form->create('User',array('type'=>'post'));?>
                    <div id="change_info">
		<table>
			<tr>
				<td>現在パスワード</td>
				<td>
					<?php
                           echo $this->Form->input ( 'pass1', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'password',
                            			'class' => 'must_info'
                            		));
                        		?>
				</td>
			</tr>
			<tr>
				<td>新しいパスワード</td>
				<td>
					<?php
                           echo $this->Form->input ( 'pass2', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'password',
                            			'class' => 'must_info'
                            		));
                        		?>
				</td>
			</tr>
			<tr>
				<td>新しいパスワード確認</td>
				<td>
					<?php
                           echo $this->Form->input ( 'pass3', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'password',
                            			'class' => 'must_info'
                            		));
                        		?>
				</td>
			</tr>
		</table>
	</div><!--End #change_info-->
		<?php echo $this->Form->end('作成');?>
</div><!--End #main_content-->

<script>
$(document).ready(function(){
    $("#UserChangePassForm").validate();
    $("#UserPass1").rules("add", {
     required:true,
     messages: {
            required: "ユーザネームを入力する"
     }
    });
    $("#UserPass2").rules("add", {
     required:true,
     messages: {
            required: "パスワードを入力する"
     }
  	});
    $("#UserPass3").rules("add", {
        required:true,
        messages: {
               required: "パスワードを入力する"
        }
     	});
});
</script>