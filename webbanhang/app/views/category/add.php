<?php include 'app/views/shares/header.php'; ?>

<style>
.form-container {
    animation: slideUp 0.5s ease-out;
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow form-container">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Thêm danh mục mới</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="/webbanhang/Category/save">
                        <div class="form-group">
                            <label>Tên danh mục</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save"></i> Lưu
                            </button>
                            <a href="/webbanhang/Category" class="btn btn-secondary px-4 ml-2">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
