<?php
/**
 *	CQPHPフレームワーク中枢
 *
 *	@author	CQPHP
 */
class CQPHP_Framework
{
	/**
	 * モジュールを読み込み、SmartyによるOutputを実行する
	 */
	static public function executeAction($path)
	{
		//action
		$class_name		= CQPHP_DefineSetting::loadActionFile($path);
		$template		= new CQPHP_ApplicationTemplate($path);
		if(class_exists($class_name)) {
			$action_class	= new $class_name($path);
			$action_class->execute($template);
		} else {
			throw new Exception('Unknown Action Class');
		}

		//entry value to template
		foreach($action_class->getAssignValues() as $key => $value) {
			$template->assign($key, $value);
		}

		//template
		if($template->display() === FALSE) {
			throw new Exception('Unknown Template HTML');
		}
	}
}
