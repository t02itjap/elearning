<?php

//項目を記入する
$line = array('タイム', '授業名', '学費');
$this->CSV->addRow($line);

//sum変数を初期化する
$sum = 0;

//各行を記入する
foreach ($temp2 as $item) {
    $line = array($item['Bill']['learn_date'], $item['Lesson']['lesson_name'], $item['Bill']['lesson_cost']);
    $this->CSV->addRow($line);
    //sum変数を計算する
    $sum += $item['Bill']['lesson_cost'];
}
//合計を記入する
$line = array('合計課金','', $sum);
$this->CSV->addRow($line);

//ファイルに出す
$filename = 'Bill.csv';
echo $this->CSV->render($filename);
?>
