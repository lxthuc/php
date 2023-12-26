<?php
include_once 'lib/session.php';
include 'classes/product.php';
include_once 'classes/cart.php';

$cart = new cart();
$totalQty = $cart->getTotalQtyByUserId();

$product = new product();
$result = $product->getProductbyId($_GET['id']);
if (!$result) {
    echo 'Không tìm thấy sản phẩm!';
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://use.fontawesome.com/2145adbb48.js"></script>
    <script src="https://kit.fontawesome.com/a42aeb5b72.js" crossorigin="anonymous"></script>
    <title><?= $result['name'] ?></title>
</head>

<body>
    <nav>
        <a class="logo" href="index.php">
            <img src="public/images/logo.png" alt="">
        </a>
        <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="productList.php" class="active">Sản phẩm</a></li>
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user']) { ?>
                <li><a href="logout.php" id="signin">Đăng xuất</a></li>
            <?php } else { ?>
                <li><a href="register.php" id="signup">Đăng ký</a></li>
                <li><a href="login.php" id="signin">Đăng nhập</a></li>
            <?php } ?>
            <li><a href="order.php" id="order">Đơn hàng</a></li>
            <li>
                <a href="checkout.php">
                    <i class="fa fa-shopping-bag"></i>
                    <span class="sumItem">
                        <?= ($totalQty['total']) ? $totalQty['total'] : "0" ?>
                    </span>
                </a>
            </li>
        </ul>
    </nav>
    <section class="banner"></section>
    <div class="featuredProducts">
        <h1>Sản phẩm</h1>
    </div>
    <div class="container-single">
        <div class="image-product">
            <img style="height: 57px;" src="admin/uploads/<?= $result['image'] ?>" alt="">
        </div>
        <div class="info">
            <div class="name">
                <h2><?= $result['name'] ?></h2>
            </div>
            <div class="price-single">
                Giá bán: <b><?= number_format($result['promotionPrice'], 0, '', ',') ?>VND</b>
            </div>
            <?php
            if ($result['promotionPrice'] < $result['originalPrice']) { ?>
                <div>
                    Gía gốc: <del><?= number_format($result['originalPrice'], 0, '', ',') ?>VND</del>
                </div>
            <?php }
            ?>
            <div class="des">
                <p>Đã bán: <?= $result['soldCount'] ?></p>
                <?= $result['des'] ?>
            </div>
            <div class="add-cart-single">
                <a href="add_cart.php?id=<?= $result['id'] ?>">Thêm vào giỏ</a>
            </div>
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