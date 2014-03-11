<?php
//debug($temp2);die;
$line= $temp2[0]['Bill'];
debug($line);die;
$this->CSV->addRow(array_keys($line));
 foreach ($temp2 as $item)
 {
      $line =$item['Bill'];
       $this->CSV->addRow($line);
 }
 $filename='Bill.csv';
 echo  $this->CSV->render($filename);
?>
