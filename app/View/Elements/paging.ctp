<div class="paging btn-group">
    <?php
    //ページングする
    echo $this->Paginator->counter(array('format' => __('結果は {:count} レコード {:start}  〜 {:end} 　（{:page}/{:pages}）')));
	echo "<br>";
    echo $this->Paginator->first('最初へ');//di den trang dau tien
    echo $this->Paginator->prev(__('前へ'), array('class' => 'btn'), null, array('class' => 'prev disabled btn'));
    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'btn', 'currentClass' => 'disabled'));
    echo $this->Paginator->next(__('次へ'), array('class' => 'btn'), null, array('class' => 'next disabled btn'));
    echo $this->Paginator->last('最後へ');//di den trang cuoi cung
    ?>
</div>