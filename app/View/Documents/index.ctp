   <div id="main_content">
    <div id="start_study">
        <p id="doc_name">資料名</p>
        <iframe id="doc_content" src="<?php echo Router::fullbaseUrl();?>/elearning/documents/read"></iframe>
        <?php
       // echo $data['Document']['file_link'];
        echo $this->Form->create(null,array('url'=>array('controller'=>'documents','action'=>'update')));
        echo $this->Form->input('',array('type' => 'hidden','value'=>$data[0]['Document']['id']));
        echo $this->Form->button ( 'Copyright違反 ', array ('type' => 'submit', 'name' => 'data[submit_data]','id' => 'submit_button' ) );
        echo $this->Form->end ()
        ?>
        <div id="comment">

            <?php
            //debug($data);
            foreach ($data as $value) {
            ?>
            <div class="comment">
                <img src="" alt="<?php echo $value['u']['user_name']?>"/>
                <span class="comment_content"><?php echo $value['c']['comment']?></span>
            </div>
            <?php
                }
            ?>
            <div id="new_comment">
                <?php
                 echo $this->Form->create(null,array('url'=>array('controller'=>'comments','action'=>'add')));
                echo $this->Form->textarea("txtComment",array('id'=>"comment"));
                echo $this->Form->input('id',array('type' => 'hidden','value'=>$data[0]['l']['id']));
                echo $this->Form->button ( 'ポスト', array ('type' => 'submit', 'name' => 'data[submit_comment]','class'=>'btn','id'=>"btn-save") );
                echo $this->Form->end ()?>
            </div><!--End #new_comment-->
        </div><!--End #comment-->
    </div><!--End #start_study-->
</div><!--End #main_content-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/
libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript" >
$(function() {
      $('#btn-save').live("click",function() {
            $.ajax({
                  url: '<?php echo Router::fullbaseUrl();?>/elearning/comments/update?>',
                  type: 'POST',
                  data: { 'comment': $(':textarea[name=txtComment]').val(),'lesson_id':$(':input[name=id]') },
                  success:function(data) {
                        $('#comment').load('<?php echo Router::fullbaseUrl();?>/elearning/documents/load?>');
                  })
            });
      return false;
      });
});
</script>

