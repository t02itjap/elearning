<h2>報酬情報</h2>
<h4 style="font-size: 1.3em;">見たい報酬情報の時間を選択します。</h4>
<?php
//echo $this->Html->script(array('jquery.validate', 'additional-methods', 'jquery.validate.min', 'additional-methods.min'));

//debug($data);
//debug($rate);
//debug($this->Session->read('testData'));
$data = $this->Session->read('data');
$time = $this->Session->read('time');
if (empty($time)) {
    $time = date('Y-m');
    $this->Session->write('time', $time);
}
echo $this->Form->create('YearMonth', array('id' => 'YearMonth_id'));
echo $this->Form->year('year', 2013, date('Y'), array('id' => 'year_id', 'value' => date('Y', strtotime($time))));
echo "年";
echo $this->Form->month('month', array('id' => 'month_id', 'value' => date('M', strtotime($time))));
echo "月";
echo $this->Form->end('表示');
?>

<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Lesson.lesson_name', '授業名'); ?></th>
                <th>学生数</th>
                <th>報酬</th>
            </tr>
        </thead>
        <tbody>	
            <?php
            foreach ($data as $item) {
                ?>
                <tr>
                    <td class='content-center'><?php echo $item['Lesson']['lesson_name']; ?></td>
                    <td class='content-center'><?php echo $item[0]['COUNT']; ?></td>
                    <td class='content-center'><?php echo $item[0]['SUM']; ?></td>
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

<p>合計報酬: <?php echo $sum; ?></p>
<?php
echo $this->Html->Link('Download', array('class' => 'link-button', 'controller' => 'admins', 'action' => 'exportBill', $time));
?>
<!--<script>
    $(document).ready(function() {

        $("#YearMonth_id").validate();
        $("#year_id").rules("add", {
            required: true
        });
        $("#month_id").rules("add", {
            required: true
        });
    });

</script>-->