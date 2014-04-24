<?php
class User extends AppModel {
	var $name = 'User';
	var $primaryKey = 'id';
	public $validate = array(
		'user_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ユーザネームを入力してください。',
			),
			'min' => array(
				'rule' => array('minLength', 3),
				'message' => 'ユーザネームが３キャラクタ以上あらなければなりません',
			),
			'max' => array(
				'rule' => array('maxLength', 16),
				'message' => 'ユーザネームが１６キャラクタ以下あらなければなりません',
			),
			'check character' => array(
				'rule' => '/^[a-z0-9]{3,16}$/i',
				'message' => 'ユーザネームが数と通常キャラクタがあらなければなりません'
			),
			'check exist' => array(
				'rule' => 'isUnique',
				'message' => 'このユーザネームが存在でした。',
			),
		),
		'real_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '名前を入力してください。',
			),
		),
		'email' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'メールを入力してください。',
			),
			'check validation' => array(
				'rule' => array('email'),
				'message' => 'メール形態が間違いです。',
			),
			'check exist' => array(
				'rule' => 'isUnique',
				'message' => 'このメールが存在でした',
			)
		),
		'address' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'アドレスを入力してください。',
			),
		),
		'bank_accout_code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '銀行口座あういはクレジットカード番号を入力してください。',
			),
		),
		'phone_number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '電話番号を入力してください。',
			),
			'min' => array(
				'rule' => array('minLength', 6),
				'message' => '電話番号が６キャラクタ以上あらなければなりません ',
			),
			'max' => array(
				'rule' => array('maxLength', 15),
				'message' => '電話番号が１５キャラクタ以下あらなければなりません',
			),
		),
		'birth_date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '誕生日をにゅうりょくしてください。',
			),
			'check birth date' => array(
				'rule' => array('date','ymd'),
				'message' => '誕生日が間違い。'
			),
		),
	);
	
	//tai khoan co level 1 admin ko
	public function isAdmin($id){
		return ($this->field('level',array('id'=>$id)) == 1);
	}
	//tai khoan co level 2 teacher ko
	public function isTeacher($id){
		return ($this->field('level',array('id'=>$id)) == 2);
	}
	//tai khoan co level 3 student ko
	public function isStudent($id){
		return ($this->field('level',array('id'=>$id)) == 3);
	}
	//kiem tra tai khoan hien co online hay ko
	public function isOnline($uname,$pass){
		$user = $this->find('first',array('user_name'=>$uname,'password'=>$pass));
		if(!empty($user)){
			return $user['User']['online_flag']== 1;
		}		
	}
	public function foo(){
		
	}
}