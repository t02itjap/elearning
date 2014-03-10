<div id="main_content">
    <div id="test_result">
        <p>学生名：<?=$userName?></p>
        <p>合計質問数：<?=$totalQuestions?></p>
        <p>正しい答え数：<?=$totalCorrectAnswers?></p>
        <p>合計点数:<?=$mark?></p>
    </div><!--End #test_result-->
    <!-- <span style="border: 1px solid green"><input type="radio"/>sdfasfs<input type="radio"/>間違い答え</span> -->

    <div id="test">
        <ul>
            <?php $i = 0; foreach ($testObject->questions as $key=>$q):?>
            <li>
                <div class="question">
                    <?php $i++;?>
                    <h4 id =<?='Question'.$i?> name=<?=$i?>> <?=$i.'.'.$q["Q($i)"]->question.'('.$q["Q($i)"]->mark.'点)'?> </h4><br>
                    <?php $j = 0; foreach ($q["Q($i)"]->answers as $key => $a):?>
                    <?php $j++; 
                    if (!isset($listUserAnswers[$i])) $listUserAnswers[$i]=0;
                    if ($j==$listUserAnswers[$i]){
                        if ($j==$listCorrectAnswers[$i]){
                                // Check and Red
                            ?>
                            <p style='color: blue'><input id=<?=$i.$j?> disabled='true' name=<?=$i?> checked='true' value=<?=$j?> type="radio" /><?=$j.'.'.$a["S($j)"]?></p><br />
                            <?php 
                        }else {
                                //Check, not Red
                            // Debug($i.$j."Check & UnRed");
                            ?>
                            <p style='color: black'><input id=<?=$i.$j?> name=<?=$i?> disabled='true' checked='true' value=<?=$j?> type="radio" /><?=$j.'.'.$a["S($j)"]?></p><br />
                            <?php 
                        }
                    } else {
                        if ($j==$listCorrectAnswers[$i]){
                                // UnCheck and Red
                            // Debug($i.$j."UnCheck & Red");   
                            ?>
                            <p style='color: blue'><input id=<?=$i.$j?> disabled='true' name=<?=$i?> value=<?=$j?> type="radio" /><?=$j.'.'.$a["S($j)"]?></p><br />
                            <?php 

                        }else {
                                //UnCheck, not Red
                            // Debug($i.$j."UnCheck & UnRed");   
                            ?>
                            <p style='color: black'><input id=<?=$i.$j?> name=<?=$i?> disabled='true' value=<?=$j?> type="radio" /><?=$j.'.'.$a["S($j)"]?></p><br />
                            <?php 
                        }
                    }
                    ?>
                <?php endforeach; ?>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
</div>
</div><!--End #main_content-->
