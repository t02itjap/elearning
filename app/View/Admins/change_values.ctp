
<?php
echo $this->Html->script(array('jquery.validate', 'additional-methods', 'jquery.validate.min', 'additional-methods.min'));
echo $this->Form->create('ChangeableValue', array('id' => 'ChangeableValue_id'));

echo "<table class='table table-striped' style='table-layout: fixed'>";

echo '<tr><td>'.'自動セション終了時間'.'</td>';
echo '<td>'.$this->Form->input('sesson', array('type' => 'text', 'id' => 'sesson_id', 'value' => $data[0]['ChangeableValue']['current_value'], "label" => false)).'</td></tr>';
echo '<tr><td>'.'報酬％'.'</td>';
echo '<td>'.$this->Form->input('rate', array('type' => 'text', 'id' => 'rate_id', 'value' => $data[1]['ChangeableValue']['current_value'], "label" => false)).'</td></tr>';
echo '<tr><td>'.'ログイン誤り回数'.'</td>';
echo '<td>'.$this->Form->input('maxPasswordRetry', array('type' => 'text', 'id' => 'maxPasswordRetry_id', 'value' => $data[3]['ChangeableValue']['current_value'], "label" => false)).'</td></tr>';
echo '<tr><td>'.'ロック時間'.'</td>';
echo '<td>'.$this->Form->input('lockTime', array('type' => 'text', 'id' => 'lockTime_id', 'value' => $data[4]['ChangeableValue']['current_value'], "label" => false)).'</td></tr>';
echo '<tr><td>'.'１回の受講料'.'</td>';
echo '<td>'.$this->Form->input('lessonCost', array('type' => 'text', 'id' => 'lessonCost_id', 'value' => $data[5]['ChangeableValue']['current_value'], "label" => false)).'</td></tr>';
echo '<tr><td>'.'受講可能時間'.'</td>';
echo '<td>'.$this->Form->input('learningTime', array('type' => 'text', 'id' => 'learningTime_id', 'value' => $data[6]['ChangeableValue']['current_value'], "label" => false)).'</td></tr>';
echo '<tr><td>'.'自動バックアップ時刻'.'</td>';
echo '<td>'.$this->Form->input('autoBackupTime', array('type' => 'text', 'id' => 'autoBackupTime_id', 'value' => $data[7]['ChangeableValue']['current_value'], "label" => false)).'</td></tr>';
echo "</table>";

echo '<center>'.$this->Form->input('変更', array('type' => 'submit', 'class' => 'link-button', 'label' => false)).'</center>';
echo $this->Form->end();
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
        
        $("#lessonCost_id").rules("add", {
            required: true,
            isNumber: true,
            messages: {
                required: "入力してください！！",
                isNumber: jQuery.format("数字を入力してください！！"),
            }
        });
        $("#learningTime_id").rules("add", {
            required: true,
            isNumber: true,
            messages: {
                required: "入力してください！！",
                isNumber: jQuery.format("数字を入力してください！！"),
            }
        });
        $("#autoBackupTime_id").rules("add", {
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