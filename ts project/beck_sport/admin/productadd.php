<?php
include "header.php";
include "slider.php";
include "class/product_class.php"
?>

<?php
$prodcut = new product; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
  
     $insert_product = $prodcut->insert_product($_POST, $_FILES);
}
?>

<div class="admin-content-right">
 <div class="admin-content-right-product_add">
                <h1>Thêm Sản Phẩm</h1>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input name ="product_name"  type="text" placeholder="Nhập tên sản phẩm" name="cartegory_name" required>
                    <select name="cartegory_id" id="">
                        <option value="">--Chọn Danh Mục</option>
                 <?php
                $show_cartegory = $prodcut ->show_cartegory();
                if($show_cartegory){while($result = $show_cartegory -> fetch_assoc()){
                ?>
                        <option value="<?php echo $result['cartegory_id'] ?>"><?php echo $result['cartegory_name'] ?></option>
                        <?php
                }}
                        ?>
                    </select>

                     <select name="brand_id" id="">
                        <option value="#">--Chọn Loại Sản phẩm</option>
                        <?php
                $show_brand = $prodcut ->show_brand();
                if($show_brand){while($result = $show_brand -> fetch_assoc()){
                ?>
                        <option value="<?php echo $result['brand_id'] ?>"><?php echo $result['brand_name'] ?></option>
                        <?php
                }}
                        ?>
                    </select>
                    <input name = "product_price" required type="text" placeholder="Giá Sản Phẩm">
                    <input name = "product_price_new"required type="text" placeholder="Giá khuyến mãi">
                   <textarea name="product_desc" id="editor1" cols="30" rows="10" placeholder="Mô tả sản phẩm" required></textarea>
                <label for="" style="display:block; font-weight:600; color:#2c3e50; margin-bottom:6px; text-transform:uppercase;">
                 Ảnh Sản Phẩm
                 </label>
                 <span><?php if(isset($insert_product)){
                    echo $insert_product;
                 }  ?></span>
                  <input name = "product_img"required type="file"><br>

                <label for="" style="display:block; font-weight:600; color:#2c3e50; margin-bottom:6px; text-transform:uppercase;">
                 Ảnh Mô Tả
                </label>
                <input name ="product_img_desc[]" required multiple type="file">

                    <button type="submit">Thêm</button>
                </form>
            </div>
</div>
</section>
</body>
<script>
    CKEDITOR.replace('editor1', {
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
    });
</script>
