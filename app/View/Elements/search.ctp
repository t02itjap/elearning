<div id="search">
<?php 
	//form search
    echo $this->Form->create('Lesson',array('controller'=>'lessons','action'=>'search_result2'));
    echo $this->Form->input('Keyword', array('div'=>false, 'name'=>'keyword', 'id'=>'keyword'));
    //echo $this->Form->input('Course name', array('div'=>false, 'name'=>'course_name', 'id'=>'course_name'));
    //echo $this->Form->input('Category name', array('div'=>false, 'name'=>'category_name', 'id'=>'category_name'));
    //them vao dong ben duoi de tao selectbox cho group
    $options = array('teacher' => '先生名', 'lesson' => '授業名', 'category' => 'カテゴリ', 'description' => 'Description');
    $attributes=array('empty'=>false);
	echo $this->Form->select('type', $options, $attributes, array('div'=>false));
    echo $this->Form->submit('検索', array('div'=>false, 'onclick'=>'return checkinput()'));
    echo $this->Form->end();
?>
</div>

<script>
function checkinput(){
    /*
    var teacher_name = document.getElementById('teacher_name').value;
    var course_name = document.getElementById('course_name').value;
    var category_name = document.getElementById('category_name').value;
    if(teacher_name==""&&course_name==""&&category_name==""){
        alert("キーワードを入力して検索してください。");
        return false;    
    }
    return true;
    */
    var keyword=document.getElementById('keyword').value;
    if(keyword==""){
        alert("キーワードを入力して検索してください。");
        return false;   
    }
    return true;
}
</script>