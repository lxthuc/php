<?php
include '../lib/session.php';
include '../classes/user.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $user = new user();
        $result = $user->create($_POST);
    }
} else {
    header("Location:../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Thêm mới danh mục</title>
</head>

<body>
    <div class="container">
        <nav>
            <a class="logo" href="index.php">
                <img style="margin-left:50px;width:80px; float:left" e src="img/admin.png"></img>
            </a>
            <ul>
                <li><a href="productList.php">Quản lý Sản phẩm</a></li>
                <li><a href="categoriesList.php" class="active">Quản lý danh mục</a></li>
                <li><a href="orderList.php">Quản lý Đơn hàng</a></li>
                <li><a href="userList.php">Quản lý tài khoản</a></li>

            </ul>
        </nav>
        <div class="title">
            <h1>Thêm mới tài khoản</h1>
        </div>
        <div class="add">
            <?php if (!empty($result) && is_array($result)) : ?>
                <p style="color: <?= $result['success'] ? 'green' : 'red'; ?>">
                    <?= $result['message']; ?>
                </p>
            <?php endif; ?>
            <div class="form-add">
                <form action="add_user.php" method="post">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input type="email" name="email" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Họ tên:</strong>
                            <input type="text" name="name" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Ngày sinh:</strong>
                            <input class="form-control" name="dob" type="date" placeholder="">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Địa chỉ:</strong>
                            <input class="form-control" name="address" type="text" placeholder="">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Mật khẩu:</strong>
                            <input class="form-control" name="password" type="password" placeholder="">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Role:</strong>
                            <select name="role_id" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Trạng thái:</strong>
                            <select name="status" class="form-control">
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" value="Lưu" name="submit">
                </form>
            </div>
        </div>
    </div>

</body>

</html>