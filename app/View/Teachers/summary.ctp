<div id="summary">
	<p class ='label label-info' style = 'display:block;font-size:14px;'>Like数：<?php echo $lesson['Lesson']['vote_count']?>件(<?php if(empty($snum)) echo(''); else echo((($lesson['Lesson']['vote_count'])/$snum*100).' ％受講者数')?>)</p>
	</br>
	<p class ='label label-info' style = 'display:block;font-size:14px;'>受講者数：<?php if(empty($snum)) echo '0'; else echo $snum;?>人</p>
	<h3>受講者リスト</h3>
	<table  style='table-layout: fixed;margin-bottom: 10px;'>
		<thead>
			<tr>
				<th style="text-align: center;font-size: 14px;">順番</th>
				<th style="text-align: center;font-size: 14px;"><?php echo $this->Paginator->sort('Bill.user_name', '名前'); ?></th>
				<th style="text-align: center;font-size: 14px;"><?php echo $this->Paginator->sort('Bill.learn_date', '時間'); ?></th>
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
	
	<h4 style="font-size: 14px;font-weight: bold;">合計報酬　：<?php echo $total?></h4>
                <?php echo $this->element('paging');?>
                </br>
                
                <h3>ライク者リスト</h3>
                <table>
		<thead>
			<tr>
			<td>順番</td>
				<td>ID</td>
				<td>名前</td>
			</tr>
		</thead>
		<tbody>
					<?php if(isset($lesson['Lesson']['like'])){?>
                    <?php $i=1;foreach ($lesson['Lesson']['like'] as $l) {?>
                    
                    <tr>
                    <td><?php echo $i;?></td>
				<td><?php echo $l['User']['user_name']?></td>
				<td><?php echo $l['User']['real_name']?></td>
			</tr>
                    <?php $i++;}}?>
                    </tbody>
	</table>
			<?php echo $this->Session->flash();?>
            <h3>ブロック学生リスト</h3>
	<table>
		<thead>
			<tr>
				<td>順番</td>
				<td><?php echo $this->Paginator->sort('Student.user_name', '名前'); ?></td>
				<td>原因</td>
				<td><?php echo $this->Paginator->sort('BannedStudent.banned_date', '時間'); ?></td>
				<td>アンブロック</td>
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
		<h3>ブロック学生追加</h3>
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
?>
<div>
<?php 
				echo $this->Form->button ( "リセット", array (
						"type" => "reset",
						"class" =>'link-button'
				) );
				echo $this->Form->end (array (
						'label' => 'ブロック',
						'div' => false,
						'class' => 'link-button',
						'name' => 'block'
				) );
				?>
</div>
				</div>
