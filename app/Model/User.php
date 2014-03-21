<?php
class User extends AppModel {
	var $name = 'User';
	var $primaryKey = 'id';
	public $validate = array(
		'user_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap user name',
			),
			'min' => array(
				'rule' => array('minLength', 4),
				'message' => 'user name phai co it nhat 4 ki tu ',
			),
			'max' => array(
				'rule' => array('maxLength', 16),
				'message' => 'user name khong duoc qua 16 ki tu',
			),
			'check character' => array(
				'rule' => '/^[a-z0-9]{4,16}$/i',
				'message' => 'user name chi chua so va chu cai thuong'
			),
			'check exist' => array(
				'rule' => 'isUnique',
				'message' => 'user name da ton tai',
			),
		),
		'real_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap ten that',
			),
		),
		'email' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap mail',
			),
			'check validation' => array(
				'rule' => array('email',true),
				'message' => 'mail cua ban khong hop le',
			),
			'check exist' => array(
				'rule' => 'isUnique',
				'message' => 'email nay da duoc su dung',
			)
		),
		'address' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap dia chi',
			),
		),
		'bank_accout_code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap ma ngan hang',
			),
		),
		'phone_number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap so dien thoai',
			),
		),
		'birth_date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'hay nhap ngay sinh',
			),
			'check birth date' => array(
				'rule' => array('date','ymd'),
				'message' => 'ngay sinh khong hop le'
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