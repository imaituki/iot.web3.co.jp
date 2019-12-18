<?php 

//直接ページを出力
header("Content-type: text/html; charset=utf-8");

echo "SQLマージ";

$merged_sql = '';

foreach(glob("./create_table/*.sql") as $create_table_sql_file)
{
	$merged_sql .= file_get_contents($create_table_sql_file);
	$merged_sql .= "\r\n";
}


file_put_contents('./all_create_table.sql', $merged_sql);

?>
