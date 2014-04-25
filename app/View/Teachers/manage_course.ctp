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
                            alert('ファイルタイプが間違う');
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
                            alert('ファイルタイプが間違う');
                        }
                    }
                });
                
            });
        });
        
        $('#addNewDocument').on('click',function(e){
            e.preventDefault();
            var tmp = 
                '<label for="fileDocument">新しい資料</label>'+
                '<input id="fileDocument" type="file" name="data[Lesson][file_link_document][]">';
            $('#fileArrayDocument').append(tmp);
        });
        $('#addNewTest').on('click',function(e){
            e.preventDefault();
            var tmp = 
                '<label for="fileTest">新しいテストTSVファイルだけ</label>'+
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
						'value'=> $dataCourse['Lesson']['lesson_name'],
                        'label' => false,
                    ));
                    ?>

                    <!--教師のユーザーからの授業名を取得-->

                </td>
            </tr>
            <tr>
                <td>カテゴリー</td>
                <td>
                    <ul id="listCategory" style="overflow-y: scroll; height:200px;width: 424px;">
                        <?php
                        foreach ($categories as $category) {
                            
                            echo '<li>';
                            echo '<label style = "line-height:25px;display:inline">' . $category['Category']['category_name'] . '</label>';
                            echo $this->Form->checkbox('Category', array(
                                'value' => $category['Category']['id'],
                                'name' => 'data[Lesson][category][]',
								'style' => 'width :300px;float:right;',
								'checked' => in_array($category['Category']['id'], $dataCategory) == true ? true : false,
                            ));
                            echo '</li>';
                        }
                        ?>

                        <!--教師のユーザーからの授業名を取得-->

                    </ul>
        
                    <button id="createNewCategory" type="button">カテゴリー追加</button>
                </td>
            </tr>
            <tr>
            <td></td>
            <td>
            <div id="formCreateNewCategory">

                <input type="text" id="nameCategory"/>
                <button id="createCategory">追加</button>
            </div>
            </td>
            </tr>

            <tr>
                <td>説明</td>
                <td>
                    <?php
                    echo $this->Form->input('Name', array(
                        'type' => 'textarea',
                        'name' => 'data[Lesson][Description]',
						'value' => $dataCourse['Lesson']['description'],
                        'label' => false,
                    ));
                    ?>

                    <!--教師のユーザーからの授業の説明を取得-->

                </td>
            </tr>
            <?php
            foreach ($dataLesson as $data) {
                echo '<tr>';
                echo '<td>';
                // echo '<a href="#" style="text-decoration: underline;overflow-x:scroll; height:24px; width=50px " >';
                // echo $data['Document']['file_name'];
                // echo '</a>';
                //debug($data);
                echo $this->Html->link($data['Document']['file_name'], array('controller'=>'documents','action'=>'viewDoc',$data['Document']['id'], $data['Lesson']['id']));
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
            <tr>
                <td></td>
                <td id="fileArrayDocument"></td>
            </tr>
            <tr>
            	<td></td>
                <td><button id="addNewDocument">資料追加</button></td>
            </tr>
            <?php
            foreach ($dataTest as $data) {
                echo '<tr>';
                echo '<td>';
                echo $this->Html->link($data['Test']['file_name'], array('controller'=>'tests','action'=>'test',$data['Test']['id']));
                // echo '<a href="#" style="text-decoration: underline;overflow-x:scroll; height:24px; width=50px " >';
                // echo $data['Test']['file_name'];
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
            <tr >
                <td></td>
                <td id="fileArrayTest"></td>
            </tr>
            <tr>
            	<td></td>
                <td><button id="addNewTest">テスト追加</button></td>
            </tr>
        </table>
    </div><!--End #change_class-->
    <div id="submit">
        <input type="submit" name="data[delete]" value="授業削除" style="color: white;background: black;"/>
        <input type="submit" name="data[ok]" value="変更"/>
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