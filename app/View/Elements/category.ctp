<<<<<<< HEAD
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
			$category_name=$category['Categorie']['category_name'];
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
=======
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
>>>>>>> khanhnd
