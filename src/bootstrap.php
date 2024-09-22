<?php

//初期化処理

// 全ページで使用する想定の各種ファイルを読み込み
require 'core/AutoLoader.php';

$loader = new AutoLoader();

$loader->registerDir(__DIR__ . '/core');
$loader->registerDir(__DIR__ . '/controller');
$loader->registerDir(__DIR__ . '/models');
$loader->register();
