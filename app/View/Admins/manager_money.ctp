
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
<div id="main_content">
    <h2>課金情報</h2>
    <div id="money_manage">
       <h4 style="font-size: 1.3em;">見たい課金情報の時間を選択します。</h4>
       <?php
       echo $this->Form->create('Admins',array('type' => 'post', 'controller'=>'admins','action'=>'managerMoney'));
       echo $this->Form->input ( 'month', array ('label' => false, 'class' => 'input-small', 'options' => $birthMonthOptions, 'id' => 'birth-month', 'div' => false, 'empty' => '-' ) );
       echo $this->Form->input ( 'year', array ('label' => false, 'class' => 'input-small', 'options' => $birthYearOptions, 'id' => 'birth-year', 'div' => false, 'empty' => '-' ) );
       echo $this->Form->button('表示', array ('type' => 'submit', 'name' => 'data[result]','class'=>'btn','id'=>"btn-save"));
       echo $this->Form->end();
       ?>
       <br />
       <br />
       <table>
        <tr>
            <td>ID</td>
            <td>氏名</td>
            <td>請求金額</td>
            <td>連絡先住所</td>
            <td>電話番号</td>
            <td>請求区分</td>
            <td>クレジットカード番号</td>
            <td>銀行口座番号</td>
        </tr>
        <?php for ($i=0; $i <count($userInfors) ; $i++) { 
        ?>
        <tr>
            <td><?=$i+1?></td>
            <td><?=$userInfors[$i]['user']['real_name']?></td>
            <td><?=$userInfors[$i][0]['sum']?></td>
            <td><?=$userInfors[$i]['user']['address']?></td>
            <td><?=$userInfors[$i]['user']['phone_number']?></td>
            <td>54</td>
            <td>クレジットカード番号</td>
            <td><?=$userInfors[$i]['user']['bank_account_code']?></td>
        </tr>
        <?php } ?>
    </table>
</div><!--End #money_manage-->

<div id="submit">
    <input type="submit" name="cancel" value="作成"/>
</div><!--End #submit-->
</div><!--End #main_content-->
