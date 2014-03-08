   <div id="main_content">
    <div id="start_study">
        <p id="doc_name">資料名</p>
        <?php
        echo $this->Form->textarea("txtPdf",array('id'=>'doc_content'));
        ?>
        <?php
        echo $this->Form->create('Lesson');
        echo $this->Form->button ( 'Copyright違反', array ('type' => 'submit', 'name' => 'data[submit_data]','id' => 'submit_button' ) );
        echo $this->Form->end ()
        ?>
        <div id="comment">
            <div class="comment">
                <img src="" alt="アバター"/>
                <span class="comment_content"></span>
            </div>
            <div class="comment">
                <img src="" alt="アバター"/>
                <span class="comment_content"></span>
            </div>
            <div id="new_comment">
                <?php
                echo $this->Form->textarea("txtComment");
                echo $this->Form->create('Comment');
                echo $this->Form->button ( 'ポスト', array ('type' => 'submit', 'name' => 'data[submit_comment]','class'=>'btn') );
                echo $this->Form->end ()?>
            </div><!--End #new_comment-->
        </div><!--End #comment-->
    </div><!--End #start_study-->
</div><!--End #main_content-->


