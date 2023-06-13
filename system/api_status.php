<?php
include('config_eddga_b3eo2c84w.php');

/* สถานะเซิฟเวอร์*/
$interval = time() + 60;
$online       = '<div class="box-status-on">ONLINE</div>';
$offline     = '<div class="box-status-off">OFFLINE</div>';

/* ไม่ควรยุ่งกับจุดตรงนี้ */
error_reporting(0);

/* Check Server Status, If Server Status Was Not Checked In Last $interval seconds */
if($_COOKIE["checked"] != "true")
{
        /* Check Server Status */
        $map = fsockopen($DBCONFIG['db_host'], $DBCONFIG['map_port'], $errno, $errstr, 1);

        /* Workout Server Status & Set Cookie */
       if (!$map) {
        $map_status = $offline;
        setcookie("map_status", "offline", $interval);
		} else {
			$map_status = $online;
		}

setcookie("checked", "true", $interval);
} else {
  if ($_COOKIE["checked"] == "true") {
		if ($_COOKIE["map_status"] == "offline") {
			$map_status = $offline;
		} else {
			$map_status = $online;
		}
	}
}

echo $map_status;
?>
