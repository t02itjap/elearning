<?php //debug($users); die(); ?>

 <div id="acc_manage">
    <span>アップロードファイルを管理します。</span>
    <?php
    echo $this->Form->create('Document');
    echo $this->Form->input('file_name', array('label'=>'アップロードファイル検索'));
    echo $this->Form->end('検索');
    ?>
    <?php if(isset($data)&&$data!=null): ?>
    <!--
    <span><input type="text"/></span>
    <span><button>検索</button></span>-->
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Document.id', 'ID'); ?></th>
                <th><?php echo $this->Paginator->sort('Document.file_name', 'ファイル名'); ?></th>
                <th><?php echo $this->Paginator->sort('Document.create_date', 'アップロード時間'); ?></th>
                <th><?php echo $this->Paginator->sort('Document.create_user_id', 'アップロード者'); ?></th>
                <th><?php echo $this->Paginator->sort('Document.copyright_violation', 'Copyright違反'); ?></th>
                <th><?php echo $this->Paginator->sort('Document.lock_flag', 'ブロック情態'); ?></th>
                <th>ブロック</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody> 
        <?php
            $sum = 0;
            foreach ($data as $item) {
                    
                    ?>
                    <tr>
                        <?php
                        echo $this->Form->create('Document',array('type' => 'post', 'controller' => 'admins', 'action' => 'delete_document'));
                        ?>
                        <?php echo $this->Form->hidden('hide', array(
                            'value' => $item['Document']['id'],
                            'name' => 'data[hide]',
                            ));
                            ?>
                        <td class='content-center'><?php echo $item['Document']['id']; ?></td>
                        <td class='content-center'><?php echo "<a href='#'>".$item['Document']['file_name']."</a>"; ?></td>
                        <td class='content-center'><?php echo $item['Document']['create_date']; ?></td>
                        <td class='content-center'><?php echo $item['User']['user_name']; ?></td>
                        <?php
                                $count = '違反ない';
                                $temp = $item['Document']['copyright_violation'];
                                if ($temp == 1) {
                                            $count = '違反';
                                    }
                                $count1='ブロックない';
                                $temp1 = $item['Document']['lock_flag'];
                                if ($temp1 == 1) {
                                            $count1 = 'ブロック';
                                    }
                        ?>
                        <td class='content-center'><?php echo $count; ?></td>
                        <td class='content-center'><?php echo $count1; ?></td>
                        <td ><?php
                        echo $this->Form->button('Block',
                            array(
                                'name'=>'data[block_file]',
                                'class'  => 'link-button',
                                'onClick'=>"return confirm('このファイルをブロックしたいですか?')",
                                'escape'=> 'flase',
                                'title'=>'xac nhan'
                                ));
                        ?></td>
                        <td ><?php

                        echo $this->Form->button('delete',
                            array(
                                'name'=>'data[delete_file]',
                                'class'  => 'link-button',
                                'onClick'=>"return confirm('このファイルを削除したいですか?')",
                                'escape'=> 'flase',
                                'title'=>'xac nhan'
                                ));
                            ?>

                        </td>
                    </tr>
                    
                <?php
            }
        ?>   
        </tbody>    
    </table>
</div>


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
