<h2>可変値を変更します。</h2>

<?php
//debug($data);
//debug($data[0]);
//echo $this->Form->create('SessonForm');
//echo $this->Form->input('sesson', array('type' => 'text', 'id' => 'sesson_id', 'value' => $data[0]['ChangeableValue']['current_value'], "label" => 'セション'));
//echo $this->Form->end('Submit');
//
//echo $this->Form->create('RateForm');
//echo $this->Form->input('rate', array('type' => 'text', 'value' => $data[1]['ChangeableValue']['current_value'], "label" => '手数料率'));
//echo $this->Form->end('Submit');
//
//echo $this->Form->create('MaxPasswordRetryForm');
//echo $this->Form->input('maxPasswordRetry', array('type' => 'text', 'value' => $data[3]['ChangeableValue']['current_value'], "label" => 'パスワード違う入力数'));
//echo $this->Form->end('Submit');
//
//echo $this->Form->create('LockTimeForm');
//echo $this->Form->input('lockTime', array('type' => 'text', 'value' => $data[4]['ChangeableValue']['current_value'], "label" => 'ロック時間'));
//echo $this->Form->end('Submit');


echo $this->Html->script(array('jquery.validate', 'additional-methods', 'jquery.validate.min', 'additional-methods.min'));

echo $this->Form->create('ChangeableValue', array('id' => 'ChangeableValue_id'));
echo $this->Form->input('sesson', array('type' => 'text', 'id' => 'sesson_id', 'value' => $data[0]['ChangeableValue']['current_value'], "label" => 'セション'));
echo $this->Form->input('rate', array('type' => 'text', 'id' => 'rate_id', 'value' => $data[1]['ChangeableValue']['current_value'], "label" => '手数料率'));
echo $this->Form->input('maxPasswordRetry', array('type' => 'text', 'id' => 'maxPasswordRetry_id', 'value' => $data[3]['ChangeableValue']['current_value'], "label" => 'パスワード違う入力数'));
echo $this->Form->input('lockTime', array('type' => 'text', 'id' => 'lockTime_id', 'value' => $data[4]['ChangeableValue']['current_value'], "label" => 'パスワード違う入力数'));
echo $this->Form->end('Submit');
?>

<script>
    $(document).ready(function() {
        $("#ChangeableValue_id").validate();
        jQuery.validator.addMethod("isNumber", function(value, element) {
            return /^[0-9]+$/.test(value);
        });
        
        jQuery.validator.addMethod("isRangeValue", function(value, element) {
            return (value >= 0 && value <= 100);
        });

        $("#sesson_id").rules("add", {
            required: true,
            isNumber: true,
            messages: {
                required: "入力してください！！",
                isNumber: jQuery.format("数字を入力してください！！"),
            }
        });
        
        $("#rate_id").rules("add", {
            required: true,
            isNumber: true,
            isRangeValue: true,
            messages: {
                required: "入力してください！！",
                isNumber: jQuery.format("数字を入力してください！！"),
                isRangeValue: jQuery.format("入力する値は=＞０そして=１００です！！"),
            }
        });
        
        $("#maxPasswordRetry_id").rules("add", {
            required: true,
            isNumber: true,
            messages: {
                required: "入力してください！！",
                isNumber: jQuery.format("数字を入力してください！！"),
            }
        });
        
        $("#lockTime_id").rules("add", {
            required: true,
            isNumber: true,
            messages: {
                required: "入力してください！！",
                isNumber: jQuery.format("数字を入力してください！！"),
            }
        });
        
    });

</script>