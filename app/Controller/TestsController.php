<?php
class TestsController extends AppController{
	var $uses = array('Test','TestHistory');
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
		// $file = WWW_ROOT . DS . $t['Test']['create_user_id'] . DS . $t['Test']['file_link'];
		$file = WWW_ROOT . $t['Test']['file_link'];
		$test = $this->TestUtil->loadTestFile(file_get_contents($file));
		$this->set('testObject',$test);
		$this->Session->write('id',$id);
		$this->Session->write('testContent',$test);
	}

	public function save(){
		$id = $this->Session->read('id');
		$test = $this->Session->read('testContent');
		//Total number questions;
		$leng = count($test->questions);
		//User Answers
		$userAnswers = $this->request->data;
			//Parse User Answers to String to push to DataBase
		$userAnswersString = $this->TestUtil->saveResult($leng,$userAnswers);

		$totalScore = 0;
		for ($i=1; $i <= $leng; $i++) { 
			if (isset($userAnswers[$i]) && $userAnswers[$i]==$test->questions[$i]['correct']){
				$totalScore=$totalScore + $test->questions[$i]['mark'];
				debug($test->questions[$i]['mark'] . '----' . $totalScore);
			}
		}
		//debug($this->Auth->user('id'));die();
		$this->TestHistory->create();
		$this->TestHistory->set(array(
			'user_id'=>$this->Auth->user('id'),
			'test_id'=>$id,
			'test_date'=>date("Y-m-d H:i:s", time()),
			'answers'=>$userAnswersString,
			'score'=>$totalScore	
			));
		$this->TestHistory->save();

		$testID = $this->TestHistory->find('first', array(
							'fields'=>array('TestHistory.id'),
							'order' => array('id' => 'DESC')
							));
		$this->redirect(array('controller' => 'tests', 'action' => 'result', $testID['TestHistory']['id']));
	}

	public function result($testID){
		if (!isset($testID)) die;
		$his = $this->TestHistory->findById($testID);
			// $file = WWW_ROOT . DS . $t['Test']['create_user_id'] . DS . $t['Test']['file_link'];
		$file = WWW_ROOT . $his['Test']['file_link'];
		$test = $this->TestUtil->loadTestFile(file_get_contents($file));
		//User Answers
		$userAnswers = preg_split('/-+/', $his['TestHistory']['answers']);

		$totalQuestions = count($test->questions);
		$totalScore = $his['TestHistory']['score'];
		$totalCorrectAnswers = 0;
		for ($i=1; $i <= $totalQuestions; $i++) 
			if ($userAnswers[$i]==$test->questions[$i]['correct']) $totalCorrectAnswers++;

		$this->set('test',$test);
		$this->set('userAnswers',$userAnswers);
		$this->set('userName',$his['User']['user_name']);
		$this->set('totalCorrectAnswers',$totalCorrectAnswers);
		$this->set('totalQuestions',$totalQuestions);
		$this->set('mark',$totalScore);
		$this->set('date',$his['TestHistory']['test_date']);
	}
}
