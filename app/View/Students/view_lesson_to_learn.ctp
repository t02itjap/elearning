<script>
    $(document).ready(function(){
        $('#learn').on('click',function(){
            var ok = confirm('勉強したい？');
            if(ok){
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
                //alert(data);
                switch(data){
                    case '2':
                        $('#learnDiv').show();
                        $('#learn').hide().remove();
                        break;
                    case '1':
                        alert("Ban da bi tu choi tham gia khoa hoc boi giao vien");
                        break;
                }
            });
            }
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
    <?php
   echo $this->Session->flash();
   if(!$isCopyright)
   	$style = 'color:gray;'; else $style = "";
   echo $this->Form->create(null,array('url'=>array('controller'=>'students','action'=>'view_lesson_to_learn',$lesson['Lesson']['id'])));
  //secho $this->Form->input('',array('type' => 'hidden','value'=>$id));
   echo $this->Form->button ( 'Copyright違反 ', array ('type' => 'submit', 'name' => 'data[submit_data]','id' => 'submit_button' ,'style'=>$style,'disabled'=>!$isCopyright) );
   echo $this->Form->end ();
   ?>
    <div id="learnDiv" style="<?php echo $tmp ?>">
        <span class="ml">資料：</span>
        <ul style="list-style-type:square;margin-left: 100px;font-size: 14px;">
        
        <?php
    	foreach ($lesson['Document'] as $documents) {
			if($documents['lock_flag']!= true){
			echo '<li>';
        	echo $this->Html->link($documents['file_name'], array('controller' => 'Documents', 'action' => 'viewDoc',$documents['id']));
        	echo '</li>';
        	echo "<br/>";
        	}
    	}
    ?></ul>
        <span class="ml">テスト：</span>
        <ul style="list-style-type:square;margin-left: 100px;font-size: 14px;">
        <?php
                foreach ($lesson['Test'] as $tests) {
					echo '<li>';
                    echo $this->Html->link($tests['file_name'], array('controller'=>'tests','action'=>'test',$tests['id']));
                    echo '</li>';
                    echo "<br/>";
                }
    ?></ul>
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
