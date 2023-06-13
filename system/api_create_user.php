<?
	if (!isset($_SESSION)) {
	session_start();
	}
	include('mysql_crud.php');
	include('config_eddga_b3eo2c84w.php');

	function clean_input($input) {
		if(get_magic_quotes_gpc()) {
			$input = stripslashes($input);
		}
		$input = strip_tags($input);
		$conoo = mysql_real_escape_string($input);
		return $conoo;
	}
	$db = new Database($DBCONFIG);
	$db->connect();
	$db->select('login', '*', NULL, 'userid="'.clean_input($_POST['eddga_userid']).'"');
	$res_uniuqe = $db->getResult();
	$db->select('login', '*', NULL, 'email="'.clean_input($_POST['eddga_email']).'"');
	$email_uniuqe = $db->getResult();
	$terms = "1";
	$gender_M = "M";
	$gender_F = "F";
	$lang = "^[a-zA-Z0-9][a-zA-Z0-9]*$";
	$langsls = "^[0-9]*$";
	$birthdate = $_POST['eddga_year']."-". $_POST['eddga_month']."-".$_POST['eddga_day'];
	if ( empty($_POST['eddga_userid']) || empty($_POST['eddga_pass']) || empty($_POST['eddga_passcfm']) || empty($_POST['eddga_email']) || empty($birthdate) || empty($_POST['eddga_gender']) || empty($_POST['eddga_captcha']) ) {
	
	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","กรุณากรอกข้อมูลให้ครบถ้วน ทุกช่อง ?","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ($_POST['eddga_captcha'] != $_SESSION['security_code']) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","Security Code ไม่ถูกต้อง ระบุเฉพาะตัวเลขเท่านั้น","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ( !ereg($lang,$_POST['eddga_userid']) || !ereg($lang,$_POST['eddga_pass']) ) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","Username & Password ต้องภาษาอังกฤษ เท่านั้น !","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ( (strlen($_POST['eddga_userid']) < 4) || (strlen($_POST['eddga_userid']) > 23) ) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","Username ความยาว 4-23 ตัวอักษรขึ้นไป","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ( (strlen($_POST['eddga_pass']) < 4) || (strlen($_POST['eddga_pass']) > 23) ) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","Password ความยาว 4-23 ตัวอักษรขึ้นไป","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ( $_POST['eddga_pass'] != $_POST['eddga_passcfm'] ) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","กรุณาระบุ Password ให้ตรงกัน","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ( $_POST['eddga_gender'] != $gender_M && $_POST['eddga_gender'] != $gender_F  ) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","กรุณาเลือกเพศตัวละคร","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ( $_POST['eddga_terms'] != $terms ) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","กรุณายอมรับข้อตกลงในการสมัครสมาชิก","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ( !ereg($lang,$_POST['eddga_year']) || !ereg($lang,$_POST['eddga_month']) || !ereg($lang,$_POST['eddga_day']) ) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","กรุณาเลือก วันเกิด (Ex.15-12-2551)","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ( !ereg("([a-zA-Z0-9._-]+)@([^[:space:]]*)([[:alnum:]]+)\.([a-z])", $_POST['eddga_email']) ) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","กรุณาระบุ อีเมล์ที่ใช้งานได้จริง","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ( $res_uniuqe ) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","ID : '.clean_input($_POST['eddga_userid']).' นี้ถูกใช้งานแล้ว","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} elseif ( $email_uniuqe ) {

	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {';
	echo 'swal("ไม่สามารถทำรายการได้","อีเมล์ : '.clean_input($_POST['eddga_email']).' นี้ถูกใช้งานแล้ว","error").then( function(val) {';
	echo 'if (val == true) window.location.href = \'create_account\';';
	echo '});';
	echo '}, 200);  </script>';
	
	} else {
		$data = array(
			'userid' => clean_input(trim($_POST['eddga_userid'])),
			'user_pass' => clean_input(trim($_POST['eddga_pass'])),
			'sex' => clean_input(trim($_POST['eddga_gender'])),
			'birthdate' => clean_input(trim($birthdate)),
			'email' => clean_input(trim($_POST['eddga_email'])),
			'last_ip' => clean_input(trim($_SERVER['REMOTE_ADDR']))
		);
		$db->insert('login', $data);
		$res = $db->getResult();
		if($res){
			
		echo '<script type="text/javascript">';
		echo 'setTimeout(function () {';
		echo 'swal("ยินดีต้อนรับสมาชิกใหม่","สมัครสมาชิกเสร็จเรียบร้อย","success").then( function(val) {';
		echo 'if (val == true) window.location.href = \'create_account\';';
		echo '});';
		echo '}, 200);  </script>';
		
		}else{

		echo '<script type="text/javascript">';
		echo 'setTimeout(function () {';
		echo 'swal("ไม่สามารถทำรายการได้","พบปัญหาการสมัครสมาชิก โปรดแจ้งทีมงาน","error").then( function(val) {';
		echo 'if (val == true) window.location.href = \'create_account\';';
		echo '});';
		echo '}, 200);  </script>';
		
		}
	}
?>
