<?php

//環境設定次第で取得方法が不安定なドキュメント情報を定数化
define('HTDOCS_DIR',  dirname(__FILE__));
define('HTDOCS_NAME', basename(HTDOCS_DIR));
require('../main.php');
