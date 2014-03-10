<?php

echo $this->Html->link("out",array("controller"=>"Users","action"=>"logout"));
echo("<br/>");
echo $this->Html->link("summary",array("controller"=>"Teachers","action"=>"summary",1));
?>