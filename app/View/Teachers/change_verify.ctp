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
				<td>質問</td>
				<td>
				<?php
                           echo $this->Form->input ( 'question', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'text',
                            			'class' => 'must_info',
                            			'disabled'=>true,
                            			'value'=>base64_decode($teacher['Verifycode']['question'])
                            		));
                        		?>
				
				</td>
			</tr>
			<tr>
				<td>現在答え</td>
				<td>
					<?php
                           echo $this->Form->input ( 'verifycode1', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'text',
                            			'class' => 'must_info'
                            		));
                        		?>
				</td>
			</tr>
			<tr>
				<td>新しい答え</td>
				<td>
					<?php
                           echo $this->Form->input ( 'verifycode2', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'text',
                            			'class' => 'must_info'
                            		));
                        		?>
				</td>
			</tr>
			<tr>
				<td>新しい答え確認</td>
				<td>
					<?php
                           echo $this->Form->input ( 'verifycode3', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'text',
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
    $("#UserChangeVerifyForm").validate();
    $("#UserVerifycode1").rules("add", {
     required:true,
     messages: {
            required: "ユーザネームを入力する"
     }
    });
    $("#UserVerifycode2").rules("add", {
     required:true,
     messages: {
            required: "パスワードを入力する"
     }
  	});
    $("#UserVerifycode3").rules("add", {
        required:true,
        messages: {
               required: "パスワードを入力する"
        }
     	});
});
</script>