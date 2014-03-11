<?php
//debug($data);
//debug($data[0]);
echo $this->Form->create('ChangeableValue');
echo $this->Form->input('sesson', array('type' => 'text', 'value' => $data[0]['ChangeableValue']['current_value'])); 
echo $this->Form->input('rate', array('type' => 'text', 'value' => $data[1]['ChangeableValue']['current_value']));
echo $this->Form->input('maxPasswordRetry', array('type' => 'text', 'value' => $data[3]['ChangeableValue']['current_value']));
echo $this->Form->end('Submit'); 

?>