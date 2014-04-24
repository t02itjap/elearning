<?php
class TestsController extends AppController{
	var $uses = array('Test');
	var $components=array('Session','TestUtil');
	function beforeFilter(){
		parent::beforeFilter();
		$this->layout= "student";
		//$test=$this->Test->loadTestFile(null,null);
		//debug($test);
	}
	public function index(){
	}
	public function test($id){
		if (!isset($id)) $this->redirect(array('controller' => 'tests', 'action' => 'test', 1));
		$t = $this->Test->findById($id);
		$file = WWW_ROOT . $t['Test']['file_link'];
		$test = $this->TestUtil->loadTestFile($file);
		$this->set('testObject',$test);
	}

	public function save($id){
		// if (!isset($id)) $this->redirect(array('controller' => 'tests', 'action' => 'test', 1));
		debug($this->request->data);
		die;
		$t = $this->Test->findById($id);
		$file = WWW_ROOT . $t['Test']['file_link'];

		$results = $this->Test->loadResult($file);
		$i=0;
		$mark;
		foreach ($test->questions as $key => $q) {
			$i++;
			$mark[$i] = $q[$i]->mark;
		}
			//Parse Corrects Answers to Array to be easy to equal them.
		$ans = preg_split('/\-+/',$results);
			//Total number questions;
		$leng = count($ans)-1;

			//User Answers
		$userAnswers = $this->request->data;
			//Parse User Answers to String to push to DataBase
		$userAnswersString = $this->TestUtil->saveResult($leng,$userAnswers);

		$totalScore = 0;
		for ($i=1; $i <= $leng; $i++) { 
			if (isset($userAnswers[$i]) && $userAnswers[$i]==$ans[$i]){
				$totalScore+=$mark[$i];
			}
		}


	}

	public function result($testID){
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
		}
	}
}
