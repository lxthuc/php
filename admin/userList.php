<?php
include '../lib/session.php';
include '../classes/user.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
} else {
    header("Location:../index.php");
}
$user = new user();
$list = $user->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Danh sách tài khoản</title>
</head>

<body>
    <div class="container">
        <nav>
            <a href="index.php">
                <label class="logo">ADMIN</label>
            </a>
            <ul>
                <li><a href="productList.php">Quản lý Sản phẩm</a></li>
                <li><a href="categoriesList.php">Quản lý Danh mục</a></li>
                <li><a href="orderList.php">Quản lý Đơn hàng</a></li>
                <li><a href="userList.php">Quản lý tài khoản</a></li>
            </ul>
        </nav>
        <div class="add">
            <div class="title">
                <h1>Danh sách tài khoản</h1>
            </div>
            <div class="addNew">
                <a class="btn btn-success" href="add_user.php">Thêm mới</a>
            </div>
            <div class="table">
                <?php $pageCount = 0;
                if ($list) { ?>
                    <table class="list">
                        <tr>
                            <th>STT</th>
                            <th>Email</th>
                            <th>Họ tên</th>
                            <th>Ngày sinh</th>
                            <th>Role</th>
                            <th>Trạng thái</th>
                            <th>Địa chỉ</th>
                            <th>Hành động</th>
                        </tr>
                        <?php foreach ($list as $key => $value) { ?>
                            <tr>
                                <td><?= ++$pageCount ?></td>
                                <td><?= $value['email'] ?></td>
                                <td><?= $value['fullname'] ?></td>
                                <td><?= $value['dob'] ?></td>
                                <td><?= ($value['role_id'] == 1) ? 'Admin' : 'User' ?></td>
                                <td><?= ($value['status'] == '1') ? 'Active' : 'Inactive' ?></td>
                                <td><?= $value['address'] ?></td>
                                <td>
                                    <?php
                                    if ($value['id']) { ?>
                                        <a href="edit_user.php?id=<?= $value['id'] ?>" class="btn btn-primary">Sửa</a>
                                        <a href="delete_user.php?id=<?= $value['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <h3>Chưa có tài khoản </h3>
                <?php } ?>
                <div class="pagination">
                    <a href="userList.php?page=<?= (isset($_GET['page'])) ? (($_GET['page'] <= 1) ? 1 : $_GET['page'] - 1) : 1 ?>">&laquo;</a>
                    <?php
                    for ($i = 1; $i <= $pageCount; $i++) {
                        if (isset($_GET['page'])) {
                            if ($i == $_GET['page']) { ?>
                                <a class="active" href="userList.php?page=<?= $i ?>"><?= $i ?></a>
                            <?php } else { ?>
                                <a href="userList.php?page=<?= $i ?>"><?= $i ?></a>
                            <?php  }
                        } else {
                            if ($i == 1) { ?>
                                <a class="active" href="userList.php?page=<?= $i ?>"><?= $i ?></a>
                            <?php  } else { ?>
                                <a href="userList.php?page=<?= $i ?>"><?= $i ?></a>
                            <?php   } ?>
                        <?php  } ?>
                    <?php }
                    ?>
                    <a href="userList.php?page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>">&raquo;</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>