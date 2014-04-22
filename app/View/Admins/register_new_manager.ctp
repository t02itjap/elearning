<!-- ham tao ngay thang nam -->
<?php
for($i = 1900; $i <= date ( 'Y' ) - 1; $i ++) {
	$birthYearOptions [$i] = $i;
}
for($i = 1; $i <= 12; $i ++) {
	if ($i < 10) {
		$birthMonthOptions ["0" . $i] = "0" . $i;
	} else {
		$birthMonthOptions [$i] = $i;
	}
}
for($i = 1; $i <= 31; $i ++) {
	if ($i < 10) {
		$birthDayOptions ["0" . $i] = "0" . $i;
	} else {
		$birthDayOptions [$i] = $i;
	}
}
?>
<!-- end ham tao ngay thang nam -->
<!-- start regiter form -->
<?php
echo $this->Form->create ( 'User', array ('type' => 'file' ) )?>
<div id="register_info">
<h4><span>*</span>は必ずインプットしてください</h4>
<table>
	<tr>
		<td><span>*</span>ユーザネーム</td>
		<td>
        	<?php
				echo $this->Form->input ( 'user_name', array ('div' => false, 'label' => false, 'type' => 'text', 'class' => 'must_info', 'id' => 'user_name' ) );
			?>
        </td>
	</tr>
	<tr>
		<td><span>*</span>名前</td>
		<td>
            <?php
				echo $this->Form->input ( 'real_name', array ('div' => false, 'label' => false, 'type' => 'text', 'class' => 'must_info', 'id' => 'real_name' ) );
			?>
        </td>
	</tr>
	<tr>
		<td><span>*</span>パスワード</td>
		<td>
            <?php
				echo $this->Form->input ( 'password', array ('div' => false, 'label' => false, 'type' => 'password', 'class' => 'must_info', 'id' => 'password' ) );
			?>
         </td>
	</tr>
	<tr>
		<td><span>*</span>確認パスワード</td>
		<td>
            <?php

				echo $this->Form->input ( 're_password', array ('div' => false, 'label' => false, 'type' => 'password', 'class' => 'must_info', 'id' => 're_password' ) );																										
			?>
                            </td>
	</tr>
	<tr>
		<td><span>*</span>ipアドレス</td>

		<td>
            <?php
				echo $this->Form->input ( 'ip_address', array ('div' => false, 'label' => false, 'type' => 'text', 'class' => 'must_info', 'id' => 'ip_address' ) );
			?>
        </td>
    </tr>
    <?php
    	If(isset($ipAddressErr)){
					echo '<tr><td></td><td><font color = "#8A0808">'.$ipAddressErr.'</font></td></tr>';
		}
	?>
	<tr>
		<td><span>*</span>メール</td>
		<td>
            <?php
				echo $this->Form->input ( 'email', array ('div' => false, 'label' => false, 'type' => 'text', 'class' => 'must_info', 'id' => 'mail' ) );
			?>
        </td>
	</tr>
	<!--ngay thang nam sinh-->
	<tr>
		<td><span>*</span>誕生日</td>
		<td>
			日： <?php
			echo $this->Form->input ( 'birth_date', array ('label' => false, 'class' => 'input-small', 'options' => $birthDayOptions, 'div' => false, 'id' => 'birth-date', 'empty' => '-' ) );
			
			?>
			月： <?php
			echo $this->Form->input ( 'birth_month', array ('label' => false, 'class' => 'input-small', 'options' => $birthMonthOptions, 'id' => 'birth-month', 'div' => false, 'empty' => '-' ) );
			?>
			年：<?php
			echo $this->Form->input ( 'birth_year', array ('label' => false, 'class' => 'input-small', 'options' => $birthYearOptions, 'id' => 'birth-year', 'div' => false, 'empty' => '-' ) );
			?> 
        </td>
	</tr>
	<!-- end ngay thang nam sinh -->
	<tr>
		<td><span>*</span>アドレス</td>
		<td>
            <?php
				echo $this->Form->input ( 'address', array ('div' => false, 'label' => false, 'type' => 'text', 'class' => 'must_info', 'id' => 'address' ) );
			?>
        </td>
	</tr>
	<tr>
		<td><span>*</span>電話番号</td>
		<td>
            <?php
				echo $this->Form->input ( 'phone_number', array ('div' => false, 'label' => false, 'type' => 'number', 'class' => 'must_info', 'id' => 'phone_number' ) );
			?>
        </td>
	</tr>
</table>
</div>
<!--End #register_info-->
<div id="submit">
	<?php
		echo $this->Form->button ( '登録', array ('type' => 'submit', 'name' => 'data[submit_data]', 'id' => 'submit_button' ) );
		echo $this->Form->button ( 'リセット', array ('type' => 'reset' ) );
	?>
</div>
<!--End #submit-->
<?php
echo $this->Form->end ()?>
<!-- end form -->
<script type="text/javascript">
$("#submit_button").click(function(){
    var passwordVal = $("#password").val();
    var checkVal = $("#re_password").val();
    if (passwordVal != checkVal ) {
        $("#re_password").after('<br><span class = "error-message">確認パスワードが間違い。</span>');
        return false;
    }
});
</script>