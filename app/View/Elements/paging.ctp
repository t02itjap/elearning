<div class="paging">
    <?php
    //ページングする
    echo $this->Paginator->counter(array('format' => __('結果は {:count} レコード {:start}  〜 {:end} 　（{:page}/{:pages}）')));
	echo "<br>";
    echo $this->Paginator->first('<<');//di den trang dau tien
    echo $this->Paginator->prev(__('<'), array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('modulus' => 4, 'separator' => false));
    echo $this->Paginator->next(__('>'), array(), null, array('class' => 'next disabled'));
    echo $this->Paginator->last('>>');//di den trang cuoi cung
    ?>
</div>