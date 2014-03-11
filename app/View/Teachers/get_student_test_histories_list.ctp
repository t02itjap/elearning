<?php
//debug($data);
?>

<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Lesson.lesson_name', 'Lesson Name'); ?></th>
                <th><?php echo $this->Paginator->sort('Test.file_name', 'Test Name'); ?></th>
                <th>So hoc sinh tham gia</th>
                <th>Diem so trung binh</th>
                <th>Xem chi tiet</th>
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
                        <td class='content-center'>Link</td>
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