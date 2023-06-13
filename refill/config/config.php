<link rel="shortcut icon" href="../../images/eddga_studio1.ico">
<?php
/*===== config database web =====*/
$Srv_Host = "localhost";
$Srv_Username = "root";
$Srv_Password = "099949858";
$Srv_DBname = "ggt_test";

date_default_timezone_set("Asia/Bangkok");
/*===============================*/

// Create connection
$conn = new mysqli($Srv_Host, $Srv_Username, $Srv_Password, $Srv_DBname);

// Check connection
if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

// AUTH GG
$_CONFIG['authgg']['authorization'] = 'ZEPDWLVYJJPE';
// format 5 = MD5
$_CONFIG['authgg']['format'] = 5;
$_CONFIG['authgg']['length'] = 8;
// prefix
$_CONFIG['authgg']['prefix'] = 'AUTHGG';
$_CONFIG['authgg']['level'] = 1;

// DOMAIN API GB PAY
$_CONFIG['gb_pay']['access_domain'] = 'https://api.gbprimepay.com';
// ข้อมูลร้านค้าของ Payment
$_CONFIG['gb_pay']['gen_token'] = '###';
// CALLBACK URL ตั้งค่าให้ถูกต้องนะครับ
$_CONFIG['gb_pay']['cb_promptpay'] = "https://127.0.0.1/web/refill/function/callback_promptpay.php";

// รายละเอียดเพิ่มเติมทีต้องการส่งไปยังรายการชำระเงิน (เช่น ชื่อเซิฟ ฯลฯ)

// define 1 จะเป็น account_id ของผู้เล่นครับ
$_CONFIG['gb_pay']['merchantDefined1'] = "account_id";
$_CONFIG['gb_pay']['merchantDefined2'] = "Server Name";
$_CONFIG['gb_pay']['merchantDefined3'] = "เช่าโปร";
$_CONFIG['gb_pay']['merchantDefined4'] = "";
$_CONFIG['gb_pay']['merchantDefined5'] = "";

// มูลค่าโอนเงินสด
$_CONFIG['scb']['amount'][0] = 125;
$_CONFIG['scb']['amount'][1] = 500;

// ข้อมูลวันใช้งานที่จะได้รับ
$_CONFIG['scb']['cash'][0] = 7;
$_CONFIG['scb']['cash'][1] = 30;

/*====================*/

$_CONFIG['cooldown'] = 5; // cooldown การเติมเงิน (นาที)
