   <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot . 'css/phi.css' ?>">
   <div id="start_study">
    <p id="doc_name">資料名 : <?php echo $doc['Document']['file_name']?></p>
    <!-- lap -->
    <div class="col-lg-9" height="500px" width="900px" style="position: relative">
      <div class="overlay"></div> 
      <div class="overlay2"></div>
      <div class="overlay3"></div>
      <div class="overlay4"></div>
      <?php
      $extension = explode('.', $file);
      $extension = $extension[1];
      ?>
      <script>
      var ext = '<?php echo $extension ?>';
            // alert(ext);
            if (ext == 'MP4') {
              $('.overlay2').css('height', '100px');
              $('.overlay2').css('width', '100%');
            } else if (ext == 'mp3' || ext == 'wav') {
              $('.overlay2').css('height', '94%');
              $('.overlay2').css('width', '100%');
              $('.overlay').css('margin-top', '0%');
              $('.overlay').css('margin-left', '0%');
              $('.overlay').css('height', '231px');
              $('.overlay').css('width', '845px');
              $('.overlay3').show();
              $('.overlay4').show();
            }
      </script>
      <!-- end -->
      <embed id="embed" src="<?php echo $file ?>"
       height="300px" width="100%" style="z-index: 1" enableContextMenu="0">
       <param name="enableContextMenu" value="0">
   </div>
   <?php
   echo $this->Session->flash();
   echo $this->Form->create(null,array('url'=>array('controller'=>'documents','action'=>'viewDoc',$id)));
  //secho $this->Form->input('',array('type' => 'hidden','value'=>$id));
   echo $this->Form->button ( 'Copyright違反 ', array ('type' => 'submit', 'name' => 'data[submit_data]','id' => 'submit_button' ) );
   echo $this->Form->end ();
   ?>
   <div id="comment">
    <div class="old_comment">
      <?php
      //debug($data);
      foreach ($data as $value) {
        ?>
        <div class="comment">
          <img src="" alt="<?php echo $value['User']['user_name']?>"/>
          <span class="comment_content"><?php echo $value['Comment']['comment']?></span>
        </div>
        <?php
      }
      ?>
    </div>
    <div id="new_comment">
        <?php
        echo $this->Form->create(null,array(array('controller'=>'documents','action'=>'viewDoc',$id, $lesson_id)));
        echo $this->Form->textarea("txtComment",array('id'=>"comment",'value'=>$clear));
        echo $this->Form->input('id',array('type' => 'hidden','value'=>$lesson_id));
        echo $this->Form->button ( 'ポスト', array ('type' => 'submit','class'=>'btn','id'=>"btn-save", 'onclick'=>'return cmtValid()'));
        echo $this->Form->end ();?>
         </div><!--End #new_comment-->
       </div><!--End #comment-->
     </div><!--End #start_study-->
   <script type="text/JavaScript">
   function cmtValid(){
    var input=document.getElementById('comment');
    var value=input.value;
    if(value=='')
      return false;
    return true;
   }
   function killCopy(e){
    return false
  }
  function reEnable(){
    return true
  }
  document.onselectstart=new Function ("return false")
  if (window.sidebar){
    document.onmousedown=killCopy
    document.onclick=reEnable
  }
  </script>
<script type="text/JavaScript">
var message="NoRightClicking"; function defeatIE() {if (document.all) {(message);return false;}} function defeatNS(e) {if (document.layers||(document.getElementById&&!document.all)) { if (e.which==2||e.which==3) {(message);return false;}}} if (document.layers) {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=defeatNS;} else{document.onmouseup=defeatNS;document.oncontextmenu=defeatIE;} document.oncontextmenu=new Function("return false") 
</script>
