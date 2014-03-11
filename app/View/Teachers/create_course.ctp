<script>
    $(document).ready(function(){
        $('#formCreateNewCategory').hide();
        $('#createNewCategory').on('click',function(e){
            e.preventDefault();
            $('#formCreateNewCategory').show();
            $('#createCategory').on('click',function(e){
                e.preventDefault();
                var name= $('#nameCategory').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->webroot . 'Teachers/createNewCategory' ?>",
                    data: { name: name}
                }) .done(function(data) {
                    
                    $('#listCategory').append('<li><label>'+name+'</label><input type="checkbox" value="'+data['id']+'" ></li>');
                });
                $('#formCreateNewCategory').hide();
            });
        });
        $('#1234').on('click',function(e){
            e.preventDefault();
            var parenttbl = document.getElementById("1234");
            var newel = document.createElement('td');
            //var elementid = document.getElementsByTagName("td").length
            //newel.setAttribute('id',elementid);
            newel.innerHTML = "New Inserted"
            parenttbl.appendChild(newel);
        });
    });
</script>


<div id="main_nav">
    <ul>
        <li><a href="#">ホームページ</a></li>
        <li><a href="#">授業リスト</a></li>                
        <li><a href="#">学生の試験結果</a></li>
        <li><a href="#">授業を作る</a></li>
    </ul>

</div><!--End #main_nav-->

<div id="main_content">
    <div id="create_class">
        <h3><span>＊</span>は必ずインプットしてください。</h3>
        <?php
        echo $this->Form->create('Lesson', array('type' => 'file'));
        ?>
        <table>
            <tr>
                <td><span>＊</span>授業名</td>
                <td>
                    <?php
                    echo $this->Form->input('Name', array(
                        'type' => 'text',
                        'name' => 'data[Lesson][Name]',
                        'label' => false,
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><span>＊</span>カテゴリー</td>
                <td>
                    <ul id="listCategory">
                        <?php
                        foreach ($categories as $category) {
                            echo '<label>' . $category['Category']['category_name'] . '</label>';
                            echo '<li>';
                            echo $this->Form->checkbox('Category', array(
                                'value' => $category['Category']['id'],
                                'name' => 'data[Lesson][category'.$category['Category']['id'].']',
                            ));
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </td>

                <td>
                    <button id="createNewCategory">カテゴリー追加</button>

                </td>   
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 300px;">
                    <p>ページ<<<a href="">1</a>,<a href="">2</a>,<a href="">3</a>>></p>
                </td>
            </tr>
            <tr>
            <div id="formCreateNewCategory">

                <input type="text" id="nameCategory"/>
                <button id="createCategory">Create</button>
            </div>
            </tr>
            <tr>
                <td><span>＊</span>説明</td>
                <td>
                        <?php
                        echo $this->Form->input('Name', array(
                            'type' => 'textarea',
                            'name' => 'data[Lesson][Description]',
                            'label' => false,
                        ));
                        ?>
                    </td>
            </tr>
            <tr>
                <td><span>＊</span>資料１</td>
                <td>
                    <?php
                    echo $this->Form->input('file_link_document', array('type' => 'file', 'label' => 'Pdf or Image'));
                    if (isset($err))
                        echo $err;
                    ?>
                </td>
<!--                <td><input type="text"/></td>
                <td><button id="uploadFileDocument">アップロードファイル選択</button></td>-->
            </tr>
            <tr>
                <td><button id="1234">資料追加</button></td>
            </tr>
            <tr>
                <td><span>＊</span>テスト１</td>
                <td>
                    <?php
                    echo $this->Form->input('file_link_test', array('type' => 'file', 'label' => 'Only tsv'));
                    if (isset($err1))
                        echo $err1;
                    ?>
                </td>
<!--                <td><input type="text"/></td>
                <td><button id="uploadFileTest">アップロードファイル選択</button> </td>-->
            </tr>
            <tr>
                <td><button>テスト追加</button></td>
            </tr>
        </table>
    </div><!--End #create_class-->
    <div id="rule">
        <h4><span>＊</span>&copy;Copyright 要求</h4>
        <label><input type="checkbox" value="賛成" />賛成</label>
    </div><!--End #rule-->

    <div id="submit">
        <input type="submit" name="data[ok]" value="作成"/>
        <input type="submit" name="cancel" value="キャセル"/>
    </div><!--End #submit-->
</div><!--End #main_content-->
</div><!--End #body-->

<?php $this->Form->end(); ?>