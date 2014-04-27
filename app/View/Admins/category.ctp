<div>
	<table>
		<tr>
			<th><?php echo $this->Paginator->sort('category_name', '授業名'); ?></th>
		</tr>
		<?php 	
		debug($categoryList);
       		foreach ($categoryList as $key) {
	       		echo "<tr>";
	       			echo "<th>";	
	        		echo $this->Html->link($key['Category']['category_name'], array('controller' =>'lessons','action' => 'lessons_by_category', $key['Category']['id'], $key['Category']['category_name']));
	        		echo "</th>";
	        	echo "</tr>";
        	}
        ?>
	</table>
</div>