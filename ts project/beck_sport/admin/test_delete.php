<?php
$mysqli = new mysqli("localhost", "root", "", "ks_project ");
$cartegory_id = 10;
$query = "DELETE FROM tbl_cartegory WHERE cartegory_id = '$cartegory_id'";
$result = $mysqli->query($query);
if ($result) {
    echo "Xóa thành công";
} else {
    echo "Xóa thất bại: " . $mysqli->error;
}
?>
