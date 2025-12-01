<?php
include "header.php";
include "slider.php";
include "class/brand_class.php";
?>

<?php
$brand = new brand; // class nên viết hoa chữ cái đầu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartegory_id = $_POST['cartegory_id'];
    $brand_name = $_POST['brand_name'];

    if (!empty($cartegory_id) && $cartegory_id != 0) {
        $insert_brand = $brand->insert_brand($cartegory_id, $brand_name);
    } else {
        echo "<span style='color:red;'>Vui lòng chọn danh mục hợp lệ.</span>";
    }
}

?>
<style>
    /* Admin Header với nút Đăng xuất */
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background-color: #2c3e50;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .admin-header h1 {
        color: white;
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* Nút Đăng xuất - Giống hình bên phải */
    .logout-btn {
        background-color: #e74c3c;
        color: white;
        padding: 12px 28px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 1px;
        box-shadow: 0 2px 5px rgba(231, 76, 60, 0.3);
    }

    .logout-btn:hover {
        background-color: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(231, 76, 60, 0.5);
    }

    .logout-btn:active {
        transform: translateY(0);
    }

    /* Content wrapper để tránh bị header che */
    body {
        padding-top: 70px;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .admin-content-right-cartegory_add {
        max-width: 400px;
        margin: 40px auto;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .admin-content-right-cartegory_add h1 {
        font-size: 20px;
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    }

    select, input[type="text"], button[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-weight: 600;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<div class="admin-content-right">
    <div class="admin-content-right-cartegory_add">
        <h1>Thêm loại sản phẩm</h1> <br>
        <form action="" method="POST">
            <select name="cartegory_id"id="">
                <option value="">-Chọn Danh Mục</option>
          <?php
$show_cartegory = $brand ->show_cartegory();
if($show_cartegory){while($result = $show_cartegory -> fetch_assoc()){


          ?>
                 <option value="<?php echo $result['cartegory_id'] ?>"><?php echo $result['cartegory_name'] ?></option>
                 <?php
                 }}
                 ?>
</select>
<br>
<input type="text" placeholder="Nhập tên loại sản phẩm" name="brand_name" required>
            <button type="submit">Thêm</button>
        </form>
    </div>
</div>
</body>
</html>
