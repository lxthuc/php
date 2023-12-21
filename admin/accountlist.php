<?php
include '../lib/session.php';
include '../classes/user.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
} else {
    header("Location:../index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product = new product();
    if (isset($_POST['block'])) {
        $result = $product->block($_POST['id']);
        if ($result) {
            echo '<script type="text/javascript">alert("Khóa sản phẩm thành công!");</script>';
        } else {
            echo '<script type="text/javascript">alert("Khóa sản phẩm thất bại!");</script>';
        }
    } else if (isset($_POST['active'])) {
        $result = $product->active($_POST['id']);
        if ($result) {
            echo '<script type="text/javascript">alert("Kích hoạt sản phẩm thành công!");</script>';
        } else {
            echo '<script type="text/javascript">alert("Kích hoạt sản phẩm thất bại!");</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Có lỗi xảy ra!");</script>';
        die();
    }
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
    <title>Danh sách sản phẩm</title>
</head>

<body>
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <a href="index.php">
            <label class="logo">ADMIN</label>
        </a>
        <ul>
            <li><a href="productlist.php" class="active">Quản lý Sản phẩm</a></li>
            <li><a href="categoriesList.php">Quản lý Danh mục</a></li>
            <li><a href="orderlist.php">Quản lý Đơn hàng</a></li>
            <li><a href="accountlist.php">Quản lý tài khoản</a></li>
        </ul>
    </nav>
    <div class="title">
        <h1>Danh sách sản phẩm</h1>
    </div>
    <div class="addNew">
        <a href="add_account.php">Thêm mới</a>
    </div>
    <div class="container">
        <?php $pageCount =0;
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
                            <a href="edit_product.php?id=<?= $value['id'] ?>">Xem/Sửa</a>
                            <?php
                            if ($value['status']) { ?>
                                <form action="productlist.php" method="post">
                                    <input type="text" name="id" hidden value="<?= $value['id'] ?>" style="display: none;">
                                    <input type="submit" value="Khóa" name="block">
                                </form>
                            <?php } else { ?>
                                <form action="productlist.php" method="post">
                                    <input type="text" name="id" hidden value="<?= $value['id'] ?>" style="display: none;">
                                    <input type="submit" value="Mở" name="active">
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <h3>Chưa có tài khoản </h3>
        <?php } ?>
        <div class="pagination">
            <a href="productlist.php?page=<?= (isset($_GET['page'])) ? (($_GET['page'] <= 1) ? 1 : $_GET['page'] - 1) : 1 ?>">&laquo;</a>
            <?php
            for ($i = 1; $i <= $pageCount; $i++) {
                if (isset($_GET['page'])) {
                    if ($i == $_GET['page']) { ?>
                        <a class="active" href="productlist.php?page=<?= $i ?>"><?= $i ?></a>
                    <?php } else { ?>
                        <a href="productlist.php?page=<?= $i ?>"><?= $i ?></a>
                    <?php  }
                } else {
                    if ($i == 1) { ?>
                        <a class="active" href="productlist.php?page=<?= $i ?>"><?= $i ?></a>
                    <?php  } else { ?>
                        <a href="productlist.php?page=<?= $i ?>"><?= $i ?></a>
                    <?php   } ?>
                <?php  } ?>
            <?php }
            ?>
            <a href="productlist.php?page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>">&raquo;</a>
        </div>
    </div>
    </div>
    <footer>
    </footer>
</body>

</html>
