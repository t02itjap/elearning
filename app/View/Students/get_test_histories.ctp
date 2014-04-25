<?php
//debug($data);
?>

<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
<!--                <th><?php echo $this->Paginator->sort('Test.Lesson.lesson_name', '授業名'); ?></th>-->
                <th><?php echo '授業名'; ?></th>
                <th><?php echo $this->Paginator->sort('Test.file_name', 'テスト名'); ?></th>
                <th><?php echo $this->Paginator->sort('TestHistory.test_date', 'テスト時間'); ?></th>
                <th><?php echo $this->Paginator->sort('TestHistory.score', '結果'); ?></th>
                <th><?php echo "具体的に見る"; ?></th>
            </tr>
        </thead>
        <tbody>	
            <?php
            foreach ($data as $item) {
                ?>
                <tr>
                    <td class='content-center'><?php echo $item['Test']['Lesson']['lesson_name']; ?></td>
                    <td class='content-center'><?php echo $item['Test']['file_name']; ?></td>
                    <td class='content-center'><?php echo $item['TestHistory']['test_date']; ?></td>
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