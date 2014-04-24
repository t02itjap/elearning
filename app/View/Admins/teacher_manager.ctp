<?php echo $this->Session->flash();?>
<?php echo $this->Form->create('User',array('type'=>'post'))?>
                    <div id="change_info">
                    <table>
                        <tr>
                            <td>ユーザネーム</td>
                            <td><p><?php echo $teacher['User']['user_name']?></p></td>
                        </tr>
                        <tr>
                            <td>メール</td>
                            <td>
                            	<?php
                            		echo $this->Form->input ( 'email', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'text',
                            			'class' => 'must_info',
                            			'id' => 'email',
                            			'value' => $teacher['User']['email']
                            		));
                        		?>
                        	</td>	
                        </tr>
                        <tr>
                            <td>電話番号</td>
                            <td>
                            	<?php
                                    echo $this->Form->input ( 'phone_number', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'number',
                            			'class' => 'must_info',
                            			'id' => 'phone_number',
                            			'value' => $teacher['User']['phone_number']
                            		));
                        		?>
                            </td>

                        </tr>
                        <tr>
                            <td>アドレス</td>
                            <td>
                            	<?php
                                    echo $this->Form->input ( 'address', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'text',
                            			'class' => 'must_info',
                            			'id' => 'address',
                            			'value' => $teacher['User']['address']
                            		));
                        		?>                            
                            </td>
                        </tr>

                        <tr>
                            <td>銀行口座番号</td>
                            <td>
                            	<?php
                            		$bankCode = explode('-',$teacher['User']['bank_account_code']);                            	
									echo $this->Form->input('bankCodePart1', array('value' => $bankCode[0], 'div' => false, 'label' => false, 'type' => 'text','maxlength' => '4', 'style' => 'width: 32px', 'class' => 'onlyNumber', 'id' => 'bankCodePart1' ));
									echo "<b style = 'font-size: 20px'> - </b>";
									echo $this->Form->input('bankCodePart2', array('value' => $bankCode[1],'div' => false, 'label' => false, 'type' => 'text','maxlength' => '3', 'style' => 'width: 24px', 'class' => 'onlyNumber', 'id' => 'bankCodePart2' ));
									echo "<b style = 'font-size: 20px'> - </b>";
									echo $this->Form->input('bankCodePart3', array('value' => $bankCode[2],'div' => false, 'label' => false, 'type' => 'text','maxlength' => '1', 'style' => 'width: 8px', 'class' => 'onlyNumber', 'id' => 'bankCodePart3' ));
									echo "<b style = 'font-size: 20px'> - </b>";
									echo $this->Form->input('bankCodePart4', array('value' => $bankCode[3],'div' => false, 'label' => false, 'type' => 'text','maxlength' => '7', 'style' => 'width: 56px', 'class' => 'onlyNumber', 'id' => 'bankCodePart4' ));	
                        		?>
                        	</td>
                        </tr>
                    </table>
                    </div><!--End #change_info-->
                    <div id="submit">
                            <?php
                            if($teacher['User']['status_flag'] == 1)
                            	echo $this->Form->button('アカウントを削除',
									array(
										'name' => 'data[delete_teacher]',
										'class' => 'link-button',
										'onClick' => "return confirm('このアカウントを削除したいですか?')",
										'escape' => false,
										'title' => '確認'
								));
							else
                            	echo $this->Form->button('アカウントを回復',
									array(
										'name' => 'data[restore_teacher]',
										'class' => 'link-button',
										'onClick' => "return confirm('このアカウントを回復したいですか?')",
										'escape' => false,
										'title' => '確認'
								));							
							?>
							<?php
                            echo $this->Form->button('リセットパスワード',
								array(
									'name' => 'data[reset_password]',
									'class' => 'link-button',
									'onClick' => "return confirm('このアカウントのパスワードをリセットしたいですか?')",
									'escape' => false,
									'title' => '確認'
									));
							?>
							<?php
                            echo $this->Form->button('リセットVerifyコード',
								array(
									'name' => 'data[reset_verifycode]',
									'class' => 'link-button',
									'onClick' => "return confirm('このアカウントのVerifyコードをリセットしたいですか?')",
									'escape' => false,
									'title' => '確認'
									));
							?>
                            <?php
                            echo $this->Form->button ( '変更', array (
                            	'type' => 'submit',
                            	'name' => 'data[submit_data]',
                            	'class' => 'link-button',
                            	'id' => 'submit_button' ) );
                            ?>
                        </div><!--End #submit-->
<?php echo $this->Form->end();?>
<script>
$(document).ready(function(){
	$("#submit_button").click(function(){
	        if($("#bankCodePart1").val().length < 4 || $("#bankCodePart2").val().length < 3 || $("#bankCodePart3").val().length < 1 || $("#bankCodePart4").val().length < 7){
				alert("銀行口座が間違いです。");
				return false;
	        }
	});
});
</script>