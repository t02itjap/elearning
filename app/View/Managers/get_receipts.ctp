<?php
//debug($data);
?>

<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Lesson.lesson_name', 'Lesson Name'); ?></th>
                <th>So hoc sinh tham gia</th>
                <th>So tien thu duoc</th>
            </tr>
        </thead>
        <tbody>	
        <?php
            $sum = 0;
            foreach ($data as $item) {
                    
                    ?>
                    <tr>
                        <td class='content-center'><?php echo $item['Lesson']['lesson_name']; ?></td>
                        <?php
                                $count = 0;
                                $salary = 0;
                                foreach ($item['Bill'] as $temp) {
                                    $salary += $temp['lesson_cost'] * $rate / 100;
                                    $count++;
                                    $sum += $salary;
                                };
                                
                        ?>
                        <td class='content-center'><?php echo $count;?></td>
                        <td class='content-center'><?php echo $salary;?></td>
                    </tr>
                <?php
            }
        ?>   
        </tbody>	
    </table>
</div>
<p>Tong so tien la: <?php echo $sum; ?></p>
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