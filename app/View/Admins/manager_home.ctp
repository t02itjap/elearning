<?php 
echo $this->Session->flash();
?>
<div id="manage_tool">
    <table>
        <tr>
            <td><?php echo $this->Html->link('可変値を変更',array('controller' => 'Admins', 'action' => 'changeValues'))?></td>
            <td><?php echo $this->Html->link('アカウントを管理',array('controller' => 'Admins', 'action' => 'getAccount'))?></td>
            <td><?php echo $this->Html->link('バックアップツール',array('controller' => 'Admins', 'action' => 'database_manager'))?></td>
        </tr>
        <tr>
            <td><?php echo $this->Html->link('管理者アカウント追加',array('controller' => 'Admins', 'action' => 'register_new_manager'))?></td>
            <td><?php echo $this->Html->link('アップロードファイル管理',array('controller' => 'Admins', 'action' => 'getDocument'))?></td>
            <td><?php echo $this->Html->link('授業管理',array('controller' => 'Admins', 'action' => 'getLesson'))?></td>
        </tr>
        <tr>
            <td><?php echo $this->Html->link('課金情報管理',array('controller' => 'Admins', 'action' => 'managerMoney'))?></td>
            <td><?php echo $this->Html->link('アカウント確認',array('controller' => 'Admins', 'action' => 'getConfirmAccount'))?></td>
            <td><?php echo $this->Html->link('手数料情報',array('controller' => 'Admins', 'action' => 'getReceipts'))?></td>
        </tr>
    </table>
</div><!--End #manage_tool-->