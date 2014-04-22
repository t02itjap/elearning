<?php 
echo $this->Html->script ( array (
		'jquery-ui.min' 
) );
echo $this->Html->script ( array (
		'jquery.validate'
) );
?>
<?php echo $this->Session->flash();?>
<div id='acc_manage'>
	<h2>バックアップ管理</h2>
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
			<td class='content-center'><?php echo $this->Html->link('リストア',array('controller'=>'admins', 'action'=>'restore_database', 'file' => $file_info['basename']),array(),"リストア？")?></td>
			<td class='content-center'><?php echo $this->Html->link('削除',array('controller'=>'admins', 'action'=>'delete_file', 'file' => $file_info['basename']),array(),"削除？") ?></td>
		</tr>
			<?php endforeach ?>

		</table>
		<?php echo "<td>".$this->Html->link('バックアップ',array('controller'=>'admins', 'action'=>'backup_database'),array('class'=>'link-button'),"すぐバックアップ？")."</td>"; ?>
		
		<h2>自動バックアップ管理</h2>
		<?php
		
		echo $this->Form->create ( "Backup", array (
				"url" => array (
						"controller" => "admins",
						"action" => "database_manager" 
				),
				"type" => "post" 
		) );
		
		echo $this->Form->input ( "start", array (
				"label" => false,
				"type" => "text",
				"readonly" => true,
				"placeholder" => "スタット日"
		) );
		echo $this->Form->input ( "startHour", array (
				"label" => false,
				"type" => "text",
				"placeholder" => "スタット時間"
		) );
		echo $this->Form->input ( "every", array (
				"label" => false,
				"after" => '分',
				"type" => "text",
				"placeholder" => "every"
				) );
		echo $this->Form->input ( "end", array (
				"label" => false,
				"type" => "text",
				"readonly" => true,
				"placeholder" => "終わる日"
				) );
		echo $this->Form->input ( "endHour", array (
		"label" => false,
		"type" => "text",
		"placeholder" => "エンド時間"
) );
		
		echo $this->Form->button ( "リセット", array (
				"type" => "reset" 
		) );
		echo $this->Form->end ( array (
				"label" => 'スタット',
				'class' => 'link-button',
				'div' => false 
		) );
		
		?>
		
</div>

<script>
$().ready(function() {

    $.validator.addMethod("time", function(value, element) {  
    return this.optional(element) || /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/i.test(value);  
    }, "タイムタイプを入力する。");

    $("#BackupDatabaseManagerForm").validate();
    $("#BackupStart").rules("add", {
        required:true,
        messages: {
               required: "バックアップスタット日を選択する"
        }
       });
    $("#BackupEnd").rules("add", {
        required:true,
        messages: {
               required: "バックアップエンド日を選択する"
        }
       });
    $("#BackupStartHour").rules("add",{
			time : "required time",
			required:true,
			messages: {
	               required: "バックアップスタットタイムを入力する。"
	        }
    	}
    );
    $("#BackupEndHour").validate({
        rules: {
                time: "タイムタイプを入力する。",
        },

	});

    $("#BackupEndHour").rules("add",{
		time : "required time",
		required:true,
		messages: {
               required: "バックアップスタットタイムを入力する。"
        }
	}
);

    });
		
		/*
		 * jQuery UI Datepicker: Parse and Format Dates
		 * http://salman-w.blogspot.com/2013/01/jquery-ui-datepicker-examples.html
		 */
		$(function() {
			$("#BackupStart").datepicker({
				dateFormat: "mm-dd-yy",
				
			});
		});
		$(function() {
			$("#BackupEnd").datepicker({
				dateFormat: "mm-dd-yy",
			});
		});
	</script>