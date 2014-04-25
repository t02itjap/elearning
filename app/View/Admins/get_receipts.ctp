
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
echo "年";
echo $this->Form->year('year', 2013, date('Y'), array('id' => 'year_id', 'value' => date('Y', strtotime($time))));
echo "月";
echo $this->Form->month('month', array('id' => 'month_id', 'value' => date('M', strtotime($time))));
echo $this->Form->button('表示', array('type' => 'submit', 'name' => 'data[submit_data]', 'class' => 'link-button', 'id' => 'submit_button', 'class' => ' btn'));
echo $this->Form->end();
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

<?php echo $this->element('paging');?>
<br>合計報酬: <?php echo $sum; ?></br>
<?php
echo $this->Html->Link('Download', array('controller' => 'admins', 'action' => 'exportBill', $time), array('class' => 'link-button'));
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