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
                            			'class' => 'must_info',
										'name' => 'data[User][verifycode1]'
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
                            			'class' => 'must_info',
										'name' => 'data[User][verifycode2]'
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
                            			'class' => 'must_info',
										'name' => 'data[User][verifycode3]'
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
  var validator = $("#UserChangeVerifyForm").validate(
		  {
			  rules: {
				  'data[User][verifycode1]':{
					  required:true,
					  minlength:6,
					  maxlength:15
				  },
				  'data[User][verifycode2]':{
					  required:true,
					  minlength:6,
					  maxlength:15
				  },
				  'data[User][verifycode3]':{
					  required:true,
					  minlength:6,
					  maxlength:15,
					  equalTo:"#UserVerifycode2"
				  }
			  },
			  messages:{
				  'data[User][verifycode1]':{
					  required:"現在Verifyコードを入力する",
					  minlength:"６文字以上、入力する",
					  maxlength:"１５文字以下、入力する"
				  },
				  'data[User][verifycode2]':{
					  required:"新しいVerifyコードを入力する",
					  minlength:"６文字以上、入力する",
					  maxlength:"１５文字以下、入力する"
				  },
				  'data[User][verifycode3]':{
					  required:"新しいVerifyコードの確認を入力する",
					  minlength:"６文字以上、入力する",
					  maxlength:"１５文字以下、入力する",
					  equalTo:"上のようなVerifyコードを入力する"
				  },
			  }
		  });
});
</script>