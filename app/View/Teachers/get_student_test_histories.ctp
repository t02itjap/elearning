<h3>試験結果</h3>
<?php
//debug($data);
?>
<div>
    <table class='table table-striped' style='table-layout: fixed'>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('User.real_name', '学生名'); ?></th>
                <th><?php echo $this->Paginator->sort('TestHistory.score', '結果'); ?></th>
                <th>具体的に見る</th>
            </tr>
        </thead>
        <tbody>	
        <?php
            foreach ($data as $item) {
                    ?>
                    <tr>
                        <td class='content-center'><?php echo $item['User']['real_name']; ?></td>
                        <td class='content-center'><?php echo $item['TestHistory']['score']; ?></td>
                        <td class='content-center'><?php echo $this->Html->link("見る", array('controller' => 'Tests','action'=> 'result', $item['TestHistory']['id']), array( 'class' => 'button'));?></td>
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