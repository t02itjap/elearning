<div id="search">
<?php 
	//form search
    echo $this->Form->create('Lesson',array('controller'=>'lessons','action'=>'search_result'));
    echo $this->Form->input('keyword', array('div'=>false));
    //them vao dong ben duoi de tao selectbox cho group
    $options = array('teacher' => '先生名', 'lesson' => '授業名', 'category' => 'カテゴリ');
    $attributes=array('empty'=>false);
	echo $this->Form->select('type', $options, $attributes, array('div'=>false));
	echo "<br>";
    echo $this->Form->submit('検索', array('div'=>false));
    echo $this->Form->end();
?>
</div>