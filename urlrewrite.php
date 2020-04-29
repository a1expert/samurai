<?php
$arUrlRewrite=array (
  5 => 
  array (
    'CONDITION' => '#^/catalog/noodles/wok/.*#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/catalog/wok.php',
    'SORT' => 1,
  ),
  4 => 
  array (
    'CONDITION' => '#^/order/thanks/\\??.*#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/order/thanks.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/catalog/(.*)/.*#',
    'RULE' => 'SECTION_CODE=$1',
    'ID' => '',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/vacancies/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/vacancies/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/stocks/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/stocks/index.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
);
