<?php
include 'classes/user.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new user();
    $result = $user->confirm($_POST['userId'], $_POST['captcha']);
    if ($result === true) {
        echo '<script type="text/javascript">alert("Xác minh tài khoản thành công!"); window.location.href = "login.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Xác minh Email</title>
</head>

<body>
    <nav>
        <a class="logo" href="index.php">
            <img src="images/logo.png" alt="">
        </a>
        <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="productList.php">Sản phẩm</a></li>
            <li><a href="register.php" id="signup" class="active">Đăng ký</a></li>
            <li><a href="login.php" id="signin">Đăng nhập</a></li>
            <li><a href="order.php" id="order">Đơn hàng</a></li>
            <li>
                <a href="checkout.php">
                    <i class="fa fa-shopping-bag"></i>
                    <span class="sumItem">
                        0
                    </span>
                </a>
            </li>
        </ul>
    </nav>
    <section class="banner"></section>
    <div class="featuredProducts">
        <h1>Xác minh Email</h1>
    </div>
    <div class="container-single">
        <div class="login">
            <b class="error"><?= !empty($result) ? $result : '' ?></b>
            <form action="confirm.php" method="post" class="form-login">
                <label for="fullName">Mã xác minh</label>
                <input type="text" id="userId" name="userId" hidden style="display: none;" value="<?= (isset($_GET['id'])) ? $_GET['id'] : $_POST['userId'] ?>">
                <input type="text" id="captcha" name="captcha" placeholder="Mã xác minh...">
                <input type="submit" value="Xác minh" name="submit">
            </form>
        </div>
    </div>
    </div>
    <footer>
        <ul class="list">
            <li>
                <a href="./">Trang Chủ</a>
            </li>
            <li>
                <a href="productList.php">Sản Phẩm</a>
            </li>
        </ul>
    </footer>
</body>

</html>