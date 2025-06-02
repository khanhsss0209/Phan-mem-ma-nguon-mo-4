<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Chi tiết sản phẩm</h2>
        </div>
        <div class="card-body">
            <?php if ($product): ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-image-container" style="height: 400px; overflow: hidden;">
                            <?php if ($product->image && file_exists($product->image)): ?>
                                <img src="/webbanhang/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                     alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                     class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <img src="/webbanhang/uploads/no-image.png" 
                                     alt="No Image" 
                                     class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="card-title text-dark font-weight-bold"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?></p>
                        <p class="text-danger font-weight-bold h4"><?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>
                        <p><strong>Danh mục:</strong>
                            <span class="badge bg-info text-white">
                                <?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Chưa có danh mục'; ?>
                            </span>
                        </p>
                        <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-success px-4"><i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng</a>
                        <a href="/webbanhang/Product" class="btn btn-secondary px-4 ml-2">Quay lại danh sách</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger text-center">
                    <h4>Không tìm thấy sản phẩm!</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>