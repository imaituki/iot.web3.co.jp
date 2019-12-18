<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * 区分値
 */
$package_name = 'kubun';
$config["{$package_name}_package_name_label"] = '区分値';
$config["{$package_name}_relation_data_type"] = '';	//親のデータ種別。デフォルトはブランク
$config["{$package_name}_basic_category_use"] = FALSE;
$config["{$package_name}_basic_category_multi_select"] = TRUE;
$config["{$package_name}_label_basic_category"] = 'カテゴリー';
$config["{$package_name}_max_list"] = FALSE;
$config["{$package_name}_label_keyword_search_condition"] = 'タイトル、本文';
$config["{$package_name}_validate_rule_basic_category"] = 'required';
