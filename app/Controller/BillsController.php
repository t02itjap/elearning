<?php
class BillsController extends AppController{
	public function index(){
		$this->set('bills',$this->Bill->getBills(3));
	}
}

?>