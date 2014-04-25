
<!-- ham tao ngay thang nam -->
<?php
for($i = 2013; $i <= date ( 'Y' ); $i ++) {
    $birthYearOptions [$i] = $i;
}
for($i = 1; $i <= 12; $i ++) {
    if ($i < 10) {
        $birthMonthOptions ["0" . $i] = "0" . $i;
    } else {
        $birthMonthOptions [$i] = $i;
    }
}
?>
    <div id="money_manage">
       <h4 style="font-size: 1.3em;">見たい課金情報の時間を選択します。</h4>
       <?php
       echo $this->Form->create('Admins',array('type' => 'post', 'controller'=>'admins','action'=>'managerMoney','id'=>'form-add'));
       echo $this->Form->input ( 'month', array ('label' => false, 'class' => 'input-small', 'options' => $birthMonthOptions, 'id' => 'birth-month', 'div' => false, 'empty' => '-' ) );
       echo $this->Form->input ( 'year', array ('label' => false, 'class' => 'input-small', 'options' => $birthYearOptions, 'id' => 'birth-year', 'div' => false, 'empty' => '-' ) );
       echo $this->Form->button('表示', array ('type' => 'submit', 'name' => 'data[result]','class'=>'btn','id'=>"btn-save"));
       echo $this->Form->end();
       ?>
       <br />
       <br />
       <h4 style="font-size: 1.3em;"><?php if(!empty($data)) echo 'ELS-UBT-GWK54M78 '.date('Y').' '.date('m').' '.date('Y').' '.date('m').' '.
       date('d').' '.date('h').' '.date('i').' '.date('s').' '.$data['createId'].' '.$data['creater']?></h4>
       <table>
        <tr>
            <td>ID</td>
            <td>氏名</td>
            <td>請求金額</td>
            <td>連絡先住所</td>
            <td>電話番号</td>
            <td>請求区分</td>
            <td>クレジットカード番号-銀行口座番号</td>
        </tr>
        
        <?php if(!empty($data)) { for ($i=0; $i <count($data['money']) ; $i++) { 
        ?>
        <tr>
            <td><?=$data['money'][$i]['user']['user_name']?></td>
            <td><?=$data['money'][$i]['user']['real_name']?></td>
            <td><?=$data['money'][$i]['sum']?></td>
            <td><?=$data['money'][$i]['user']['address']?></td>
            <td><?=$data['money'][$i]['user']['phone_number']?></td>
            <td><?php if($data['money'][$i]['user']['level']==2 ) echo '54';else echo '18';?></td>
            <td><?=$data['money'][$i]['user']['bank_account_code']?></td>
        </tr>
        <?php } }?>
    </table>
    <?php
    ?>
</div><!--End #money_manage-->

<div id="submit">
        <?php
        if($isDownload){
	       echo $this->Form->create('Admins',array('type' => 'post', 'controller'=>'admins','action'=>'exportMoney'));
	       echo $this->Form->button('作成', array('type' => 'submit', 'name' => 'noname','class'=>'btn','id'=>"btn-save"));
	       echo $this->Form->end();
	       }
       ?>
</div><!--End #submit-->
