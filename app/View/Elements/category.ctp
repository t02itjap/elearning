<?php 
$categoryList = $this->requestAction('app/category');
//debug($categoryList);die();
?>
        <div id="category">
            <label><em><center>カテゴリ</center></em></label>
            <ul>
            <?php for($i = 0; $i < count($categoryList); $i++){?>
                <li><?php echo $this->Html->link($categoryList[$i]['Category']['category_name'], array('controller' =>'lessons','action' => 'lessons_by_category', $categoryList[$i]['Category']['id'], $categoryList[$i]['Category']['category_name']));?></li>
            <?php }?>
            </ul>
        </div><!--End #category-->
