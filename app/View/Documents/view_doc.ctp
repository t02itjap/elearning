    <div id="start_study">
      <p id="doc_name">資料名</p>
      <?php if ($extension=='PDF') {# code...
      ?>
      <iframe id="doc_content" src="<?php echo Router::fullbaseUrl();?>/elearning/documents/read"></iframe>
      <?php
}else if($extension=='MP4') {
      ?>
      <!-- <video autoplay="autoplay" src="app/webroot/test.mp4"></video> -->
      <video style="width: 688px;" controls><source src="<?php echo Router::fullbaseUrl(); echo $path ?>" type="video/mp4"></video>
      <?php
    }
      ?>
      <?php
       // echo $data['Document']['file_link'];
      echo $this->Form->create(null,array('url'=>array('controller'=>'documents','action'=>'update')));
      echo $this->Form->input('',array('type' => 'hidden','value'=>$data[0]['Document']['id']));
      echo $this->Form->button ( 'Copyright違反 ', array ('type' => 'submit', 'name' => 'data[submit_data]','id' => 'submit_button' ) );
      echo $this->Form->end ()
      ?>
      <div id="comment">
      <div class="old_comment">
        <?php
        foreach ($data as $value) {
          ?>
          <div class="comment">
            <img src="" alt="<?php echo $value['u']['user_name']?>"/>
            <span class="comment_content"><?php echo $value['c']['comment']?></span>
          </div>
          <?php
        }
        ?>
        </div>
        <div id="new_comment">
          <form action="#" method="post">
          <?php
         // echo $this->Form->create(null,array('url'=>array('controller'=>null,'action'=>null)));
          echo $this->Form->textarea("txtComment",array('id'=>"comment"));
          echo $this->Form->input('id',array('type' => 'hidden','value'=>$data[0]['l']['id']));
          echo $this->Form->button ( 'ポスト', array ('type' => 'submit', 'name' => 'data[submit_comment]','class'=>'btn','id'=>"btn-save") );
         // echo $this->Form->end ()?>
         <form>
        </div><!--End #new_comment-->
      </div><!--End #comment-->
    </div><!--End #start_study-->
    <?php echo $this->Html->script(array('jquery-1.4.4.min.js')); ?>
  <script type="text/javascript" >
  $(function() {
    $('.btn').live("click",function() {
      $.ajax({
        url: '<?php echo Router::fullbaseUrl();?>/elearning/comments/add?>',
        type: 'POST',
        data: { 'comment': $(':textarea[name=txtComment]').val(),'lesson_id':$(':input[name=id]') },
        success:function(html) {
          $('.old_comment').append(html);
        })
    });
    return false;
  });
});
   </script>

