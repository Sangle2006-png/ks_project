<?php
include "database.php";
?>
<?php
class brand{
    private $db;
    
    public function __construct(){
        $this->db = new Database();
    }
    
public function insert_brand($cartegory_id, $brand_name){
    $brand_name = mysqli_real_escape_string($this->db->link, $brand_name);
    $cartegory_id = mysqli_real_escape_string($this->db->link, $cartegory_id);
    $query = "INSERT INTO tbl_brand (cartegory_id, brand_name) VALUES('$cartegory_id', '$brand_name')";
    
   
    $result = $this->db->insert($query);
    
    
    return $result;
}

    
    // Hiển thị danh sách brand
    public function show_brand(){
     $query = "SELECT tbl_brand.*, tbl_cartegory.cartegory_name
          FROM tbl_brand 
          LEFT JOIN tbl_cartegory ON tbl_brand.cartegory_id = tbl_cartegory.cartegory_id
          ORDER BY tbl_brand.brand_id DESC";

        $result = $this->db->select($query);
        return $result;
    }
    
    // Lấy thông tin brand theo ID
    public function get_brand($brand_id){
        $brand_id = mysqli_real_escape_string($this->db->link, $brand_id);
        $query = "SELECT * FROM tbl_brand WHERE brand_id = '$brand_id'";
        $result = $this->db->select($query);
        return $result;
    }
    
    // Cập nhật brand - ĐÃ SỬA: Phải cập nhật CẢ cartegory_id VÀ brand_name
    public function update_brand($brand_id, $cartegory_id, $brand_name){
        $brand_id = mysqli_real_escape_string($this->db->link, $brand_id);
        $cartegory_id = mysqli_real_escape_string($this->db->link, $cartegory_id);
        $brand_name = mysqli_real_escape_string($this->db->link, $brand_name);
        
        // QUAN TRỌNG: Phải UPDATE cả cartegory_id và brand_name
        $query = "UPDATE tbl_brand 
                  SET cartegory_id = '$cartegory_id', brand_name = '$brand_name' 
                  WHERE brand_id = '$brand_id'";
        $result = $this->db->update($query);
        return $result;
    }
    
    // Xóa brand
    public function brand_delete($brand_id){
        $brand_id = mysqli_real_escape_string($this->db->link, $brand_id);
        $query = "DELETE FROM tbl_brand WHERE brand_id = '$brand_id'";
        $result = $this->db->delete($query);
        header('Location:brandlist.php');
        return $result;
    }
    
    // Hiển thị danh sách category
    public function show_cartegory(){
        $query = "SELECT * FROM tbl_cartegory ORDER BY cartegory_id DESC";
        $result = $this->db->select($query);
        return $result;
    }
    
    // Cập nhật category
    public function update_cartegory($cartegory_name, $cartegory_id){
        $cartegory_name = mysqli_real_escape_string($this->db->link, $cartegory_name);
        $cartegory_id = mysqli_real_escape_string($this->db->link, $cartegory_id);
        $query = "UPDATE tbl_cartegory SET cartegory_name = '$cartegory_name' WHERE cartegory_id='$cartegory_id'";
        $result = $this->db->update($query);
        header('Location:cartegorylist.php');
        return $result;
    }
    
    // Xóa category
    public function delete_cartegory($cartegory_id){
        $cartegory_id = mysqli_real_escape_string($this->db->link, $cartegory_id);
        $query = "DELETE FROM tbl_cartegory WHERE cartegory_id = '$cartegory_id'";
        $result = $this->db->delete($query);
        header('Location:cartegorylist.php');
        return $result;
    }
}
?>