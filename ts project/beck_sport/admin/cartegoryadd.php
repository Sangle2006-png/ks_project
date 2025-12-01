<?php
include "header.php";
include "slider.php";
include "class/cartegory_class.php";
?>

<?php
$cartegory = new Cartegory; // class nên viết hoa chữ cái đầu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // lấy dữ liệu từ form
    $cartegory_name = $_POST['cartegory_name']; 
    // gọi hàm insert
    $insert_cartegory = $cartegory->insert_cartegory($cartegory_name);
}
?>

<div class="admin-content-right">
    <div class="admin-content-right-cartegory_add">
        <h1>Thêm Danh Mục</h1>
        <form action="" method="POST">
            <input type="text" placeholder="Nhập tên danh mục" name="cartegory_name" required>
            <button type="submit">Thêm</button>
        </form>
    </div>
</div>
</section>
</body>
</html>
