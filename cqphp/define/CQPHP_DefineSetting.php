<?php
/**
 *	CQPHP設定クラス
 *
 *	@author	CQPHP
 */
class CQPHP_DefineSetting {

	/** アクションファイル格納先 */
	static	public	$_action_dir			= "";
	/** テンプレートファイル格納先 */
	static	public	$_template_dir			= "";

	/** アクションファイル拡張子 */
	static	public	$_action_extension		= 'php';
	/** テンプレートファイル拡張子 */
	static	public	$_template_extension	= 'html';

	/** Smarty テンプレートパス */
	static	public	$_smarty_template_dir	= "";
	/** Smarty コンパイルパス */
	static	public	$_smarty_compile_dir	= "";
	/** Smarty コンフィグパス */
	static	public	$_smarty_config_dir		= "";
	/** Smarty キャッシュパス */
	static	public	$_smarty_cache_dir		= "";

	/**
	 *	アクションファイル読み込み
	 *	@param	string	$path	指定アクションパス
	 *	@return	string|boolean	アクションクラス名(成功),FALSE(失敗)
	 */
	static public function loadActionFile($path) {
		$check_path	= self::editActionFilePath($path);
		if(is_file($check_path)) {
			require_once($check_path);
			return self::editActionClassName($path, $access_define);
		}
		return	FALSE;
	}

	/**
	 *	指定アクションパスからクラス名を生成
	 *		指定パスが「test/script/index」なら、「_TestScriptIndex」となる
	 *	@param	string	$path	指定アクションパス
	 *	@return	string	アクションクラス名
	 */
	static public function editActionClassName($path) {
		$tmp_path_array	= explode('/', $path);
		$tmp_path		= "_";
		foreach($tmp_path_array as $key => $value) {
			$tmp_path	.= mb_convert_case($value,MB_CASE_TITLE);
		}
		return	$tmp_path;
	}

	/**
	 *	アクションファイルへ絶対パスの生成
	 *	@param	string	$path	指定アクションパス
	 *	@return	string	指定アクションファイルへの絶対パス
	 */
	static public function editActionFilePath($path) {
		$action_path	= rtrim(self::$_action_dir, '/') . "{$path}." . self::$_action_extension;
		return $action_path;
	}

	/**
	 *	テンプレートファイルへ絶対パスの生成
	 *	@param	string	$path	指定テンプレートパス
	 *	@return	string	指定テンプレートファイルへの絶対パス
	 */
	static public function editTemplateFilePath($path) {
		$template_path	= rtrim(self::$_template_dir, '/') . "{$path}." . self::$_template_extension;
		return $template_path;
	}
}

