<div id="category">
<form action="" method="get">
<label><em>カテゴリ</em></label>
<ul>
    <?php 
        //debug($categories);
        foreach ($categories as $category):
    ?>
	    <li>
		<?php 
			$category_name=$category['Category']['category_name'];
			echo $this->Html->link($category_name, array(
				'controller'=>'lessons', 
				'action'=>'lessons_by_category', 
				$category_name
				)
			);
		?>
		</li>
    <?php endforeach; ?>
</ul>
</form> 
</div><!--End #category-->