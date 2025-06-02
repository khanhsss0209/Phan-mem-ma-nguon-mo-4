<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h3 class="mb-0">Chỉnh sửa danh mục</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="/webbanhang/Category/update">
                        <input type="hidden" name="id" value="<?php echo $category->id; ?>">
                        <div class="form-group">
                            <label>Tên danh mục</label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?php echo htmlspecialchars($category->name); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($category->description); ?></textarea>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning px-4">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                            <a href="/webbanhang/Category" class="btn btn-secondary px-4 ml-2">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
