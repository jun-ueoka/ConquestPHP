<?php
/**
 *	アプリケーション用設定ファイル
 *	ローカルPC環境用
 *
 *	@author
 */

//セッション名設定
session_name('S');
//エラーレベル設定
error_reporting((E_ALL|E_STRICT) & ~E_NOTICE);
//エラー出力を許可
ini_set('display_errors', 1);
//タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');
//PEAR等のインクルードパス
set_include_path(get_include_path());// . PATH_SEPARATOR . '');
//デバッグorリリース
define('DEVELOPMENT', TRUE);

//URL設定
define('URL_DOMAIN',	'http://conquest-php.localhost');
define('URL_SITE',		URL_DOMAIN . '/');

//アプリケーション側ディレクトリ定数設定
require(dirname(__FILE__) . '/common/_htdocs.common.php');


