<?php
/** ไฟล์นี้ยังไม่เปิดใช้งาน
 * ติดตั้งโดยสลับ
 * system-cooldown-bak.min.js กับ system.min.js
 */

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str);

session_start();
include "../config/config.php";

function check_cooldown($user_id = 0, $amount = 0){
    global $_CONFIG, $conn;
    $cooldown = 60;
    $wait_status = '02';

    $user_id = (!empty($user_id) && is_numeric($user_id)) ? intval($user_id) : 0;
    $amount = (!empty($amount) && is_numeric($amount)) ? intval($amount) : 0;

    if(!empty($_CONFIG['cooldown']) && is_numeric($_CONFIG['cooldown'])){
        $cooldown = 60 * intval($_CONFIG['cooldown']);
    }

    $strSQL = "SELECT added_time FROM payment WHERE user_id='$user_id' AND amount='$amount' AND status='$wait_status' ORDER BY scb_id DESC LIMIT 1";
    $objQuery = mysqli_query($conn, $strSQL);
    $row = mysqli_fetch_assoc($objQuery);
    
    if(empty($row) || empty($row['added_time'])){
        return $_CONFIG['cooldown'];
    }
    
    $select_time = new DateTime($row['added_time']);
    $now = new DateTime;
    $diff_cooldown = $now->getTimestamp() - $select_time->getTimestamp();
    
    
    
    $calc_cooldown = ($diff_cooldown > 0 ) ? intval(ceil($diff_cooldown/60)) : $_CONFIG['cooldown'];
    return $calc_cooldown;
}

if (!empty($json_obj) && !empty($json_obj->user_id) && !empty($json_obj->amount)) {
    $strAmout = $json_obj->amount;
    $strAccountId = $json_obj->user_id;

    // ! ANTI FLOOD REQUEST
    $check_cooldown = check_cooldown($strAccountId, $strAmout);
    if($check_cooldown < $_CONFIG['cooldown']){
        mysqli_close($conn);

        $diff = $_CONFIG['cooldown'] - $check_cooldown;
        $message = 'ทำรายการถี่เกินไป. กรุณาลองอีกครั้งหลังจาก ' . $diff . ' นาที';
        echo json_encode(array(
            'message' => $message,
            'status' => false,
        ));
        die;
    }

    echo json_encode(array(
        'message' => 'สามารถทำรายการได้ตามปกติ',
        'status' => true,
    ));
}

mysqli_close($conn);
