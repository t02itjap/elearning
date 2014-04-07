<?php // debug($users); die(); ?>

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
                <th><?php echo $this->Paginator->sort('User.status_flag', 'ブロック情態'); ?></th>
            </tr>
        </thead>
        <tbody> 
        <?php
            $sum = 0;
            foreach ($data as $item) {
                    
                    ?>
                    <tr>
                        <td class='content-center'><?php echo $item['User']['id']; ?></td>
                        <td class='content-center'><?php echo "<a href='#'>".$item['User']['user_name']."</a>"; ?></td>
                        <td class='content-center'><?php echo $item['User']['real_name']; ?></td>
                        <?php
                                $count = 'khong';
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
<div class="paging btn-group">
    <?php
    echo $this->Paginator->prev(__('前'), array('class' => 'btn'), null, array('class' => 'prev disabled btn'));
    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn', 'currentClass' => 'disabled'));
    echo $this->Paginator->next(__('後'), array('class' => 'btn'), null, array('class' => 'next disabled btn'));
    ?>
</div>
<?php else: {
    echo $message;
} ?>
<?php endif; ?>
</div>

 <?php if(isset($users)): ?>
<div class="paging btn-group">
    <?php
    echo $this->Paginator->prev(__('Trước'), array('class' => 'btn'), null, array('class' => 'prev disabled btn'));
    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn', 'currentClass' => 'disabled'));
    echo $this->Paginator->next(__('Sau'), array('class' => 'btn'), null, array('class' => 'next disabled btn'));
    ?>
</div>
<?php endif; ?>
