<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">Sửa sản phẩm</h1>
        </div>
        <div class="card-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/webbanhang/Product/update" enctype="multipart/form-data" onsubmit="return validateForm();">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">

                <div class="form-group">
                    <label for="name">Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Giá:</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Danh mục:</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>" <?php echo ($category->id == $product->category_id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Hình ảnh:</label>
                    <input type="file" id="image" name="image" class="form-control" onchange="previewImage(this);">
                    <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="mt-2" id="imagePreview">
                        <?php if (!empty($product->image) && file_exists($product->image)): ?>
                            <img src="/webbanhang/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                 alt="Product Image Preview" 
                                 class="img-thumbnail" 
                                 style="max-height: 200px">
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </form>

            <a href="/webbanhang/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    var preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('img-thumbnail');
            img.style.maxHeight = '200px';
            preview.appendChild(img);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include 'app/views/shares/footer.php'; ?>