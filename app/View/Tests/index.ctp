<?php 
echo $this->Form->create('Tests',array('type' => 'post', 'controller'=>'tests','action'=>'result'));
?>

<div id="test">
    <ul>
        <?php $i = 0; foreach ($testObject->questions as $key=>$q):?>
        <li>
            <div class="question">
                <?php $i++;?>
                <h4 name=<?=$i?>> <?=$i.'.'.$q["Q($i)"]->question.'('.$q["Q($i)"]->mark.'点)'?> </h4><br>
                    <?php $j = 0; foreach ($q["Q($i)"]->answers as $key => $a):?>
                    <?php $j++; ?>
                    <p style='color: black'><input id=<?=$i.$j?> name=<?=$i?> value=<?=$j?> type="radio" /><?=$j.'.'.$a["S($j)"]?></p><br />
            <?php endforeach; ?>
        </div>
    </li>
<?php endforeach; ?>
</ul>
</div>
<?php 
echo $this->Form->button('終わる', array ('type' => 'submit', 'name' => 'data[result]','class'=>'btn','id'=>"btn-save"));
echo $this->Form->end();
?>
