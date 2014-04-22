<?php
echo $this->Html->script ( array (
		'jquery.validate', 'jquery-1.4.4.min.js'
) );
?>

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
echo $this->Form->create ( 'User', array ('type' => 'post', 'novalidate' => 'true', 'id' => 'form') )?>
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
			<td><span>*</span>自分の名前</td>
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
			<tr>
				<td><span>*</span>メール</td>
				<td>
					<?php
					echo $this->Form->input ( 'email', array ('div' => false, 'label' => false, 'type' => 'text', 'class' => 'must_info', 'id' => 'mail' ) );
					?>
				</td>
		</tr>

			<tr>
				<td><span>*</span>アカウントタイプ</td>
				<td>
					<?php
					$userType [2] = '先生';
					$userType [3] = '学生';
					echo $this->Form->input ( 'user_type', array ('label' => false, 'class' => 'input-small', 'options' => $userType, 'div' => false, 'id' => 'user_type' ) );
					?>
				</td>
			</tr>
			<tr id="quest">
				<td><span>*</span>秘密質問</td>
				<td>
					<?php
					echo $this->Form->input ( 'question', array ('div' => false, 'label' => false, 'type' => 'text', 'class' => 'must_info', 'id' => 'question' ) );
					?>
				</td>
			</tr>
			<?php if(isset($questionErr)) echo '<tr><td></td><td><font color = "#8A0808">'.$questionErr.'</font></td></tr>';?>
			<tr id="ans">
				<td><span>*</span>答え</td>
				<td>
					<?php
					echo $this->Form->input ( 'verifycode', array ('div' => false, 'label' => false, 'type' => 'text', 'class' => 'must_info', 'id' => 'answer' ) );
					?>
				</td>
			</tr>
			<?php if(isset($answerErr)) echo '<tr><td></td><td><font color = "#8A0808">'.$answerErr.'</font></td></tr>';?>
		<tr id="bank">
			<td><span>*</span>銀行口座</td>
			<td>
				<?php
				echo $this->Form->input('bankCodePart1', array('div' => false, 'label' => false, 'type' => 'text','maxlength' => '4', 'style' => 'width: 32px', 'class' => 'onlyNumber', 'id' => 'bankCodePart1' ));
				echo "<b style = 'font-size: 20px'> - </b>";
				echo $this->Form->input('bankCodePart2', array('div' => false, 'label' => false, 'type' => 'text','maxlength' => '3', 'style' => 'width: 24px', 'class' => 'onlyNumber', 'id' => 'bankCodePart2' ));
				echo "<b style = 'font-size: 20px'> - </b>";
				echo $this->Form->input('bankCodePart3', array('div' => false, 'label' => false, 'type' => 'text','maxlength' => '1', 'style' => 'width: 8px', 'class' => 'onlyNumber', 'id' => 'bankCodePart3' ));
				echo "<b style = 'font-size: 20px'> - </b>";
				echo $this->Form->input('bankCodePart4', array('div' => false, 'label' => false, 'type' => 'text','maxlength' => '7', 'style' => 'width: 56px', 'class' => 'onlyNumber', 'id' => 'bankCodePart4' ));							
				?>
			</td>
		</tr>
		<tr id="regedit" hidden='true'>
			<td><span>*</span>クレジットカード番号</td>
			<td>
				<?php
				echo $this->Form->input('cardPart1', array('div' => false, 'label' => false, 'type' => 'text','maxlength' => '8', 'style' => 'width: 64px', 'class' => 'onlyNumber', 'id' => 'cardPart1' ));
				echo "<b style = 'font-size: 20px'> - </b>";
				echo $this->Form->input('cardPart2', array('div' => false, 'label' => false, 'type' => 'text','maxlength' => '4', 'style' => 'width: 32px', 'class' => 'onlyNumber', 'id' => 'cardPart2' ));
				echo "<b style = 'font-size: 20px'> - </b>";
				echo $this->Form->input('cardPart3', array('div' => false, 'label' => false, 'type' => 'text','maxlength' => '4', 'style' => 'width: 32px', 'class' => 'onlyNumber', 'id' => 'cardPart3' ));
				echo "<b style = 'font-size: 20px'> - </b>";
				echo $this->Form->input('cardPart4', array('div' => false, 'label' => false, 'type' => 'text','maxlength' => '4', 'style' => 'width: 32px', 'class' => 'onlyNumber', 'id' => 'cardPart4' ));							
				echo "<b style = 'font-size: 20px'> - </b>";
				echo $this->Form->input('cardPart5', array('div' => false, 'label' => false, 'type' => 'text','maxlength' => '4', 'style' => 'width: 32px', 'class' => 'onlyNumber', 'id' => 'cardPart5' ));				
				?>
			</td>
		</tr>
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
				echo $this->Form->input ( 'phone_number', array ('div' => false, 'label' => false, 'type' => 'number', 'class' => 'onlyNumber', 'id' => 'phone_number' ) );
				?>
			</td>
		</tr>
	</table>
</div>
<!--End #register_info-->

<div id="rule">
	<h4><span>*</span>システムの使用要求</h4>
	<?php
	echo $this->Form->input ( 'agree', array ('type' => 'checkbox', 'label' => '賛成', 'id' => 'agree_rule', 'checked' => false ) );
	?>
</div>
<!--End #rule-->

<div id="submit">
	<?php
	echo $this->Form->button ( '登録', array ('type' => 'submit', 'name' => 'data[submit_data]', 'disabled' => 'disabled', 'id' => 'submit_button' ) );
	?>
	<?php
	echo $this->Form->button ( 'リセット', array ('type' => 'reset' ) );
	?>
</div>
<!--End #submit-->
<?php
echo $this->Form->end ()?>
<!-- end form -->
<script type="text/javascript">
$(document).ready(function(){
	var value = $("#user_type").val();
	if(value == 3){
		$("#bank").hide();
		$("#regedit").show();
		$("#quest").hide();
		$("#ans").hide();
	}
//	$(".onlyNumber").keypress(function(e){
//        return !(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46);
//	});	
	$("#agree_rule").click(function(){
		var checked = $(this).attr("checked");
		if(checked == true){
			$("#submit_button").removeAttr("disabled");
		}else{
			$("#submit_button").attr("disabled","disabled");
		}
	});
	$("#submit_button").click(function(){
        var passwordVal = $("#password").val();
        var checkVal = $("#re_password").val();
        if (passwordVal != checkVal ) {
            $("#re_password").after('<br><span class="error-message">確認パスワードが間違い。</span>');
            return false;
        }
        if($("#user_type").val()==2){
            if($("#bankCodePart1").val().length < 4 || $("#bankCodePart2").val().length < 3 || $("#bankCodePart3").val().length < 1 || $("#bankCodePart4").val().length < 7){
				alert("銀行口座が間違いです。");
				return false;
            }
        }
        else{
            if($("#cardPart1").val().length < 8 || $("#cardPart2").val().length < 4 || $("#cardPart3").val().length < 4 || $("#cardPart4").val().length <4 || $("#cardPart5").val().length <4){
				alert("クレジットカード番号が間違いです。");
				return false;
            }
        }
            
	});
	$("#user_type").change(function(){
		var value = $(this).val();
		if(value==2){
			$("#bank").show();
			$("#regedit").hide();
			$("#quest").show();
			$("#ans").show();
		}else{
			$("#bank").hide();
			$("#regedit").show();
			$("#quest").hide();
			$("#ans").hide();
		}
	});
	
});
</script>