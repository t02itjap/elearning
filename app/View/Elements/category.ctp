<?php 
$categoryList = $this->requestAction('app/category');
?>
        <div id="category">
            <label><em>カテゴリ</em></label>
            <ul>
            <?php for($i = 0; $i < count($categoryList); $i++){?>
                <li><?php echo $this->Html->link($categoryList[$i]['Category']['category_name'], array('controller' =>'','action' => ''));?></li>
            <?php }?>
            </ul>
        </div><!--End #category-->