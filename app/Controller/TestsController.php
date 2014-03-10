<?php
class TestsController extends AppController{
	var $components=array('Session','Test');
	function beforeFilter(){
		parent::beforeFilter();
		$this->layout= "student";
		//$test=$this->Test->loadTestFile(null,null);
		//debug($test);
	}
	public function index(){
		$test = $this->Test->loadTestFile(null,null);
		$this->Session->write('testObject',$test);
		$this->set('testObject',$test);
		// $test=$this->Test->loadTestFile(null,null);
		// debug($test); die();
		//debug($this->Test->loadTestFile(null,null));
	}
	public function result(){
		if(isset($this->request->data['result'])){

			//Get List question and Mark from Session
			$test = $this->Session->read('testObject');

			//load Correct Answers from DataBase
			$results = $this->Test->loadResult();
			$i=0;
			$mark;
			foreach ($test->questions as $key => $q) {
				$i++;
				$mark[$i] = $q["Q($i)"]->mark;
			}
			//Parse Corrects Answers to Array to be easy to equal them.
			$ans = preg_split('/\-+/',$results);
			//Total number questions;
			$leng = count($ans)-1;

			//User Answers
			$userAnswers = $this->request->data;
			//Parse User Answers to String to push to DataBase
			$userAnswersString = $this->Test->saveResult($leng,$userAnswers);

			$totalScore = 0;
			$totalCorrectAnswers = 0;
			for ($i=1; $i <= $leng; $i++) { 
				if (isset($userAnswers[$i]) && $userAnswers[$i]==$ans[$i]){
					$totalScore+=$mark[$i];
					$totalCorrectAnswers++;
				}
			}

			$this->set('testObject',$test);
			$this->set('listUserAnswers',$userAnswers);
			$this->set('listCorrectAnswers',$ans);
			$this->set('userName',$this->Auth->user('user_name'));
			$this->set('totalCorrectAnswers',$totalCorrectAnswers);
			$this->set('totalQuestions',$leng);
			$this->set('mark',$totalScore);
			// this->set('user',)

			// debug('UserAnswers:');debug($userAnswers);
			// debug('CorrectAnswers:'); debug($ans);
			// debug($mark);
			// debug($totalScore);
			// die();
		}
	}
}
