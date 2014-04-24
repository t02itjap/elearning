<?php

class TestUtilComponent extends Component {
	public function loadTestFile($file_contents){
		$lines= preg_split('/\n+/', $file_contents);
		$numberline = count($lines);
		$ql= new QuestionList();

		
		$i = 0; // index of line.
		//Get title.
		while (true) {
			$lines[$i] = $this->formalString($lines[$i]);
			if (strlen($lines[$i])==0) $i++; // This line is a comment.
			else {
				$words=preg_split('/\t+/', $lines[$i]);
				if (count($words)>2) return false;
				if ($words[0]!='TestTitle') return false;				
				$ql->title = $words[1];
				$i++;
				break;
			}
		}
		//Get Subtitle.
		while (true) {
			$lines[$i] = $this->formalString($lines[$i]);
			if (strlen($lines[$i])==0) $i++; // This line is a comment.
			else {
				$words=preg_split('/\t+/', $lines[$i]);
				if (count($words)>2) return false;
				if ($words[0]!='TestSubTitle') return false;				
				$ql->subtitle = $words[1];
				break;
			}
		}

		//Get Question
		$q = 0; //First question is number 1.
		$a = 0;
		$isFinish = false;
		while ($i<$numberline-1) {
			$i++;
			$lines[$i] = $this->formalString($lines[$i]);
			if (strlen($lines[$i])==0) continue;
			$words = preg_split('/\t+/', $lines[$i]);
			if ($words[0]!="Q($q)"){ // Check new question
				if ($words[0]=='End' && count($words)!=1) return false;
				if ($words[0]=='End')  {
					$isFinish = true;
					continue;
				}
				if ($words[1]!='QS') return false;
				$q++;
				if (count($words)!=3) return false;
				$ql->questions[$q]['question'] = $words[2];
				$a = 1;
			} else { // found Q($q)
				if ($words[1]=='KS') {
					if (count($words)!=4) return false;
					$ql->questions[$q]['mark'] = $words[3];
					$qa = $this->getNumberFromString($words[2]);
					if ($qa==false) return false;
					$ql->questions[$q]['correct'] = $qa;
				} else {
					if ($words[1]!="S($a)" || count($words)!=3 ) return false;
					$ql->questions[$q]['answers'][$a] = $words[2];
					$a++;
				}
			}
		}
		if ($isFinish==true) return $ql;
		else return false;
	}

	public function formalString($s){
		$s = str_replace(strstr($s,'#'),'', $s);
		$s = ltrim($s); $s = rtrim($s);
		return $s;
	}

	public function getNumberFromString($s){
		preg_match_all('!\d+!', $s, $matches);
		if (count($matches[0])!=1) return false;
		return $matches[0][0];
	}

	public function loadResult($file_link){
		$file= file_get_contents($file_link);
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
	public $title;
	public $subtitle;
	public $questions;
}

?>