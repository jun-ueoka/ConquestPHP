<?php
/**
 *	汎用関数宣言クラス
 *
 *	@author	CQPHP
 */
class CQPHP_Utility
{
	/**
	 *	UserAgentからブラウザタイプを取得
	 *	@return	ブラウザタイプ
	 */
	static public function getBrowserType() {
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		//Softbank
		if (preg_match('/^(J\-PHONE|Vodafone|MOT\-[CV]|SoftBank)/i', $useragent)) {
			return CQPHP_DefineBrowser::SOFTBANK;
		}
		//Docomo
		elseif (preg_match('/^DoCoMo/i', $useragent)) {
			return CQPHP_DefineBrowser::DOCOMO;
		}
		//AU
		elseif (preg_match('/^KDDI\-/i', $useragent) || preg_match('/UP\.Browser/i',$useragent)) {
			return CQPHP_DefineBrowser::AU;
		}
		//iPhone
		elseif (preg_match('/iPhone/i', $useragent)) {
			return CQPHP_DefineBrowser::IPHONE;
		}
		//iPod
		elseif (preg_match('/iPod/i', $useragent)) {
			return CQPHP_DefineBrowser::IPOD;
		}
		//iPad
		elseif (preg_match('/iPad/i', $useragent)) {
			return CQPHP_DefineBrowser::IPAD;
		}
		//Android
		elseif (preg_match('/Android/i', $useragent)) {
			return CQPHP_DefineBrowser::ANDROID;
		}
		//MSIE
		elseif (preg_match('/MSIE/i', $useragent)) {
			if (strstr($useragent, 'MSIE 6.0')) {
				return CQPHP_DefineBrowser::IE6;
			} else
			if (strstr($useragent, 'MSIE 7.0')) {
				return CQPHP_DefineBrowser::IE7;
			} else
			if (strstr($useragent, 'MSIE 8.0')) {
				return CQPHP_DefineBrowser::IE8;
			} else
			if (strstr($useragent, 'MSIE 9.0')) {
				return CQPHP_DefineBrowser::IE9;
			}
			else {
				return CQPHP_DefineBrowser::IE;
			}
		}
		//Firefox
		elseif (preg_match('/Firefox/i', $useragent)) {
			return CQPHP_DefineBrowser::FIREFOX;
		}
		//Safari
		elseif (preg_match('/Safari/i', $useragent)) {
			return CQPHP_DefineBrowser::SAFARI;
		}
		//Chrome
		elseif (preg_match('/Chrome/i', $useragent)) {
			return CQPHP_DefineBrowser::CHROME;
		}
		//Opera
		elseif (preg_match('/Opera/i', $useragent)) {
			return CQPHP_DefineBrowser::OPERA;
		}
		//WebKit
		elseif (preg_match('/WebKit/i', $useragent)) {
			return CQPHP_DefineBrowser::WEBKIT;
		}
		//KHTML
		elseif (preg_match('/KHTML/i', $useragent)) {
			return CQPHP_DefineBrowser::KHTML;
		}
		//KHTML
		elseif (preg_match('/Gecko/i', $useragent)) {
			return CQPHP_DefineBrowser::GECKO;
		}
		//etc..
		else {
			return CQPHP_DefineBrowser::OTHER;
		}
	}

	/**
	 *	URLのQueryStringからアクションパスを取得
	 *	@return	string	アクションパス
	 */
	static public function getActionPathByUrl() {
		$baseUrl	= rtrim(pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME), '/');
		$path		= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		if(strpos($path, $baseUrl) === 0) {
			$path		= substr($path, strlen($baseUrl));
			$path		= ltrim($path, '/');
		}

		//QueryStringから判断出来ない場合、indexとする
		if(($path == '') || (substr($path, -1, 1) == '/')) {
			$path .= 'index';
		}

		return $path;
	}
}

