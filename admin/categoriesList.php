<?php
include '../lib/session.php';
include '../classes/categories.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    # code...
} else {
    header("Location:../index.php");
}
$categories = new categories();
$list = $categories->getAllAdmin((isset($_GET['page']) ? $_GET['page'] : 1));
$pageCount = $categories->getCountPaging();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Danh sách danh mục</title>
</head>

<body>
    <div class="container">
        <nav>
            <a class="logo" href="index.php">
                <img style="margin-left:50px;width:80px; float:left" e src="img/admin.png"></img>
            </a>
            <ul>
                <li><a href="productlist.php">Quản lý Sản phẩm</a></li>
                <li><a href="categoriesList.php" class="active">Quản lý danh mục</a></li>
                <li><a href="orderlist.php" id="order">Quản lý Đơn hàng</a></li>
                <li><a href="userList.php">Quản lý tài khoản</a></li>
            </ul>
        </nav>
        <div class="title">
            <h1>Danh sách danh mục</h1>
        </div>
        <div class="addNew">
                <a class="btn btn-success" href="add_category.php">Thêm mới</a>
            </div>
        <div class="add">
            <?php $count = 1;
            if ($list) { ?>
                <table class="list">
                    <tr>
                        <th>STT</th>
                        <th>Tên danh mục</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php foreach ($list as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['name'] ?></td>
                            <td><?= ($value['status']) ? "Active" : "Block" ?></td>
                            <td>
                                <?php
                                if ($value['id']) { ?>
                                    <a href="edit_category.php?id=<?= $value['id'] ?>" class="btn btn-primary">Sửa</a>
                                    <a href="delete_category.php?id=<?= $value['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có danh mục nào...</h3>
            <?php } ?>
            <div class="pagination">
                <a href="categoriesList.php?page=<?= (isset($_GET['page'])) ? (($_GET['page'] <= 1) ? 1 : $_GET['page'] - 1) : 1 ?>">&laquo;</a>
                <?php
                for ($i = 1; $i <= $pageCount; $i++) {
                    if (isset($_GET['page'])) {
                        if ($i == $_GET['page']) { ?>
                            <a class="active" href="categoriesList.php?page=<?= $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a href="categoriesList.php?page=<?= $i ?>"><?= $i ?></a>
                        <?php  }
                    } else { ?>
                        <a href="categoriesList.php?page=<?= $i ?>"><?= $i ?></a>
                    <?php  } ?>
                <?php }
                ?>
                <a href="categoriesList.php?page=<?= (isset($_GET['page'])) ? $_GET['page'] + 1 : 2 ?>">&raquo;</a>
            </div>
        </div>
    </div>
</body>

</html>