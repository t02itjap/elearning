<?php echo $this->Session->flash(); ?>

 <div id="acc_manage">
    <span>アカウント検索</span>
    <?php
    echo $this->Form->create('User');
    echo $this->Form->input('user_name', array('label'=>'アカウント検索'));
    echo $this->Form->end('検索');
    ?>
    <span>アカウント種類</span>
    <?php
    $options = array('1' => '管理者', '2' => '先生', '3'=>'学生');
    echo $this->Form->create('User');
    echo $this->Form->input('level', array('class' => 'select', 'options' => $options, 'label' => false));
    echo $this->Form->end('表示');
    ?>





    <?php if(isset($data)&&$data!=null): ?>

    
    <!--
    <span><input type="text"/></span>
    <span><button>検索</button></span>-->
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('User.id', 'ID'); ?></th>
                <th><?php echo $this->Paginator->sort('User.user_name', 'ユーザネーム'); ?></th>
                <th><?php echo $this->Paginator->sort('User.real_name', '名前'); ?></th>
                <th><?php echo $this->Paginator->sort('User.level', 'タイプ'); ?></th>
            </tr>
        </thead>
        <tbody> 
        <?php
            $sum = 0;
            foreach ($data as $item) {
                    
                    ?>
                    <tr>
                        <td class='content-center'><?php echo $item['User']['id']; ?></td>
                        <td class='content-center'><?php echo $this->Html->link($item['User']['user_name'], array('controller' => 'Admins', 'action' => 'get_user_request', $item['User']['id']))?></td>
                        <td class='content-center'><?php echo $item['User']['real_name']; ?></td>
                        <?php
                                $count = 'khong';
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
                                
                        ?>
                        <td class='content-center'><?php echo $count;?></td>
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
