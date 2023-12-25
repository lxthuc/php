<?php
include '../lib/session.php';
include '../classes/categories.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $category = new categories();
        $result = $category->insert($_POST['name']);
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
                <li><a href="productlist.php">Quản lý Sản phẩm</a></li>
                <li><a href="categoriesList.php" class="active">Quản lý danh mục</a></li>
                <li><a href="orderlist.php">Quản lý Đơn hàng</a></li>
            </ul>
        </nav>
        <div class="title">
            <h1>Thêm mới danh mục</h1>
        </div>
        <div class="add">
            <p style="color: green;"><?= !empty($result) ? $result : '' ?></p>
            <div class="form-add">
                <form action="add_category.php" method="post">
                    <label for="name">Tên danh mục</label>
                    <input type="text" id="name" name="name" placeholder="Tên danh mục.." required>

                    <input type="submit" value="Lưu" name="submit">
                </form>
            </div>
        </div>
    </div>
</body>

</html>