<?php
/**
 *	リクエスト解析クラス
 *
 *	@author	CQPHP
 */
class CQPHP_Request
{
	/**
	 *	HTTPメソッドがPOSTかどうか判定
	 *	@return	boolean
	 */
	static public function isPost() {
		return ($_SERVER['REQUEST_METHOD'] === 'POST');
	}

	/**
	 *	HTTPSでアクセスされたか判定
	 *	@return	boolean
	 */
	static public function isSsl() {
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on");
	}

	/**
	 *	ホスト名取得
	 *	@return	string
	 */
	static public function getHost() {
		if(!empty($_SERVER['HTTP_HOST'])) {
			return $_SERVER['HTTP_HOST'];
		}
		return $_SERVER['SERVER_NAME'];
	}

	/**
	 *	URIを取得
	 *	@return	string
	 */
	static public function getRequestUri() {
		$request_uri	= "";
		if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
			$request_uri = $_SERVER['HTTP_X_REWRITE_URL'];
		}
		elseif (isset($_SERVER['REQUEST_URI'])) {
			$request_uri = $_SERVER['REQUEST_URI'];
			if (($request_uri[0] !== "/") && (($num = strpos($request_uri, self::getHost())) !== FALSE)) {
				$request_uri = substr($request_uri, $num + strlen(self::getHost()));
			}
		}
		elseif (isset($_SERVER['ORIG_PATH_INFO'])) {
			$request_uri = $_SERVER['ORIG_PATH_INFO'];
			if (!empty($_SERVER['QUERY_STRING'])) {
				$request_uri .= '?' . $_SERVER['QUERY_STRING'];
			}
		}
		return $request_uri;
	}

	/**
	 *	URLのQueryStringからアクションパスを取得
	 *	@return	string	アクションパス
	 */
	static public function getActionPathByUrl() {
		$baseUrl	= rtrim(pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME), '/');
		$path		= parse_url(self::getRequestUri(), PHP_URL_PATH);
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

	/**
	 *	リクエストデータを取得
	 *	@param	boolean	$delete_request		取得時に削除するかの命令
	 *	@return	multitype:array				各種パラメータ情報
	 */
	static public function getRequestParams($delete_request = false) {
		$array = array(
			'get'		=> $_GET
		,	'post'		=> $_POST
		,	'cookie'	=> $_COOKIE
		);

		//リクエスト削除命令がある場合は削除
		if($delete_request) {
			$_GET		= array();
			$_POST		= array();
			$_COOKIE	= array();
		}
		return $array;
	}
}

