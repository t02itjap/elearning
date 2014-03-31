<h3>学生の試験結果</h3>
<?php
//debug($data);
?>

<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Lesson.lesson_name', '授業名'); ?></th>
                <th><?php echo $this->Paginator->sort('Test.file_name', 'テスト名'); ?></th>
                <th>合計学生数</th>
                <th>平均結果</th>
                <th>具体的に見る</th>
            </tr>
        </thead>
        <tbody>	
        <?php
            foreach ($data as $item) {
                    ?>
                    <tr>
                        <td class='content-center'><?php echo $item['Lesson']['lesson_name']; ?></td>
                        <td class='content-center'><?php echo $item['Test']['file_name']; ?></td>
                        <?php
                                $sum = 0;
                                $count = 0;
                                foreach ($item['TestHistory'] as $history) {
                                    $sum += $history['score'];
                                    $count++;
                                };
                                if($count != 0) $point = $sum / $count;
                        ?>
                        <td class='content-center'><?php echo $count;?></td>
                        <td class='content-center'><?php if ($count != 0) echo $point; else echo 'na';?></td>
                        <td class='content-center'><?php echo $this->Html->link("見る", array('controller' => 'teachers','action'=> 'getStudentTestHistories', $item['Test']['id']), array( 'class' => 'button'));?></td>
                    </tr>
                <?php
            }
        ?>   
        </tbody>	
    </table>
</div>
<div class="paging btn-group">
    <?php
    //ページングする
    echo $this->Paginator->first('最初へ');//di den trang dau tien
    echo $this->Paginator->prev(__('前へ'), array('class' => 'btn'), null, array('class' => 'prev disabled btn'));
    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn', 'currentClass' => 'disabled'));
    echo $this->Paginator->next(__('次へ'), array('class' => 'btn'), null, array('class' => 'next disabled btn'));
    echo $this->Paginator->last('最後へ');//di den trang cuoi cung
    ?>
</div>
<?php
    echo $this->Paginator->counter(array(
        'format' => __('結果は {:count} レコード {:start}  〜 {:end} 　（{:page}/{:pages}）')
    ));
?>