<?php
class TestsController extends Controller{
function beforeFilter(){
		parent::beforeFilter();
		$this->layout= "student";
		// $this->Auth->authenticate = array ('Form' => array ('userModel' => 'User', 'fields' => array ('username' => 'user_name', 'password' => 'password' ) )//'scope' => array('User.')
		//  );
		// $this->Auth->allow ( array ('home', 'login', 'register' ) );
	}
	public function index(){
	
	}
}