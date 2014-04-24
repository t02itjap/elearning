<?php echo $this->Session->flash();?>
<?php echo $this->Form->create('User',array('type'=>'post'))?>
                    <div id="change_info">
                    <table>
                        <tr>
                            <td>ユーザネーム</td>
                            <td><p><?php echo $student['User']['user_name']?></p></td>
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
                            			'value' => $student['User']['email']
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
                            			'value' => $student['User']['phone_number']
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
                            			'value' => $student['User']['address']
                            		));
                        		?>                            
                            </td>
                        </tr>

                        <tr>
                            <td>クレジットカード番号</td>
                            <td>
                            	<?php
                            		$bankCode = explode('-',$student['User']['bank_account_code']);
									echo $this->Form->input('cardPart1', array('value' => $bankCode[0], 'div' => false, 'label' => false, 'type' => 'text','maxlength' => '8', 'style' => 'width: 64px', 'class' => 'onlyNumber', 'id' => 'cardPart1' ));
									echo "<b style = 'font-size: 20px'> - </b>";
									echo $this->Form->input('cardPart2', array('value' => $bankCode[1], 'div' => false, 'label' => false, 'type' => 'text','maxlength' => '4', 'style' => 'width: 32px', 'class' => 'onlyNumber', 'id' => 'cardPart2' ));
									echo "<b style = 'font-size: 20px'> - </b>";
									echo $this->Form->input('cardPart3', array('value' => $bankCode[2], 'div' => false, 'label' => false, 'type' => 'text','maxlength' => '4', 'style' => 'width: 32px', 'class' => 'onlyNumber', 'id' => 'cardPart3' ));
									echo "<b style = 'font-size: 20px'> - </b>";
									echo $this->Form->input('cardPart4', array('value' => $bankCode[3], 'div' => false, 'label' => false, 'type' => 'text','maxlength' => '4', 'style' => 'width: 32px', 'class' => 'onlyNumber', 'id' => 'cardPart4' ));							
									echo "<b style = 'font-size: 20px'> - </b>";
									echo $this->Form->input('cardPart5', array('value' => $bankCode[4], 'div' => false, 'label' => false, 'type' => 'text','maxlength' => '4', 'style' => 'width: 32px', 'class' => 'onlyNumber', 'id' => 'cardPart5' ));
                        		?>
                        	</td>
                        </tr>
                    </table>
                    </div><!--End #change_info-->
                    <div id="submit">
                            <?php
                            if(isset($teacher['User']['status_flag'])&&$teacher['User']['status_flag']== 1)
                            echo $this->Form->button('アカウントを削除',
								array(
									'name' => 'data[delete_student]',
									'class' => 'link-button',
									'onClick' => "return confirm('このアカウントを削除したいですか?')",
									'escape' => false,
									'title' => '確認'
									));
							else
                            	echo $this->Form->button('アカウントを回復',
									array(
										'name' => 'data[restore_student]',
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
	        if($("#cardPart1").val().length < 8 || $("#cardPart2").val().length < 4 || $("#cardPart3").val().length < 4 || $("#cardPart4").val().length < 4 || $("#cardPart5").val().length < 4){
				alert("クレジットカード番号が間違いです。");
				return false;
	        }
	});
});
</script>