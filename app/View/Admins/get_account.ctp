<?php // debug($users); die(); ?>

 <div id="acc_manage">
    <?php
    echo $this->Form->create('User', array ('type' => 'post', 'novalidate' => 'true'));
    echo $this->Form->input('user_name', array('label' => false, 'placeholder' => 'ユーザネーム入力'));
    $options = array('0' => '全部' ,'1' => '管理者', '2' => '先生', '3'=>'学生');
    echo $this->Form->input('level', array('class' => 'select', 'options' => $options, 'label' => false));
    echo $this->Form->button ( '表示', array ('type' => 'submit', 'name' => 'data[submit_data]', 'class' => 'link-button', 'id' => 'submit_button' ) );
    echo $this->Form->end();
    ?>
    <?php if(isset($data)&&$data!=null): ?>  
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('User.id', 'idコード'); ?></th>
                <th><?php echo $this->Paginator->sort('User.user_name', 'ユーザネーム'); ?></th>
                <th><?php echo $this->Paginator->sort('User.real_name', '名前'); ?></th>
                <th><?php echo $this->Paginator->sort('User.level', 'タイプ'); ?></th>
                <th><?php echo $this->Paginator->sort('User.status_flag', 'ブロック情態'); ?></th>
            </tr>
        </thead>
        <tbody> 
        <?php
            $sum = 0;
            foreach ($data as $item) {
                    
                    ?>
                    <tr>
                        <td class='content-center'><?php echo $item['User']['id']?></td>
                        <td class='content-center'>
                        	<?php
                        	if($item['User']['level'] == 1)
                        		echo $this->Html->link($item['User']['user_name'], array('controller' => 'Admins', 'action' => 'manager_manager', $item['User']['id']));
                        	else if($item['User']['level'] == 2)
                        		echo $this->Html->link($item['User']['user_name'], array('controller' => 'Admins', 'action' => 'teacherManager', $item['User']['id']));
                        	else
                        		echo $this->Html->link($item['User']['user_name'], array('controller' => 'Admins', 'action' => 'student_manager', $item['User']['id']));
                        	?>
                        </td>
                        <td class='content-center'><?php echo $item['User']['real_name']; ?></td>
                        <?php
                                $block = 'ブロック';
                                $temp = $item['User']['level'];
                                
                                    if ($temp == 1) {
                                            $count = '管理者';
                                    }
                                    if ($temp == 2) {
                                            $count = '先生';
                                    }
                                    if ($temp == 3) {
                                            $count = '学生';
                                    }
                                $temp1 = $item['User']['status_flag'];
                                    if($temp1==1){
                                            $block='ブロックない';
                                    }
                                
                        ?>
                        <td class='content-center'><?php echo $count;?></td>
                        <td class='content-center'><?php echo $block; ?></td>
                    </tr>

                <?php
            }
        ?>   
        </tbody>    
    </table>
<?php else: {
    echo '結果がない';
} ?>
<?php endif; ?>
</div>

 <?php if(isset($users)): ?>

<?php endif; ?>
<?php echo $this->element('paging');?>
