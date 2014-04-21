<div id="summary">
	<p>Like数：<?php echo $lesson['Lesson']['vote_count']-1?>件（<?php echo ($lesson['Lesson']['vote_count']-1)/$snum*100?>％受講者数)</p>
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
                <?php echo $this->element('paging');?>
                </br>
                <?php echo $this->Session->flash();?>
            <h2>ブロック学生リスト</h2>
	<table>
		<thead>
			<tr>
				<td>順番</td>
				<td><?php echo $this->Paginator->sort('Student.user_name', '名前'); ?></td>
				<td>原因</td>
				<td><?php echo $this->Paginator->sort('BannedStudent.banned_date', '時間'); ?></td>
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
				<td><?php echo $this->Html->link('アンブロック',array('controller'=>'teachers','action'=>'unblock',$b['BannedStudent']['id'],$lesson['Lesson']['id']),array('class'=>'link-button'));?></td>
			</tr>
                    <?php }?>
                    </tbody>
	</table>
				<!--<?php echo $this->element('paging',array('model'=>'BannedStudent'));?>-->
		<h2>ブロック学生追加</h2>
	<div class="err" id="add_err"></div>		
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
				echo $this->Form->end (array (
						'label' => 'ブロック',
						'div' => false,
						'name' => 'block'
				) );
				?>
</div>
