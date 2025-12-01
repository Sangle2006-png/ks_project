<?php
include "class/cartegory_class.php";
$cartegory = new Cartegory;
if (!isset($_GET['cartegory_id']) || $_GET['cartegory_id'] == NULL) {
    echo "<script>window.location = 'cartegorylist.php'</script>";
} else {
    $cartegory_id = $_GET['cartegory_id'];
    echo "ID cần xóa: " . $cartegory_id;

}

// lấy danh mục theo id
$delete_cartegory = $cartegory->delete_cartegory($cartegory_id);

?>
