<?php
session_start();
include "../config/config.php";

$strUsername = trim($_POST["tUsername"]);
$strPassword = trim($_POST["tPassword"]);

$strSQL = "SELECT userid FROM users where username = '" . $strUsername . "' LIMIT 1";
$objQuery = mysqli_query($conn, $strSQL);
$objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);

if (!empty($objResult)) {
    echo "error";
}

$strSQL = "INSERT INTO users (username,password) VALUES ('" . $strUsername . "', '" . $strPassword . "')";
$objQuery = mysqli_query($conn, $strSQL);

if (!$objQuery) {
    echo "error";
}

$strSQL = "SELECT userid,username FROM users where username = '" . $strUsername . "' LIMIT 1";
$objQuery = mysqli_query($conn, $strSQL);
$objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC);

if (empty($objResult)) {
    echo "error";
} else {
    $_SESSION["userid"] = $objResult['userid'];
    $_SESSION["username"] = $strUsername;

    session_write_close();
}

mysqli_close($conn);
