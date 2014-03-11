<?php
//debug($data);
//debug($rate);
echo $this->Form->create('YearMonth');
echo $this->Form->year('year', 2013, date('Y'));
echo $this->Form->month('month');
echo $this->Form->end('Submit');
?>

<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Lesson.lesson_name', 'Lesson Name'); ?></th>
                <th>So hoc sinh tham gia</th>
                <th>Luong</th>
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

<p>
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Kết quả tìm được có {:count} bản ghi bắt đầu từ {:start}  〜 {:end} 　（{:page}/{:pages}）')
    ));
    ?>	
</p>

<div class="paging btn-group">
    <?php
    echo $this->Paginator->prev(__('Trước'), array('class' => 'btn'), null, array('class' => 'prev disabled btn'));
    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn', 'currentClass' => 'disabled'));
    echo $this->Paginator->next(__('Sau'), array('class' => 'btn'), null, array('class' => 'next disabled btn'));
    ?>
</div>

<p>Tong so tien la: <?php echo $sum; ?></p>