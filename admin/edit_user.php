<?php
include '../lib/session.php';
include '../classes/user.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
$result = null;

if ($role_id == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $user = new user();
        $userId = $_POST['user_id']; // Assuming you have a hidden input field for user_id in your form
        $result = $user->edit($userId, $_POST);
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
    <title>Chỉnh sửa tài khoản</title>
</head>

<body>
    <div class="container">
        <nav>
            <a href="index.php">
                <label class="logo">ADMIN</label>
            </a>
            <ul>
                <li><a href="productList.php">Quản lý Sản phẩm</a></li>
                <li><a href="categoriesList.php" class="active">Quản lý danh mục</a></li>
                <li><a href="orderList.php">Quản lý Đơn hàng</a></li>
                <li><a href="userList.php">Quản lý tài khoản</a></li>
            </ul>
        </nav>
        <div class="title">
            <h1>Chỉnh sửa tài khoản</h1>
        </div>
        <div class="add">
            <?php if (!empty($result) && is_array($result)) : ?>
                <p style="color: <?= $result['success'] ? 'green' : 'red'; ?>">
                    <?= $result['message']; ?>
                </p>
            <?php endif; ?>
            <div class="form-add">
                <form action="edit_user.php" method="post" enctype="multipart/form-data">
                    <?php
                    // Assuming you have a user ID passed through the URL (e.g., edit_user.php?id=1)
                    $userId = isset($_GET['id']) ? $_GET['id'] : null;
                    ?>
                    <input type="hidden" name="user_id" value="<?= $userId ?>">

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input type="text" name="email" class="form-control" placeholder="">
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