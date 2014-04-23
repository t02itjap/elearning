<?php 
echo $this->Html->script ( array (
		'jquery-ui.min' 
) );
echo $this->Html->script ( array (
		'jquery.validate'
) );
?>
<?php echo $this->Session->flash('backup');?>
<div id='data_manage'>
	<h3>バックアップ管理</h3>
	<table>
		<tr>
			<th>ファイル名</th>
			<th>ファイルサイズ</th>
			<th>作った日</th>
			<th>リストア</th>
			<th><?php echo $this->Html->link('完全削除',array('controller'=>'admins', 'action'=>'delete_all'),array('class'=>'link-button'),"完全削除？");?></th>
		</tr>
			<?php foreach ($files_info as $file_info): ?>
			<tr>
			<td class='content-left'><?php echo $file_info['basename'] ?></td>
			<td class='content-left'><?php echo $filesize = round($file_info['filesize']/1024,1);?> KB</td>
			<td class='content-left'><?php echo $file_info['created_date']?></td>
			<td class='content-left'><?php echo $this->Html->link('リストア',array('controller'=>'admins', 'action'=>'restore_database', 'file' => $file_info['basename']),array(),"リストア？")?></td>
			<td class='content-center'><?php echo $this->Html->link('削除',array('controller'=>'admins', 'action'=>'delete_file', 'file' => $file_info['basename']),array(),"削除？") ?></td>
		</tr>
			<?php endforeach ?>

		</table>
		<?php echo "<td>".$this->Html->link('バックアップ',array('controller'=>'admins', 'action'=>'backup_database'),array('class'=>'link-button'),"すぐバックアップ？")."</td>"; ?>
		
		<h3>自動バックアップ管理</h3>
		<?php echo $this->Session->flash('autobackup');?>
		<?php
		
		echo $this->Form->create ( "Backup", array (
				"url" => array (
						"controller" => "admins",
						"action" => "database_manager" 
				),
				"type" => "post" 
		) );
		echo '<table style ="width:10%;">';
		echo '<tr>';
		echo '<td>';
		echo $this->Form->input ( "start", array (
				"label" => false,
				"type" => "text",
				"readonly" => true,
				"placeholder" => "スタット日",
				"div" => false
		) );
		echo '</td>';
		echo '<td>';
		echo $this->Form->input ( "startTime", array (
				"label" => false,
				"type" => "text",
				"placeholder" => "スタット時間",
				"div" => false
		) );
		echo '</td>';
		echo '<tr>';
		echo '<td>';
		echo $this->Form->input ( "every", array (
				"label" => false,
				"type" => "text",
				"placeholder" => "繰り返すタイム"
				) );
		echo '</td>';
		echo '<td>'.'<label style="font-size:14px;padding-top:5px;">分</label>'.'</td>';
		echo '</tr>';
		echo '<td>';
		echo $this->Form->input ( "end", array (
				"label" => false,
				"type" => "text",
				"readonly" => true,
				"placeholder" => "終わる日",
				"div" => false
				) );
		echo '</td>';
		echo '<td>';
		echo $this->Form->input ( "endTime", array (
		"label" => false,
		"type" => "text",
		"placeholder" => "終わる時間",
		"div" => false
		) );
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo $this->Form->button ( "リセット", array (
				"type" => "reset" ,
				
		) );
		echo $this->Form->button ('スタット', array (
			'class' => 'link-button',
			'name'  => 'start',
			'type ' => 'submit',
			'div' => false
		) );
		echo $this->Html->link ( "終わり",array (
			'controller' => 'admins',
			'action' => 'endBackup'),
			array('class' => 'link-button','style' => 'padding:5px;float:right;') );
		$this->Form->end();	
	?>
		
</div>

<script>
$().ready(function() {

    $.validator.addMethod("time", function(value, element) {  
    return this.optional(element) || /^([01]\d|2[0-3]):([0-5]\d)$/i.test(value);  
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

    $("#BackupEvery").rules("add", {
        required:true,
        messages: {
               required: "繰り返すタイムを入力する"
        }
       });
    $("#BackupStartTime").rules("add",{
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

    $("#BackupEndTime").rules("add",{
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


jQuery(function($){
	$.datepicker.regional['jp'] = {
		closeText: '關閉',
		prevText: '&#x3c;先月',
		nextText: '来月&#x3e;',
		currentText: '今天',
		monthNames: ['一月','二月','三月','四月','五月','六月',
		'七月','八月','九月','十月','十一月','十二月'],
		monthNamesShort: ['一','二','三','四','五','六',
		'七','八','九','十','十一','十二'],
		dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
		dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
		dayNamesMin: ['日','月','火','水','木','金','土'],
		weekHeader: '周',
		dateFormat: 'yy/mm/dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '年'};
	$.datepicker.setDefaults($.datepicker.regional['jp']);
});

		 
		 $(function() {
			$("#BackupStart").datepicker({
				dateFormat: "yy-mm-dd",
				
			});
		});
		$(function() {
			$("#BackupEnd").datepicker({
				dateFormat: "yy-mm-dd",
				
			});
		});
	</script>