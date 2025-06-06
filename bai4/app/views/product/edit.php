<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1 class="text-center" style="color: #0d6efd;">Sửa sản phẩm</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" style="background-color: #cfe2ff; border-color: #0d6efd;">
            <ul class="list-unstyled">
                <?php foreach ($errors as $error): ?>
                    <li class="text-danger"><i class="fas fa-exclamation-triangle mr-2"></i> <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/bai4/Product/update" enctype="multipart/form-data" onsubmit="return validateForm();">
        <input type="hidden" name="id" value="<?php echo $product->id; ?>">
        <div class="form-group">
            <label for="name" style="color: #0d6efd;"><i class="fas fa-tag mr-2"></i> Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required style="border-color: #0d6efd;">
        </div>
        <div class="form-group">
            <label for="description" style="color: #0d6efd;"><i class="fas fa-file-alt mr-2"></i> Mô tả:</label>
            <textarea id="description" name="description" class="form-control" required style="border-color: #0d6efd;"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="form-group">
            <label for="price" style="color: #0d6efd;"><i class="fas fa-dollar-sign mr-2"></i> Giá:</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required style="border-color: #0d6efd;">
        </div>
        <div class="form-group">
            <label for="category_id" style="color: #0d6efd;"><i class="fas fa-list mr-2"></i> Danh mục:</label>
            <select id="category_id" name="category_id" class="form-control" required style="border-color: #0d6efd;">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image" style="color: #0d6efd;"><i class="fas fa-image mr-2"></i> Hình ảnh:</label>
            <input type="file" id="image" name="image" class="form-control" style="border-color: #0d6efd;">
            <input type="hidden" name="existing_image" value="<?php echo $product->image; ?>">
            <?php if ($product->image): ?>
                <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image" style="max-width: 100px; border-radius: 5px; margin-top: 10px;">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-lg btn-block" style="background-color: #0d6efd; border-color: #0d6efd;">
            <i class="fas fa-save mr-2"></i> Lưu thay đổi
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="/bai4/Product/list" class="btn btn-outline-primary mt-2" style="color: #0d6efd; border-color: #0d6efd;">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách sản phẩm
        </a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .btn-outline-primary {
        color: #0d6efd !important;
        border-color: #0d6efd !important;
    }
    .btn-outline-primary:hover {
        background-color: #0d6efd !important;
        color: white !important;
    }
</style>