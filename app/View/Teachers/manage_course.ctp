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
        //22-3-2014
        $('.changeDocument').on('click',function(e){
            e.preventDefault();
            $(this).hide();
            var buttonAdd= $(this);
            var documentId = $(this).attr('document_id');
            var hiddenDocument = $(this).parents().prev('td');
            hiddenDocument.show();
            var file = hiddenDocument.find('input');
            var file_old_name = file.attr('old_name');
            var upload = hiddenDocument.find('.submitNewDocument');
            upload.unbind('click');
            upload.on('click',function(e){
                e.preventDefault();
                var tmpdata = new FormData();
                $.each(file[0].files, function(i, file) {
                    tmpdata.append('file-'+i, file);                   
                });
                $.ajax({
                    url: "<?php echo $this->webroot . 'teachers/uploadNewDocument' ?>",
                    data: tmpdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data){
                        if(data){
                            $.ajax({
                                url: "<?php echo $this->webroot . 'teachers/updateNewDocument' ?>",
                                data: {
                                    old_name:file_old_name,
                                    id : documentId,
                                    newName : file.val()
                                },
                                type: 'GET',
                                beforeSend: function(){
                                    upload.parents('tr').find('img').show();
                                },
                                success: function(){
                                    upload.parents('tr').find('a').text(file.val());
                                    file.val('');
                                    hiddenDocument.hide();
                                    buttonAdd.show();
                                    upload.parents('tr').find('img').hide();
                                }
                            });
                        } else {
                            alert('File sai dinh dang hoac da bi trung, moi nhap lai');
                        }
                    }
                });
                
            });
        });
        
        $('.changeTest').on('click',function(e){
            e.preventDefault();
            $(this).hide();
            var buttonAdd= $(this);
            var testId = $(this).attr('test_id');
            var hiddenTest = $(this).parents().prev('td');
            hiddenTest.show();
            var file = hiddenTest.find('input');
            var file_old_name = file.attr('old_name');
            var upload = hiddenTest.find('.submitNewTest');
            upload.unbind('click');
            upload.on('click',function(e){
                e.preventDefault();
                var tmpdata = new FormData();
                $.each(file[0].files, function(i, file) {
                    tmpdata.append('file-'+i, file);                   
                });
                $.ajax({
                    url: "<?php echo $this->webroot . 'teachers/uploadNewTest' ?>",
                    data: tmpdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data){
                        if(data){
                            $.ajax({
                                url: "<?php echo $this->webroot . 'teachers/updateNewTest' ?>",
                                data: {
                                    old_name:file_old_name,
                                    id : testId,
                                    newName : file.val()
                                },
                                type: 'GET',
                                beforeSend: function(){
                                    upload.parents('tr').find('img').show();
                                },
                                success: function(){
                                    upload.parents('tr').find('a').text(file.val());
                                    file.val('');
                                    hiddenTest.hide();
                                    buttonAdd.show();
                                    upload.parents('tr').find('img').hide();
                                }
                            });
                        } else {
                            alert('File sai dinh dang hoac da bi trung, moi nhap lai');
                        }
                    }
                });
                
            });
        });
        
        $('#addNewDocument').on('click',function(e){
            e.preventDefault();
            var tmp = 
                '<label for="fileDocument">Pdf or Image</label>'+
                '<input id="fileDocument" type="file" name="data[Lesson][file_link_document][]">';
            $('#fileArrayDocument').append(tmp);
        });
        $('#addNewTest').on('click',function(e){
            e.preventDefault();
            var tmp = 
                '<label for="fileTest">Only TSV</label>'+
                '<input id="fileTest" type="file" name="data[Lesson][file_link_test][]">';
            $('#fileArrayTest').append(tmp);
        });
    });
    
</script>

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
                    <ul id="listCategory" style="overflow-y: scroll; height:200px;">
                        <?php
                        foreach ($categories as $category) {
                            echo '<label>' . $category['Category']['category_name'] . '</label>';
                            echo '<li>';
                            echo $this->Form->checkbox('Category', array(
                                'value' => $category['Category']['id'],
                                'name' => 'data[Lesson][category][]',
                            ));
                            echo '</li>';
                        }
                        ?>

                        <!--教師のユーザーからの授業名を取得-->

                    </ul>
                </td>
                <td>
                    <button id="createNewCategory" type="button">カテゴリー追加</button>
                </td>
            <tr>
            <div id="formCreateNewCategory">

                <input type="text" id="nameCategory"/>
                <button id="createCategory">追加</button>
            </div>
            </tr>

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
<!--            <tr>
                <td>資料１</td>
                <td><a href="" style="text-decoration: underline;">資料１</a></td>
                <td><button>変更</button></td>
            </tr>
            <tr>
                <td>資料２</td>
                <td><a href="" style="text-decoration: underline;">資料2</a></td>
                <td><button>変更</button></td>
            </tr>-->
            <?php
            foreach ($dataLesson as $data) {
                echo '<tr>';
                echo '<td>';
                echo '<a href="#" style="text-decoration: underline;overflow-x:scroll; height:24px; width=50px " >';
                echo $data['Document']['file_name'];
                echo '</a>';
                echo '</td>';
                echo '<td class="hiddenDocument" style="display:none">';
                echo '<input type="file" old_name ="' . $data['Document']['file_name'] . '" id="' . $data['Document']['id'] . '"/>';
                echo '<button class="submitNewDocument">';
                echo 'Upload';
                echo '</button>';
                echo '</td>';
                echo '<td>';
                echo '<button class="changeDocument" document_id ="' . $data['Document']['id'] . '">';
                echo '変更';
                echo '</button>';
                echo '</td>';
                echo '<td>';
                echo '<img style="display:none"  width="24" height="24" src= "' . $this->webroot . 'img/loading.gif" >';
                echo '</td>';
                echo '</tr>';
            }
            ?>
            <tr id="fileArrayDocument">
                
            </tr>
            <tr>
                <td><button id="addNewDocument">資料追加</button></td>
            </tr>
<!--            <tr>
                <td>テスト１</td>
                <td><a href="" style="text-decoration: underline;">テスト１　時間：３０分</a></td>
                <td><button>変更</button></td>
            </tr>
            <tr>
                <td>テスト２</td>
                <td><a href="" style="text-decoration: underline;">テスト2　時間：３０分</a></td>
                <td><button>変更</button></td>
            </tr>-->
            <?php
            foreach ($dataTest as $data) {
                echo '<tr>';
                echo '<td>';
                echo '<a href="#" style="text-decoration: underline;overflow-x:scroll; height:24px; width=50px " >';
                echo $data['Test']['file_name'];
                echo '</a>';
                echo '</td>';
                echo '<td class="hiddenTest" style="display:none">';
                echo '<input type="file" old_name ="' . $data['Test']['file_name'] . '" id="' . $data['Test']['id'] . '"/>';
                echo '<button class="submitNewTest">';
                echo 'Upload';
                echo '</button>';
                echo '</td>';
                echo '<td>';
                echo '<button class="changeTest" document_id ="' . $data['Test']['id'] . '">';
                echo '変更';
                echo '</button>';
                echo '</td>';
                echo '<td>';
                echo '<img style="display:none"  width="24" height="24" src= "' . $this->webroot . 'img/loading.gif" >';
                echo '</td>';
                echo '</tr>';
            }
            ?>
            <tr id="fileArrayTest">
                
            </tr>
            <tr>
                <td><button id="addNewTest">テスト追加</button></td>
            </tr>
        </table>
    </div><!--End #change_class-->
    <div id="submit">
        <input type="submit" name="data[delete]" value="授業削除" style="color: white;background: black;"/>
        <input type="submit" name="data[ok]" value="作成"/>
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
<?php $this->Form->end(); ?>