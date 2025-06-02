<?php include 'app/views/shares/header.php'; ?>

<style>
  .header-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .header-actions .btn {
    min-width: 140px;
  }

  .cart-btn i {
    margin-right: 0.5rem;
  }

  .product-card {
    transition: box-shadow 0.3s ease;
    border-radius: 1rem;
    overflow: hidden;
  }

  .product-card:hover {
    box-shadow: 0 8px 20px rgba(102, 166, 255, 0.3);
  }

  .product-card .card-img-top {
    height: 200px;
    overflow: hidden;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .product-card .card-img-top img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
  }

  .product-card:hover .card-img-top img {
    transform: scale(1.05);
  }

  .card-title a {
    font-weight: 700;
    color: #0d6efd;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .card-title a:hover {
    color: #0a58ca;
    text-decoration: underline;
  }

  .card-text.text-truncate {
    max-height: 3.6em; /* khoảng 2 dòng */
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .card-footer {
    background-color: #fff;
    border-top: none;
    padding: 0.75rem 1rem;
  }

  .btn-group .btn {
    flex: 1;
    border-radius: 50px;
    font-size: 0.85rem;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .btn-group .btn:not(:last-child) {
    margin-right: 0.3rem;
  }

  .btn-group .btn i {
    margin-right: 0.3rem;
  }

  /* Responsive adjustments */
  @media (max-width: 767.98px) {
    .header-actions {
      flex-direction: column;
      align-items: stretch;
    }

    .header-actions .btn {
      width: 100%;
      min-width: unset;
    }
  }
</style>

<div class="container my-5">
  <h1 class="mb-4 fw-bold">Danh sách sản phẩm</h1>

  <div class="header-actions">
    <a href="/webbanhang/Product/add" class="btn btn-success shadow-sm">
      <i class="fas fa-plus-circle"></i> Thêm sản phẩm
    </a>
    <a href="/webbanhang/Product/cart" class="btn btn-primary cart-btn shadow-sm">
      <i class="fas fa-shopping-cart"></i> Giỏ hàng
    </a>
  </div>

  <div class="row g-4">
    <?php foreach ($products as $product): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card product-card h-100 shadow-sm">
          <div class="card-img-top">
            <?php if ($product->image && file_exists($product->image)): ?>
              <img
                src="/webbanhang/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                loading="lazy"
              >
            <?php else: ?>
              <img
                src="/webbanhang/uploads/no-image.png"
                alt="No Image"
                loading="lazy"
              >
            <?php endif; ?>
          </div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">
              <a href="/webbanhang/Product/show/<?php echo $product->id; ?>">
                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
              </a>
            </h5>
            <p class="card-text text-truncate flex-grow-1" title="<?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>">
              <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <p class="card-text fw-bold mb-1">
              Giá: <?php echo number_format($product->price, 0, ',', '.'); ?> VND
            </p>
            <p class="text-muted mb-0 small">Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
          </div>
          <div class="card-footer d-flex gap-2">
            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="btn btn-info btn-sm flex-fill" title="Xem chi tiết">
              <i class="fas fa-eye"></i> Xem
            </a>
            <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-sm flex-fill" title="Thêm vào giỏ">
              <i class="fas fa-cart-plus"></i> Thêm
            </a>
            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm flex-fill" title="Chỉnh sửa">
              <i class="fas fa-edit"></i> Sửa
            </a>
            <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm flex-fill" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
              <i class="fas fa-trash"></i> Xóa
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
