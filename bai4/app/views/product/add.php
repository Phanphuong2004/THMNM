<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1 class="text-center" style="color: #198754;">Thêm sản phẩm mới</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" style="background-color: #c3e6cb; border-color: #198754;">
            <ul class="list-unstyled">
                <?php foreach ($errors as $error): ?>
                    <li class="text-danger"><i class="fas fa-exclamation-triangle mr-2"></i> <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/bai4/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="form-group">
            <label for="name" style="color: #198754;"><i class="fas fa-tag mr-2"></i> Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" required style="border-color: #198754;">
        </div>
        <div class="form-group">
            <label for="description" style="color: #198754;"><i class="fas fa-file-alt mr-2"></i> Mô tả:</label>
            <textarea id="description" name="description" class="form-control" required style="border-color: #198754;"></textarea>
        </div>
        <div class="form-group">
            <label for="price" style="color: #198754;"><i class="fas fa-dollar-sign mr-2"></i> Giá:</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" required style="border-color: #198754;">
        </div>
        <div class="form-group">
            <label for="category_id" style="color: #198754;"><i class="fas fa-list mr-2"></i> Danh mục:</label>
            <select id="category_id" name="category_id" class="form-control" required style="border-color: #198754;">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image" style="color: #198754;"><i class="fas fa-image mr-2"></i> Hình ảnh:</label>
            <input type="file" id="image" name="image" class="form-control" style="border-color: #198754;">
        </div>
        <button type="submit" class="btn" style="background-color: #198754; border-color: #198754; color: white; font-size: 1.2rem;">
            <i class="fas fa-plus-circle mr-2"></i> Thêm sản phẩm
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="/bai4/Product/" class="btn btn-outline-success" style="color: #198754; border-color: #198754;">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách sản phẩm
        </a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .btn-outline-success {
        color: #198754 !important;
        border-color: #198754 !important;
    }
    .btn-outline-success:hover {
        background-color: #198754 !important;
        color: white !important;
    }
</style>