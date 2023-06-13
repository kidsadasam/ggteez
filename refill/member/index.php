<link rel="shortcut icon" href="../../images/eddga_studio1.ico">
<?php
session_start();
header("content-type: text/html; charset=UTF-8");
include(__DIR__ . '/../config/config.php');
?>
<html lang="en">

<head>
    <meta charset="utf-8">
	<link rel="shortcut icon" href="../../images/eddga_studio1.ico">
    <title>Refill Cente</title>

    <meta name="robots" content="index,follow">
    <meta name="googlebots" content="index,follow" />
	<!-- Favicon -->
    <link rel="shortcut icon" href="../../images/eddga_studio1.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../system/system.min.js?v=<?= filemtime(__DIR__ . '../system/system.min.js') ?>"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
                <div class="card animated bounceInDown">
                    <div class="card-header text-center">
                        <h5><b>Member Login</b></h5>
                        <h6>เข้าสู่ระบบสมาชิก</h6>
                        <p class="text-danger m-0">(ระบบสมาชิกเฉพาะส่วนของระบบเติมเงินเท่านั้น)</p>
                        <p class="text-primary m-0">สมัครสมาชิก กรอก id/pass กดปุ่ม Register ได้เลยครับ</p>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="txtUsername" onKeyPress="return text_only(event);" name="txtUsername" placeholder="ไอดีของคุณ">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="txtPassword" onKeyPress="return text_only(event);" name="txtPassword" placeholder="รหัสผ่านของคุณ">
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-success btn-block" onClick="doCallAjaxLogin();">Login</button>
                        <button type="button" class="btn btn-primary btn-block" onClick="doCallAjaxRegister();">Register</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.onkeydown = chkEvent

    function chkEvent(e) {
        var keycode;
        if (window.event) keycode = window.event.keyCode; //*** for IE ***//
        else if (e) keycode = e.which; //*** for Firefox ***//
        if (keycode == 13) {
            setTimeout(function() {
                doCallAjaxLogin();
            }, 5);
        }
    }
</script>

</html>
