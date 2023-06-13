<?php
include('config_eddga_b3eo2c84w.php');

$link = mysql_connect($DBCONFIG['db_host'],$DBCONFIG['db_user'],$DBCONFIG['db_pass']) or die(mysql_error());
@mysql_select_db($DBCONFIG['db_name'],$link);

$count_table="SELECT* From `setting_counter` WHERE `set_id` = '1'";
$count_query=mysql_db_query($DBCONFIG['db_name'],$count_table);
$row = mysql_fetch_array($count_query);

/* จำนวน id ทั้งหมด */
$query = "SELECT COUNT(*) as total FROM `login` WHERE `sex` != 'S'";
$result = mysql_query($query);
$acc = mysql_fetch_array($result);
$usercount = number_format($acc["total"]+$count_userid, 0, '.', ',');


echo '<div class="box-status-user"><span class="counter">'.$usercount.'</span></div>';
?>
