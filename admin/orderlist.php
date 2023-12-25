<?php
include_once '../lib/session.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    # code...
} else {
    header("Location:../index.php");
}
include '../classes/order.php';

$order = new order();
$processingOrderList = $order->getProcessingOrder();
$processedOrderList = $order->getProcessedOrder();
$deliveringOrderList = $order->getDeliveringOrder();
$completeOrderList = $order->getCompleteOrder();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Quản lý đơn đặt hàng</title>
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
            <h1>Danh sách đơn đặt hàng</h1>
        </div>
        <div class="add">
            <!-- Tab links -->
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'Processing')">Đang xử lý</button>
                <button class="tablinks" onclick="openTab(event, 'Processed')">Đã xử lý</button>
                <button class="tablinks" onclick="openTab(event, 'Delivering')">Đang giao hàng</button>
                <button class="tablinks" onclick="openTab(event, 'Complete')">Đã hoàn thành</button>
            </div>

            <!-- Tab content -->
            <div id="Processing" class="tabcontent">
                <?php
                if ($processingOrderList) { ?>
                    <table class="list">
                        <tr>
                            <th>STT</th>
                            <th>Mã khách hàng</th>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Ngày giao</th>
                            <th>Tình trạng</th>
                            <th>Địa chỉ</th>
                            <th>Thao tác</th>
                        </tr>
                        <?php $count = 1;
                        foreach ($processingOrderList as $key => $value) { ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $value['userId']?></td>
                                <td><?= $value['id'] ?></td>
                                <td><?= $value['createdDate'] ?></td>
                                <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?= ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                                <td><?= $value['status'] ?></td>
                                <td><?= $value['address'] ?></td>
                                <td>
                                    <a href="orderlistdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                <?php } else { ?>
                    <h3>Chưa có đơn hàng nào đang xử lý</h3>
                <?php }
                ?>
            </div>

            <div id="Processed" class="tabcontent">
                <?php
                if ($processedOrderList) { ?>
                    <table class="list">
                        <tr>
                            <th>STT</th>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Ngày giao</th>
                            <th>Tình trạng</th>
                            <th>Thao tác</th>
                        </tr>
                        <?php $count = 1;
                        foreach ($processedOrderList as $key => $value) { ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $value['id'] ?></td>
                                <td><?= $value['createdDate'] ?></td>
                                <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?= ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                                <td><?= $value['status'] ?></td>
                                <td>
                                    <a href="delivering_order.php?orderId=<?= $value['id'] ?>">Giao hàng</a>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                <?php } else { ?>
                    <h3>Chưa có đơn hàng nào đã xử lý</h3>
                <?php }
                ?>
            </div>

            <div id="Delivering" class="tabcontent">
                <?php
                if ($deliveringOrderList) { ?>
                    <table class="list">
                        <tr>
                            <th>STT</th>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Ngày nhận</th>
                            <th>Tình trạng</th>
                            <th>Thao tác</th>
                        </tr>
                        <?php $count = 1;
                        foreach ($deliveringOrderList as $key => $value) { ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $value['id'] ?></td>
                                <td><?= $value['createdDate'] ?></td>
                                <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?= ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                                <td><?= $value['status'] ?></td>
                                <td>
                                    <a href="orderlistdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                <?php } else { ?>
                    <h3>Chưa có đơn hàng nào đang giao</h3>
                <?php }
                ?>
            </div>

            <div id="Complete" class="tabcontent">
                <?php
                if ($completeOrderList) { ?>
                    <table class="list">
                        <tr>
                            <th>STT</th>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Ngày nhận</th>
                            <th>Tình trạng</th>
                            <th>Thao tác</th>
                        </tr>
                        <?php $count = 1;
                        foreach ($completeOrderList as $key => $value) { ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $value['id'] ?></td>
                                <td><?= $value['createdDate'] ?></td>
                                <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?= ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                                <td><?= $value['status'] ?></td>
                                <td>
                                    <a href="orderlistdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                <?php } else { ?>
                    <h3>Chưa có đơn hàng nào đã hoàn thành</h3>
                <?php }
                ?>
            </div>
        </div>
    </div>
    <footer></footer>
</body>
<script type="text/javascript">
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 1; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        document.getElementById(tabName).style.display = "block";
    }
</script>

</html>
