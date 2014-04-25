
<?php
//debug($data);
?>
<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('User.real_name', '学生名'); ?></th>
                <th><?php echo $this->Paginator->sort('TestHistory.score', '結果'); ?></th>
                <th>具体的に見る</th>
            </tr>
        </thead>
        <tbody>	
        <?php
            foreach ($data as $item) {
                    ?>
                    <tr>
                        <td class='content-center'><?php echo $item['User']['real_name']; ?></td>
                        <td class='content-center'><?php echo $item['TestHistory']['score']; ?></td>
                        <td class='content-center'><?php echo $this->Html->link("見る", array('controller' => 'Tests','action'=> 'result', $item['TestHistory']['id']), array( 'class' => 'button'));?></td>
                    </tr>
                <?php
            }
        ?>   
        </tbody>	
    </table>
</div>
<?php echo $this->element('paging');?>