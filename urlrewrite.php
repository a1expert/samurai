<?php
$arUrlRewrite=array (
	0 => array (
		'CONDITION' => '#^/catalog/(.*)/.*#',
		'RULE' => 'SECTION_CODE=$1',
		'ID' => '',
		'PATH' => '/catalog/index.php',
		'SORT' => 100,
	),
	1 => array (
		'CONDITION' => '#^/stocks/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => '/stocks/index.php',
		'SORT' => 100,
	),
	2 => array (
		'CONDITION' => '#^/rest/#',
		'RULE' => '',
		'ID' => NULL,
		'PATH' => '/bitrix/services/rest/index.php',
		'SORT' => 100,
	),
);
