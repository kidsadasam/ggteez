<?php
include('config_eddga_b3eo2c84w.php');

$link = mysql_connect($DBCONFIG['db_host'],$DBCONFIG['db_user'],$DBCONFIG['db_pass']) or die(mysql_error());
@mysql_select_db($DBCONFIG['db_name'],$link);

/* จำนวน Char ทั้งหมด */
$query_char = "SELECT COUNT(*) as total FROM `char` WHERE `sex` != 'S'";
$result_char = mysql_query($query_char);
$arr = mysql_fetch_array($result_char);
$show_char = number_format($arr["total"]+$count_charid, 0, '.', ',');


echo '<div class="box-status-charid"><span class="counter">'.$show_char.'</spn></div>';
?>
