<?php
/**
 *	CQPHPフレームワーク中枢
 *
 *	@author	CQPHP
 */
class CQPHP_Framework {

	/** Singleton */
	static private $instance	= null;

	/** 実行がコマンドラインからかどうか */
	private $commandline		= FALSE;

	/**
	 *	インスタンス生成
	 *	@return	CQPHP_Framework
	 */
	static public function getInstance() {
		if(is_null(self::$instance)) {
			self::$instance	= new self();
		}
		return self::$instance;
	}

	/**
	 *	コンストラクタ
	 */
	public function __construct() {
	}

	/**
	 *	フレームワーク実行
	 */
	public function run($commandline) {
		$this->commandline	= $commandline;

		$path	= CQPHP_Request::getActionPathByUrl();

		$this->executeAction($path);
	}

	/**
	 *	モジュールを読み込み、SmartyによるOutputを実行する
	 *	@param	string	$path	アクションパス
	 */
	public function executeAction($path) {
		//アクション実行
		$class_name		= CQPHP_DefineSetting::loadActionFile($path);
		$template		= new CQPHP_ApplicationTemplate($path);
		if(class_exists($class_name)) {
			$action_class	= new $class_name($path);
			$action_class->execute($template);
		} else {
			throw new Exception('Unknown Action Class');
		}

		//テンプレートにアクションクラスのパラメータを保存
		foreach($action_class->getAssignValues() as $key => $value) {
			$template->assign($key, $value);
		}

		//テンプレート実行
		if($template->display() === FALSE) {
			throw new Exception('Unknown Template HTML');
		}
	}
}
