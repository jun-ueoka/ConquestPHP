 <?php
/**
 *	アクション実行クラス
 *
 *	@author	CQPHP
 */
class CQPHP_ApplicationAction implements CQPHP_InterfaceAction {

	/** アクションパス */
	protected	$action_path	= '';

	/**
	 *	コンストラクタ
	 *	@param	strint	$path	アクションパス
	 */
	public function __construct($path) {
		$this->action_path	= $path;
	}

	/**
	 *	実行
	 *	@param	CQPHP_InterfaceTemplate	$template	テンプレート出力クラス
	 */
	public function execute(CQPHP_InterfaceTemplate $template) {
		//バリデータ実行
		$this->validate();
		//アクションメイン処理実行
		$this->action($template);
	}

	/**
	 *	バリデータ実行(派生クラスで上書きが必要)
	 */
	public function validate() {
		echo 'No Validate';
		exit;
	}

	/**
	 *	アクションメイン処理実行(派生クラスで上書きが必要)
	 *	@param	CQPHP_InterfaceTemplate	$template	テンプレート出力クラス
	 */
	public function action(CQPHP_InterfaceTemplate $template) {
		echo 'No Action';
		exit;
	}

	/**
	 *	インスタンスに宣言されている属性に対し、リクエストデータを代入する
	 *		各リクエストデータ毎に対応した名称を持つ属性に対して代入を行う
	 *		例えばGET値なら、$_GET['test']の値を受け取りたい場合、アクションに「$_g_test」属性を宣言する
	 *	@param	array	$get		GET値、名称が「$_g_xxxx」のルールで宣言された属性に対し代入
	 *	@param	array	$post		POST値、名称が「$_p_xxxx」のルールで宣言された属性に対し代入
	 *	@param	array	$cookie		COOKIE値、名称が「$_c_xxxx」のルールで宣言された属性に対し代入
	 */
	public function setRequestParams(array &$get, array &$post, array &$cookie) {
		$tmp = array("_g_" => $get, "_p_" => $post, "_c_" => $cookie);
		foreach($tmp as $code => $param) {
			foreach($param as $p_key => $p_value) {
				$param_name = $code . $p_key;
				if(property_exists($this, $param_name)) {
					$this->$param_name	= $p_value;
				}
			}
		}
	}

	/**
	 *	インスタンスに宣言されている全属性を配列で取得
	 *	@return	array	属性格納配列
	 */
	public function getAssignValues() {
		$ret	= array();
		foreach((array)$this as $key => $value) {
			$ret[$key]	= $value;
		}
		return	$ret;
	}
}

