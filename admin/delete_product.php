<?php
include '../lib/session.php';
include '../classes/product.php';

Session::checkSession('admin');
$role_id = Session::get('role_id');

if ($role_id == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        $product_id = $_GET['id'];
        $product = new product();
        $result = $product->delete($product_id);

        if ($result) {
            // Xóa thành công, chuyển hướng về trang danh sách sản phẩm
            header("Location: productlist.php");
        } else {
            // Xóa không thành công, hiển thị thông báo hoặc xử lý tùy ý
            echo "Xóa không thành công";
        }
    }
} else {
    header("Location:../index.php");
}
?>
