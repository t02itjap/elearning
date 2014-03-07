   <div id="main_content">
            <div id="start_study">
                <p id="doc_name">資料名</p>
                
                
                <textarea id="doc_content"> 資料の内容</textarea>
                <?php
echo $this->Form->create('Lesson');
?>
                    <input type="submit" name="start" value="Copyright違反" onclick=""/>
<?php 
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
                        <textarea></textarea>
                        <form>
                            <input type="submit" value="ポスト"/>
                        </form>
                    </div><!--End #new_comment-->
                </div><!--End #comment-->
            </div><!--End #start_study-->
            </div><!--End #main_content-->


