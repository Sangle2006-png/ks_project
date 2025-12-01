<?php
include "header.php";
include "slider.php";
include "class/brand_class.php";
?>

<?php
$brand = new brand;

// Khởi tạo biến brand_id
$brand_id = null;

// Kiểm tra xem có brand_id không
if(isset($_GET['brand_id']) && !empty($_GET['brand_id'])){
    $brand_id = $_GET['brand_id'];
} else {
    echo "<script>alert('Không tìm thấy ID thương hiệu!'); window.location='brandlist.php';</script>";
    exit();
}

// Khởi tạo biến mặc định
$resultA = null;

// Lấy thương hiệu theo id
$get_brand = $brand->get_brand($brand_id);

if($get_brand && $get_brand->num_rows > 0){
    $resultA = $get_brand->fetch_assoc();
} else {
    echo "<script>alert('Không tìm thấy thương hiệu với ID: $brand_id'); window.location='brandlist.php';</script>";
    exit();
}

// QUAN TRỌNG: Xử lý CẬP NHẬT thương hiệu (KHÔNG PHẢI THÊM MỚI!)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartegory_id = $_POST['cartegory_id']; 
    $brand_name = $_POST['brand_name'];
    
    // GỌI HÀM update_brand 
    $update_brand = $brand->update_brand($brand_id, $cartegory_id, $brand_name);
    
    if($update_brand){
        echo "<script>alert('Cập nhật thành công!'); window.location='brandlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Cập nhật thất bại!');</script>";
    }
}
?>
<style>
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
        <!-- TIÊU ĐỀ ĐÚNG: SỬA (không phải THÊM) -->
        <h1>Sửa loại sản phẩm</h1>
        <form action="" method="POST">
            <select name="cartegory_id" id="" required>
                <option value="">-Chọn Danh Mục-</option>
                <?php
                $show_cartegory = $brand->show_cartegory();
                if($show_cartegory){
                    while($result = $show_cartegory->fetch_assoc()){
                        $selected = '';
                        if($resultA && isset($resultA['cartegory_id']) && $result['cartegory_id'] == $resultA['cartegory_id']){
                            $selected = 'selected';
                        }
                ?>
                    <option value="<?php echo $result['cartegory_id'] ?>" <?php echo $selected ?>>
                        <?php echo $result['cartegory_name'] ?>
                    </option>
                <?php
                    }
                }
                ?>
            </select>
            <input required name="brand_name" type="text" placeholder="Nhập tên loại sản phẩm" 
                value="<?php echo isset($resultA['brand_name']) ? htmlspecialchars($resultA['brand_name']) : '' ?>">
            <button type="submit">Sửa</button>
        </form>
    </div>
</div>
</section>
</body>
</html>