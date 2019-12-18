<?php 

//直接ページを出力
header("Content-type: text/html; charset=utf-8");

echo "SQL　VIEWマージ";

$merged_sql = '';

foreach(glob("./create_view/*.sql") as $create_table_sql_file)
{
	$merged_sql .= file_get_contents($create_table_sql_file);
	$merged_sql .= "\r\n";
}


file_put_contents('./all_create_view.sql', $merged_sql);

?>
