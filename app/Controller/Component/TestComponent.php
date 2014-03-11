<?php

class TestComponent extends Component {
	public function loadTestFile($file_link=null,$file_name=null){
		$file= file_get_contents('../webroot/test2.tsv');
		$lines= preg_split('/\n+/', $file);
		$ql= new QuestionList();
		$words=preg_split('/\t+/', $lines[0]);
		$words[1] = trim(preg_replace('/\s\s+/',' ',$words[1]));
		$ql->title=$words[1];
		$words=preg_split('/\t+/', $lines[1]);
		$words[1] = trim(preg_replace('/\s\s+/',' ',$words[1]));
		$ql->subtitle=$words[1];
		$i=0;
		foreach ($lines as $line) {
			if(preg_match('/Q\(/',$line))
			{
				$line = trim(preg_replace('/\s\s+/',' ',$line));
				$words=preg_split('/\t+/', $line);
				if($words[0]=="Q($i)") {
					if($words[1]=="KS") {
						// $q->result=$words[2];
						$q->mark=	$words[3];
					}
					else {
						$q->answers[] = array($words[1] => $words[2]);
					}
				} else {
					$i++;
					$q= new Question();
					if($i!=0) $ql->questions[] = array("Q($i)" => $q );
					$q->question=$words[2];
				}
			}
		}
		// if($i!=0) $ql->questions[] = array("Q($i)" => $q );
		return $ql;
	}

	public function loadResult($file_link=null, $file_name=null){
		$file= file_get_contents('../webroot/test2.tsv');
		$lines= preg_split('/\n+/', $file);
		$i = 1;
		$listResult="";
		foreach ($lines as $line) {
			if(preg_match('/Q\(/',$line)) {
				$line = trim(preg_replace('/\s\s+/',' ',$line));
				$words=preg_split('/\t+/', $line);
				if ($words[0]=="Q($i)" && $words[1]=="KS"){
					// $result[$i]=$words[2];
					preg_match_all('!\d+!', $words[2], $number);
					$listResult = $listResult."-";
					$listResult = $listResult.$number[0][0];
					$i++;
				}
			}
		}
		return $listResult;
	}

	public function saveResult($leng,$answers){
		$listResult = "";
		for ($i=1; $i <=$leng ; $i++) { 
			if (isset($answers[$i])) {
				$listResult = $listResult."-";
				$listResult = $listResult.$answers[$i];
			}else {
				$listResult = $listResult."-0";
			}
		}
		return $listResult;
	}
}
/**
* 
*/
class QuestionList
{
	public $title="";
	public $subtitle="";
	public $questions = array();
}
/**
* 
*/
class Question
{
	public $question = '';
	public $answers = array();
	public $mark;
}

?>