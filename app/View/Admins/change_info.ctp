<?php echo $this->Session->flash();?>
<?php echo $this->Form->create('User',array('type'=>'post'))?>
                    <div id="change_info">
                    <table>
                        <tr>
                            <td>ユーザネーム</td>
                            <td><p><?php echo $admin['User']['user_name']?></p></td>
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
                            			'value' => $admin['User']['email']
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
                            			'value' => $admin['User']['phone_number']
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
                            			'value' => $admin['User']['address']
                            		));
                        		?>                            
                            </td>
                        </tr>
                        <?php 
                        	$t = count($ipList);
                        	echo $this->Form->hidden('hide', array(
								'value' => $t,
                        		'id' => 'count_click',
								'name' => 'data[hide]',
							));
                        ?>
                        <tr id = 'after_here'>
                        	<td>IPアドレス</td>
                        	<td>
                        	<?php                                            		
                        		echo $this->Form->button ( '追加', array (
	                            	'type' => 'button',
	                            	'class' => 'link-button',
                            		'id' => 'add_button',
                            		'onClick' => 'add_ip()', 
                            	));
                        	?>
                        	</td>
                        </tr>
                        <?php
                        for($i = 0; $i < count($ipList); $i++){
                        	echo '<tr id = ip_address'.$i.'><td></td><td>';
                        	echo $this->Form->input ( 'ip_address'.$i, array (
                            	'div' => false,
                            	'label' => false,
                            	'type' => 'text',
                            	'value' => $ipList[$i]['IpAddress']['ip_address'],
                            ));
                            echo $this->Form->button ( '削除', array (
	                            'type' => 'button',
	                            'class' => 'link-button',
                            	'id' => 'delete_button'.$i,
                            	'onClick' => 'delete_ip('.$i.')', 
                            ));
                            echo '</td></tr>';
                        }
                        ?>                        	
                    </table>
                    </div><!--End #change_info-->
                    <div id="submit">
                            <?php
                            echo $this->Form->button ( '変更', array (
                            	'type' => 'submit',
                            	'name' => 'data[submit_data]',
                            	'class' => 'link-button',
                            	'id' => 'submit_button' ) );
                            ?>
                        </div><!--End #submit-->
<?php echo $this->Form->end();?>
<script type="text/javascript">
function delete_ip(i){
	var ip_id = '#ip_address' + i;
	var button_id = '#delete_button' + i;
	$(ip_id).remove();
	$(button_id).remove();
}
function add_ip(){
	var i = $("#count_click").val();
	var ip_id = '#ip_address' + i;
	var text_input = "<tr id = 'ip_address"+i+"'><td></td><td><input type = 'text' name = 'ip_address"+i+"'><button type = 'button' onclick='delete_ip("+i+")' id = 'delete_button"+i+"'>削除</button></td></tr>";
	$("#after_here").after(text_input);
	i = parseInt(i) + 1;
	$("#count_click").val(i); 
}
</script>