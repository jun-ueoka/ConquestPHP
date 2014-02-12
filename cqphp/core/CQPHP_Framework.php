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
	 *	@param	boolean	$commandline	コマンドライン実行確認
	 */
	public function run($commandline) {
		$path	= CQPHP_Request::getActionPathByUrl();

		//出力のバッファリングを開始
		ob_start();

		//TODO initialフィルター

		//外部からのリクエストデータを全て取得
		$requests	= CQPHP_Request::getRequestParams(true);

		//アクションパスに対応したクラスファイルを読み込む
		$class_name	= CQPHP_DefineSetting::loadActionFile($path);
		if(!class_exists($class_name)) {
			throw new Exception('Fatal Error : unknown action class file');
		}

		//アクションクラス生成
		$action	= new $class_name($path);
		if(!($action instanceof CQPHP_ApplicationAction))
		{
			throw new Exception('Fatal Error : invalid action interface');
		}

		//テンプレートクラス生成
		$template	= new CQPHP_ApplicationTemplate($path);

		//アクションクラスを実行
		$action->setRequestParams($requests['get'], $requests['post'], $requests['cookie']);
		$action->execute($template);

		//TODO after actionフィルター

		//テンプレートにアクションクラスのパラメータを保存
		foreach($action->getAssignValues() as $key => $value) {
			$template->assign($key, $value);
		}

		//TODO Smartyプリフィルター

		//テンプレート実行
		if($template->display() === FALSE) {
			throw new Exception('Fatal Error : unknown template HTML file');
		}

		//出力バッファを取得し、バッファは削除する
		$contents = ob_get_contents();
		ob_end_clean();

		//TODO lastフィルター

		echo $contents;
	}
}
