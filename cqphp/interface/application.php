<?php
/**
 *	アプリケーションインターフェース定義
 *
 *	@author	CQPHP
 */

/**
 *	テンプレート出力クラスインターフェース
 */
interface CQPHP_InterfaceTemplate
{
	public function __construct($path);
	public function setTemplate($path);
	public function assign($name, $value, $htmlspc = false);
	public function display();
}

/**
 *	アクション実行クラスインターフェース
 */
interface CQPHP_InterfaceAction
{
	public function __construct($path);
	public function execute(CQPHP_InterfaceTemplate $template);
	public function validate();
	public function action(CQPHP_InterfaceTemplate $template);
}

