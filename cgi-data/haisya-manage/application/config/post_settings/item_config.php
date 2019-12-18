<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * 製品
 */
$package_name = 'item';
$config["{$package_name}_package_name_label"] = '製品';	//親のデータ種別。デフォルトはブランク
$config["{$package_name}_relation_data_type"] = '';	//親のデータ種別。デフォルトはブランク
$config["{$package_name}_basic_category_use"] = TRUE;
$config["{$package_name}_basic_category_multi_select"] = TRUE;
$config["{$package_name}_label_basic_category"] = 'カテゴリー';
$config["{$package_name}_use_image_upload"] = TRUE;
$config["{$package_name}_use_doc_upload"] = FALSE;
$config["{$package_name}_max_image_file"] = 1;
$config["{$package_name}_max_doc_file"] = 2;
$config["{$package_name}_use_image_caption"] = FALSE;
$config["{$package_name}_use_image_paragraph_title"] = FALSE;
$config["{$package_name}_main_image_width"] = 940;
$config["{$package_name}_main_image_height"] = 443;
$config["{$package_name}_thumbnail_width"] = 200;
$config["{$package_name}_thumbnail_height"] = 150;
$config["{$package_name}_thumbnail_m_width"] = 176;
$config["{$package_name}_thumbnail_m_height"] = 135;
$config["{$package_name}_thumbnail_ss_width"] = 100;
$config["{$package_name}_thumbnail_ss_height"] = 77;
$config["{$package_name}_max_list"] = 10;
$config["{$package_name}_column_post_date_use"] = TRUE;
$config["{$package_name}_column_new_icon_end_date_use"] = FALSE;
$config["{$package_name}_column_publish_end_date_use"] = FALSE;
$config["{$package_name}_column_post_title_use"] = TRUE;
$config["{$package_name}_column_post_content_use"] = TRUE;
$config["{$package_name}_column_post_sub_title_use"] = TRUE;
$config["{$package_name}_column_post_link_use"] = FALSE;
$config["{$package_name}_column_post_link_text_use"] = FALSE;
$config["{$package_name}_column_order_number_use"] = TRUE;
$config["{$package_name}_label_keyword_search_condition"] = '商品名称、一般名称、検索キーワード';
$config["{$package_name}_label_post_date"] = '登録日';
$config["{$package_name}_label_new_icon_end_date"] = 'NEWアイコン掲載終了日';
$config["{$package_name}_label_publish_end_date"] = '記事の掲載終了日';
$config["{$package_name}_label_post_title"] = '商品名称';
$config["{$package_name}_label_post_content"] = '紹介文';
$config["{$package_name}_label_post_sub_title"] = '一般名称';
$config["{$package_name}_label_post_link"] = 'リンク';
$config["{$package_name}_label_post_link_text"] = 'リンク用テキスト';
$config["{$package_name}_label_order_number"] = 'ソート優先度';
$config["{$package_name}_validate_rule_basic_category"] = 'required';
$config["{$package_name}_validate_rule_post_date"] = 'trim|required|callback_check_date|max_length[10]';
$config["{$package_name}_validate_rule_new_icon_end_date"] = 'callback_check_date|max_length[10]';
$config["{$package_name}_validate_rule_publish_end_date"] = 'callback_check_date|max_length[10]';
$config["{$package_name}_validate_rule_post_title"] = 'trim|required|max_length[200]';
$config["{$package_name}_validate_rule_post_content"] = 'trim|required|max_length[500]';
$config["{$package_name}_validate_rule_post_sub_title"] = 'trim|required|max_length[200]';
$config["{$package_name}_validate_rule_post_link"] = 'callback_check_url|max_length[200]';
$config["{$package_name}_validate_rule_post_link_text"] = 'max_length[100]';
$config["{$package_name}_validate_rule_order_number"] = 'trim|required|integer|less_than[11]|greater_than[0]';

//製品の複数選択の最大数
$config["{$package_name}_item_select_max"] = '3';
