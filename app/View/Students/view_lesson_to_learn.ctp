<script>
    $(document).ready(function(){
        $('#learn').on('click',function(){
            var lesson_id = $(this).attr('lesson_id');
            var user_id = $(this).attr('user_id');
            $.ajax({
                type: "POST",
                url: "<?php echo $this->webroot . 'Students/payForLesson' ?>",
                data: { 
                    lesson_id : lesson_id,
                    user_id : user_id
                }
            }) .done(function(data) {
                if(data == 1){
                    $('#learnDiv').show();
                    $('#learn').hide().remove();
                }
            });
        });
        $('#like').on('click',function(){
            var lesson_id = $(this).attr('lesson_id');
            var user_id = $(this).attr('user_id');
            var likeButton = $(this);
            $.ajax({
                type: "POST",
                url: "<?php echo $this->webroot . 'students/likeLesson' ?>",
                data: { 
                    lesson_id : lesson_id,
                    user_id : user_id
                }
            }) .done(function(data) {
                likeButton.attr('disabled','disabled');
                var currentCount = parseInt($('#countLike').text());
                console.log(currentCount);
                currentCount += 1;
                $('#countLike').text(currentCount);
            });
        });
    }); 
</script>

<div id="start_study">
    <span class="ml">授業名 <?php echo $lesson['Lesson']['lesson_name'] ?> </span><br />
    <span class="ml">カテゴリ <?php
foreach ($category as $categories) {
    echo $categories['Category']['category_name'] . ';';
}
?></span><br />
    <span class="ml">作る日: <?php echo $lesson['Lesson']['create_date']; ?></span><br />
    <span class="ml">説明: <?php echo $lesson['Lesson']['description']; ?></span><br />
    <span class="ml">先生: <?php echo $lesson['User']['user_name']; ?></span><br />
    <span class="ml">学費：<?php echo $cost; ?> VND </span><br />
    <span class="ml" >Like数 :
        <span id="countLike"><?php echo $countLike; ?></span>
    </span><br /><br />


    <?php
    if ($flag) {
        $tmp = 'display:block';
        $tmp_2 = 'display:none';
    } else {
        $tmp_2 = 'display:block';
        $tmp = 'display:none';
    }
    echo '<button id="learn" lesson_id="' . $id . '" user_id="' . $user_id . '" style="' . $tmp_2 . '">勉強しましょう</button>';
    ?>
    <div id="learnDiv" style="<?php echo $tmp ?>">
        <span class="ml">資料：</span>
        <span class="doc">
        <?php
    	foreach ($lesson['Document'] as $documents) {
        	echo $this->Html->link($documents['file_name'], array('controller' => 'Documents', 'action' => 'viewDoc',$documents['id']));
        	echo "<br/>";
    	}
    ?></a></span><br /><br /><br />
        <span class="ml">テスト：</span>
        <span class="test"><?php
                foreach ($lesson['Test'] as $tests) {
                    echo $this->Html->link($tests['file_name'], array('controller'=>'tests','action'=>'test',$tests['id']));
                    echo "<br/>";
                }
    ?></span><br /><br /><br />
        <?php
        $tmpDisable = '';
        if ($flagLike)
            $tmpDisable = 'disabled';
        echo '<button id="like"' . $tmpDisable . ' lesson_id="' . $id . '" user_id="' . $user_id . '">Like</button>';
        ?>
    </div>   

    <!-- <h3>------コメント------</h3>
    <div id="comment">
        <div class="comment">
            <?php echo $this->Html->image('student.jpg');?>
            <span class="comment_content"></span>
        </div>
        <div id="new_comment">
            <textarea></textarea>
            <form>
                <input type="submit" value="ポスト"/>
            </form>
        </div><!--End #new_comment-->
    <!--</div><!--End #comment--> 
</div><!--End #start_study-->
