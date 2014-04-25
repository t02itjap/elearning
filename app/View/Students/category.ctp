<?php $this->set('title_for_layout', 'カテゴリリスト'); ?>
<div>
	<table style="font-size: 15px;">
		<tr>
			<th><?php echo $this->Paginator->sort('category_name', 'カテゴリリスト'); ?></th>
		</tr>
		<?php 
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
<?php echo $this->element('paging');?>