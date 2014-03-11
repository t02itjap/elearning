<?php
//debug($data);
?>

<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Test.Lesson.lesson_name', 'Ten bai hoc'); ?></th>
                <th><?php echo $this->Paginator->sort('Test.file_name', 'Ten bai test'); ?></th>
                <th><?php echo $this->Paginator->sort('TestHistory.test_date', 'Ngay lam test'); ?></th>
                <th><?php echo $this->Paginator->sort('TestHistory.score', 'Ket qua'); ?></th>
                <th><?php echo "Xem chi tiet"; ?></th>
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
                    <td class='content-center'><?php echo "link"; ?></td>
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