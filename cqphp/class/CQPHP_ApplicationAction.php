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
	 *	インスタンスに宣言されている全変数を配列で取得
	 *	@return	array	変数格納配列
	 */
	public function getAssignValues() {
		$ret	= array();
		foreach((array)$this as $key => $value) {
			if(isset($this->$key)) {
				$ret[$key]	= $value;
			}
		}
		return	$ret;
	}
}

