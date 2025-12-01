<?php
include "header.php";
include "slider.php";
include "class/brand_class.php";
?>

<?php
$brand = new brand; // class nên viết hoa chữ cái đầu
$show_brand= $brand ->show_brand();
?>

<div class="admin-content-right">
   <div class="admin-content-right-cartegory_list">
          <h1>Danh sách loaị sản phẩm</h1>
          <table>
            <tr>
                <th>Stt</th>
                <th>Id</th>
                <th>Danh mục</th>
                <th>Loại sản phẩm</th>
                <th>Tùy biến</th>
            </tr>
            <?php
            if($show_brand){$i=0;
            while($result = $show_brand->fetch_assoc()){$i++;
            
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $result['brand_id']?></td>
                <td><?php echo $result['cartegory_name'] ?? '<span style="color:red;">(Không tìm thấy danh mục)</span>'; ?></td>

                <td><?php echo $result['brand_name']?></td>
                <td><a href="brandedit.php?brand_id=<?php echo $result['brand_id']?> ">Sửa</a>
                <a href="branddelete.php?brand_id=<?php echo $result['brand_id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            </tr>
            <?php
            }
        }
        ?>
          </table>
            </div>
</div>
</body>
</html>
