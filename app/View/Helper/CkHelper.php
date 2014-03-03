
<?php
class CkHelper extends AppHelper { 

    public $helpers = array('Html');
    public function load($id) {
        $code = "CKEDITOR.replace( '".$id."' );";
        return $this->Html->scriptBlock($code);
    }
} 
?>