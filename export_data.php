<?php
extract($_GET);
//print_r($wpdb);
//exit;
$table = $prefix."historycollection";
$database = $dbname;
mysql_connect($dbhost,$username,$password);
mysql_select_db($database);
/*mysql_connect("localhost","root","");
mysql_select_db("ecommerce");*/
//echo "select * from ".$wpdb->prefix."wp_historycollection";
//exit;
$result = mysql_query("select * from ".$prefix."historycollection");
$out = '';
// Get all fields names in table "mytablename" in database "mydb".
$fields = mysql_list_fields($database,$table);
// Count the table fields and put the value into $columns.
$columns = mysql_num_fields($fields);
// Put the name of all fields to $out.
for ($i = 1; $i <= $columns-3; $i++) {
$l=mysql_field_name($fields, $i);
$out .= '"'.$l.'",';
}
$out .="\n";

// Add all values in the table to $out.
while ($l = mysql_fetch_array($result)) {
for ($i = 1; $i <= $columns-3; $i++) {
$out .='"'.stripslashes($l["$i"]).'",';
}
$out .="\n";
}
 
// Open file export.csv.
$f = fopen ('export.csv','w');
// Put all values from $out to export.csv.
fputs($f, $out);
fclose($f);
echo 'success';
?>