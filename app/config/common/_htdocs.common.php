<?php
/**
 *	ドキュメントルート別共通設定ファイル
 *
 *	@author
 */

//基本文字コード(ファイル文字コード)
define('CHARSET_DEFAULT',	'UTF-8');

//出力文字コード
define('CHARSET_OUTPUT',	'UTF-8');

//出力操作
ini_set("default_charset", CHARSET_DEFAULT);
mb_internal_encoding(CHARSET_OUTPUT);
mb_http_output(CHARSET_OUTPUT);
ob_start("mb_output_handler");

//アプリケーション側ディレクトリ定数設定
define('DIR_BASE',		str_replace("\\", "/", dirname(dirname(dirname(__FILE__)))));
define('DIR_ACTION',	DIR_BASE.'/action');
define('DIR_CONFIG',	DIR_BASE.'/config');
define('DIR_DEFINE',	DIR_BASE.'/define');
define('DIR_FILTER',	DIR_BASE.'/filter');
define('DIR_MODEL',		DIR_BASE.'/model');
define('DIR_TEMPLATE',	DIR_BASE.'/template');

//サイト情報
define('SERVER_DOMAIN', 	CQPHP_Request::getHost());
define('SERVER_ADDRESS',	$_SERVER['SERVER_ADDR']);
define('SERVER_URI',		rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));

//閲覧側情報
define('REMOTE_ADDR',	$_SERVER['REMOTE_ADDR']);
define('REMOTE_PORT',	$_SERVER['REMOTE_PORT']);

//パスの設定
CQPHP_DefineSetting::$_smarty_template_dir	= DIR_TEMPLATE;
CQPHP_DefineSetting::$_action_dir			= DIR_ACTION;
CQPHP_DefineSetting::$_template_dir			= DIR_TEMPLATE;

