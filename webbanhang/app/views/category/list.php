<?php include 'app/views/shares/header.php'; ?>

<style>
.category-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 15px;
    overflow: hidden;
}
.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
.action-buttons {
    opacity: 0;
    transition: all 0.3s ease;
}
.category-card:hover .action-buttons {
    opacity: 1;
}
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Danh sách danh mục</h2>
        <a href="/webbanhang/Category/add" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm danh mục
        </a>
    </div>

    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-4 mb-4">
                <div class="card category-card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($category->name); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($category->description); ?></p>
                        <div class="action-buttons">
                            <a href="/webbanhang/Category/edit/<?php echo $category->id; ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="/webbanhang/Category/delete/<?php echo $category->id; ?>" 
                               class="btn btn-danger btn-sm ml-2"
                               onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
