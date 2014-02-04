<?php
/**
 *	autoloadの設定
 *		未定義のクラスが呼び出された時に、自動でクラスの読込を試みる。
 *		「クラス名.php」のように、PHPファイル名とその中のクラス名が関連付けられている必要がある。
 *
 *	@author	CQPHP
 */
class CQPHP__Autoload {

	/**
	 *	自動読込を行うディレクトリを格納する配列
	 */
	static private $autoload_dir	= array();

	/**
	 *	自動読込先ディレクトリ配列追加
	 *	@param	func_get_args
	 *	@return	boolean	成否
	 */
	static public function setAutoloadDir() {
		self::$autoload_dir	= array_merge(self::$autoload_dir, func_get_args());
		return true;
	}

	/**
	 *	自動読込先ディレクトリ配列取得
	 *	@return	自動読込先ディレクトリ配列
	 */
	static public function getAutoloadDir() {
		return self::$autoload_dir;
	}

	/**
	 *	クラス名による読込を行う
	 *	@param	string	$class	クラス名
	 *	@return	boolean	成否
	 */
	static public function autoloadClass($class) {
		if(is_string($class)) {
			foreach(self::$autoload_dir as $dir) {
				if(is_file($path = $dir . '/' . $class . '.php')) {
					require($path);
					return true;
				}
			}
		}
		return false;
	}
}

//自動読み込みメソッド設定
spl_autoload_register("CQPHP__Autoload::autoloadClass");
