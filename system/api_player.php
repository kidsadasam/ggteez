<?php
include('config_eddga_b3eo2c84w.php');

$link = mysql_connect($DBCONFIG['db_host'],$DBCONFIG['db_user'],$DBCONFIG['db_pass']) or die(mysql_error());
@mysql_select_db($DBCONFIG['db_name'],$link);

/* จำนวน ผู้เล่นออนไลน์ ทั้งหมด */
$useronline = "SELECT COUNT(*) as total FROM `char` WHERE `online` != '0'";
$useronline_r = mysql_query($useronline);
$user = mysql_fetch_array($useronline_r);
$show_user = number_format($user["total"]*$count_user, 0, '.', ',');


echo '<div class="box-status-player"><span class="counter">'.$show_user.'</spn></div>';
?>
