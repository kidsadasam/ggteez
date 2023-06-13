<?php
session_start();
include(__DIR__ . '/../config/config.php');

if ($_SESSION['userid'] == "") {
    echo "<script>
				window.location.replace('../member/index.php');
			  </script>";
    die;
}

$strSQLPay = "SELECT * FROM `payment` WHERE user_id = '" . $_SESSION['userid'] . "' ORDER BY scb_id DESC LIMIT 10";
$objQueryPay = mysqli_query($conn, $strSQLPay);

$strSQLPoint = "SELECT COUNT(*) AS count FROM `payment` WHERE user_id = '" . $_SESSION['userid'] . "'";
$objQueryPoint = mysqli_query($conn, $strSQLPoint);
$objResultPoint = mysqli_fetch_array($objQueryPoint, MYSQLI_ASSOC);

if (empty($objResultPoint["count"])) {
    $count_license = number_format(0);
} else {
    $count_license = number_format($objResultPoint["count"]);
}

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Refill Center</title>
    <meta name="robots" content="index,follow">
    <meta name="googlebots" content="index,follow" />
    <link rel="shortcut icon" href="../../images/eddga_studio1.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.27.2/dist/axios.min.js"></script>
    <script src="../system/system.min.js?v=<?= time() ?>"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-9 mx-auto mt-5">
                <div class="card animated bounceInDown">
                    <div class="card-header text-center">
                        <h5><b>Refill Infomation</b></h5>
                        <h6>บัญชี Username : <?php echo $_SESSION["username"]; ?></h6>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle cursor-pointer" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-money"></i> เติมเงินคลิก
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <?php
                                        for ($i = 0; $i < sizeof($_CONFIG['scb']['amount']); $i++) {
                                            if ($_CONFIG['scb']['amount'][$i] > 0) {
                                        ?>
                                                <a class="dropdown-item" onClick="FunctionPromptPay(<?= $_CONFIG['scb']['amount'][$i] ?>)">โอน <?= number_format($_CONFIG['scb']['amount'][$i]) ?> บาท</a>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a id="exchangePay" class="nav-link"> <i class="fa fa-exchange"></i> อัตราการเติมเงิน</a>
                                </li>
                                <li class="nav-item">
                                    <a id="pay" class="nav-link"> <i class="fa fa-history"></i> ประวัติการโอนเงิน</a>
                                </li>

                            </ul>
                            <form class="form-inline my-2 my-lg-0">
                                <button type="button" class="btn btn-outline-danger my-2 my-sm-0" onClick="doCallAjaxLogout();">Logout <i class="fa fa-sign-out"></i></button>
                            </form>
                        </div>
                    </nav>
                    <div class="card-body">
                        <p class="m-0">จำนวน licenses ที่เคยเติมไปแล้วทั้งหมด</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="<?php echo $count_license; ?> licenses" readonly>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div class="table table-hover">
                            <table id="exchange" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">โอนเงิน QR Code</th>
                                        <th class="text-center" scope="col">วันใช้งาน license</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < sizeof($_CONFIG['scb']['amount']); $i++) {
                                        if ($_CONFIG['scb']['amount'][$i] > 0) {
                                    ?>
                                            <tr>
                                                <td class="text-center"><?php echo $_CONFIG['scb']['amount'][$i]; ?> บาท</th>
                                                <td class="text-center"><?php echo $_CONFIG['scb']['cash'][$i]; ?> วัน</td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <div id="exchangeTMTZ" class="form-group p-3 mb-2 bg-danger" style="font-size:12px; color: #fff; text-align: left; border-radius: 10px;">
                            <li>หมายเหตุ : ทีมงานขอสงวนสิทธิ์ในการเปลี่ยนแปลงอัตราวันใช้งาน และ โปรโมชั่นตามความเหมาะสมโดยไม่ได้แจ้งให้ทราบล่วงหน้า</li>
                        </div>
                        <div class="table-responsive" id="history">
                            <p class="text-center">
                                ข้อมูลล่าสุดเมื่อ <i class="fa fa-history"></i> <?= date('d/m/Y H:i:s') ?>
                                <br>
                                อัพเดทรายการล่าสุดให้รีโหลดหน้าเว็บ (F5)
                            </p>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">Transaction ID</th>
                                        <th class="text-center" scope="col">เวลา</th>
                                        <th class="text-center" scope="col">ราคา (จำนวนวัน)</th>
                                        <th class="text-center" scope="col">token (คลิกเพื่อ copy)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $order = 1;
                                        while ($objResultPay = mysqli_fetch_array($objQueryPay, MYSQLI_ASSOC)) {
                                            $conFirm = mb_strtoupper($objResultPay["confirmId"]);
                                        ?>
                                            <td class="text-center"><?php echo $objResultPay["transactionId"]; ?></td>
                                            <td class="text-center"><?php echo $objResultPay["added_time"]; ?></td>
                                            <td class="text-center"><?php echo $objResultPay["amount"]; ?> บาท (<?php echo $objResultPay["days"]; ?>)</td>
                                            <td class="text-center">
                                                <input type="text" id="cpy-<?= $order ?>" class="" onClick="copyText('<?= 'cpy-' . $order ?>')" value="<?= $objResultPay["license"] ?>">
                                            </td>
                                    </tr>
                                <?php
                                            $order++;
                                        }
                                ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
    var now = new Date();
    var ref;
    var userid = encodeURI('<?= $_SESSION["username"] ?>');
    var accountid = encodeURI('<?= $_SESSION["userid"] ?>');

    const gbpay_domain = '<?= $_CONFIG['gb_pay']['access_domain'] ?>';

    const gbpay_token = '<?= $_CONFIG['gb_pay']['gen_token'] ?>';

    const gbpay_desc2 = '<?= $_CONFIG['gb_pay']['merchantDefined2'] ?>';
    const gbpay_desc3 = '<?= $_CONFIG['gb_pay']['merchantDefined3'] ?>';
    const gbpay_desc4 = '<?= $_CONFIG['gb_pay']['merchantDefined4'] ?>';
    const gbpay_desc5 = '<?= $_CONFIG['gb_pay']['merchantDefined5'] ?>';

    const gbpay_cb_promtpay = '<?= $_CONFIG['gb_pay']['cb_promptpay'] ?>';

    function doCallAjaxOBT() {
        Swal.fire({
            type: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'เปิดให้ใช้ได้ได้ตอน OBT!',
        });
    }
</script>

</html>

<?php
mysqli_close($conn);
?>
