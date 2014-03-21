<script>
    $(document).ready(function(){
        $('#formCreateNewCategory').hide();
        $('#createNewCategory').on('click',function(e){
            e.preventDefault();
            //オートローディングページを防ぐ
            $('#formCreateNewCategory').show();                         //入力ボックスが表示され
            $('#createCategory').unbind('click');
            $('#createCategory').on('click',function(e){
                e.preventDefault();
                var name= $('#nameCategory').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->webroot . 'Teachers/createNewCategory' ?>",
                    data: { name: name}
                }) .done(function(data) {
                    var data =  $.parseJSON(data);
                    //console.log( data);
                    $('#listCategory').append('<li><label>'+name+'</label><input type="checkbox" value="'+data['id']+'" ></li>');
                });
                //すぐにカテゴリ情報を取得し、ページ上に表示され、自動ロードを無視
                $('#formCreateNewCategory').hide();                     //入力ボックスを非表示
            });
        });
        
    });
</script>

<div id="main_content">
    <div id="change_class">
        <h3>授業管理</h3>
        <?php
        echo $this->Form->create('Lesson', array('type' => 'file'));
        ?>
        <table>
            <tr>
                <td>授業名</td>
                <td>
                    <?php
                    echo $this->Form->input('Name', array(
                        'type' => 'text',
                        'name' => 'data[Lesson][Name]',
                        'label' => false,
                    ));
                    ?>

                    <!--教師のユーザーからの授業名を取得-->

                </td>
            </tr>
            <tr>
                <td>カテゴリー</td>
                <td>
                    <ul id="listCategory">
                        <?php
                        foreach ($categories as $category) {
                            echo '<label>' . $category['Category']['category_name'] . '</label>';
                            echo '<li>';
                            echo $this->Form->checkbox('Category', array(
                                'value' => $category['Category']['id'],
                                'name' => 'data[Lesson][category' . $category['Category']['id'] . ']',
                            ));
                            echo '</li>';
                        }
                        ?>

                        <!--教師のユーザーからの授業名を取得-->

                    </ul>
                </td>

                <td>
                    <button id="createNewCategory" type="button">カテゴリー追加</button>
            <tr>
            <div id="formCreateNewCategory">

                <input type="text" id="nameCategory"/>
                <button id="createCategory">追加</button>
            </div>
            </tr>

            </td>   
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 300px;">
                    <p>ページ<<<a href="">1</a>,<a href="">2</a>,<a href="">3</a>>></p>
                </td>
            </tr>

            <tr>
                <td>説明</td>
                <td>
                    <?php
                    echo $this->Form->input('Name', array(
                        'type' => 'textarea',
                        'name' => 'data[Lesson][Description]',
                        'label' => false,
                    ));
                    ?>

                    <!--教師のユーザーからの授業の説明を取得-->

                </td>
            </tr>
            <tr>
                <td>資料１</td>
                <td><a href="" style="text-decoration: underline;">資料１</a></td>
                <td><button>変更</button></td>
            </tr>
            <tr>
                <td>資料２</td>
                <td><a href="" style="text-decoration: underline;">資料2</a></td>
                <td><button>変更</button></td>
            </tr>
            <tr>
                <td><button>資料追加</button></td>
            </tr>
            <tr>
                <td>テスト１</td>
                <td><a href="" style="text-decoration: underline;">テスト１　時間：３０分</a></td>
                <td><button>変更</button></td>
            </tr>
            <tr>
                <td>テスト２</td>
                <td><a href="" style="text-decoration: underline;">テスト2　時間：３０分</a></td>
                <td><button>変更</button></td>
            </tr>

            <tr>
                <td><button>テスト追加</button></td>
            </tr>
        </table>
    </div><!--End #change_class-->
    <div id="submit">
        <input type="submit" name="ok" value="授業削除" style="color: white;background: black;"/>
        <input type="submit" name="ok" value="作成"/>
        <input type="submit" name="cancel" value="キャセル"/>
    </div><!--End #submit-->
    <br /><br />
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
</div><!--End #main_content-->
<?php $this->Form->end(); ?>