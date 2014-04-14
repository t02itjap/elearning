<h4 style="font-size: 1.3em; margin-left: 10px;">見たい報酬情報の時間を選択します。</h4>
<?php
//debug($data);
//フォルムを作る
//echo $this->Form->create('YearMonth');
//echo $this->Form->year('year', 2013, date('Y'));
//echo $this->Form->month('month');
//echo $this->Form->end('Submit');

$data = $this->Session->read('data');
$time = $this->Session->read('time');
if (empty($time)) {
    $time = date('Y-m');
    $this->Session->write('time', $time);
}
echo $this->Form->create('YearMonth', array('id' => 'YearMonth_id'));
echo "<font>年:</font>";
echo $this->Form->year('year', 2013, date('Y'), array('id' => 'year_id', 'value' => date('Y', strtotime($time))));
echo "<font>月:</font>";
echo $this->Form->month('month', array('id' => 'month_id', 'value' => date('M', strtotime($time))));
echo $this->Form->end('表示');

?>
<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Bill.learn_date', 'タイム'); ?></th>
                <th><?php echo $this->Paginator->sort('Lesson.lesson_name', '授業名'); ?></th>
                <th><?php echo $this->Paginator->sort('Bill.lesson_cost', '学費'); ?></th>
            </tr>
        </thead>
        <tbody>	
            <?php
            foreach ($data as $item) {
                ?>
                <tr>
                    <td class='content-center'><?php echo $item['Bill']['learn_date']; ?></td>
                    <td class='content-center'><?php echo $item['Lesson']['lesson_name']; ?></td>
                    <td class='content-center'><?php echo $item['Bill']['lesson_cost']; ?></td>
                </tr>
                <?php
            }
            ?>   
        </tbody>	
    </table>
</div>
<div>
    <?php
    //ページングする
    echo $this->Paginator->counter(array('format' => __('結果は {:count} レコード {:start}  〜 {:end} 　（{:page}/{:pages}）')));
    echo $this->Paginator->first('最初へ');//di den trang dau tien
    echo $this->Paginator->prev(__('前へ'), array('class' => 'btn'), null, array('class' => 'prev disabled btn'));
    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn', 'currentClass' => 'disabled'));
    echo $this->Paginator->next(__('次へ'), array('class' => 'btn'), null, array('class' => 'next disabled btn'));
    echo $this->Paginator->last('最後へ');//di den trang cuoi cung
    ?>

<p>合計課金: <?php echo $sum; ?></p>
<center>
<?php
echo $this->Html->link('ダウンロード', array('controller' => 'students', 'action' => 'exportBill', $time), array('class' => 'link-button'));
?>
</center>
</div>
