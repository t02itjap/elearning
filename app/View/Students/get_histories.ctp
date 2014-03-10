<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Lesson.lesson_name', 'Lesson Name'); ?></th>
                <th><?php echo $this->Paginator->sort('LearnHistory.learn_date', 'Learn Date'); ?></th>
            </tr>
        </thead>
        <tbody>	
            <?php
            foreach ($data as $item) {
                foreach ($item['LearnHistory'] as $history) {
                    ?>
                    <tr>
                        <td class='content-center'><?php echo $item['Lesson']['lesson_name'] ?></td>
                        <td class='content-center'><?php echo $history['learn_date'] ?></td>				
                    </tr>
                <?php }
            }
            ?>
        </tbody>	
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