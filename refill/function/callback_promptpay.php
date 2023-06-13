<?php

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str);

session_start();
include "../config/config.php";
date_default_timezone_set('Asia/Bangkok');

function authgg_generate($days = 1)
{
    global $_CONFIG;
    $certkey = "sha256//+4v/M3rTRuEkcLqd33NswOW6SFz4GQfyfD3jsGcXWCc=";
    $api = "https://developers.auth.gg/LICENSES/";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_PINNEDPUBLICKEY, $certkey);
    $values = array(
        "type" => "generate",
        "days" => $days,
        "amount" => 1,
        "level" => $_CONFIG['authgg']['level'],
        "prefix" => $_CONFIG['authgg']['prefix'],
        "format" => $_CONFIG['authgg']['format'],
        "length" => $_CONFIG['authgg']['length'],
        "authorization" => $_CONFIG['authgg']['authorization'],
    );
    $url = $api . '?' . http_build_query($values);

    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    curl_close($ch);

    return (array)json_decode($response);
}

function get_headers_from_curl_response($response)
{
    $headers = array();
    $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

    foreach (explode("\r\n", $header_text) as $i => $line) {
        if ($i === 0) {
            $headers['http_code'] = $line;
        } else {
            list($key, $value) = explode(': ', $line);
            $headers[$key] = $value;
        }
    }

    return $headers;
}

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } else if (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}

$gballow = gethostbyname('api.gbprimepay.com');
$vuserip = getUserIP();

// ! check ip
if (strcmp($vuserip, $gballow) != 0) {
    echo 'ei';
    return false;
    die;
}

$strConfirmId = $json_obj->referenceNo;
$strTransactionId = $json_obj->gbpReferenceNo;
$strResCode = $json_obj->resultCode;
$strUserID = $json_obj->customerName;

$strAmout = $json_obj->amount;
$strAccountId = $json_obj->merchantDefined1;

$date = date_create();

// ! validate rescode = 00
if ($strResCode != '00') {
    echo 'erc';
    return false;
    die;
}

$strAmout = number_format((float)$strAmout, 2, '.', '');
$date_sql = date_format($date, "Y-m-d H:i:s");
$date_txt = date_format($date, "d/m/Y H:i:s");

/**
 * CHECK PRICING
 */

$price_data = array();

for ($i = 0; $i != sizeof($_CONFIG['scb']['amount']); $i++) {
    if ($_CONFIG['scb']['amount'][$i] > 0) {
        $key = $_CONFIG['scb']['amount'][$i];
        $price_data[$key] = $_CONFIG['scb']['cash'][$i];
    }
}

$day_gen = 0;
$real_price = number_format((float)$json_obj->amount, 0, '.', '');
$real_price = intval($real_price);
if (!array_key_exists($real_price, $price_data)) {
    echo 'epr';
    return false;
    die;
}

/**
 * GEN LICENSE
 */

$day_gen = $price_data[$real_price];
$license = authgg_generate($day_gen);

if (empty($license) || !is_array($license)) {
    echo 'elc';
    die;
    return false;
}

$license = $license[0];

/**
 * INSERT DATA
 */

$strSQL = "INSERT INTO payment (user_id,confirmId,transactionId,amount,status,added_time,license,days) VALUES ('" . $strAccountId . "','" . $strConfirmId . "','" . $strTransactionId . "','" . $strAmout . "','" . $strResCode . "','" . $date_sql . "', '" . $license . "', '" . $day_gen . "')";
$objQuery = mysqli_query($conn, $strSQL);

mysqli_close($conn);
