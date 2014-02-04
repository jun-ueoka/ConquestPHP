<?php
/**
 *	メインスクリプト
 *
 *	@author	CQPHP
 */

//TODO try~catchの負荷が気になるが、ベンチマークは後で行う
try {
	//必要な定数が宣言されてなければ処理を無効とする
	//HTDOCS_DIR  = ドキュメントルートへの物理パス
	//HTDOCS_NAME = ドキュメントルートディレクトリ名
	if(!defined("HTDOCS_DIR") || !defined("HTDOCS_NAME"))
	{
		throw new Exception("Undefined HTDOCS_DIR,HTDOCS_NAME");
	}

	//設定タイプのリスト(配列の順番がチェック順になる)
	//ドキュメントルートに設定ファイルが置かれてなければエラー
	$config_type_list	= array("local", "debug", "release");
	foreach($config_type_list as $key => $value)
	{
		if(is_file(HTDOCS_DIR."/.{$value}"))
		{
			define('SERVER_TYPE', $value);
		}
	}
	if(!defined("SERVER_TYPE"))
	{
		throw new Exception("Undefined SERVER_TYPE");
	}

	//ドキュメントルートと設定タイプに紐付けられた設定ファイルが存在しなければエラー
	//(ドキュメントルートディレクトリ名)_(設定タイプ).ini.php
	if(!is_file($config_file_path = dirname(__FILE__)."/app/config/".HTDOCS_NAME."_".SERVER_TYPE.".ini.php"))
	{
		throw new Exception("Fatal error {$config_file_path}");
	}

	//フレームワークの準備
	require(dirname(__FILE__)."/cqphp/initialize.php");

	//アプリケーションの準備
	require($config_file_path);

	//フレームワーク実行
	CQPHP_Framework::executeAction(CQPHP_Utility::getActionPathByUrl());

}
catch(Exception $e) {
	echo $e->getMessage();
	error_log($e->getMessage());
	header('HTTP', true, 500);

	//例外表示
	if((defined('DEVELOPMENT') && DEVELOPMENT)) {
		echo "Exception Error<br /><br />\n";
		echo "Msg  : " . $e->getMessage() . "<br />\n";
		echo "Code : " . $e->getCode() . "<br />\n";
		echo "File : " . $e->getFile() . " line " . $e->getLine() . "<br />\n";
		echo "<br />\n";
		foreach($e->getTrace() as $k => $v) {
			echo sprintf("%s %s(%s): %s(%s)<br />\n",
				"#$k", $v['file'], $v['line'],
				(!empty($v['class']) ? $v['class'] . $v['type'] : "") . $v['function'],
				(!empty($v['args']) ? (is_array($v['args']) ? '"' . implode('","', $v['args']) : $v['args']) . '"' : "")
			);
		}
	}
	exit;
}

