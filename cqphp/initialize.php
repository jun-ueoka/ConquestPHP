<?php
/**
 *	CQPHPフレームワークの準備
 *	・ディレクトリの定数化
 *	・必要なファイルの読み込み
 *	・_autoloadの設定
 *
 *	@author	CQPHP
 */

//フレームワーク側ディレクトリ定数設定
define('CQPHP_DIR',				str_replace("\\", "/", dirname(__FILE__)));
define('CQPHP_DIR_CACHE',		CQPHP_DIR . '/cache');
define('CQPHP_DIR_CORE',		CQPHP_DIR . '/core');
define('CQPHP_DIR_DEFINE',		CQPHP_DIR . '/define');
define('CQPHP_DIR_FILTER',		CQPHP_DIR . '/filter');
define('CQPHP_DIR_INTERFACE',	CQPHP_DIR . '/interface');
define('CQPHP_DIR_LIBRARY',		CQPHP_DIR . '/library');

//ライブラリ読み込み
require_once(CQPHP_DIR_LIBRARY . '/Smarty/Smarty.class.php');
require_once(CQPHP_DIR_LIBRARY . '/Garuda/Garuda.php');

//インターフェース読み込み
require_once(CQPHP_DIR_INTERFACE . '/application.php');
require_once(CQPHP_DIR_CORE . '/CQPHP_Autoload.php');

//autoloadのデフォルト設定
CQPHP_Autoload::setAutoloadDir(
	CQPHP_DIR_CORE
,	CQPHP_DIR_DEFINE
,	CQPHP_DIR_FILTER
);

//デフォルト設定
CQPHP_DefineSetting::$_smarty_template_dir	= CQPHP_DIR_CACHE . "/smarty/template";
CQPHP_DefineSetting::$_smarty_compile_dir	= CQPHP_DIR_CACHE . "/smarty/template_c";
CQPHP_DefineSetting::$_smarty_config_dir	= CQPHP_DIR_CACHE . "/smarty/config";
CQPHP_DefineSetting::$_smarty_cache_dir		= CQPHP_DIR_CACHE . "/smarty/cache";

