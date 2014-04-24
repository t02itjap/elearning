<?php 
echo $this->Form->create('Tests',array('type' => 'post', 'controller'=>'tests','action'=>'save'));
?>

<div id="test">
    <ul>
        <?php 
            $q = $testObject->questions;
            for ($i =1; $i<=count($q); $i++) {
                $question = $q[$i]['question'];
                $mark = $q[$i]['mark'];
                echo '<li>';
                echo '<div class="question">';
                echo "<h4 name=$i> $i . $question ( $mark 点) </h4><br>";
                for ($j=1; $j<=count($q[$i]['answers']); $j++) {
                    $answer = $q[$i]['answers'][$j];
                    echo "<p style='color: black'><input name=$i value=$j type='radio'/>$j.$answer</p><br />";
                }
                echo '</div>';
                echo '</li>';
            }
        ?>
    </ul>
</div>
<?php 
echo $this->Form->button('表示', array ('type' => 'submit','class'=>'btn','id'=>"btn-save"));
echo $this->Form->end();
?>