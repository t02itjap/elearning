<div id="summary">
	<h2>授業サマリー</h2>
	<p>Like数：<?php echo $lesson['Lesson']['voters']?>件（<?php echo $lesson['Lesson']['voters']/$snum*100?>％受講者数)</p>
	<p>参照数：<?php echo $lesson['Lesson']['viewers']?>人</p>
	<p>受講者数：<?php echo $snum;?>人</p>
		<h2>受講者リスト</h2>
			<table class='table table-striped' style='table-layout: fixed'>
				<thead>
					<tr>
						<th>順番</th>
						<th><?php echo $this->Paginator->sort('Bill.user_name', '名前'); ?></th>
						<th><?php echo $this->Paginator->sort('Bill.learn_date', '時間'); ?></th>
					</tr>
				</thead>
				<tbody>
	                        <?php $i=1; foreach ($students as $s) {?>
	                        <tr>
						<td class='content-center'><?php echo $i?></td>
						<td class='content-center'><?php $i++; echo $s['Bill']['user_name']?></td>
						<td class='content-center'><?php echo $s['Bill']['learn_date']?></td>
					</tr>
	                        <?php }?>
	                    </tbody>
			</table>
                <?php echo $this->paginator->prev(); ?> – &nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo $this->paginator->numbers(array('separator'=>'-')); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo $this->paginator->next('Next Page'); ?>
            <h2>ブロック学生リスト</h2>
		<table>
			<thead>
				<tr>
					<td>順番</td>
					<td>名前</td>
					<td>原因</td>
					<td>時間</td>
					<td>Unブロック</td>
				</tr>
			</thead>
			<tbody>
                    <?php $i=1;foreach ($banList as $b) {?>
                    <tr>
					<td><?php echo $i;?></td>
					<td><?php $i++;echo $b['Student']['user_name']?></td>
					<td><?php echo $b['BannedStudent']['reason']?></td>
					<td><?php echo $b['BannedStudent']['banned_date']?></td>
					<td><?php echo $this->Html->link('Unブロック',array('controller'));?></td>
				</tr>
                    <?php }?>
                    </tbody>
		</table>

		<h2>ブロック学生追加</h2>
				
				<?php
				echo $this->Session->flash ();
				echo $this->Form->create ( 'BannedStudent', array (
						'div' => false,
						'type' => 'post' 
				) );
				echo $this->Form->input ( 'StudentName', array (
						'div' => false,
						'label' => false,
						'placeholder' => '学生名' 
				) );
				echo $this->Form->input ( 'Reason', array (
						'div' => false,
						'label' => false,
						'placeholder' => '原因' 
				) );
				echo $this->Form->button ( "リセット", array (
						"type" => "reset" 
				) );
				echo $this->Form->end ( 'ブロック', array (
						'div' => false 
				) );
				?>
</div>