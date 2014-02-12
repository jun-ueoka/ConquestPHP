<?php
/**
 *	テンプレート出力クラス
 *
 *	@author	CQPHP
 */
class CQPHP_ApplicationTemplate implements CQPHP_InterfaceTemplate {

	/** Smartyライブラリクラス */
	private	$smarty			= NULL;

	/** テンプレートパス */
	private	$template_path	= '';

	/**
	 *	コンストラクタ
	 *	@param	string	$path	テンプレートパス
	 */
	public function __construct($path) {
		$this->setTemplate($path);

		//Smartyデフォルト設定
		$this->smarty				= new Smarty();
		$this->smarty->template_dir	= CQPHP_DefineSetting::$_smarty_template_dir;
		$this->smarty->compile_dir	= CQPHP_DefineSetting::$_smarty_compile_dir;
		$this->smarty->config_dir	= CQPHP_DefineSetting::$_smarty_config_dir;
		$this->smarty->cache_dir	= CQPHP_DefineSetting::$_smarty_cache_dir;
	}

	/**
	 *	テンプレートパス設定
	 *	@param	string	$path	テンプレートパス
	 */
	public function setTemplate($path) {
		$this->template_path	= $path;
	}

	/**
	 *	Smartyへ変数の代入を実行
	 */
	public function assign($name, $value, $htmlspc = false) {
		if($htmlspc) {
			$value	= array_map('htmlspecialchars', $value);
		}
		$this->smarty->assign($name, $value);
	}

	/**
	 * Smartyによる出力実行
	 */
	public function display() {
		$check_path	= CQPHP_DefineSetting::editTemplateFilePath($this->template_path);
		if(!$this->smarty->templateExists($check_path)) {
			return FALSE;
		}
		$this->smarty->display($check_path);
	}
}
