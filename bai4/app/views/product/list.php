<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-3 text-center" style="color: #FF69B4;">Danh sách sản phẩm</h1>
    <div class="d-flex justify-content-end mb-3">
        <a href="/bai4/Product/add" class="btn btn-success mb-2" style="background-color: #FF69B4; border-color: #FF69B4; color: white;">Thêm sản phẩm mới</a>
    </div>
    <ul class="list-group">
        <?php foreach ($products as $product): ?>
            <li class="list-group-item" style="border-color: #FFB6C1;">
                <h2 style="color: #FF69B4;"><a href="/bai4/Product/show/<?php echo $product->id; ?>" style="color: #FF69B4; text-decoration: none;"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></a></h2>
                <?php if ($product->image): ?>
                    <img src="/bai4/<?php echo $product->image; ?>" alt="Product Image" style="max-width: 100px; border-radius: 5px;">
                <?php endif; ?>
                <p style="color: #FFB6C1;"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                <p style="color: #FF69B4;">Giá: <?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?> VND</p>
                <p style="color: #FF69B4;">Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                
                <div class="mt-4">
                    <div class="d-flex gap-2 flex-wrap">
                        <?php if (SessionHelper::isAdmin()): ?>
                            <a href="/bai4/Product/edit/<?php echo $product->id; ?>"
                               class="btn btn-warning btn-sm w-100 fw-bold text-white rounded-pill transition-all hover-btn"
                               style="background-color: #FFB6C1; border-color: #FFB6C1; color: #212529 !important;">
                                <i class="fas fa-edit me-1"></i> Sửa
                            </a>
                            <a href="/bai4/Product/delete/<?php echo $product->id; ?>"
                               class="btn btn-danger btn-sm w-100 fw-bold rounded-pill transition-all hover-btn delete-btn"
                               style="background-color: #FF69B4; border-color: #FF69B4; color: white !important;"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                <i class="fas fa-trash me-1"></i> Xóa
                            </a>
                        <?php endif; ?>
                        <a href="/bai4/Product/addToCart/<?php echo $product->id; ?>"
                           class="btn btn-primary btn-sm w-100 fw-bold rounded-pill transition-all hover-btn"
                           style="background-color: #FF1493; border-color: #FF1493; color: white !important;">
                            <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .btn-warning:hover, .btn-warning:focus {
        background-color: #E9967A !important; /* Light Salmon */
        border-color: #E9967A !important;
        color: #212529 !important;
    }

    .btn-danger:hover, .btn-danger:focus {
        background-color: #C71585 !important; /* Medium Violet Red */
        border-color: #C71585 !important;
    }

    .btn-primary:hover, .btn-primary:focus {
        background-color: #FF69B4 !important; /* Hot Pink */
        border-color: #FF69B4 !important;
    }
</style>