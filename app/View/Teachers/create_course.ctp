<?php echo $this->Html->script ( array (
		'jquery.validate' 
) );?>

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
                if(!name){
					alert('カテゴリー名を入力してください。');
					return false;
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->webroot . 'Teachers/createNewCategory' ?>",
                    data: { name: name}
                }) .done(function(data) {
                    var data =  $.parseJSON(data);
                    //console.log( data);
                    if(data.error != null)   alert(data.error);
                    else $('#listCategory').append('<li ><label style = "display:inline;line-height:25px;">'+name+'</label><input type="checkbox" style = "width :300px;float:right;" value="'+data['id']+'" ></li>');
                });
                //すぐにカテゴリ情報を取得し、ページ上に表示され、自動ロードを無視
                $('#formCreateNewCategory').hide();                     //入力ボックスを非表示
            });
        });
        $('#addNewDocument').on('click',function(e){
            e.preventDefault();
            var tmp = 
                '<input id="fileDocument" type="file" name="data[Lesson][file_link_document][]">';
            $('#fileArrayDocument').append(tmp);
        });
        $('#addNewTest').on('click',function(e){
            e.preventDefault();
            var tmp = 
                '<input id="fileTest" type="file" name="data[Lesson][file_link_test][]">';
            $('#fileArrayTest').append(tmp);
        });
        //        $('#fileTriggerDocument').on('click',function(){
        //           $(this).hide();
        //           $('#fileDocument').trigger('click');
        //        });
        //        $('#fileTriggerTest').on('click',function(){
        //           $(this).hide();
        //           $('#fileTest').trigger('click');
        //        });
    });
</script>


    <div id="create_class">
    	<?php echo $this->Session->flash();?>
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

                    <!--教師のユーザーからの授業名を取得-->

                </td>
            </tr>
            <tr>
                <td><span>＊</span>カテゴリー</td>
                <td>
                    <ul id="listCategory" style="overflow-x: hidden; overflow-y: scroll; height:200px; width: 424px">
                        <?php
                        foreach ($categories as $category) {
                            
                            echo '<li>';
                            echo '<label style = "line-height:25px;display:inline">' . $category['Category']['category_name'] . '</label>';
                            echo $this->Form->checkbox('Category', array(
                                'value' => $category['Category']['id'],
                                'name' => 'data[Lesson][category][]',
								'style' => 'width :300px;float:right;'
                            ));
                            echo '</li>';
                        }
                        ?>						
                    </ul>
                    <?php
                    	if(isset($notHaveCategoryMessage)) echo $notHaveCategoryMessage;
                    	if(isset($notCheckCategoryMessage)) echo $notCheckCategoryMessage;
                    ?>
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

            </td>   
            </tr>


            <tr>
                <td style = 'vertical-align:top;'><span>＊</span>説明</td>
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
                <td><span>＊</span>資料</td>
                <td id="fileArrayDocument">
                    <input id="fileDocument" type="file" name="data[Lesson][file_link_document][]">
                    <?php
                    //アップロードファイル選択するフォームを作成
                    if (isset($err))
                        echo $err;//もしあれば、エラーを表示
                    ?>
                </td>

            </tr>
            <tr>
           		<td></td>
                <td><button id="addNewDocument">資料追加</button></td>
            </tr>
            <tr>
                <td><span>＊</span>テスト</td>
                <td id="fileArrayTest">
                    <input id="fileTest" type="file" name="data[Lesson][file_link_test][]">
                    <?php
                    //echo $this->Form->input('file_link_test', array('type' => 'file', 'label' => 'Only tsv'));
                    //アップロードファイル選択するフォームを作成
                    if (isset($err1))
                        echo $err1;//もしあれば、エラーを表示
                    ?>
                </td>
<!--                <td><input type="text"/></td>
                <td><button id="uploadFileTest">アップロードファイル選択</button> </td>-->
            </tr>
            <tr>
            	<td></td>
                <td><button id="addNewTest">テスト追加</button></td>
            </tr>
        </table>
    </div><!--End #create_class-->
    <div id="rule">
        <h4><span>＊</span>&copy;Copyright 要求</h4>
        <?php
        echo $this->Form->input('agree', array('type' => 'checkbox', 'label' => '賛成', 'id' => 'agree_rule'));
        ?>
    </div><!--End #rule-->
    <div id="submit">
        <?php
        echo $this->Form->button('作成', array('type' => 'submit', 'name' => 'data[ok]','id' => 'submit_button'));
        ?>
        <?php
        echo $this->Form->button('リセット', array('type' => 'reset'));
        ?>
    </div><!--End #submit-->
    <script type="text/javascript">
    $(document).ready(function () {

    	$('#submit_button').click(function(){
  	      var isChecked = $("#agree_rule:checked").length;
  	      if(isChecked<1){
    	    	alert('Copyright要求を賛成することは必要です');
  	      } 	      
  	   });

        $('#LessonCreateCourseForm').validate({
            rules: {
                'data[Lesson][Name]': {
                    required: true
                },
                'data[Lesson][Description]':{
                	required: true
                }
            },
            messages: {
                'data[Lesson][Name]': {
                    required: "授業名を必ずインプットする"
                },
                'data[Lesson][Description]':{
                	required: "授業説明を必ずインプットする" 
            	}
            }
        });
    });
</script>
    <?php $this->Form->end(); ?>