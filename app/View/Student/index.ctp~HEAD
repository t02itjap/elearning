<div>
	<table class='table table-striped' style='table-layout: fixed'>
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('User.user_name', 'ニックネーム'); ?></th>
				<th><?php echo $this->Paginator->sort('User.real_name', '名前'); ?></th>
				<th><?php echo "登録の日" ?></th>
				<th><?php echo "メール" ?></th>
				<th><?php echo "電話番号" ?></th>
			</tr>
		</thead>
		<tbody>	
			<?php foreach ($studentList as $student){?>
				<tr>
				    <td class='content-center'><?php echo $student['User']['user_name']?></td>
					<td class='content-center'><?php echo $student['User']['real_name']?></td>	
					<td class='content-center'><?php echo $student['User']['reg_date']?></td>	
					<td class='content-center'><?php echo $student['User']['email']?></td>
					<td class='content-center'><?php echo $student['User']['phone_number']?></td>				
				</tr>
			<?php }?>
		</tbody>	
		</tbody>
	</table>
</div>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Kết quả tìm được có {:count} bản ghi bắt đầu từ {:start}  〜 {:end} 　（{:page}/{:pages}）')
));
?>	
</p>

<div class="paging btn-group">
	<?php
		echo $this->Paginator->prev( __('Trước') , array('class' => 'btn'), null, array('class' => 'prev disabled btn'));
		echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn', 'currentClass' => 'disabled'));
		echo $this->Paginator->next(__('Sau') , array('class' => 'btn'), null, array('class' => 'next disabled btn'));
	?>
</div>