<!-- ham tao ngay thang nam -->
<?php
		for ($i = 1900; $i <= date('Y')-1; $i++) {
			$birthYearOptions[$i] = $i;
		}
		for ($i = 1; $i <= 12; $i++) {
			if ($i < 10) {
				$birthMonthOptions["0".$i] = "0".$i;
			} else {
				$birthMonthOptions[$i] = $i;
			}
		}
		for ($i = 1; $i <= 31; $i++) {
			if ($i < 10) {
				$birthDayOptions["0".$i] = "0".$i;
			} else {
				$birthDayOptions[$i] = $i;
			}
		}			
?>
<!-- end ham tao ngay thang nam -->
<!-- start regiter form -->
<?php echo $this->Form->create('User', array('type' => 'post')) ?>
                <div id="register_info">
                    <h4><span>*</span>は必ずインプットしてください</h4>
                    <table>
                        <tr>
                        	<td>
                            	<span>*</span>ユーザネーム
                            </td>
                            <td>
                            	<?php
                            	echo $this->Form->input('user_name', array(
												'div' => false,
												'label' => false,
												'type' => 'text',
                            					'class' => 'must_info',
                            					'id' => 'user_name'
												));
								?>
                            </td>
                        </tr>
                        <tr>
                            <td><span>*</span>自分の名前</td>
                            <td>
                            	<?php
                            	echo $this->Form->input('real_name', array(
												'div' => false,
												'label' => false,
												'type' => 'text',
                            					'class' => 'must_info',
                            					'id' => 'real_name'
												));
								?>
                            </td>
                        </tr>
                        <tr>
                            <td><span>*</span>パスワード</td>
                            <td>
                            	<?php
                            	echo $this->Form->input('password', array(
												'div' => false,
												'label' => false,
												'type' => 'password',
                            					'class' => 'must_info',
                            					'id' => 'password'
												));
								?>
                            </td>
                        </tr>
                        <tr>
                            <td><span>*</span>確認パスワード</td>
                            <td>
                            	<?php
                            	echo $this->Form->input('re_password', array(
												'div' => false,
												'label' => false,
												'type' => 'password',
                            					'class' => 'must_info',
												'id' => 're_password'
                            					));
												
								?>
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td><span>*</span>メール</td>
                            <td>
                            	<?php
                            	echo $this->Form->input('email', array(
												'div' => false,
												'label' => false,
												'type' => 'text',
                            					'class' => 'must_info',
                            					'id' => 'mail'
												));
								?>
                            </td>
                        </tr>
                        
<!--ngay thang nam sinh-->
                        <tr>
                            <td>誕生日</td>
                            <td>
							日： <?php
									echo $this->Form->input('birth_date', array(
							       'label' => false,
							       'class' => 'input-small', 
							       'options' => $birthDayOptions, 
							       'div' => false,
							       'id' => 'birth-date',
							       'empty' => '-',
							
									));
								   ?>
							月： <?php
									echo $this->Form->input('birth_month', array(
							       'label' => false, 
							       'class' => 'input-small', 
							       'options' => $birthMonthOptions,
							       'id' => 'birth-month',
							       'div' => false,
							       'empty' => '-'
							       ));
							       ?>
							年：<?php
							       echo $this->Form->input('birth_year', array(
							       'label' => false, 
							       'class' => 'input-small', 
							       'options' => $birthYearOptions,
							       'id' => 'birth-year',
							       'div' => false,
							       'empty' => '-'
							       ));
							       ?> 
                            </td>
                        </tr>
<!-- end ngay thang nam sinh -->

                        <tr>
                            <td><span>*</span>アカウントタイプ</td>
                            <td>
                            	<?php
                            		$userType[2] = '先生';
                            		$userType[3] = '学生';
									echo $this->Form->input('user_type', array(
							       'label' => false,
							       'class' => 'input-small', 
							       'options' => $userType, 
							       'div' => false,
									'id' => 'user_type'
									));
								   ?>
                            </td>
                        </tr>
                        <tr id="quest">
                            <td><span>*</span>秘密質問</td>
                            <td>
                            	<?php
                            	echo $this->Form->input('email', array(
												'div' => false,
												'label' => false,
												'type' => 'text',
                            					'class' => 'must_info',
                            					'id' => 'question'
												));
								?>
                            </td>
                        </tr>
                        <tr id="ans">
                            <td><span>*</span>答え</td>
                            <td>
                            	<?php
                            	echo $this->Form->input('verifycode', array(
												'div' => false,
												'label' => false,
												'type' => 'text',
                            					'class' => 'must_info',
                            					'id' => 'answer'
												));
								?>
                            </td>
                        </tr>
                        	<td id="bank"><span>*</span>銀行口座</td>
                        	<td id="regedit" hidden='true'><span>*</span>クレジットカード番号</td>
                            <td>
                            	<?php
                            	echo $this->Form->input('bank_code', array(
												'div' => false,
												'label' => false,
												'type' => 'text',
                            					'class' => 'must_info',
                            					'id' => 'bank_code'
												));
								?>
                            </td>
                        </tr>
                            <td></td>
                        <tr>
                            <td><span>*</span>アドレス</td>
                            <td>
                            	<?php
                            	echo $this->Form->input('address', array(
												'div' => false,
												'label' => false,
												'type' => 'text',
                            					'class' => 'must_info',
                            					'id' => 'address'
												));
								?>
                            </td>
                        </tr>
                        <tr>
                            <td><span>*</span>電話番号</td>
                            <td>
                            	<?php
                            	echo $this->Form->input('phone_number', array(
												'div' => false,
												'label' => false,
												'type' => 'text',
                            					'class' => 'must_info',
                            					'id' => 'phone_number'
												));
								?>
                            </td>
                        </tr>
                                                <tr>
                            <td>プロフィール写真</td>
                            <td>
								<?php 
								echo $this->Form->input('profile_img',array(
									 		'type' => 'file',
									 		'label' => false,
											'id' => ' profile_img'
											));
								?>
                            </td>
                        </tr>
                        
                    </table>
                </div><!--End #register_info-->
                
                <div id="rule">
                    <h4><span>*</span>システムの使用要求</h4>
                    <?php
                    	echo $this->Form->input('agree', array(
							'type' => 'checkbox',
							'label' => '賛成',
							'id' => 'agree_rule'
						));
					?>
                </div><!--End #rule-->
                
                <div id="submit">
                	<?php echo $this->Form->button('登録', array('type' => 'submit', 'name' => 'data[submit_data]', 'disabled' => 'disabled', 'id' => 'submit_button'));?>
                    <?php echo $this->Form->button('リセット', array('type' => 'reset'));?>
                </div><!--End #submit-->
<?php echo $this->Form->end() ?>
<!-- end form -->
<script type="text/javascript">
$(document).ready(function(){
	$("#agree_rule").click(function(){
		var checked = $(this).attr("checked");
		  if(checked == true){
		      $("#submit_button").removeAttr("disabled");
		  }
		  else{
		   $("#submit_button").attr("disabled","disabled");
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
	$("#re_password").blur(function(){
		var value = $(this).val();
		if(value != $("#password").val()){
			alert("xac nhan mat khau khong dung");
			$(this).focus();
		}
	});
});
</script>