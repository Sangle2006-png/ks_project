<?php
include_once __DIR__ . "/../database.php";
?>
<?php
class product{
    private $db;
    
    public function __construct(){
        $this->db = new Database();
    }  
    // Hiển thị danh sách category
    public function show_cartegory(){
        $query = "SELECT * FROM tbl_cartegory ORDER BY cartegory_id DESC";
        $result = $this->db->select($query);
        return $result;
    }
  // Hiển thị danh sách brand
    public function show_brand(){
        $query = "SELECT tbl_brand.*, tbl_cartegory.cartegory_name
                  FROM tbl_brand 
                  INNER JOIN tbl_cartegory ON tbl_brand.cartegory_id = tbl_cartegory.cartegory_id
                  ORDER BY tbl_brand.brand_id DESC";
        $result = $this->db->select($query);
        return $result;
    }
    // Thêm brand mới
    public function insert_product(){
     $product_name =$_POST['product_name'];
     $cartegory_id =$_POST['cartegory_id'];
     $brand_id =$_POST['brand_id'];
     $product_price =$_POST['product_price'];
     $product_price_new =$_POST['product_price_new'];
     $product_desc =$_POST['product_desc'];
     $product_img =$_FILES['product_img']['name'];
     $filetarget = basename($_FILES['product_img']['name']);
     $filetype = strtolower(pathinfo($product_img,PATHINFO_EXTENSION));
     $filesize = $_FILES['product_img']['size'];
     if(file_exists("uploads/$filetarget")){
        $alert ="File đã tồn tại";
        return $alert;
     }
     else{
        if($filetype != "jpg" && $filetype!= "png" ){
            $alert ="chỉ chọn file png hoặc jpg";
            return $alert;
        }
        else {
            if($filesize > 1000000)
            {
                $alert="File không được lớn hơn 1MB";
                return $alert;
            }
            else{
                 move_uploaded_file($_FILES['product_img']['tmp_name'], "uploads/" . $_FILES['product_img']['name']);
        $query = "INSERT INTO tbl_product
        (product_name,
        cartegory_id,
        brand_id,
        product_price,
        product_price_new,
        product_desc,
        product_img)
         VALUES
         ('$product_name', 
         '$cartegory_id', 
         '$brand_id', 
         '$product_price', 
         '$product_price_new', 
         '$product_desc', 
         '$product_img')";
        $result = $this->db->insert($query);
       if($result){
        $query = "SELECT * FROM tbl_product ORDER BY product_id DESC LIMIT 1";
        $result= $this -> db ->select($query)->fetch_assoc();
        $product_id = $result['product_id'];
        $filename = $_FILES['product_img_desc']['name'];
        $filttmp = $_FILES['product_img_desc']['tmp_name'];
        foreach ($filename as $key => $value){
            move_uploaded_file($filttmp[$key], "uploads/" . $value);
            $query = "INSERT INTO tbl_product_img_desc (product_id,product_img_desc) VALUES('$product_id','$value')";
            $result = $this->db->insert($query);
             
        }
       }
            }
       
        }


     }
   


        return $result;
    }
    

    // Lấy sản phẩm theo brand_id
public function get_product_by_brand($brand_id){
    $brand_id = mysqli_real_escape_string($this->db->link, $brand_id);
    $query = "SELECT * FROM tbl_product WHERE brand_id = '$brand_id' ORDER BY product_id DESC";
    $result = $this->db->select($query);
    return $result;
}
// Hiển thị tất cả sản phẩm
public function show_product(){
    $query = "SELECT * FROM tbl_product ORDER BY product_id DESC";
    $result = $this->db->select($query);
    return $result;
}
// Lấy chi tiết sản phẩm theo ID
public function get_product_detail($product_id){
    $product_id = mysqli_real_escape_string($this->db->link, $product_id);
    $query = "SELECT tbl_product.*, tbl_cartegory.cartegory_name, tbl_brand.brand_name
              FROM tbl_product
              LEFT JOIN tbl_cartegory ON tbl_product.cartegory_id = tbl_cartegory.cartegory_id
              LEFT JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
              WHERE tbl_product.product_id = '$product_id'";
    $result = $this->db->select($query);
    if ($result) {
        return $result->fetch_assoc();
    }
    return null;
}

// Lấy ảnh mô tả sản phẩm
public function get_product_images($product_id){
    $product_id = mysqli_real_escape_string($this->db->link, $product_id);
    $query = "SELECT * FROM tbl_product_img_desc WHERE product_id = '$product_id'";
    $result = $this->db->select($query);
    return $result;
}

// ==================== CHỨC NĂNG TÌM KIẾM ====================

// Tìm kiếm sản phẩm cơ bản
public function search_product($keyword){
    // Làm sạch từ khóa tìm kiếm
    $keyword = mysqli_real_escape_string($this->db->link, $keyword);
    
    // Tìm kiếm trong tên sản phẩm, mô tả, tên thương hiệu
    $query = "SELECT tbl_product.*, tbl_brand.brand_name, tbl_cartegory.cartegory_name
              FROM tbl_product
              LEFT JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
              LEFT JOIN tbl_cartegory ON tbl_product.cartegory_id = tbl_cartegory.cartegory_id
              WHERE tbl_product.product_name LIKE '%$keyword%' 
              OR tbl_product.product_desc LIKE '%$keyword%'
              OR tbl_brand.brand_name LIKE '%$keyword%'
              OR tbl_cartegory.cartegory_name LIKE '%$keyword%'
              ORDER BY tbl_product.product_id DESC";
    
    $result = $this->db->select($query);
    return $result;
}

// Tìm kiếm nâng cao với phân trang
public function search_product_advanced($keyword, $limit = 12, $offset = 0){
    $keyword = mysqli_real_escape_string($this->db->link, $keyword);
    
    $query = "SELECT tbl_product.*, tbl_brand.brand_name, tbl_cartegory.cartegory_name
              FROM tbl_product
              LEFT JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
              LEFT JOIN tbl_cartegory ON tbl_product.cartegory_id = tbl_cartegory.cartegory_id
              WHERE tbl_product.product_name LIKE '%$keyword%' 
              OR tbl_product.product_desc LIKE '%$keyword%'
              OR tbl_brand.brand_name LIKE '%$keyword%'
              OR tbl_cartegory.cartegory_name LIKE '%$keyword%'
              ORDER BY tbl_product.product_id DESC
              LIMIT $limit OFFSET $offset";
    
    $result = $this->db->select($query);
    return $result;
}

// Đếm số lượng kết quả tìm kiếm
public function count_search_results($keyword){
    $keyword = mysqli_real_escape_string($this->db->link, $keyword);
    
    $query = "SELECT COUNT(*) as total
              FROM tbl_product
              LEFT JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
              LEFT JOIN tbl_cartegory ON tbl_product.cartegory_id = tbl_cartegory.cartegory_id
              WHERE tbl_product.product_name LIKE '%$keyword%' 
              OR tbl_product.product_desc LIKE '%$keyword%'
              OR tbl_brand.brand_name LIKE '%$keyword%'
              OR tbl_cartegory.cartegory_name LIKE '%$keyword%'";
    
    $result = $this->db->select($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    return 0;
}

// Tìm kiếm với bộ lọc (theo giá, thương hiệu, danh mục)
public function search_product_with_filter($keyword, $brand_id = null, $cartegory_id = null, $min_price = null, $max_price = null){
    $keyword = mysqli_real_escape_string($this->db->link, $keyword);
    
    $query = "SELECT tbl_product.*, tbl_brand.brand_name, tbl_cartegory.cartegory_name
              FROM tbl_product
              LEFT JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
              LEFT JOIN tbl_cartegory ON tbl_product.cartegory_id = tbl_cartegory.cartegory_id
              WHERE (tbl_product.product_name LIKE '%$keyword%' 
              OR tbl_product.product_desc LIKE '%$keyword%'
              OR tbl_brand.brand_name LIKE '%$keyword%'
              OR tbl_cartegory.cartegory_name LIKE '%$keyword%')";
    
    // Thêm điều kiện lọc theo brand
    if ($brand_id) {
        $brand_id = mysqli_real_escape_string($this->db->link, $brand_id);
        $query .= " AND tbl_product.brand_id = '$brand_id'";
    }
    
    // Thêm điều kiện lọc theo category
    if ($cartegory_id) {
        $cartegory_id = mysqli_real_escape_string($this->db->link, $cartegory_id);
        $query .= " AND tbl_product.cartegory_id = '$cartegory_id'";
    }
    
    // Thêm điều kiện lọc theo giá
    if ($min_price !== null) {
        $min_price = mysqli_real_escape_string($this->db->link, $min_price);
        $query .= " AND tbl_product.product_price >= '$min_price'";
    }
    
    if ($max_price !== null) {
        $max_price = mysqli_real_escape_string($this->db->link, $max_price);
        $query .= " AND tbl_product.product_price <= '$max_price'";
    }
    
    $query .= " ORDER BY tbl_product.product_id DESC";
    
    $result = $this->db->select($query);
    return $result;
}

// Lấy gợi ý tìm kiếm (cho autocomplete)
public function get_search_suggestions($keyword, $limit = 5){
    $keyword = mysqli_real_escape_string($this->db->link, $keyword);
    
    $query = "SELECT product_id, product_name, product_price, product_img
              FROM tbl_product
              WHERE product_name LIKE '%$keyword%'
              ORDER BY product_id DESC
              LIMIT $limit";
    
    $result = $this->db->select($query);
    return $result;
}
    
// ==================== KẾT THÚC CHỨC NĂNG TÌM KIẾM ====================

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