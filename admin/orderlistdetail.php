<?php
include_once '../lib/session.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    # code...
} else {
    header("Location:../index.php");
}
include '../classes/orderDetails.php';
include '../classes/order.php';

$orderDetails = new orderDetails();
$result = $orderDetails->getOrderDetails($_GET['orderId']);
$order = new order();
$order_result = $order->getById($result[0]['orderId']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://use.fontawesome.com/2145adbb48.js"></script>
    <script src="https://kit.fontawesome.com/a42aeb5b72.js" crossorigin="anonymous"></script>
    <title>Chi tiết đơn đặt hàng</title>
</head>

<body>
    <div class="container">
        <nav>
            <a class="logo" href="index.php">
                <img style="margin-left:50px;width:80px; float:left" e src="img/admin.png"></img>
            </a>
            <ul>
                <li><a href="productlist.php">Quản lý Sản phẩm</a></li>
                <li><a href="categoriesList.php">Quản lý Danh mục</a></li>
                <li><a href="orderlist.php" class="active">Quản lý Đơn hàng</a></li>
                <li><a href="userList.php">Quản lý tài khoản</a></li>

            </ul>
        </nav>
        <div class="title">
            <h1>Chi tiết đơn đặt hàng <?= $order_result['id'] ?></h1>
        </div>
        <div class="add">
            <?php
            if ($result) { ?>
                <table class="list">
                    <tr>
                        <th>STT</th>
                        <th>Mã khách hàng</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Địa chỉ</th>
                    </tr>
                    <?php $count = 1;
                    foreach ($result as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['userId']?></td>
                            <td><?= $value['productName'] ?></td>
                            <td><img class="image-cart" src="uploads/<?= $value['productImage'] ?>" alt=""></td>
                            <td><?= $value['productPrice'] ?></td>
                            <td><?= $value['qty'] ?></td>
                            <td><?= $value['address']?></td>

                        </tr>
                    <?php }
                    ?>
                </table>
                <?php
                if ($order_result['status'] == 'Processing') { ?>
                    <a href="processed_order.php?orderId=<?= $_GET['orderId'] ?>">Xác nhận</a>
                <?php }
                ?>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đang xử lý</h3>
            <?php }
            ?>
        </div>
    </div>
</body>

</html>