<?php //debug($requestUser); die();?>
<div id="change_info">
    <table>
        <tr>
            <td>ユーザネーム</td>
            <td><input type="text" value="<?php echo $requestUser['user_name']; ?>" disabled="true"/></td>
        </tr>
        
        <tr>
            <td>名前</td>
            <td><input type="text" value="<?php echo $requestUser['real_name']; ?>" disabled="true"/></td>
        </tr>

		<tr>
            <td>登録日</td>
            <td><input type="text" value="<?php echo $requestUser['reg_date']; ?>" disabled="true"/></td>
        </tr>        

        <tr>
            <td>生年月日</td>
            <td><input type="text" value="<?php echo $requestUser['birth_date']; ?>" disabled="true"/></td>
        </tr>

        <tr>
            <td>メール</td>
            <td><input type="text" value="<?php echo $requestUser['email']; ?>" disabled="true"/></td>
        </tr>

        <tr>
            <td>携帯番号</td>
            <td><input type="text" value="<?php echo $requestUser['phone_number']; ?>" disabled="true"/></td>
        </tr>

        <tr>
            <td>アドレス</td>
            <td><input type="text" value="<?php echo $requestUser['address']; ?>" disabled="true"/></td>
        </tr>

        <tr>
        <?php 
        	if($requestUser['level']==2)
            	echo '<td>銀行口座</td>';
            else
            	echo '<td>クレジット</td>';            	
        ?>
        	<td><input type="text" value="<?php echo $requestUser['bank_account_code']; ?>" disabled="true"/></td>
    	</tr>
    </table>
    <div>
    	<?php
    	echo $this->Html->link(
		    '確認',
		    array(
		        'controller' => 'admins',
		        'action' => 'accept_user',
		        $requestUser['id']
		    	),
		    array('class'=>'confirm_accept')
			);
    	echo '--------';
    	echo $this->Html->link(
		    '拒否',
		    array(
		        'controller' => 'admins',
		        'action' => 'remove_user',
		        $requestUser['id']
		    	),
		    array('class'=>'confirm_remove')
			);
		?>
    </div>
</div><!--End #change_info-->