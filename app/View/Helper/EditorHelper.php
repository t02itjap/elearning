<?php
class EditorHelper extends FormHelper {

	public $helpers = array('Html');
	public $uses = array('TemplateInfo');
	
	/**
	 * Echo script for TinyMCE editor
	 * 
	 * @param options array
	 * template_field: rtf_body_mb | rtf_body_pc
	 * @author hungit <hungnq@lifetimetech.vn>
	 * @return void
	 */
	public function tinyMce($options = array()) {
		$plugin = '';
		$templateInit = '';
		$templatePlugin = '';
		$classInit = '';
		
		
		if (!isset($options['target_group_id'])) {
			$options['target_group_id'] = 0;
		}
		if (isset($options['template_field'])) {
			$templateInit = 'template_templates : ['.$this->requestAction('/template/get_templates/' . $options['template_field'] . '/' . $options['target_group_id']).'],';
			$templatePlugin = ',template';
			$plugin = $plugin.$templatePlugin;
		}
		if (isset($options['class'])) {
			$classInit = 'editor_selector : "' . $options['class'] . '",';
		}
		
		$plugin = $plugin.',|,images';
		
		if (isset($options['emoji_plugin'])) {
			$plugin = $plugin.',|,emotions';
		}
		
		if (!isset($options['image_category_type'])) {
			$options['image_category_type'] = 0;
		}
		
		if (!isset($options['target_publisher_id'])) {
			$options['target_publisher_id'] = 0;
		}
		
		
		$info = $options['target_group_id'] . '/' . $options['target_publisher_id'] . '/' . $options['image_category_type'];
		
		echo $this->Html->script('tiny_mce/tiny_mce', array('inline' => false));
		$this->Html->scriptStart(array('inline' => false));
		echo 'tinyMCE.init({
					mode : "textareas",
					theme : "advanced",
					skin : "o2k7",
					skin_variant : "silver",
					width: "100%",
					height: "400",
					plugins : "emotions'.$templatePlugin.',preview,imagemanager,inlinepopups,images",
					relative_urls : false,
					convert_urls : false,
					force_br_newlines : true,
					force_p_newlines : false,
					forced_root_block : "",
					theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect,|,bullist,numlist,|,code,preview,|,forecolor,backcolor,|,'.$plugin .'",
					theme_advanced_buttons2 : "",
					theme_advanced_buttons3 : "",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
					theme_advanced_fonts : "MS UI Gothic=MS UI Gothic;ＭＳ Ｐゴシック=ＭＳ Ｐゴシック;ＭＳ ゴシック=ＭＳ ゴシック;ＭＳ Ｐ明朝=ＭＳ Ｐ明朝;ＭＳ 明朝=ＭＳ 明朝;メイリオ=メイリオ;Meiryo UI=Meiryo UI",
					content_css : "' . $this->webroot . 'css/editor-style.css",'.
					$templateInit.
					$classInit.
					'ajax_json : "'. $this->webroot .'tinymce_image_masters/index/'. $info . '.json",
					url_upload : "' . $this->webroot . 'tinymce/upload/' .  $info . '",
					base_path : "' . (env('HTTPS') ? 'https://' : 'http://') . env('SERVER_NAME') . $this->webroot . '" ,
				});';
		
		$this->Html->scriptEnd();
	}

	function ck($fieldName, $options = array()) {
		$options = $this->_initInputField($fieldName, $options);
		$value = null;
		$config = null;
		$events = null;

		if (array_key_exists('value', $options)) {
			$value = $options['value'];
			unset($options['value']);
		}
		
		if (array_key_exists('config', $options)) {
			$config = $options['config'];
			unset($options['config']);
		}
		
		if (array_key_exists('events', $options)) {
			$events = $options['events'];
			unset($options['events']);
		}
		
		require_once WWW_ROOT.DS.'js'.DS.'ckeditor'.DS.'ckeditor.php';
		$CKEditor = new CKEditor();
		$CKEditor->basePath = $this->webroot.'js/ckeditor/';

		return $CKEditor->editor($options['name'], $value, $config, $events);
	}
}
?>