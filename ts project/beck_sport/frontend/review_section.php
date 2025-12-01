<?php
include_once '../admin/database.php'; // chỉnh đường dẫn nếu cần

$product_id = $_GET['id'] ?? 0; // lấy ID sản phẩm từ URL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Xử lý gửi đánh giá
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $username = trim($_POST['username']);
    $rating = (int)$_POST['rating'];
    $comment = trim($_POST['comment']);

    if ($username && $rating >= 1 && $rating <= 5 && $comment) {
        $stmt = $conn->prepare("INSERT INTO reviews (product_id, username, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $product_id, $username, $rating, $comment);
        $stmt->execute();
       echo "<script>location.href='" . $_SERVER['REQUEST_URI'] . "';</script>";
exit();

    }
}

// Lấy danh sách đánh giá
$stmt = $conn->prepare("SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$reviews = $stmt->get_result();
?>

<style>
.review-section {
    margin-top: 40px;
    background: #fff8dc;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.review-section h3 {
    color: #f4b400;
    margin-bottom: 20px;
}
.review {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}
.review strong {
    color: #333;
}
.review span {
    color: #f4b400;
    font-weight: bold;
}
.review small {
    color: #888;
    font-size: 12px;
}
.review-form {
    margin-top: 30px;
}
.review-form input,
.review-form select,
.review-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
.review-form button {
    background-color: #f4b400;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
}
.review-form button:hover {
    background-color: #d99900;
}
</style>

<div class="review-section">
    <h3>🗣️ Đánh giá của khách hàng</h3>

    <?php if ($reviews->num_rows > 0): ?>
        <?php while ($row = $reviews->fetch_assoc()): ?>
            <div class="review">
                <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                <span>⭐ <?php echo $row['rating']; ?>/5</span>
                <p><?php echo nl2br(htmlspecialchars($row['comment'])); ?></p>
                <small><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
    <?php endif; ?>

    <div class="review-form">
        <h4>Gửi đánh giá của bạn</h4>
        <form method="POST">
            <input type="text" name="username" placeholder="Tên của bạn" required>
            <select name="rating" required>
                <option value="">Chọn số sao</option>
                <option value="5">5 sao</option>
                <option value="4">4 sao</option>
                <option value="3">3 sao</option>
                <option value="2">2 sao</option>
                <option value="1">1 sao</option>
            </select>
            <textarea name="comment" placeholder="Nội dung đánh giá" rows="4" required></textarea>
            <button type="submit" name="submit_review">Gửi đánh giá</button>
        </form>
    </div>
</div>
