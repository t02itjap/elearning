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
                            			'type' => 'text',
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
                                    echo $this->Form->input ( 'bank_account_code', array (
                            			'div' => false,
                            			'label' => false,
                            			'type' => 'text',
                            			'class' => 'must_info',
                            			'id' => 'bank_account_code',
                            			'value' => $student['User']['bank_account_code']
                            		));
                        		?>
                        	</td>
                        </tr>
                    </table>
                    </div><!--End #change_info-->
                    <div id="submit">
                            <?php
                            echo $this->Form->button('アカウントを削除',
								array(
									'name' => 'data[delete_student]',
									'class' => 'link-button',
									'onClick' => "return confirm('このアカウントを削除したいですか?')",
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
                            echo $this->Form->button ( '作成', array (
                            	'type' => 'submit',
                            	'name' => 'data[submit_data]',
                            	'class' => 'link-button',
                            	'id' => 'submit_button' ) );
                            ?>
                        </div><!--End #submit-->
<?php echo $this->Form->end();?>