<?php

//項目を記入する
$line = array('授業名', '学生数', '報酬');
$this->CSV->addRow($line);

//sum変数を初期化する
$sum = 0;

//各行を記入する
foreach ($temp2 as $item) {
    $line = array($item['Lesson']['lesson_name'], $item[0]['COUNT'], $item[0]['SUM']);
    //debug($line);
    $this->CSV->addRow($line);
    //sum変数を計算する
    $sum += $item[0]['SUM'];
}
//合計を記入する
$line = array('合計課金','', $sum);
$this->CSV->addRow($line);

//ファイルに出す
$filename = 'Receipt.csv';
echo $this->CSV->render($filename);
?>
