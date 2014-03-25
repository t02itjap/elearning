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
                            			'class' => 'must_info',
										'name'=>'data[User][pass1]'
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
                            			'class' => 'must_info',
										'name'=>'data[User][pass2]'
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
                            			'class' => 'must_info',
										'name'=>'data[User][pass3]'
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
  var validator = $("#UserChangePassForm").validate(
		  {
			  rules: {
				  'data[User][pass1]':{
					  required:true,
					  minlength:6,
					  maxlength:15
				  },
				  'data[User][pass2]':{
					  required:true,
					  minlength:6,
					  maxlength:15
				  },
				  'data[User][pass3]':{
					  required:true,
					  minlength:6,
					  maxlength:15,
					  equalTo:"#UserPass2"
				  }
			  },
			  messages:{
				  'data[User][pass1]':{
					  required:"現在パスワードを入力する",
					  minlength:"６文字以上、入力する",
					  maxlength:"１５文字以下、入力する"
				  },
				  'data[User][pass2]':{
					  required:"新しいパスワードを入力する",
					  minlength:"６文字以上、入力する",
					  maxlength:"１５文字以下、入力する"
				  },
				  'data[User][pass3]':{
					  required:"新しいパスワードの確認を入力する",
					  minlength:"６文字以上、入力する",
					  maxlength:"１５文字以下、入力する",
					  equalTo:"上のようなパスワードを入力する"
				  },
			  }
		  });
});
</script>