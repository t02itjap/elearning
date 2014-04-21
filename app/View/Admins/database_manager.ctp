<?php echo $this->Session->flash();?>
<div id ='acc_manage'>
		<table>
			<tr>
				<th>ファイル名</th>
				<th>ファイルサイズ</th>
				<th>作った日</th>
				<th>リストア</th>
				<th><?php echo $this->Html->link('完全削除',array('controller'=>'admins', 'action'=>'delete_all'),array(),"完全削除？");?></th>
			</tr>
			<?php foreach ($files_info as $file_info): ?>
			<tr>
				<td class='content-center'><?php echo $file_info['basename'] ?></td>
				<td class='content-center'><?php echo $filesize = round($file_info['filesize']/1024,1);?> KB</td>
				<td class='content-center'><?php echo $file_info['created_date']?></td>
				<td class='content-center'><?php echo $this->Html->link('Restore',array('controller'=>'admins', 'action'=>'restore_database', 'file' => $file_info['basename']),array(),"リストア？")?></td>
				<td class='content-center'><?php echo $this->Html->link('Delete',array('controller'=>'admins', 'action'=>'delete_file', 'file' => $file_info['basename']),array(),"削除？") ?></td>
			</tr>
			<?php endforeach ?>

		</table>
		<?php echo "<td>".$this->Html->link('ーバックアップー',array('controller'=>'admins', 'action'=>'backup_database'),array('class'=>'link_button'),"ーーバックアップ？ーー")."</td>"; ?>
</div>