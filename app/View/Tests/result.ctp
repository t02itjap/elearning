<div id="test_result">
    <p>学生名：<?=$userName?></p>
    <p>合計質問数：<?=$totalQuestions?></p>
    <p>正しい答え数：<?=$totalCorrectAnswers?></p>
    <p>合計点数:<?=$mark?></p>
    <p>試験日：<?=$date?></p>
</div><!--End #test_result-->
<!-- <span style="border: 1px solid green"><input type="radio"/>sdfasfs<input type="radio"/>間違い答え</span> -->

<div id="test">
	<h4 style="color:blue;font-size: 14px;font-weight: bold;">青い色：正解</h4>   <h4 style ="color:red;font-size: 14px;font-weight: bold;">赤い色：選択した答え</h4>
    <ul>
        <?php 
        $q = $test->questions;
        for ($i =1; $i<=count($q); $i++) {
            $question = $q[$i]['question'];
            $mark = $q[$i]['mark'];
            echo '<li>';
            echo '<div class="question">';
            echo "<h4 name=$i> $i . $question ( $mark 点) </h4><br>";
            for ($j=1; $j<=count($q[$i]['answers']); $j++) {
                $answer = $q[$i]['answers'][$j];
                if ($j==$userAnswers[$i]) {
                    if ($j==$q[$i]['correct']) {
                        //Check and Blue.
                        echo "<p style='color: blue'><input name=$i disable='true' checked='true' value=$j type='radio'/>$j.$answer</p><br />";
                    } else {
                        //Check and not Blue.
                        echo "<p style='color: red'><input name=$i disable='true' checked='true' value=$j type='radio'/>$j.$answer</p><br />";
                    }
                } else {
                    if ($j==$q[$i]['correct']) {
                        //Uncheck and Blue.
                        echo "<p style='color: blue'><input name=$i disable='true' value=$j type='radio'/>$j.$answer</p><br />";
                    } else {
                        //Uncheck and not Blue.
                        echo "<p style='color: black'><input name=$i disable='true' value=$j type='radio'/>$j.$answer</p><br />";
                    }

                }                
            }
            echo '</div>';
            echo '</li>';
        }
        ?>

    </ul>
</div>
